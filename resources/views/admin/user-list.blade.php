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
                        <div class="col-md-2 mt-2">
                            <div class="form-group">
                                <select name="role_filter" id="roleFilter" class="form-control" >
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="dokter">Dokter</option>
                                    <option value="apoteker">Apoteker</option>
                                    <option value="pasien">Pasien</option>
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
                    <a href="/insert-user" class="btn btn-success">Tambah Data</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 600px; width:auto; margin: 0 20px" >
                    <table class="table table-head-fixed table-bordered text-nowrap mt-2 mb-4" id="example1" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Peran</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Email</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->role}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->umur}} Tahun</td>
                                <td>{{$row->email}}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-view"
                                        data-id="{{$row->id}}"
                                        data-name="{{$row->name}}"
                                        data-umur="{{$row->umur}}"
                                        data-role="{{$row->role}}"
                                        data-email="{{$row->email}}"
                                        data-toggle="modal"
                                        data-target="#viewModalUser">
                                        View
                                    </a>
                                    <a href="/user-edit/{{$row->id}}" class="btn btn-primary">Edit</a>
                                    <a href="/delete-user/{{$row->id}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data {{$row->name}}?')">Delete</a>
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

<!-- Modal untuk User -->
<div class="modal" id="viewModalUser" tabindex="-1" role="dialog">
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
                            <td id="modal-user-id"></td>
                        </tr>
                        <tr id="modal-user-role-specific" style="display: none;">
                            <td id="modal-user-role-specific-label"></td>
                            <td id="modal-user-role-specific-value"></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td id="modal-user-name"></td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td id="modal-user-umur"></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td id="modal-user-role"></td>
                        </tr>
                        <tr id="modal-user-spesialis-specific" style="display: none;">
                            <td id="modal-user-spesialis-specific-label"></td>
                            <td id="modal-user-spesialis-specific-value"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="modal-user-email"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-success" href="" id="jadwalkanPemeriksaanBtn">Jadwalkan Pemeriksaan</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('input[name="table_search"], select[name="role_filter"]').on('input change', function () {
            var searchTerm = $('input[name="table_search"]').val().toLowerCase();
            var roleFilter = $('select[name="role_filter"]').val().toLowerCase();

            $('#example1 tbody tr').filter(function () {
                var rowText = $(this).text().toLowerCase();
                var hasMatch = true;

                if (searchTerm && rowText.indexOf(searchTerm) === -1) {
                    hasMatch = false;
                }

                if (roleFilter && $(this).find('td:eq(1)').text().toLowerCase() !== roleFilter) {
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
            var umur = $(this).data('umur') + " Tahun";
            var role = $(this).data('role');
            var email = $(this).data('email');

            $('#modal-user-id').text(id);
            $('#modal-user-name').text(name);
            $('#modal-user-umur').text(umur);
            $('#modal-user-role').text(role);
            $('#modal-user-email').text(email);
            $('#jadwalkanPemeriksaanBtn').hide();

            if (role === 'dokter') {
                var dokter = getDokterById(id);
                $('#modal-user-role-specific-label').text('Dokter ID');
                $('#modal-user-role-specific-value').text(dokter.id);
                $('#modal-user-role-specific').show();
                $('#modal-user-spesialis-specific-label').text('Spesialis');
                $('#modal-user-spesialis-specific-value').text(dokter.spesialis);
                $('#modal-user-spesialis-specific').show();
            } else if (role === 'apoteker') {
                var apoteker = getApotekerById(id);
                $('#modal-user-role-specific-label').text('Apoteker ID');
                $('#modal-user-role-specific-value').text(apoteker.id);
                $('#modal-user-role-specific').show();
            } else if (role === 'pasien') {
                var pasien = getPasienById(id);
                $('#modal-user-role-specific-label').text('Pasien ID');
                $('#modal-user-role-specific-value').text(pasien.id);
                $('#modal-user-role-specific').show();
                $('#jadwalkanPemeriksaanBtn').show();
                $('#jadwalkanPemeriksaanBtn').attr('href', '/atur-pasien/' + id);
            } else {
                $('#modal-user-role-specific').hide();
            }
        });
    });

    function getDokterById(userId) {
        return {!! $dokters !!}.find(dokter => dokter.user_id === userId);
    }

    function getApotekerById(userId) {
        return {!! $apotekers !!}.find(apoteker => apoteker.user_id === userId);
    }

    function getPasienById(userId) {
        return {!! $pasiens !!}.find(pasien => pasien.user_id === userId);
    }
</script>

@endsection