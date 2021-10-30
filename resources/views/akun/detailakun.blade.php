@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">Pengaturan</div>
                <div class="card-body p-0">
                @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
                @endif
                <h5>
                <div class="row ml-3">
                    <div class="col-lg-6">
                        <table class="table">
                            <tr class="">
                                <td class="">Nama</td>
                                <td class="">:</td>
                                <td class=""><a href="/akun/name" class="text-decoration-none text-dark font-weight-bold">{{Auth::user()->name}}</a></td>
                            </tr>
                            <tr class="">
                                <td class="">Username</td>
                                <td class="">:</td>
                                <td class="">{{Auth::user()->username}}</td>
                            </tr>
                            <tr class="">
                                <td class="">Posisi</td>
                                <td class="">:</td>
                                <td class="">{{Auth::user()->jabatan}}</td>
                            </tr>
                            <tr class="">
                                <td class="">Password</td>
                                <td class="">:</td>
                                <td class="">*******</td>
                            </tr>
                        </table>
                    </div>
                </div>
               
                </h5>
                   
            <div class="card-footer bg-transparent border-success text-right">
                <a href="/akun/password" class="btn btn-primary">Ganti Password</a>
            </div>
            </div>

        </div>
    </div>
</div>
@endsection