<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;
use App\User;
use App\scooter;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->scooter_id != ''&& $user->scooter_id != '0'){
            $scooter = scooter::select()->where('id',$user->scooter_id)->first();
            return view('home')
            ->with('scooter',$scooter);
        }
        return view('home');
    }
    public function verify()
    {
        return view('verify');
    }
    public function scooters()
    {
        $scooters = scooter::select()
                            ->get();
        return view('scooters')
                ->with('scooters',$scooters);
    }
    public function id_verify(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $stripe = new \Stripe\StripeClient('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');

        // In the route handler for /create-verification-session:
        // Authenticate your user

        // Create the session
            $verification_session = $stripe->identity->verificationSessions->create([
                'type' => 'document',
              ]);

        $user = Auth::user();
        $user->stripe_status = $verification_session->id;
        $user->save();
        // Return only the client secret to the frontend.
        return json_encode($verification_session);
    }
    public function check_verify()
    {
        $user = Auth::user();
        $stripe = new \Stripe\StripeClient('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');
        $session = $stripe->identity->verificationSessions->retrieve(
            $user->stripe_status
        );
        if($session->status == 'verified'){
            $user->stripe_status = $session->status;
            $user->save();
        }
        elseif($session->status == 'processing'){
            $user->save();
        }
        elseif($session->status == 'requires_input'){
            $user->stripe_url = $session->url;
            $user->save();
        }
        elseif($session->status == 'canceled'){
            $user->stripe_status = 'no';
            $user->save();
        }
        return back();
    }
    public function clicked_stripe_url(Request $request)
    {
        $user = Auth::user();
        $user->stripe_url = '';
        $user->save();
    }
    public function create_checkout(Request $request)
    {
        
        $user = Auth::user();
        $stripe = new \Stripe\StripeClient('sk_test_TcxAHEwTT1NLP2UzkOFsTwsS00XWB0wC2p');
        if(substr($user->customer_id, 0, 4) != 'cus_'){
            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                    'name' => 'Pre Pay for Scooter Rent',
                    ],
                    'unit_amount' => $request->amount,
                ],
                'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'https://rent.havencoliving.com/checkout_success/'.Auth::user()->id,
                'cancel_url' => 'https://rent.havencoliving.com/checkout_cancel/'.Auth::user()->id,
            ]);
          }else{
            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                    'name' => 'Pre Pay for Scooter Rent',
                    ],
                    'unit_amount' => $request->amount,
                ],
                'quantity' => 1,
                ]],
                'customer' =>  $user->customer_id,
                'mode' => 'payment',
                'success_url' => 'https://rent.havencoliving.com/checkout_success/'.Auth::user()->id,
                'cancel_url' => 'https://rent.havencoliving.com/checkout_cancel/'.Auth::user()->id,
            ]);
          }
          $user->customer_id = $session->id;
          $user->pbalance = $request->amount;
          $user->save();
          return redirect()->away($session->url);
    }
    public function rent_scooter($id)
    {
        $user = Auth::user();
        if(($user->scooter_id == ''|| $user->scooter_id == '0') && floatval($user->balance) >= 5){
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
            $scooter = scooter::select()->where('id',$id)->first();
            $scooter->rent_status = "no";
            $scooter->save();
            $user->scooter_id = $scooter->id;
            $user->open_code = $pin->pin;
            $user->save();
        }
        return redirect('/home');
    }
}
