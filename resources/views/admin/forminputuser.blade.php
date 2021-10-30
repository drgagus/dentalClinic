@extends ('../layouts/dentalclinic')


@section('title', 'Admin')


@section('navigation')
@include ('admin/navigation')
@endsection



@section('content')
<div class="container">
        <div class="row">
            <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Tambah User</div>

                <div class="card-body">
                    <form method="POST" action="/admin/user">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jabatan" class="col-md-4 col-form-label text-md-right">Posisi</label>
                            <div class="col-md-6">
                            <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" autofocus>
                                <option  value="" >--pilih posisi--</option>
                                <option  {{ old('jabatan') === 'dokter gigi' ? 'selected':'' }} value="dokter gigi" >Dokter Gigi</option>
                                <option  {{ old('jabatan') === 'perawat gigi' ? 'selected':'' }} value="perawat gigi" >Perawat Gigi</option>
                                <option  {{ old('jabatan') === 'perawat' ? 'selected':'' }} value="perawat" >Perawat</option>
                                <option  {{ old('jabatan') === 'bidan' ? 'selected':'' }} value="bidan" >Bidan</option>
                                <option  {{ old('jabatan') === 'analis kesehatan' ? 'selected':'' }} value="analis kesehatan" >Analis Kesehatan</option>
                                <option {{ old('jabatan') === 'apoteker' ? 'selected':'' }}  value="apoteker" >Apoteker</option>
                                <option  {{ old('jabatan') === 'non-medis' ? 'selected':'' }} value="non-medis" >Non-medis</option>
                                <option  {{ old('jabatan') === 'akuntan' ? 'selected':'' }} value="akuntan" >Akuntan</option>
                            </select>

                                @error('jabatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Hak Akses</label>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="pendaftaran" id="pendaftaran" {{ old('pendaftaran') === 1 ? 'checked':'' }}  value=1>
                                    <label class="form-check-label" for="pendaftaran">Pendaftaran</label>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan" id="pemeriksaan" {{ old('pemeriksaan') === 1 ? 'checked':'' }}  value=1>
                                    <label class="form-check-label" for="pemeriksaan">Pemeriksaan</label>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="dentist" id="dentist" {{ old('dentist') === 1 ? 'checked':'' }}  value=1>
                                    <label class="form-check-label" for="dentist">Dental Room</label>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="apotek" id="apotek" {{ old('apotek') === 1 ? 'checked':'' }}  value=1>
                                    <label class="form-check-label" for="apotek">Apotek</label>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="kasir" id="kasir" {{ old('kasir') === 1 ? 'checked':'' }}  value=1>
                                    <label class="form-check-label" for="kasir">Kasir</label>
                                </div><br>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    INPUT
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