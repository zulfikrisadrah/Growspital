@extends('layouts.main')

@section('content')

<div class="content mx-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mt-1">
                            <h1 class="judul">User List</h1>
                        </div>
                        <!-- ... (Bagian lain dari header) ... -->
                    </div>
                </div>
                <div class="insert mt-3 ml-4 mb-2">
                    <a href="/insert-obat" class="btn btn-success">Tambah Data</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 600px; width:auto; margin: 0 20px" >
                    <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Role</th>
                                <th>Spesialis</th>
                                <th>Email</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokters as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->user->name}}</td>
                                <td>{{$row->user->umur}}</td>
                                <td>{{$row->user->role}}</td>
                                <td>{{$row->spesialis}}</td>
                                <td>{{$row->user->email}}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-view-dokter"
                                        data-id="{{$row->id}}"
                                        data-name="{{$row->user->name}}"
                                        data-umur="{{$row->user->umur}}"
                                        data-role="{{$row->user->role}}"
                                        data-spesialis="{{$row->spesialis}}"
                                        data-email="{{$row->user->email}}"
                                        data-toggle="modal"
                                        data-target="#viewModalDokter">
                                        View
                                    </a>
                                    <a href="" class="btn btn-primary">Edit</a>
                                    <a href="/delete-obat/{{$row->id}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data {{$row->user->name}}?')">Delete</a>
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
<div class="modal" id="viewModalDokter" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detail-box mt-4 mx-4 mb-4">
                    <table class="table table-bordered">
                        <tr>
                            <td>ID</td>
                            <td id="modal-dokter-id"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td id="modal-dokter-name"></td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td id="modal-dokter-umur"></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td id="modal-dokter-role"></td>
                        </tr>
                        <tr>
                            <td>Spesialis</td>
                            <td id="modal-dokter-spesialis"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="modal-dokter-email"></td>
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
        $('.btn-view-dokter').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var umur = $(this).data('umur');
            var role = $(this).data('role');
            var spesialis = $(this).data('spesialis');
            var email = $(this).data('email');

            $('#modal-dokter-id').text(id);
            $('#modal-dokter-name').text(name);
            $('#modal-dokter-umur').text(umur);
            $('#modal-dokter-role').text(role);
            $('#modal-dokter-spesialis').text(spesialis);
            $('#modal-dokter-email').text(email);
        });
    });
</script>

@endsection
