@extends ('../layouts/dentalclinic')


@section('title', 'pendaftaran')


@section('navigation')
@include ('pendaftaran/navigation')
@endsection



@section('content')

<div class="container">

<div class="row mb-1 mt-1">
    <div class="col-lg-6">
        <a href="/pendaftaran/pasien/{{$patient->id}}" class="btn btn-sm btn-primary">DETAIL</a>
        <a href="/pendaftaran/pasien/{{$patient->id}}/edit" class="btn btn-sm btn-warning">EDIT</a>
<!-- ----awal hapus----- -->

            <button type="button" class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#exampleModal">
            HAPUS
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/pendaftaran/pasien/{{$patient->id}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="row">
                    <div class="col-lg-12">
                    <table class="">
                        <tr class="">
                            <td class="">Nomor Rekam Medis</td><td class="">:</td><td class="">{{$patient -> nomorrekammedis}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Nomor NIK</td><td class="">:</td><td class="">{{$patient -> nik}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Nama</td><td class="">:</td><td class="">{{$patient -> nama}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Jenis Kelamin</td><td class="">:</td><td class="">{{$patient -> jeniskelamin}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Alamat</td><td class="">:</td><td class="">{{$patient -> alamat ?? '-'}}</td>
                        </tr>
                    </table>
                    </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
<!-- ----akhir hapus----- -->
    </div>
</div>

    <div class="row">

        <div class="col-lg-6">  
        <form action="/pendaftaran/pasien/{{$patient->id}}/edit" method="post">
        @csrf 
        @method('patch')

  <div class="form-group">
    <label class="font-weight-bold" for="nomorrekammedis">Nomor Rekam Medis</label>
    <input type="text" class="form-control" id="nomorrekammedis" name="nomorrekammedis" value="{{ old('nomorrekammedis') ?? $patient->nomorrekammedis}}">
    @error('nomorrekammedis')
    <div class="text text-danger">Nomor rekam medis harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="nik">NIK</label>
    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') ?? $patient->nik}}">
    @error('nik')
    <div class="text text-danger">NIK harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="nama">Nama</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') ?? $patient->nama}}">
    @error('nama')
    <div class="text text-danger">Nama lengkap harus diidi</div>
    @enderror
  </div>
  

  <div class="form-group">
    <label class="font-weight-bold" for="jeniskelamin">Jenis Kelamin</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="jeniskelamin" id="laki-laki" {{ old('jeniskelamin')  ?? $patient->jeniskelamin === "Laki-laki" ? 'checked':'' }} value="Laki-laki">
      <label class="form-check-label" for="laki-laki">
        Laki-laki
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="jeniskelamin" id="perempuan" {{ old('jeniskelamin')  ?? $patient->jeniskelamin === "Perempuan" ? 'checked':'' }} value="Perempuan">
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
    <input type="text" class="form-control" id="tempatlahir"  name="tempatlahir" value="{{ old('tempatlahir') ?? $patient->tempatlahir}}">
    @error('tempatlahir')
    <div class="text text-danger">Tempat lahir harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="tanggallahir">Tanggal Lahir</label>
    <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" value={{ old('tanggallahir') ?? $patient->tanggallahir}}>
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
      <option {{ old('agama') ?? $patient->agama  === "Islam" ? 'selected':'' }} value="Islam">Islam</option>
      <option {{ old('agama') ?? $patient->agama  === "Kristen" ? 'selected':'' }} value="Kristen">Kristen</option>
      <option {{ old('agama') ?? $patient->agama  === "Katolik" ? 'selected':'' }} value="Katolik">Katolik</option>
      <option {{ old('agama') ?? $patient->agama  === "Hindu" ? 'selected':'' }} value="Hindu">Hindu</option>
      <option {{ old('agama') ?? $patient->agama  === "Budha" ? 'selected':'' }} value="Budha">Budha</option>
      <option {{ old('agama') ?? $patient->agama  === "Kong Hu Chu" ? 'selected':'' }} value="Kong Hu Chu">Kong Hu Chu</option>
    </select>
    @error('agama')
    <div class="text text-danger">Agama harus dipilih</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="pendidikan">Pendidikan</label>
    <select class="form-control" id="pendidikan" name="pendidikan">
        <option value="">pilih pendidikan</option>
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "Belum/Tidak Tamat SD/Sederajat" ? 'selected':'' }} value="Belum/Tidak Tamat SD/Sederajat">Belum/Tidak Tamat SD/Sederajat</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "SD/MI/Sederajat" ? 'selected':'' }} value="SD/MI/Sederajat">SD/MI/Sederajat</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "SLTP/MTs/Sederajat" ? 'selected':'' }} value="SLTP/MTs/Sederajat">SLTP/MTs/Sederajat</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "SLTA/SMK/MA/Sederajat" ? 'selected':'' }} value="SLTA/SMK/MA/Sederajat">SLTA/SMK/MA/Sederajat</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "Diploma I/II" ? 'selected':'' }} value="Diploma I/II">Diploma I/II</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "Diploma III/Sarjana Muda" ? 'selected':'' }} value="Diploma III/Sarjana Muda">Diploma III/Sarjana Muda</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "Diploma IV/S1" ? 'selected':'' }} value="Diploma IV/S1">Diploma IV/S1</option> 
        <option {{ old('pendidikan') ?? $patient->pendidikan  === "S2/S3" ? 'selected':'' }} value="S2/S3">S2/S3</option> 
    </select>
    @error('pendidikan')
    <div class="text text-danger">Pendidikan harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="pekerjaan">Pekerjaan</label>
    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') ?? $patient->pekerjaan}}">
    @error('pekerjaan')
    <div class="text text-danger">Pekerjaan harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="alamat">Alamat</label>
    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') ?? $patient->alamat}}">
    @error('alamat')
    <div class="text text-danger">Alamat harus diisi</div>
    @enderror
  </div>

  <div class="form-group">
    <label class="font-weight-bold" for="nomortelepon">Nomor Telepon</label>
    <input type="text" class="form-control" id="nomortelepon" name="nomortelepon" value="{{ old('nomortelepon') ?? $patient->nomortelepon}}">
    @error('nomortelepon')
    <div class="text text-danger">Nomor telepon harus diisi</div>
    @enderror
  </div>

    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">EDIT</button>
    </div>

</form>

  </div>
 
    </div>
</div>

@endsection