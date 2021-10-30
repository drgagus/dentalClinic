@extends ('../layouts/dentalclinic')


@section('title', 'Kasir')


@section('navigation')
@include ('kasir/navigation')
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
              <div class="col-lg-6">
                    <table class="table table-hover">
                          <tr class="">
                              <th class="">#</th><th class="">Tindakan</th><th class="">Harga</th>
                          </tr>
                          <?php $jasa=0 ;?>
                          @foreach ($dentaltreatments as $dentaltreatment)
                          <?php $jasa=$jasa+$dentaltreatment->cost->harga; ?>
                          <tr class="">
                              <td class="">#</td><td class="">{{$dentaltreatment->cost->tindakan}}</td><td class="">Rp. {{number_format($dentaltreatment->cost->harga, 0, ",", ".")}},-</td>
                          </tr>
                          @endforeach
                          <tr class="">
                              <th class="">Total</th><th class=""></th><th class="">Rp. {{number_format($jasa, 0, ",", ".")}},-</th>
                          </tr>
                    </table>
              </div>
              <div class="col-lg-6">
                    <table class="table table-hover">
                          <tr class="">
                              <th class="">#</th><th class="">Obat</th><th class="">Jumlah</th><th class="">Harga</th>
                          </tr>
                          <?php $obat=0 ;?>
                          @foreach ($medicinerecords as $medicinerecord)
                          <?php 
                          $obat = $obat+($medicinerecord->jumlah * $medicinerecord->medicine->harga)
                          ?>
                          <tr class="">
                              <td class="">#</td><td class="">{{$medicinerecord->medicine->obat}}</td><td class="">{{$medicinerecord->jumlah ?? '-'}}</td><td class="">Rp. {{number_format($medicinerecord->jumlah * $medicinerecord->medicine->harga, 0, ",", ".")}},-</td>
                          </tr>
                          @endforeach
                          <tr class="">
                              <th class="">Total</th><th class=""></th><th class=""></th><th class="">Rp. {{number_format($obat, 0, ",", ".")}},-</th>
                          </tr>
                    </table>
              </div>   
          </div>

          <div class="row">
                <div class="col-lg-3">
                    <div class="font-weight-bold bg-warning text-danger p-2">
                        Total Tagihan Rp. {{number_format($jasa+$obat, 0, ",", ".")}},-
                    </div>
                </div>
          </div>

          <form action="/kasir/pasien/{{$dentalrecord->id}}/edit" class="" method="post">
          @csrf 
          @method('patch')
              <div class="row mt-1">
                    <div class="col-lg-12">
                        <div class="text-right">
                              <button type="submit" class="btn btn-primary">BAYAR</button>
                        </div>
                    </div>
              </div>
          </form>

      </div>
    </div>
       
        </div>
    </div>
</div>

@endsection