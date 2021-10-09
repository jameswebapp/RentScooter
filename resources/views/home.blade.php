@extends('layouts.app')

@section('freejs')
@endsection
@section('content')
<section id="" class="one dark cover">
    <div class="container">
        <header>
            <h2 class="alt">Your Account Status</h2>
            <p>Please check your balance,Rented scooter name,....</p>
        </header>
        <footer>
        </footer>
    </div>
</section>


<section class="three">
    <div class="container">
        <header>
            <h2></h2>
        </header>
        <div class="row">
            <div class="col-md-12">
                <h2>Balance</h2> <h3>${{Auth::User()->balance}}</h3>
            </div>
            @if(Auth::User()->scooter_id != '' && Auth::User()->scooter_id != '0' )
                @if(Auth::User()->open_code != '')
                <div class="col-md-6">
                    <h4>Generated keybox Open Code for "Start use Scooter"</h4> {{Auth::User()->open_code}}
                </div>
                @elseif(Auth::User()->close_code != '')
                <div class="col-md-6">
                    <h4>Generated keybox Open Code for "End use Scooter"</h4> {{Auth::User()->open_code}}
                </div>
                @endif
                <div class="col-md-6">
                    <h4>"{{$scooter->name}}" Scooter Rent Time</h4> {{Auth::User()->start_time}}
                </div>
                <div class="col-md-6">
                    <h4>Price to start (includes 1st hour))</h4> {{$scooter->price1}} </br>
                </div>
                <div class="col-md-6">
                    <h4>Price ech additional Hours</h4> {{$scooter->price2}} 
                </div>
            @else
                <div class="col-md-12">
                    <h3>Please run Scooter</h3>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
@section('js')

<script type="text/javascript">
    setTimeout(doStuff, 5000);
    function doStuff() {
    console.log("hello!");
    setTimeout(doStuff, 5000);
    }
</script>
@endsection