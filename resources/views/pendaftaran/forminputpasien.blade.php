@extends ('../layouts/dentalclinic')


@section('title', 'pendaftaran')


@section('navigation')
@include ('pendaftaran/navigation')
@endsection



@section('content')

<div class="container mt-3">
    <div class="row">

        <div class="col-lg-6">  
        <form action="/pendaftaran/pasien" method="post">
        @csrf 

  <div class="form-group">
    <label class="font-weight-bold" for="nomorrekammedis">Nomor Rekam Medis</label>
    <input type="text" class="form-control" id="nomorrekammedis" name="nomorrekammedis" value="{{ old('nomorrekammedis') }}">
    @error('nomorrekammedis')
    <div class="text text-danger">Nomor rekam medis harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="nik">NIK</label>
    <input type="text" class="form-control" id="nik"  name="nik" value="{{ old('nik') }}">
    @error('nik')
    <div class="text text-danger">NIK harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="nama">Nama</label>
    <input type="text" class="form-control" id="nama"  name="nama" value="{{ old('nama') }}">
    @error('nama')
    <div class="text text-danger">Nama harus diidi</div>
    @enderror
  </div>
  

  <div class="form-group">
    <label class="font-weight-bold" for="jeniskelamin">Jenis Kelamin</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="jeniskelamin" id="laki-laki" {{ old('jeniskelamin')  === "Laki-laki" ? 'checked':'' }} value="Laki-laki">
      <label class="form-check-label" for="laki-laki">
        Laki-laki
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="jeniskelamin" id="perempuan" {{ old('jeniskelamin')  === "Perempuan" ? 'checked':'' }} value="Perempuan">
      <label class="form-check-label" for="perempuan">
        Perempuan
      </label>
      @error('jeniskelamin')
    <div class="text text-danger">Jenis kelamin harus dipilih</div>
    @enderror
    </div>
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="tempatlahir">Tempat Lahir</label>
    <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="{{ old('tempatlahir') }}">
    @error('tempatlahir')
    <div class="text text-danger">Tempat lahir harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="tanggallahir">Tanggal Lahir</label>
    <input type="date" class="form-control" id="tanggallahir"  name="tanggallahir" value={{ old('tanggallahir') }}>
    @error('tanggallahir')
    <div class="text text-danger">Tanggal lahir harus diisi</div>
    @enderror
  </div>

  </div>
  <div class="col-lg-6">

  <div class="form-group">
    <label class="font-weight-bold" for="agama">Agama</label>
    <select class="form-control" id="agama" name="agama">
      <option value="">pilih agama</option>
      <option {{ old('agama')  === "Islam" ? 'selected':'' }} value="Islam">Islam</option>
      <option {{ old('agama')  === "Kristen" ? 'selected':'' }} value="Kristen">Kristen</option>
      <option {{ old('agama')  === "Katolik" ? 'selected':'' }} value="Katolik">Katolik</option>
      <option {{ old('agama')  === "Hindu" ? 'selected':'' }} value="Hindu">Hindu</option>
      <option {{ old('agama')  === "Budha" ? 'selected':'' }} value="Budha">Budha</option>
      <option {{ old('agama')  === "Kong Hu Chu" ? 'selected':'' }} value="Kong Hu Chu">Kong Hu Chu</option>
    </select>
    @error('agama')
    <div class="text text-danger">Agama harus dipilih</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="pendidikan">Pendidikan</label>
    <select class="form-control" id="pendidikan" name="pendidikan">
        <option value="">pilih pendidikan</option>
        <option {{ old('pendidikan')  === "Belum/Tidak Tamat SD/Sederajat" ? 'selected':'' }} value="Belum/Tidak Tamat SD/Sederajat">Belum/Tidak Tamat SD/Sederajat</option> 
        <option {{ old('pendidikan')  === "SD/MI/Sederajat" ? 'selected':'' }} value="SD/MI/Sederajat">SD/MI/Sederajat</option> 
        <option {{ old('pendidikan')  === "SLTP/MTs/Sederajat" ? 'selected':'' }} value="SLTP/MTs/Sederajat">SLTP/MTs/Sederajat</option> 
        <option {{ old('pendidikan')  === "SLTA/SMK/MA/Sederajat" ? 'selected':'' }} value="SLTA/SMK/MA/Sederajat">SLTA/SMK/MA/Sederajat</option> 
        <option {{ old('pendidikan')  === "Diploma I/II" ? 'selected':'' }} value="Diploma I/II">Diploma I/II</option> 
        <option {{ old('pendidikan')  === "Diploma III/Sarjana Muda" ? 'selected':'' }} value="Diploma III/Sarjana Muda">Diploma III/Sarjana Muda</option> 
        <option {{ old('pendidikan')  === "Diploma IV/S1" ? 'selected':'' }} value="Diploma IV/S1">Diploma IV/S1</option> 
        <option {{ old('pendidikan')  === "S2/S3" ? 'selected':'' }} value="S2/S3">S2/S3</option> 
    </select>
    @error('pendidikan')
    <div class="text text-danger">Pendidikan harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="pekerjaan">Pekerjaan</label>
    <input type="text" class="form-control" id="pekerjaan"  name="pekerjaan" value="{{ old('pekerjaan') }}">
    @error('pekerjaan')
    <div class="text text-danger">Pekerjaan harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="alamat">Alamat</label>
    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}">
    @error('alamat')
    <div class="text text-danger">Alamat harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="nomortelepon">Nomor Telepon</label>
    <input type="text" class="form-control" id="nomortelepon" name="nomortelepon" value="{{ old('nomortelepon') }}">
    @error('nomortelepon')
    <div class="text text-danger">Nomor telepon harus diisi</div>
    @enderror
  </div>

    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">INPUT</button>
    </div>

</form>

  </div>
 
    </div>
</div>

@endsection