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

              <a href="javascript:window.history.go(-1);" class="text-primary btn btn-sm btn-outline-primary">back</a>
                <div class="row">
                    <div class="col-lg-6">
                        <form action="/apotek/pasien/add" class="" method="post">
                        @csrf 
                        <input type="hidden" class="" name="dentalrecord_id" value={{$dentalrecord->id}}>
                            <table class="table table-hover border border-dark mt-1" style="width:100%">
                                    <tr class="bg-dark text-white">
                                        <th class="" style="width:10%">#</th>
                                        <th class="" style="width:70%">Nama Obat</th>
                                        <th class="" style="width:10%">Jumlah</th>
                                        <th class="" style="width:10%"></th>
                                    </tr>
                                    @foreach ($medicinerecords as $medicinerecord)
                                    <tr class="">
                                        <td class="">#</td>
                                        <td class="">{{$medicinerecord->medicine->obat}}</td>
                                        <td class="">{{$medicinerecord->jumlah ?? '-'}}</td>
                                        <td class=""></td>
                                    </tr>
                                    @endforeach
                                    <tr class="">
                                            <td class="py-1" style="width:10%">#</td>
                                            <td class="py-1" style="width:80%">
                                                <select class="form-control @error('obat') is-invalid @enderror" name="obat">
                                                <option value="">nama obat</option>
                                                    @foreach ($medicines as $medicine)
                                                    <option {{ old('obat') === $medicine->id ? 'selected':'' }} value="{{$medicine->id}}">{{$medicine->obat}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="py-1" style="width:10%">
                                                <input type="text" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{old('jumlah')}}">
                                            </td>
                                            <td class="">
                                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                            </td>
                                        </tr>
                            </table>
                        </form>
                    </div>
                </div>

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