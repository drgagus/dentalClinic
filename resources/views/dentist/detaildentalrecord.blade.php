@extends ('../layouts/dentalclinic')


@section('title', 'Dentist')


@section('navigation')
@include ('dentist/navigation')
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <div class="card border-primary mb-3">
      <div class="card-header p-0">
<div class="row">
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nama
    <span class="">{{$patient->nama}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Umur
    <span class="">{{$dentalrecord->usiatahun}} Tahun {{$dentalrecord->usiabulan}} Bulan {{$dentalrecord->usiahari}} Hari</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Jenis Kelamin
    <span class="">{{$patient->jeniskelamin}}</span>
  </li>
</ul>
</div>
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nomor Rekam Medik
    <span class="">{{$patient->nomorrekammedis}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Alamat
    <span class="">{{$patient->alamat ?? '-'}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Tanggal Kunjungan
    <span class="">{{date(('d M Y'), strtotime($dentalrecord->tanggalkunjungan))}}</span>
  </li>
</ul>
</div>
</div>

      </div>
      <div class="card-body text-dark">

      <div class="row">
      <div class="col-lg-12 p-0 text-right">
        <a class="btn btn-sm btn-primary" href="/dentalrecord/{{$patient->id}}" target=_blank>DentalRecord</a>
        <!-- <a class="btn btn-sm btn-primary" href="/poligigi/odontogram/create/{{$patient->id}}">Odontogram</a> -->
      </div>
      </div>

        <div class="row">
        <div class="col-lg-12 border">
            <label class="font-weight-bold" for="keluhanutama">Keluhan Utama</label>
            <p class="">{{$dentalrecord->keluhanutama ?? '-'}}</p>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-2 border">
            <label class="font-weight-bold" for="tinggibadan" name="tinggibadan">Tinggi Badan</label>
            <p class="">{{$dentalrecord->tinggibadan ?? '-'}} cm</p>
        </div>
        <div class="col-lg-2 border">
            <label class="font-weight-bold" for="beratbadan">Berat Badan</label>
            <p class="">{{$dentalrecord->beratbadan ?? '-'}} Kg</p>
        </div>
        <div class="col-lg-2 border">
            <label class="font-weight-bold" for="tekanandarah" name="tekanandarah">Tekanan Darah</label>
            <p class="">{{$dentalrecord->tekanandarah ?? '-'}}mm/Hg</p>
        </div>
        <div class="col-lg-2 border">
            <label class="font-weight-bold" for="pernafasan">Pernafasan</label>
            <p class="">{{$dentalrecord->pernafasan ?? '-'}}/menit</p>
        </div>
        <div class="col-lg-2 border">
            <label class="font-weight-bold" for="detakjantung">Detak Jantung</label>
            <p class="">{{$dentalrecord->detakjantung ?? '-'}}/menit</p>
        </div>
        <div class="col-lg-2 border">
            <label class="font-weight-bold" for="suhutubuh">Suhu Tubuh</label>
            <p class="">{{$dentalrecord->suhutubuh ?? '-'}}Celcius</p>
        </div>
        </div>

        <div class="row">
          <div class="col-lg-6 border">
                <label class="font-weight-bold" for="pemeriksaansubjektif">Pemeriksaan Subjektif</label>
                <p class="">{!! nl2br($dentalrecord->pemeriksaansubjektif) ?? '-' !!}</p>
          </div>
          <div class="col-lg-6 border">
              <label class="font-weight-bold" for="pemeriksaanobjektif">Pemeriksaan Objektif</label>
              <p class="">{!! nl2br($dentalrecord->pemeriksaanobjektif) ?? '-' !!}</p>
          </div>
        </div>

        <div class="row">
        <div class="col-lg-12 border">
              <label class="font-weight-bold" for="diagnosa">Diagnosa</label>
              <p class="">{!! nl2br($dentalrecord->diagnosa) ?? '-' !!}</p>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-3 border">
              <label class="font-weight-bold @error('informedconsent') text-danger @enderror" for="informedconsent">Informed Consent</label>
              @if ($dentalrecord->informedconsent)
              <p class="" ><a href="{{asset('storage/'.$dentalrecord->informedconsent)}}" class="" target=_blank><img src="{{asset('storage/'.$dentalrecord->informedconsent)}}" alt="" class="" style="width:100px;height:100px"></a></p>
              @else
              <p class="" ><img src="{{asset('storage/images/informedconsent/noimage.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
              @endif
        </div>
        <div class="col-lg-9 border">
              <label class="font-weight-bold" for="pengobatan">Obat</label>
                <p class="">{!! nl2br($dentalrecord->pengobatan) ?? '-' !!}</p>
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
                            <td class="text-right d-flex">
                                <!-- ----hapus----- -->
                                <button type="button" class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#exampleModal{{$dentaltreatment->id}}">
                                hapus
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$dentaltreatment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Dental Treatment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/dentist/dentaltreatment/{{$dentaltreatment->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <div class="row">
                                        <div class="col-lg-12">
                                          <table class="text-left" style="width:100%">
                                            <tr class="">
                                              <td class="">Gigi</td><td class="">:</td><td class="">{{$dentaltreatment->gigi}}</td>
                                            <tr class="">
                                              <td class="">Diagnosa</td><td class="">:</td><td class="">{{$dentaltreatment->diag->diagnosa}}</td>
                                            </tr>
                                            <tr class="">
                                              <td class="">Tindakan</td><td class="">:</td><td class=""><textarea name="" id="" style="width:100%" rows="6" class="">{{$dentaltreatment->tindakan ?? '-'}}</textarea></td>
                                            </tr>
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
                                <a href="/dentist/dentaltreatment/{{$dentaltreatment->id}}/edit#home" class="btn btn-sm btn-primary">EDIT</a>
                            </td>
                        </tr>
                  </table>
              </div>
          @endforeach
        </div>
      </div>
  </div>

      </div>
      <div class="card-footer bg-transparent border-success text-right">
<!-- ----hapus----- -->
          <button type="button" class="btn btn-danger mr-1" data-toggle="modal" data-target="#exampleModal{{$dentalrecord->id}}">hapus</button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$dentalrecord->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Hapus Dental Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                <div class="modal-body">
                   <form action="/dentist/pasien/{{$dentalrecord->id}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="row text-left">
                        <div class="col-lg-12">
                              Yakin Hapus ?
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
          <a href="/dentist/pasien/{{$dentalrecord->id}}/edit" class="btn btn-primary">EDIT</a>
      </div>
    </div>
       
        </div>
    </div>
</div>

@endsection