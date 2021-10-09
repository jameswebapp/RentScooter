<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\scooter;
use Stripe\Stripe;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\AddMoney;

class ApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function checkout_success($id)
    {
        $stripe = new \Stripe\StripeClient('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');
        $user = User::select()->where('id',$id)->first();
        if(substr($user->customer_id, 0, 4) != 'cus_'){
            $session = $stripe->checkout->sessions->retrieve(
                $user->customer_id,
              );
            $user->customer_id = $session->customer;
        } 
        \Stripe\Stripe::setApiKey('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');
        \Stripe\Customer::createBalanceTransaction(
            $user->customer_id,
            [
              'amount' => -floatval($user->pbalance),
              'currency' => 'usd',
            ]
          );
        $user->balance = floatval($user->pbalance)/100 + floatval($user->balance);
        $user->pbalance = "0";
        $user->save();
        return redirect('/verify');
    }
    public function checkout_cancel($id)
    {
        
        $user = User::select()->where('id',$id)->first();
        $user->pbalance = "0";
        $user->save();
        return redirect('/verify');
    }
    public function signsuccess($email)
    {
        $user = User::select()->where('email',$email)->first();
        $user->sign_terms = "yes";
        $user->save();
        return redirect('/verify');
    }
    public function send_billing($id)
    {
        $user = User::select()->where('id',$id)->first();
        
        $scooter = scooter::select()->where('id',$user->scooter_id)->first();
        $scooter->rent_status = 'yes';
        $scooter->save();
        $diff = strtotime(date("Y-m-d H:i:s")) - strtotime($user->start_time) - 3600;
        if($diff > 0 ){
          \Stripe\Stripe::setApiKey('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');
          $price = intval((floatval($scooter->price1)+floatval($scooter->price2)*$diff/3600)*100);
          \Stripe\Customer::createBalanceTransaction(
              $user->customer_id,
              [
                'amount' => $price,
                'currency' => 'usd',
              ]
            );
            $user->balance =  floatval($user->balance) - floatval($price/100);
        }
        else{
          \Stripe\Stripe::setApiKey('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');
          $price = ntval(floatval($scooter->price1)*100);
          \Stripe\Customer::createBalanceTransaction(
              $user->customer_id,
              [
                'amount' => $price,
                'currency' => 'usd',
              ]
            );
            $user->balance =  floatval($user->balance) - floatval($price/100);
        }
        $user->scooter_id = "0";
        $user->close_code = "";
        $user->save();
        if(floatval($user->balance) <= 5){
          Mail::to($user->email)->send(new AddMoney($user));
        }
        return redirect('/home');
    }
    
    public function start_track($id)
    {
      $user = User::select()->where('id',$id)->first();
      $user->start_time = date("Y-m-d H:i:s");
      $ch = curl_init();
      $headers  = [
                  'X-IGLOOCOMPANY-APIKEY: 22OlTmCTdNuC4sgPLOmZI4.BycxexHR4jV5jXw62AzgWSwGNZtygrJ0vzTbSugr',
                  'Content-Type: application/json'
              ];
      $postData = [
          'variance' => '5',
          'startDate' => date('Y-m-d').'T'.date('H').':00:00+00:00'
      ];
      curl_setopt($ch, CURLOPT_URL,"https://api.igloodeveloper.co/v2/locks/IGK305cbc5f6/pin/onetime");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $result     = curl_exec ($ch);
      $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $pin = json_decode($result);
      $user->close_code = $pin->pin;
      $user->open_code = '';
      $user->save();
      return redirect('/home');
    }
    public function webhook(Request $request)
    {
      $user = User::select()->where('id',30)->first();
      Mail::to($user->email)->send(new AddMoney($user));
      dd($request);
      //start_track 

      //send_billing 
    }
}
