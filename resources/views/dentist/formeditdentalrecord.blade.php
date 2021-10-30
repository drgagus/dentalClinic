@extends ('../layouts/dentalclinic')


@section('title', 'Dentist')


@section('navigation')
@include ('dentist/navigation')
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <form action="/dentist/pasien/{{$dentalrecord->id}}/edit" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

        <div class="card border-primary mb-3">
      <div class="card-header p-0">
<div class="row">
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nama
    <span class="btn btn-outline-dark">{{$patient->nama}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Umur
    <span class="btn btn-outline-dark">{{$dentalrecord->usiatahun}} Tahun {{$dentalrecord->usiabulan}} Bulan {{$dentalrecord->usiahari}} Hari</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Jenis Kelamin
    <span class="btn btn-outline-dark">{{$patient->jeniskelamin}}</span>
  </li>
</ul>
</div>
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nomor Rekam Medik
    <span class="btn btn-outline-dark">{{$patient->nomorrekammedis}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Alamat
    <span class="btn btn-outline-dark">{{$patient->alamat ?? '-'}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Tanggal Kunjungan
    <span class="btn btn-dark">{{date('d M Y', strtotime($dentalrecord->tanggalkunjungan))}}</span>
  </li>
</ul>
</div>
</div>

      </div>
      <div class="card-body text-dark">


        <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
            <label class="font-weight-bold" for="keluhanutama">Keluhan Utama</label>
            <input type="text" class="form-control @error('keluhanutama') is-invalid @enderror" id="keluhanutama" name="keluhanutama" value="{{ old('keluhanutama') ?? $dentalrecord->keluhanutama}}">
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <label class="font-weight-bold" for="tinggibadan" name="tinggibadan">Tinggi Badan (cm)</label>
            <input type="text" class="form-control @error('tinggibadan') is-invalid @enderror" id="tinggibadan" name="tinggibadan" value="{{ old('tinggibadan') ?? $dentalrecord->tinggibadan}}">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label class="font-weight-bold" for="beratbadan">Berat Badan (Kg)</label>
            <input type="text" class="form-control @error('beratbadan') is-invalid @enderror" id="beratbadan" name="beratbadan" value="{{ old('beratbadan') ?? $dentalrecord->beratbadan}}">
          </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="tekanandarah" name="tekanandarah">Tekanan Darah (mm/Hg)</label>
            <input type="text" class="form-control @error('tekanandarah') is-invalid @enderror" id="tekanandarah" name="tekanandarah" value="{{ old('tekanandarah') ?? $dentalrecord->tekanandarah}}">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="pernafasan">Pernafasan (/menit)</label>
            <input type="text" class="form-control @error('pernafasan') is-invalid @enderror" id="pernafasan" name="pernafasan" value="{{ old('pernafasan') ?? $dentalrecord->pernafasan}}">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="detakjantung">Detak Jantung (/menit)</label>
            <input type="text" class="form-control @error('detakjantung') is-invalid @enderror" id="detakjantung" name="detakjantung" value="{{ old('detakjantung') ?? $dentalrecord->detakjantung}}">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="suhutubuh">Suhu Tubuh (celcius)</label>
            <input type="text" class="form-control @error('suhutubuh') is-invalid @enderror" id="suhutubuh" name="suhutubuh" value="{{ old('suhutubuh') ?? $dentalrecord->suhutubuh}}">
          </div>
        </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
              <div class="form-group">
                <label class="font-weight-bold" for="pemeriksaansubjektif">Pemeriksaan Subjektif</label>
                <textarea class="form-control @error('pemeriksaansubjektif') is-invalid @enderror" id="pemeriksaansubjektif" rows="3" name="pemeriksaansubjektif">{{ old('pemeriksaansubjektif') ?? $dentalrecord->pemeriksaansubjektif }}</textarea>
              </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="font-weight-bold" for="pemeriksaanobjektif">Pemeriksaan Objektif</label>
              <textarea class="form-control @error('pemeriksaanobjektif') is-invalid @enderror" id="pemeriksaanobjektif" rows="3" name="pemeriksaanobjektif">{{ old('pemeriksaanobjektif') ??$dentalrecord->pemeriksaanobjektif }}</textarea>
            </div>
          </div>
        </div>

        <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
              <label class="font-weight-bold" for="diagnosa">Diagnosa</label>
              <textarea class="form-control @error('diagnosa') is-invalid @enderror" id="diagnosa" rows="3" name="diagnosa">{{ old('diagnosa') ?? $dentalrecord->diagnosa }}</textarea>
            </div>
        </div>
        <div class="col-lg-6">
                <div class="form-group">
                <label class="font-weight-bold" for="pengobatan">Pengobatan</label>
                  <textarea class="form-control @error('pengobatan') is-invalid @enderror" id="pengobatan" rows="3" name="pengobatan">{{ old('pengobatan') ?? $dentalrecord->pengobatan }}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                @if ($dentalrecord->informedconsent)
                <p class="" ><a href="{{asset('storage/'.$dentalrecord->informedconsent)}}" class="" target=_blank><img src="{{asset('storage/'.$dentalrecord->informedconsent)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                @else
                <p class="" ><img src="{{asset('storage/images/informedconsent/noimage.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label class="font-weight-bold @error('informedconsent') text-danger @enderror" for="informedconsent">Informed Consent</label>
                  <input type="file" name="informedconsent" class="form-control-file" id="informedconsent">
                </div>
            </div>
        </div>

        
        <div class="row">
          <div class="col-lg-12 p-0">
            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active border border-info border-bottom-0" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dental Treatment</a>
              </li>
              @foreach ($dentaltreatments as $dentaltreatment)
              <li class="nav-item">
                  <a class="nav-link border border-info border-bottom-0" id="profile-tab{{$dentaltreatment->id}}" data-toggle="tab" href="#profile{{$dentaltreatment->id}}" role="tab" aria-controls="profile" aria-selected="false">{{$dentaltreatment->gigi}}</a>
              </li>
              @endforeach
            </ul>

            <div class="tab-content border border-info bg-light" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="height:200px">
              <a href="/dentist/dentaltreatment/create/{{$dentalrecord->id}}#home" class="btn btn-primary mx-2 my-2">+DentalTreatment</a>
              </div>
              @foreach ($dentaltreatments as $dentaltreatment)
                  <div class="tab-pane fade" id="profile{{$dentaltreatment->id}}" role="tabpanel" aria-labelledby="profile-tab{{$dentaltreatment->id}}">
                      <table class="p-0 border" style="width:100%">
                          <tr class="border">
                                <td class="border" style="width:15%">{{$dentaltreatment->gigi ?? '-'}}<br>-{{$dentaltreatment->diag->diagnosa ?? '-'}}-</td>
                                <td class="border" style="width:65%">
                                    <textarea name="" id="" style="width:100%" rows="6" class="border-none">{{$dentaltreatment->tindakan ?? '-'}}</textarea>
                                </td>
                                <td class="border text-center" style="width:10%">
                                                @if ($dentaltreatment->imagebefore)
                                                <p class="" >
                                                <a href="{{asset('storage/'.$dentaltreatment->imagebefore)}}" class="" target=_blank>
                                                <img src="{{asset('storage/'.$dentaltreatment->imagebefore)}}" alt="" class="" style="width:100px;height:100px">
                                                </a></p>
                                                @else
                                                <p class="" ><img src="{{asset('storage/images/before/noimagebefore.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                                                @endif
                                                <label class="font-weight-bold">Before</label>
                                </td>
                                <td class="border text-center" style="width:10%">
                                                @if ($dentaltreatment->imageafter)
                                                <p class="" ><a href="{{asset('storage/'.$dentaltreatment->imageafter)}}" class="" target=_blank><img src="{{asset('storage/'.$dentaltreatment->imageafter)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                                                @else
                                                <p class="" ><img src="{{asset('storage/images/after/noimageafter.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                                                @endif
                                                <label class="font-weight-bold">After</label>
                                </td>
                            </tr>
                            <tr class="">
                                <td colspan="2" class="">{{$dentaltreatment->cost->tindakan}} - Rp. {{number_format($dentaltreatment->cost->harga, 0, ",", ".")}},-</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                            </tr>
                      </table>
                  </div>
              @endforeach
            </div>
          </div>
      </div>
        

      </div>
      <div class="card-footer bg-transparent border-success text-right">
      <button type="submit" class="btn btn-primary">SIMPAN</button>
      </div>
    </div>
    </form>
       
        </div>
    </div>
</div>

@endsection