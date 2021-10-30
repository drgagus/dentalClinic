@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route('account') }}" class="text-decoration-none text-dark font-weight-bold">{{Auth::user()->name}}</a></div>

                <div class="card-body">
                    <form method="POST" action="/akun/password">
                        @csrf
                        @method('patch')

                        @if (session('status'))
                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                    <div class="alert alert-danger">
                                        {{ session('status') }}
                                    </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">Password Lama</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="{{ old('old_password') }}" required  autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password Baru</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi Password Baru</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required >
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    UBAH
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
