@extends('layouts.main')

@section('content')

<div class="content" >
    <div class="col-6" style="margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col md mt-1">
                        <h1 class="judul">Profile User</h1>
                    </div>
                    <div class="mt-1">
                        @if (auth()->user()->hasRole('dokter'))
                            <td>
                                <div class="btn-group">
                                <a type="button" class="btn btn-primary" href="{{route('setBertugas')}}">Bertugas</a>
                                <a type="button" class="btn btn-default" href="{{route('setTidakBertugas')}}">Tidak Bertugas</a>
                                </div>
                            </td>
                        @endif
                    </div>
                </div>
            </div>
            <div class="detail-box mt-4 mx-4 mb-4">
                <table class="table table-bordered">
                    <tr>
                        <td>User ID</td>
                        <td>{{ auth()->user()->id }}</td>
                    </tr>
                    @if (auth()->user()->hasRole('dokter'))
                    <tr>
                        <td>Dokter ID</td>
                        <td>{{ auth()->user()->dokter->id }}</td>
                    </tr>
                    <tr>
                    @endif
                    @if (auth()->user()->hasRole('apoteker'))
                    <tr>
                        <td>Apoteker ID</td>
                        <td>{{ auth()->user()->apoteker->id }}</td>
                    </tr>
                    <tr>
                    @endif
                    @if (auth()->user()->hasRole('pasien'))
                    <tr>
                        <td>Pasien ID</td>
                        <td>{{ auth()->user()->pasien->id }}</td>
                    </tr>
                    <tr>
                    @endif
                        <td>Nama</td>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>{{ auth()->user()->umur }}</td>
                    </tr>
                    <tr>
                        <td>Peran</td>
                        <td>{{ auth()->user()->role }}</td>
                    </tr>
                    @if (auth()->user()->hasRole('dokter'))
                    <tr>
                        <td>Spesialis</td>
                        <td>{{ auth()->user()->dokter->spesialis }}</td>
                    </tr>                     
                    @endif
                    <tr>
                        <td>Username</td>
                        <td>{{ auth()->user()->username }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>

@endsection
