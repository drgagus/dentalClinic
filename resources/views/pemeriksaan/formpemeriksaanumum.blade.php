@extends ('../layouts/dentalclinic')


@section('title', 'pemeriksaan')


@section('navigation')
@include ('pemeriksaan/navigation')
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <form action="/pemeriksaan/pasien/{{$customer->id}}/edit" method="post">
            @csrf
            @method('patch')
        <div class="card border-dark mb-3">
      <div class="card-header">
<div class="row">
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nama
    <span class="btn btn-outline-dark">{{$customer->patient->nama}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Usia
    <span class="btn btn-outline-dark">{{$customer->usia}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Jenis Kelamin
    <span class="btn btn-outline-dark">{{$customer->patient->jeniskelamin}}</span>
  </li>
</ul>
</div>
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nomor Rekam Medis
    <span class="btn btn-outline-dark">{{$customer->patient->nomorrekammedis}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Alamat
    <span class="btn btn-outline-dark">{{$customer->patient->alamat ?? '-'}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Tanggal
    <span class="btn btn-dark">{{date('d M Y')}}</span>
  </li>
</ul>
</div>
</div>

      </div>
      <div class="card-body text-dark">

      <div class="row">
      <div class="col-lg-12">
        <h2 class="text-center">PEMERIKSAAN UMUM</h2>
      </div>
      </div>

        <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
            <label class="font-weight-bold" for="keluhanutama">Keluhan Utama</label>
            <input type="text" class="form-control" id="keluhanutama" name="keluhanutama" value="{{ old('keluhanutama') ?? $customer->keluhanutama}}">
            @error('keluhanutama')<label class="text text-danger">Keluhan utama harus diisi</label>@enderror
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <label class="font-weight-bold" for="tinggibadan" name="tinggibadan">Tinggi Badan (cm)</label>
            <input type="text" class="form-control" id="tinggibadan" name="tinggibadan" value="{{ old('tinggibadan') ?? $customer->tinggibadan}}">
            @error('tinggibadan')<label class="text text-danger">Tinggi badan harus diisi</label>@enderror
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label class="font-weight-bold" for="beratbadan">Berat Badan (Kg)</label>
            <input type="text" class="form-control" id="beratbadan" name="beratbadan" value="{{ old('beratbadan') ?? $customer->beratbadan}}">
            @error('beratbadan')<label class="text text-danger">Berat badan harus diisi</label>@enderror
          </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="tekanandarah" name="tekanandarah">Tekanan Darah (mm/Hg)</label>
            <input type="text" class="form-control" id="tekanandarah" name="tekanandarah" value="{{ old('tekanandarah') ?? $customer->tekanandarah}}">
            @error('tekanandarah')<label class="text text-danger">Tekanan darah harus diisi</label>@enderror
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="pernafasan">Pernafasan (/menit)</label>
            <input type="text" class="form-control" id="pernafasan" name="pernafasan" value="{{ old('pernafasan') ?? $customer->pernafasan}}">
            @error('pernafasan')<label class="text text-danger">Pernafasan harus diisi</label>@enderror
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="detakjantung">Detak Jantung (/menit)</label>
            <input type="text" class="form-control" id="detakjantung" name="detakjantung" value="{{ old('detakjantung') ?? $customer->detakjantung}}">
            @error('detakjantung')<label class="text text-danger">Detak jantung harus diisi</label>@enderror
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="suhutubuh">Suhu Tubuh(celcius)</label>
            <input type="text" class="form-control" id="suhutubuh" name="suhutubuh" value="{{ old('suhutubuh') ?? $customer->suhutubuh}}">
            @error('suhutubuh')<label class="text text-danger">Suhu tubuh harus diisi</label>@enderror
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
              <label class="font-weight-bold" for="user_id">Dokter Gigi</label>
              <select class="form-control" id="user_id" name="user_id">
                    <option value="">--pilih dokter gigi--</option>
                    @foreach ($users as $user)
                      <option {{ old('user_id') ?? $customer->user_id === $user->id ? 'selected':'' }} value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
              </select>
              @error('user_id')<label class="text text-danger">Dokter Gigi harus dipilih</label>@enderror
          </div>
        </div>
        </div>

      </div>
      <div class="card-footer bg-transparent border-success text-right">
      <button type="submit" class="btn btn-primary">
      @if ($customer->user_id)
      SIMPAN
      @else
      INPUT
      @endif
      </button>
      </div>
    </div>
    </form>
       
        </div>
    </div>
</div>

@endsection