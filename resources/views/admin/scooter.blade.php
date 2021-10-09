@extends('admin.layout.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('jsPostApp')
    <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
		    $('select[name=DataTables_Table_0_length]').show();
            $('.datatable-badges').DataTable({
                columnDefs: [{
                    width: '15%',
                    targets: [0]
                }, {
                    width: '10%',
                    targets: [1]
                }, {
                    width: '10%',
                    targets: [2]
                }, {
                    width: '25%',
                    targets: [3]
                }, {
                    width: '20%',
                    targets: [4]
                }, {
                    width: '20%',
                    targets: [5]
                },{
                    width: 'auto',
                    targets: [6]
                }]
            });
            $('#open_addscooter').click(function(){
                $('#div_addscooter').show();
            })
            $('.open_editscooter').click(function(){
                $('#edit_name').val($(this).next().val());
                $('#edit_rent_status').val($(this).next().next().val());
                $('#edit_price1').val($(this).next().next().next().val());
                $('#edit_price2').val($(this).next().next().next().next().val());
                $('#edit_id').val($(this).next().next().next().next().next().val());
                $('#div_editscooter').show();
            })
                
            $('.filestyle1').on('change',function(e){
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onloadend =function(){
                    $('#image1').show();
                    $('#image1')
                            .attr('width','300')
                            .attr('height','300')
                            .attr('src',reader.result);  
                }
                reader.readAsDataURL(file);    
            });
            $('.filestyle2').on('change',function(e){
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onloadend =function(){
                    $('#image2').show();
                    $('#image2')
                            .attr('width','300')
                            .attr('height','300')
                            .attr('src',reader.result);    
                }
                reader.readAsDataURL(file);    
            });
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    <div class="row" id="div_addscooter" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Add Scooter Info</h5>
                    <form  action="{{ url('/admin/addscooter') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="name" name="name" class="validate" required>
                                <label for="name" class="active">Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="rent_status" name="rent_status" class="validate" required>
                                <label for="rent_status" class="active">Rent Status</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="price1" name="price1" class="validate" required>
                                <label for="price1" class="active">Price for Start</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="price2" name="price2" class="validate" required>
                                <label for="price2" class="active">Price For Additional</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6 file-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input class="filestyle margin images filestyle1" data-input="false" type="file" name="image" data-buttonText="Upload Logo" data-size="sm" data-badge="false">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" >
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <div style="text-align:center">
                                    <img class="images" id="image1" src="#" alt="Your Logo" style="display:none"/>
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
    <div class="row" id="div_editscooter" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Edit Scooter Info</h5>
                    <form  action="{{ url('/admin/editscooter') }}" method="POST"   enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="edit_id" class="validate" required>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="edit_name" name="edit_name" class="validate" required>
                                <label for="edit_name" class="active">Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="edit_rent_status" name="edit_rent_status" class="validate" required>
                                <label for="edit_rent_status" class="active">Rent Status</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="edit_price1" name="edit_price1" class="validate" required>
                                <label for="edit_price1" class="active">Price for Start</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="edit_price2" name="edit_price2" class="validate" required>
                                <label for="edit_price2" class="active">Price For Additional</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6 file-field">
                                <div class="btn">
                                    <span>New File</span>
                                    <input class="filestyle margin images filestyle2" data-input="false" type="file" name="image" data-buttonText="Upload Logo" data-size="sm" data-badge="false">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" >
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <div style="text-align:center">
                                    <img class="images" id="image2" src="#" alt="Your Logo" style="display:none"/>
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
                        <h5 class="content-headline">Driver Info Table</h5>
                    </div>

                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_addscooter"  data-position="bottom" data-delay="50" data-tooltip="Create new driver"><i class="material-icons">add</i></a>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price for Start One Hour </th>
                                    <th>Price for Additional Hours</th>
                                    <th>Photo</th>
                                    <th>Rent Status</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scooters as $scooter)
                                        <tr>
                                            <td>{{$scooter->name }}</td>
                                            <td>{{$scooter->price1}}</td>
                                            <td>{{$scooter->price2}}</td>
                                            <td><img style="width:100px;Height:100px;"src="{{ asset('upload/scooter') }}/{{$scooter->filename}}"></td>
                                            <td>{{$scooter->rent_status }}</td>
                                            <td>{{Carbon\Carbon::parse($scooter->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating wornging-bg open_editscooter" href="#"  id="">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <input type="hidden" value="{{$scooter->name}}">
                                                    <input type="hidden" value="{{$scooter->rent_status}}">
                                                    <input type="hidden" value="{{$scooter->price1}}">
                                                    <input type="hidden" value="{{$scooter->price2}}">
                                                    <input type="hidden" value="{{$scooter->id}}">
                                                </div>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/delscooter/'.$scooter->id)}}">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
