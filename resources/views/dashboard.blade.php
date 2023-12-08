@extends('layouts.main')

@section('content')
<div class="content mx-5">
        <div class="col-8" style="margin:0 auto;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            @if(auth()->user()->hasRole('admin'))
                                <h1 class="judul">Dokter Yang Bertugas</h1>
                            @endif
                            @if(auth()->user()->hasRole('dokter'))
                                <h1 class="judul">Pasien Terbaru</h1>
                            @endif
                            @if(auth()->user()->hasRole('pasien'))
                                <h1 class="judul">Riwayat Medis Terbaru</h1>
                            @endif
                            @if(auth()->user()->hasRole('apoteker'))
                                <h1 class="judul">Obat Terlaris</h1>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="dashboard mt-3 ml-4 mb-2 mr-3">
                    @if(auth()->user()->hasRole('admin'))
                    <div class="card-body table-responsive p-0" style="height: 600px; width:auto; margin: 0 20px" >
                        <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    {{-- <th>Peran</th> --}}
                                    <th>Spesialis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1
                                @endphp
                                @foreach($dokterBertugas as $dokters)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$dokters->name}}</td>
                                    {{-- <td>{{$dokters->role}}</td> --}}
                                    <td>{{$dokters->dokter->spesialis}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(auth()->user()->hasRole('dokter'))
                        <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">    
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Berobat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($pasien->sortByDesc(function($patient) {
                                    return optional($patient->medicalRecord->sortByDesc('tgl_berobat')->first())->tgl_berobat;
                                })->take(5) as $row)
                                    <tr>
                                        <td style="vertical-align: middle">{{$no++}}</td>
                                        <td style="vertical-align: middle">{{$row->user->name}}</td>
                                        <td> {{$row->tgl_berobat}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if(auth()->user()->hasRole('pasien'))
                        <div class="dashboard mt-3 ml-4 mb-2 mr-3">
                            <div class="card-body table-responsive p-0" style="height: 600px; width:auto; margin: 0 20px" >
                                <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Nama Dokter</th>
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
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ $appointment->dokter->user->name }}</td>
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
                    @endif
                    @if(auth()->user()->hasRole('apoteker'))
                        <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no= 1;
                                @endphp
                                @foreach($obats as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->deskripsi}}</td>
                                    <td>{{$row->tipe}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>  
            </div>
        </div>
</div>
@endsection