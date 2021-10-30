@extends ('../layouts/dentalclinic')


@section('title', 'Apotek')


@section('navigation')
@include ('apotek/navigation')
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
      <div class="col-lg-12 p-0">
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active border border-info border-bottom-0" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Obat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link border border-info border-bottom-0" id="medicine-tab" data-toggle="tab" href="#medicine" role="tab" aria-controls="medicine" aria-selected="true">Resep Dokter</a>
          </li>
          @foreach ($dentaltreatments as $dentaltreatment)
          <li class="nav-item">
              <a class="nav-link border border-info border-bottom-0" id="profile-tab{{$dentaltreatment->id}}" data-toggle="tab" href="#profile{{$dentaltreatment->id}}" role="tab" aria-controls="profile" aria-selected="false">{{$dentaltreatment->gigi}}</a>
          </li>
          @endforeach
        </ul>

        <div class="tab-content border border-info bg-light" id="myTabContent">
          <div class="tab-pane fade show px-2 py-2 active" id="home" role="tabpanel" aria-labelledby="home-tab">

            <form action="/apotek/pasien" method="post">
            @csrf
            <input type="hidden" name="dentalrecordid" value="{{$dentalrecord->id}}">

              <div class="row">
                  <div class="col-lg-3">
                      @for ($i = 1; $i < 4; $i++)
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group d-flex">
                                      <div class="col-8 p-0">
                                      <select class="form-control mb-1" name="obat{{$i}}">
                                              <option value="">nama obat</option>
                                              @foreach ($medicines as $medicine)
                                              <option value="{{$medicine->id}}">{{$medicine->obat}}</option>
                                              @endforeach
                                      </select>
                                      </div>
                                      <div class="col-4">
                                      <input type="text" class="form-control  @error('jumlah'.$i) is-invalid @enderror" id="jumlahobat{{$i}}" name="jumlah{{$i}}"  Placeholder="jumlah" value="{{old('jumlah'.$i)}}">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endfor
                  </div>
                  <div class="col-lg-3">
                      @for ($i = 4; $i < 7; $i++)
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group d-flex">
                                      <div class="col-8 p-0">
                                      <select class="form-control mb-1" name="obat{{$i}}">
                                              <option value="">nama obat</option>
                                              @foreach ($medicines as $medicine)
                                              <option value={{$medicine->id}}>{{$medicine->obat}}</option>
                                              @endforeach
                                      </select>
                                      </div>
                                      <div class="col-4">
                                      <input type="text" class="form-control @error('jumlah'.$i) is-invalid @enderror" id="jumlahobat{{$i}}" name="jumlah{{$i}}"  Placeholder="jumlah" value="{{old('jumlah'.$i)}}">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endfor
                  </div>
              </div>

              <div class="row">
                  <div class="col-lg-6 text-right">
                      <button type="submit" class="btn btn-primary">INPUT</button>
                  </div>
              </div>
            </form>

          </div>
          <div class="tab-pane fade show px-2 py-2" id="medicine" role="tabpanel" aria-labelledby="medicine-tab">
              <div class="row">
                  <div class="col-lg-2">
                      {!! nl2br($dentalrecord->pengobatan) ?? '-' !!}
                  </div>
              </div>
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
                                            <p class="" ><a href="{{asset('storage/'.$dentaltreatment->imagebefore)}}" class="" target=_blank><img src="{{asset('storage/'.$dentaltreatment->imagebefore)}}" alt="" class="" style="width:100px;height:100px"></a></p>
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
                  </table>
              </div>
          @endforeach
        </div>
      </div>
  </div>

      </div>
    </div>
       
        </div>
    </div>
</div>

@endsection