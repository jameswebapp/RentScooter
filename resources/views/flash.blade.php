@if(session()->has('flash_message'))
	<div class="animated alert-flash {{ session('flash_class') }} valign-wrapper pos-relative">
        @if(session('flash_message_level')!='')
        	<strong>{{ ucwords(session('flash_message_level')) }}!</strong> {{ session('flash_message') }}
        @else
        	{{ session('flash_message') }}
        @endif
        <a href="#" class="close-flash"><i class="material-icons right primary-text">close</i></a>
    </div>    
@endif