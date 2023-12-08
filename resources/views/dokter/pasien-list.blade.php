@extends('layouts.main')

@section('content')

<div class="content mx-5">
    <div class="row" style="margin-bottom: 50px">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <h1 class="judul">Pasien List</h1>
                        </div>
                        <div class="col-md-2 mt-2">
                            <div class="form-group">
                                <select name="tipe_filter1" id="tipeFilter1" class="form-control" >
                                    <option value="">Semua Kategori</option>
                                    <option value="umum">Umum</option>
                                    <option value="gigi">Gigi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-2">
                            <div class="input-group input-group-sm" style="height: 38px">
                                <input type="search" name="table_search" class="form-control" placeholder="Search" aria-controls="example1" style="height: 38px; font-size:16px">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="insert mt-3 ml-4 mb-2">
                    <a href="insert-riwayat" class="btn btn-success">Tambah Data</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 600px; width:auto; margin: 0 20px" >
                    <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                        <thead>
                            @php
                                $no = 1;
                            @endphp
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Nama Dokter</th>
                                <th>Kategori</th>
                                {{-- <th>Tindakan</th>
                                <th>Obat</th> --}}
                                <th>Tanggal Berobat</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $row)
                                @if ($row->role === 'pasien' && $row->pasien->appointment->isNotEmpty())
                                    @foreach ($row->pasien->appointment as $appointment)
                                        @if ($appointment->status == "Selesai")
                                            <tr>
                                                <td>{{$row->pasien->id}}</td>
                                                <td>{{$row->name}}</td>
                                                @if ($appointment->dokter)
                                                    <td>{{$appointment->dokter->user->name}}</td>                                            
                                                @endif
                                                <td>{{$row->pasien->kategori}}</td>
                                                {{-- <td>{{$appointment->medicalrecord->tindakan }}</td>
                                                <td>
                                                    @if ($appointment->medicalrecord->obat)
                                                        {{ $appointment->medicalrecord->obat->name }}
                                                    @endif
                                                </td> --}}
                                                <td>{{$appointment->medicalrecord->tgl_berobat}}</td>
                                                <td class="text-center">
                                                    @if ($appointment->dokter)
                                                    <a href="#" class="btn btn-warning btn-view"
                                                                data-id="{{$appointment->pasien->id}}"
                                                                data-name="{{$row->name}}"
                                                                @if ($appointment->dokter)
                                                                    data-dokter="{{$appointment->dokter->user->name}}"
                                                                @endif
                                                                data-kategori="{{$row->pasien->kategori}}"
                                                                data-keluhan="{{$row->pasien->keluhan}}"
                                                                data-tindakan="{{$appointment->medicalrecord->tindakan}}"
                                                                data-obat="{{$appointment->medicalrecord->obat->name ?? ''}}"
                                                                data-tanggal="{{$appointment->medicalrecord->tgl_berobat}}"
                                                                data-toggle="modal"
                                                                data-target="#viewModal">
                                                                View
                                                            </a>
                                                        <a href="/edit-riwayat/{{$row->id}}" class="btn btn-primary">Edit</a>
                                                        <a href="/delete-pasiensss/{{$row->id}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data {{$row->name}}?')">Delete</a>
                                                    @endif
                                                </td>
                                            </tr>      
                                        @endif
                                    @endforeach
                                @endif                          
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <div class="col-8" style="margin: 0 auto">
            <div class="card">
                <div class="card-header">
                    <div class="row mx-2">
                        <div class="col-md-10 mt-1">
                            <h1 class="judul">Menunggu  Giliran Pemeriksaan</h1>
                        </div>
                        <div class="col-md-2 mt-2">
                            <div class="input-group input-group-sm" style="height: 38px">
                                <input type="search" name="table_search2" class="form-control" placeholder="Search" aria-controls="example2" style="height: 38px; font-size:16px">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-fdefault">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive pt-3" style="height: 600px; width:auto; margin: 0 20px" >
                    <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                        <thead>
                            @php
                                $no = 1;
                            @endphp
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Keluhan</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach($users as $row)
                                    @if ($row->role === 'pasien' && $row->pasien && $row->pasien->appointment && $row->pasien->appointment->isNotEmpty())
                                        @foreach ($row->pasien->appointment->where('status', 'Menunggu') as $appointment)
                                            @if ($row->pasien->kategori == auth()->user()->dokter->spesialis)
                                                <tr>
                                                    <td>{{ $row->pasien->id }}</td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->pasien->kategori }}</td>
                                                    <td>{{ $row->pasien->keluhan }}</td>
                                                    <td class="text-center">
                                                        <a href="insert-riwayat" class="btn btn-primary">Mulai Pemeriksaan</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="viewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Medical Records</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detail-box mt-4 mx-4 mb-4">
                    <table class="table table-bordered">
                        <tr>
                            <td>ID</td>
                            <td id="modal-id"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td id="modal-name"></td>
                        </tr>
                        <tr>
                            <td style="">Nama Dokter</td>
                            <td id="modal-dokter"></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td id="modal-kategori"></td>
                        </tr>
                        <tr>
                            <td>Keluhan</td>
                            <td id="modal-keluhan"></td>
                        </tr>
                        <tr>
                            <td>Tindakan</td>
                            <td id="modal-tindakan"></td>
                        </tr>
                        <tr>
                            <td>Obat</td>
                            <td id="modal-obat"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Berobat</td>
                            <td id="modal-tanggal"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('input[name="table_search"], select[name="tipe_filter1"]').on('input change', function () {
            var searchTerm = $('input[name="table_search"]').val().toLowerCase();
            var tipeFilter = $('select[name="tipe_filter1"]').val().toLowerCase();

            $('#example1 tbody tr').filter(function () {
                var rowText = $(this).text().toLowerCase();
                var hasMatch = true;

                if (searchTerm && rowText.indexOf(searchTerm) === -1) {
                    hasMatch = false;
                }

                if (tipeFilter && $(this).find('td:eq(3)').text().toLowerCase() !== tipeFilter) {
                    hasMatch = false;
                }

                $(this).toggle(hasMatch);
            });
        });

        $('input[name="table_search2"], select[name="tipe_filter1"]').on('input change', function () {
            var searchTerm = $('input[name="table_search2"]').val().toLowerCase();
            var tipeFilter = $('select[name="tipe_filter1"]').val().toLowerCase();

            $('#example1 tbody tr').filter(function () {
                var rowText = $(this).text().toLowerCase();
                var hasMatch = true;

                if (searchTerm && rowText.indexOf(searchTerm) === -1) {
                    hasMatch = false;
                }

                if (tipeFilter && $(this).find('td:eq(3)').text().toLowerCase() !== tipeFilter) {
                    hasMatch = false;
                }

                $(this).toggle(hasMatch);
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.btn-view').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var dokter = $(this).data('dokter');
            var kategori = $(this).data('kategori');
            var tindakan = $(this).data('tindakan');
            var keluhan = $(this).data('keluhan');
            var obat = $(this).data('obat');
            var tanggal = $(this).data('tanggal');

            $('#modal-id').text(id);
            $('#modal-name').text(name);
            $('#modal-dokter').text(dokter);
            $('#modal-kategori').text(kategori);
            $('#modal-keluhan').text(keluhan);
            $('#modal-tindakan').text(tindakan);
            $('#modal-obat').text(obat);
            $('#modal-tanggal').text(tanggal);
        });
    });
</script>

@endsection