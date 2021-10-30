@extends ('../layouts/dentalclinic')


@section('title', 'pemeriksaan')


@section('navigation')
@include ('pemeriksaan/navigation')
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <div class="card border-dark mb-3">
      <div class="card-header p-0">
<div class="row">
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nama
    <span class="">{{$customer->patient->nama}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Usia
    <span class="">{{$customer->usia}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Jenis Kelamin
    <span class="">{{$customer->patient->jeniskelamin}}</span>
  </li>
</ul>
</div>
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nomor Rekam Medis
    <span class="">{{$customer->patient->nomorrekammedis}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Alamat
    <span class="">{{$customer->patient->alamat ?? '-'}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Tanggal
    <span class="">{{date('d M Y')}}</span>
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
            <label class="font-weight-bold">Keluhan Utama</label>
            <p class="">{{$customer->keluhanutama ?? '-'}}</p>
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-2">
            <label class="font-weight-bold">Tinggi Badan</label>
            <p class="">{{$customer->tinggibadan ?? '-'}} cm</p>
        </div>
        <div class="col-lg-2">
            <label class="font-weight-bold">Berat Badan</label>
            <p class="">{{$customer->beratbadan ?? '-'}} Kg</p>
        </div>
        <div class="col-lg-2">
            <label class="font-weight-bold">Tekanan Darah</label>
            <p class="">{{$customer->tekanandarah ?? '-'}} mm/Hg</p>
        </div>
        <div class="col-lg-2">
            <label class="font-weight-bold">Pernafasan</label>
            <p class="">{{$customer->pernafasan ?? '-'}}/menit</p>
        </div>
        <div class="col-lg-2">
            <label class="font-weight-bold">Detak Jantung</label>
            <p class="">{{$customer->detakjantung ?? '-'}}/menit</p>
        </div>
        <div class="col-lg-2">
            <label class="font-weight-bold">Suhu Tubuh</label>
            <p class="">{{$customer->suhutubuh ?? '-'}} Celcius</p>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-3">
              <label class="font-weight-bold" for="user_id">Dokter Gigi</label>
              <p class="">{{$customer->user->name}}</p>
        </div>
        </div>

      </div>
    </div>
       
        </div>
    </div>
</div>

@endsection