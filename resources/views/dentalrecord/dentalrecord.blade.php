@extends ('../layouts/dentalclinic')

@section('title', 'Dental Record')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <div class="card border-primary mb-3 mt-3">
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
                <span class="">{{$usia['tahun']}} Tahun {{$usia['bulan']}} Bulan {{$usia['hari']}} Hari</span>
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
                Kunjungan
                <span class="">{{$dentalrecords->count()}}</span>
              </li>
            </ul>
            </div>
            </div>

          </div>
          <div class="card-body text-dark">

            <div class="row responsive">
                  <div class="col-lg-12 p-0">
                
                      <table border="2" class="table">
                      <tr class="bg-dark text-white text-center">
                          <th class="">Tanggal<br>Kunjungan</th>
                          <th class="">Tindakan</th>
                          <th class="">Obat</th>
                          <th class="">Informed<br>Consent</th>
                          <th class="">Dokter Gigi</th>
                      </tr>
                          @foreach ($dentalrecords as $dentalrecord)
                            <tr class="">
                                    <td class="">{{date(('d M Y'), strtotime($dentalrecord->tanggalkunjungan))}}</td>
                                    <!-- <td class="">TD: {{$dentalrecord->tekanandarah ?? '-'}}mmHg<br>RR: {{$dentalrecord->pernafasan ?? '-'}}/menit<br>HR: {{$dentalrecord->detakjantung ?? '-'}}/menit<br>Temp: {{$dentalrecord->suhutubuh ?? '-'}} Celcius<br>TB: {{$dentalrecord->tinggibadan ?? '-'}}cm<br>BB: {{$dentalrecord->beratbadan ?? '-'}}kg<br></td>
                                    <td class="">{{$dentalrecord->keluhanutama ?? ''}} {{$dentalrecord->pemeriksaansubjektif ?? ''}} {{$dentalrecord->pemeriksaanobjektif ?? ''}}</td> -->
                                    <td class="p-0">
                                        <table class="p-0 border" style="width:100%">
                                @foreach ($dentalrecord->dentaltreatments as $dentaltreatment)
                                    <tr class="border">
                                        <td class="border" style="width:15%">{{$dentaltreatment->gigi ?? '-'}}<br>-{{$dentaltreatment->diag->diagnosa ?? '-'}}-</td>
                                        <td class="text-justify border" style="width:65%">{!! nl2br($dentaltreatment->tindakan) ?? '-' !!}</td>
                                        <td class="text-center border" style="width:10%">
                                            @if ($dentaltreatment->imagebefore)
                                            <p class="" ><a href="{{asset('storage/'.$dentaltreatment->imagebefore)}}" class="" target=_blank><img src="{{asset('storage/'.$dentaltreatment->imagebefore)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                                            @else
                                            <p class="" ><img src="{{asset('storage/images/before/noimagebefore.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                                            @endif
                                            <label class="font-weight-bold">Before</label>
                                        </td>
                                        <td class="text-center border" style="width:10%">
                                            @if ($dentaltreatment->imageafter)
                                            <p class="" ><a href="{{asset('storage/'.$dentaltreatment->imageafter)}}" class="" target=_blank><img src="{{asset('storage/'.$dentaltreatment->imageafter)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                                            @else
                                            <p class="" ><img src="{{asset('storage/images/after/noimageafter.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                                            @endif
                                            <label class="font-weight-bold">After</label>
                                        </td>
                                    </tr>
                                @endforeach
                                        </table>
                                    </td>
                                    <td class="">{!! nl2br($dentalrecord->pengobatan) ?? '-' !!}</td>
                                    <td class="text-center">
                                        @if ($dentalrecord->informedconsent)
                                        <p class="" ><a href="{{asset('storage/'.$dentalrecord->informedconsent)}}" class="" target=_blank><img src="{{asset('storage/'.$dentalrecord->informedconsent)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                                        @else
                                        <p class="" ><img src="{{asset('storage/images/informedconsent/noimage.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                                        @endif
                                    </td>
                                    <td class="">{{$dentalrecord->user->name}}</td>
                            </tr>
                          @endforeach
                      </table>

                  </div>
            </div>

          </div>
        </div>
       
        </div>
    </div>
</div>

@endsection