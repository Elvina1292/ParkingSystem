@extends('parkings.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12" style="text-align: center">
            <div>
                <h2>Parking System - Elvina</h2>
            </div>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a href="javascript:void(0)" class="btn btn-success mb-2" id="new-parking" data-toggle="modal">New
                    parking</a>
                <a href="{{ URL::to('/parking/pdf') }}" class="btn btn-primary" id="print-parking" >Print PDF</a>
            </div>
        </div>
    </div>
    <br/>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p id="msg">{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Kode Tiket</th>
            <th>Jenis Kendaraan</th>
            <th>Plat No</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Durasi</th>
            <th>Tarif Parkir</th>
            <th>Aksi</th>
        </tr>

        @foreach ($parkings as $parking)

            <tr id="parking_id{{ $parking->kode_tiket }}">
                <td>{{ $parking->kode_tiket }}</td>
                <td>{{ $parking->jenis_kendaraan }}</td>
                <td>{{ $parking->plat_no }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($parking->created_at))}}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($parking->updated_at))}}</td>
                <td>{{ $parking->durasi}}</td>
                <td>Rp. {{ $parking->tarif}}</td>
                <td>
                    <a class="btn btn-info" id="show-parking" data-toggle="modal"
                       data-id="{{ $parking->kode_tiket }}">Show</a>
                    <a class="btn btn-success" id="edit-parking" data-toggle="modal"
                       data-id="{{ $parking->kode_tiket }}">Edit </a>
                    <form action=" {{ route('parkings.destroy', $parking->id) }}" method="POST">
                       <meta name="csrf-token" content="{{ csrf_token() }}">
                       <a id="delete-parking" data-id="{{ $parking->id }}" class="btn btn-danger delete-user">Delete</a>
                    </form>
                </td>
            </tr>
        @endforeach
            <tr>
                <td colspan="8">
                   Record Count : {{ $parkings->count()}}
                </td>    
            </tr>

    </table>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="{{ $parkings->previousPageUrl() }}">Previous</a></li>
        <li class="page-item"><a class="page-link" href="{{ $parkings->nextPageUrl() }}">Next</a></li>
    </ul>
    <!-- Add and Edit parking modal -->
    <div class="modal fade" id="crud-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="parkingCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form name="parkForm" action="{{ route('parkings.store') }}" method="POST">
                        <input type="hidden" name="parking_id" id="parking_id">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Jenis Kendaraan:</strong>
                                    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control"
                                            onchange="validate()">
                                        <option value="">--Pilih--</option>
                                        <option value="Mobil">Mobil</option>
                                        <option value="Motor">Motor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Plat No:</strong>
                                    <div class="row">
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <input type="text" name="plat_no_1" id="plat_no_1" class="form-control"
                                                   onchange="validate()" onkeypress="validate()">

                                              
                                            @if($errors->has('plat_no_1'))
                                                <div class="text-danger">
                                                    {{ $errors->first('plat_no_1')}}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4">
                                            <input type="text" name="plat_no_2" id="plat_no_2" class="form-control"
                                                   onchange="validate()" onkeypress="validate()">
                                            @if($errors->has('plat_no_2'))
                                                <div class="text-danger">
                                                    {{ $errors->first('plat_no_2')}}
                                                </div>
                                            @endif
                                        </div>
                                        <p id="plat_no_2_msg"></p>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <input type="text" name="plat_no_3" id="plat_no_3" class="form-control"
                                                   onchange="validate()" onkeypress="validate()">
                                            @if($errors->has('plat_no_3'))
                                                <div class="text-danger">
                                                    {{ $errors->first('plat_no_3')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Jam Masuk:</strong>
                                    <input type="text" name="created_at" id="created_at"
                                           value="{{\Carbon\Carbon::now('Asia/Jakarta')}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Jam Keluar:</strong>
                                    <input type="datetime-local" name="updated_at" id="updated_at" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>
                                    Submit
                                </button>
                                <a href="{{ route('parkings.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Show parking modal -->
    <div class="modal fade" id="crud-modal-show" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="parkingCrudModal-show"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-2 col-sm-2 col-md-2"></div>
                        <div class="col-xs-10 col-sm-10 col-md-10 ">
                            @if(isset($parking->kode_tiket))

                                <table>
                                    <tr>
                                        <td><strong>Kode Tiket:</strong></td>
                                        <td>{{$parking->kode_tiket}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Kendaraan:</strong></td>
                                        <td>{{$parking->jenis_kendaraan}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Plat No:</strong></td>
                                        <td>{{$parking->plat_no}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jam Masuk:</strong></td>
                                        <td>{{$parking->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jam Keluar:</strong></td>
                                        <td>{{$parking->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: right "><a
                                                href="{{ route('parkings.index') }}" class="btn btn-danger">OK</a></td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    error = false

    function validate() {
        if (document.parkForm.jenis_kendaraan.value !== '' && document.parkForm.plat_no_1.value !== '' && document.parkForm.plat_no_2.value !== '' && document.parkForm.plat_no_3.value !== '')
                document.parkForm.btnsave.disabled = false
        else
            document.parkForm.btnsave.disabled = true
    }
</script>
