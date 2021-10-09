@extends('layouts.app')

@section('freejs')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
    <section id="start_section" class="one dark cover">
        <div class="container">
            <header>
                <h2 class="alt">Hi {{Auth::User()->name}}! You can Simply Verify account with Stripe.</h2>
                <p>You can check Your Verify Status with button. (After click button wait few seconds...)</p>
            </header>
            <footer>
                <div>
                    @if (Auth::user()->stripe_status == 'no')
                        <a id="verify-button"  class="button scrolly btn" style="background:brown;">Start Verify</a>
                        <a id="refresh-button" style="display:none" href="{{ url('/check_verify/') }}" style="background:blueviolet;">Refresh Page</a>
                    @elseIf (Auth::user()->stripe_status == 'verified')
                        <a  class="button scrolly">Verified</a>
                        <a id="verify-button" style="display:none"></a>
                    @elseIf (Auth::user()->stripe_url != '')
                        <a id="continue_verify" href="#"  class="button scrolly btn"  style="background:brown;"> Continue Verify Your Account</a>
                        <a id="stripe_url" style="display:none"> {{Auth::user()->stripe_url}}</a>
                        <a id="verify-button" style="display:none"></a>
                    @else
                        <a href="{{ url('/check_verify/') }}"  class="button scrolly"  style="background:blueviolet;"> Check Your Account Verify Status </a>
                        <a id="verify-button" style="display:none"></a>
                    @endIf
                </div>
            </footer>
        </div>
    </section>

    <section class="three">
        <div class="container">

            <header>
                <h2>Sign Term</h2>
            </header>
            @if(Auth::User()->sign_terms != 'yes')
                <a href="https://www.signwell.com/new_doc/glbRsUhS1BpTqRld/" class="button scrolly" style="background:brown;">Sign Terms</a>
            @else
                <a  class="button scrolly" >Already Signed Terms</a>
            @endIf
            <p>You need sign Term before rent Scooter.</p>

        </div>
    </section>

    <section class="two">
        <div class="container">

            <header>
                <h2>Add Payment( Current Balance : ${{Auth::User()->balance}})</h2>
            </header>

            <p>You can add some PrePayment.</p>

            <form action="{{ url('/create_checkout') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6 col-12-mobile">
                        <article class="item">
                            <header>
                                <input type="radio" value="1000" name="amount" style="appearance: auto;    -webkit-appearance: auto;"> $10
                            </header>
                        </article>
                        <article class="item">
                            <header>
                                <input type="radio" value="2000" name="amount" style="appearance: auto;    -webkit-appearance: auto;"> $20
                            </header>
                        </article>
                    </div>
                    <div class="col-6 col-12-mobile">
                        <article class="item">
                            <header>
                                <input type="radio" value="3000" name="amount" style="appearance: auto;    -webkit-appearance: auto;"> $30
                            </header>
                        </article>
                        <article class="item">
                            <header>
                                <input type="radio" value="4000" name="amount" style="appearance: auto;    -webkit-appearance: auto;"> $40
                            </header>
                        </article>
                    </div>
                    <div class="col-12 col-12-mobile" style="text-align:center">
                        @if (floatval(Auth::User()->balance) >= 5)
                            <button type="submit">Checkout</button>
                        @else
                            <button type="submit"  style="background:brown;">Checkout</button>
                        @endIf
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="four">
        <div class="container">

            <header>
                <h2>Rent</h2>
            </header>

            <p>If you verify ID , Signed Term and have balance (>$5),  you can rent Scooter</p>
            @if (Auth::user()->stripe_status == 'verified' && Auth::User()->sign_terms == 'yes' && floatval(Auth::User()->balance) >= 5)
                <a href="{{ url('/scooters') }}"  class="button scrolly">Start Rent Scooter</a>
            @else
                <a href="#start_section" class="button scrolly" style="background:brown;">Please Full Verify Account</a>
            @endIf
        </div>
    </section>

    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align:center;">
                    <h5 class="modal-title">Refresh Modal</h5>
                </div>
                <div class="modal-body">
                    <p>Please wait few seconds.</br> "Verify Progress" is coming!!! </br> After done "Verify" Progress click "Refresh".</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('/check_verify/') }}"  class="button scrolly"  style="background:blueviolet;">Refresh</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/apikeys

    $(document).ready(function () {
        $('#continue_verify').click(function(){
            $.ajax({
                type:'post',
                url:'/clicked_stripe_url',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                }, success:function(response) {
                        window.open($('#stripe_url').text(), '_blank' );
                },
                failure:function(e){
                    console.log(e);
                }
            });
        })
        $(".btn").click(function(){
            $("#myModal").modal({backdrop: 'static', keyboard: false});
        });
    });

    var stripe = Stripe('pk_test_dzwuL3hzok0awvbgeLpFtQW3');
    var verifyButton = document.getElementById('verify-button');

    verifyButton.addEventListener('click', function() {
        // Get the VerificationSession client secret using the server-side
        // endpoint you created in step 3.
        $.ajax({
            type:'post',
            url:'/id_verify',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success:function(response) {           
                var session = JSON.parse(response);
                result = stripe.verifyIdentity(session.client_secret);
                if (result.error) {
                    alert(result.error.message);
                }
                else{
                    /*$.ajax({
                        type:'post',
                        url:'/create_webhook',
                        data: {
                            "id": $('#user_id').val(),
                            "client_secret": session.client_secret,
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        }, success:function(response) {
                            console.log(response);    
                        },
                        failure:function(e){
                            console.log(e);
                        }
                    });
                    $('.pending-text').show();*/
                }
            },
            failure:function(e){
                console.log(e);
            }
        });
    });
    
</script>
@endsection