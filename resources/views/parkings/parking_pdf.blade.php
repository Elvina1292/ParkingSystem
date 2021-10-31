@extends('parkings.layout')
@section('content')
	<center>
		<h>Parking Report</h5>
	</center>

	<table class='table table-bordered'>
		<thead>
	        <tr>
	            <th>Kode Tiket</th>
	            <th>Jenis Kendaraan</th>
	            <th>Plat No</th>
	            <th>Jam Masuk</th>
	            <th>Jam Keluar</th>
	            <th>Durasi</th>
	            <th>Tarif Parkir</th>
	        </tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach ($parkings as $parking)

            <tr id="parking_id{{ $parking->kode_tiket }}">
                <td>{{ $parking->kode_tiket }}</td>
                <td>{{ $parking->jenis_kendaraan }}</td>
                <td>{{ $parking->plat_no }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($parking->created_at))}}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($parking->updated_at))}}</td>
                <td>{{ $parking->durasi}}</td>
                <td>Rp. {{ $parking->tarif}}</td>
            </tr>
        @endforeach
		</tbody>
	</table>

@endsection