@extends('layouts.main')

@section('content')
<div class="content mx-5">
        <div class="col-8" style="margin:0 auto;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <h1 class="judul">My Medical Record</h1>
                        </div>
                    </div>
                </div>
                <div class="dashboard mt-3 ml-4 mb-2 mr-3">
                    <div class="card-body table-responsive p-0" style="height: 600px; width:auto; margin: 0 20px" >
                        <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                            <thead>
                                @php
                                    $no =1;
                                @endphp
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Nama Dokter</th>
                                <th>Kategori</th>
                                <th>Keluhan</th>
                                <th>Tindakan</th>
                                <th>Nama Obat</th>
                                <th>Tanggal Berobat</th>
                            </thead>
                            <tbody>
                                @foreach($users as $row)
                                    @foreach ($row->pasien->appointment as $appointment)
                                        @if ($appointment->status == "Selesai"  && $appointment->pasien->id == auth()->user()->pasien->id)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $appointment->dokter->user->name }}</td>
                                                <td>{{ $appointment->pasien->kategori }}</td>
                                                <td>{{ $appointment->pasien->keluhan }}</td>
                                                <td>{{ $appointment->medicalrecord->tindakan }}</td>
                                                <td>{{ $appointment->medicalrecord->obat->name ?? '' }}</td>
                                                <td>{{ $appointment->medicalrecord->tgl_berobat }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
</div>
@endsection