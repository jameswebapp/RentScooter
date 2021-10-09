@extends('admin.layout.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('jsPostApp')
    <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable-badges').DataTable({
            });
		    $('select[name=DataTables_Table_0_length]').show();
        } );
        $('#open_adduser').click(function(){
            $('#div_adduser').show();
        })
        $('.open_edituser').click(function(){
            $('#edit_id').val($(this).next().val());
            if($(this).next().next().val() == 'verified'){
                $('#edit_rb1').prop("checked", true);
            }
            else if($(this).next().next().val() == 'no'){
                $('#edit_rb2').prop("checked", true);
            }
            else{
                $('#edit_rb5').prop("checked", true);
                $('#edit_rb5').val($(this).next().next().val());
            }
            if($(this).next().next().next().val() == 'yes'){
                $('#edit_rb3').prop("checked", true);
            }
            else{
                $('#edit_rb4').prop("checked", true);
            }
            $('#edit_balance').val($(this).next().next().next().next().val());
            $('#edit_name').val($(this).next().next().next().next().next().val());
            $('#div_edituser').show();
        })
    </script>
@endsection

@section('content')
<div class="main-container">
    <div class="row" id="div_adduser" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Edit Driver Info</h5>
                    <form  action="{{ url('/admin/adduser') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="name" name="name" class="validate" required>
                                <label for="name" class="active">Name</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="balance" name="balance" class="validate" required>
                                <label for="balance" class="active">Balance</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="email" name="email" class="validate" required>
                                <label for="email" class="active">Email</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="Password" name="password" class="validate" required>
                                <label for="Password" class="active">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <div class="row">
                                    <p class="col s12">
                                        <input type="radio" id="rb1" name="stripe_status" value="verified"/>
                                        <label for="rb1">Verified</label>
                                    </p>
                                    <p class="col s12">
                                        <input type="radio" id="rb2" name="stripe_status" value="no" checked="checked"/>
                                        <label for="rb2">No Verified</label>
                                    </p>
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <div class="row">
                                    <p class="col s12">
                                        <input type="radio" name="sign_terms" id="rb3" value="yes"/>
                                        <label for="rb3">Sign Terms</label>
                                    </p>
                                    <p class="col s12">
                                        <input type="radio" name="sign_terms" id="rb4" value="no"  checked="checked"/>
                                        <label for="rb4">Not Sign Terms</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 right-align">
                            <button class="btn waves-effect waves-set" type="submit" name="update_profile">Save<i class="material-icons right">save</i>
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="div_edituser" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Edit User Info</h5>
                    <form  action="{{ url('/admin/edituser') }}" method="POST">
                        @csrf
                        <input type="hidden" id="edit_id" name="edit_id" class="validate" required>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="edit_name" name="edit_name" class="validate" required>
                                <label for="edit_name" class="active">Name</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="edit_balance" name="edit_balance" class="validate" required>
                                <label for="edit_balance" class="active">Balance</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <div class="row">
                                    <p class="col s12">
                                        <input type="radio" id="edit_rb1" name="edit_stripe_status" value="verified"/>
                                        <label for="edit_rb1">Verified</label>
                                    </p>
                                    <p class="col s12">
                                        <input type="radio" id="edit_rb2" name="edit_stripe_status"  value="no"/>
                                        <label for="edit_rb2">No</label>
                                    </p>
                                    <p class="col s12">
                                        <input type="radio" id="edit_rb5" name="edit_stripe_status" />
                                        <label for="edit_rb5">Pending</label>
                                    </p>
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <div class="row">
                                    <p class="col s12">
                                        <input type="radio" name="edit_sign_terms" id="edit_rb3"  value="yes"/>
                                        <label for="edit_rb3">Sign Terms</label>
                                    </p>
                                    <p class="col s12">
                                        <input type="radio" name="edit_sign_terms" id="edit_rb4"  value="no"/>
                                        <label for="edit_rb4">Not Sign Terms</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 right-align">
                            <button class="btn waves-effect waves-set" type="submit" name="update_profile">Save<i class="material-icons right">save</i>
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- With Action-->
        <div class="col s12">
            <div class="card-panel">
                <div class="row box-title">
                    <div class="col s12">
                        <h5 class="content-headline">User Table</h5>
                    </div>

                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_adduser"  data-position="bottom" data-delay="50" data-tooltip="Create new User"><i class="material-icons">add</i></a>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border" style="text-align:center;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Verify</th>
                                        <th>Terms</th>
                                        <th>Balance</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>@if($user->stripe_status == 'no')
                                                No Verified
                                                @elseIf($user->stripe_status == 'verified')
                                                Verified
                                                @else
                                                Pending
                                                @endIf
                                            <td>{{ $user->sign_terms }}</td>
                                            <td>{{ $user->balance }}</td>
                                            <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating wornging-bg open_edituser" href="#"  id="">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <input type="hidden" value="{{$user->id}}">
                                                    <input type="hidden" value="{{$user->stripe_status}}">
                                                    <input type="hidden" value="{{$user->sign_terms}}">
                                                    <input type="hidden" value="{{$user->balance}}">
                                                    <input type="hidden" value="{{$user->name}}">
                                                </div>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/deluser/'.$user->id)}}">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
