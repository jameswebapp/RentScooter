@extends('admin.layout.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('jsPostApp')
    <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dashboard-permisionlist').DataTable({
            });
		$('select[name=dashboard-permisionlist_length]').show();
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    <div class="row">
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign primary-text">supervisor_account</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{ $data->adminCount }}</div>
                        <p>Administrators</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign secondary-text">person</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{ $data->usersCount }}</div>
                        <p>Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Tables --}}
    <div class="row">
        <div class="col s12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Users</span>
                    <div class="datatable-wrapper">
                        <table cellspacing="0" width="100%"
                            class="datatable-badges display cell-border dataTable"
                            id="dashboard-permisionlist">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Verify</th>
                                    <th>Terms</th>
                                    <th>Balance</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->user as $user)
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
@endsection
