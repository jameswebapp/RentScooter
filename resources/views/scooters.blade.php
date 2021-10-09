@extends('layouts.app')

@section('freejs')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="scooter row">
                    @foreach ($scooters as $scooter)
                        <div class="col-md-6">
                            <div class="one-scooter">
                                <div class="scooter-photo">
                                    <img src="{{ asset('upload/scooter') }}/{{$scooter->filename}}">
                                </div>
                                <div class="scooter-details">
                                    <div class="scooter-name">
                                        @if ( Auth::User()->scooter_id != '' && Auth::User()->scooter_id != '0')
                                        <a class="button scrolly" style="background:brown;" >{{$scooter->name}}</a>
                                        @elseif ($scooter->rent_status == 'no')
                                        <a class="button scrolly" style="background:brown;" >{{$scooter->name}}</a>
                                        @else
                                        <a href="{{ url('/rent_scooter/'.$scooter->id) }}"  class="button scrolly" >{{$scooter->name}}</a>
                                        @endIf
                                    </div>
                                    <div class="scooter-prices">
                                        <h6>${{$scooter->price1}} to start (includes 1st hour)</h6>
                                        <h6>${{$scooter->price2}} ech additional Hours</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endForeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
</script>
@endsection