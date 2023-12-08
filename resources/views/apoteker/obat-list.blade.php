@extends('layouts.main')

@section('content')

<div class="content mx-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <h1 class="judul">Obat List</h1>
                        </div>
                        <div class="col-md-2 mt-2">
                            <div class="form-group">
                                <select name="tipe_filter" id="tipeFilter" class="form-control" >
                                    <option value="">Semua Tipe</option>
                                    <option value="keras">Keras</option>
                                    <option value="biasa">Biasa</option>
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
                    <a href="/insert-obat" class="btn btn-success">Tambah Data</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive pt-0" style="height: 600px; width:auto; margin: 0 20px" >
                    <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Tipe</th>
                                <th>Stok</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obats as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->deskripsi}}</td>
                                <td>{{$row->tipe}}</td>
                                <td>{{$row->stok}}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-view"
                                        data-id="{{$row->id}}"
                                        data-name="{{$row->name}}"
                                        data-deskripsi="{{$row->deskripsi}}"
                                        data-tipe="{{$row->tipe}}"
                                        data-stok="{{$row->stok}}"
                                        data-toggle="modal"
                                        data-target="#viewModal">
                                        View
                                    </a>
                                    <a href="/obat-edit/{{$row->id}}" class="btn btn-primary">Edit</a>
                                    <a href="/delete-obat/{{$row->id}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data {{$row->name}}?')">Delete</a>
                                </td>
                            </tr>
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
                <h5 class="modal-title">Detail Obat</h5>
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
                            <td style="">Deskripsi</td>
                            <td id="modal-deskripsi"></td>
                        </tr>
                        <tr>
                            <td>Tipe</td>
                            <td id="modal-tipe"></td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td id="modal-stok"></td>
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
        $('input[name="table_search"], select[name="tipe_filter"]').on('input change', function () {
            var searchTerm = $('input[name="table_search"]').val().toLowerCase();
            var tipeFilter = $('select[name="tipe_filter"]').val().toLowerCase();

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
            var deskripsi = $(this).data('deskripsi');
            var tipe = $(this).data('tipe');
            var stok = $(this).data('stok');

            $('#modal-id').text(id);
            $('#modal-name').text(name);
            $('#modal-deskripsi').text(deskripsi);
            $('#modal-tipe').text(tipe);
            $('#modal-stok').text(stok);
        });
    });
</script>

@endsection