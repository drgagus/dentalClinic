@extends ('../layouts/dentalclinic')


@section('title', 'CEO')


@section('navigation')
@include ('ceo/navigation')
@endsection



@section('content')
<div class="container">

    <div class="row mb-5">
        <div class="col-lg-12">
            <h3 class="">Bulan 
            @if ($bulan == '01' ) Januari @elseif($bulan == '02') Februari @elseif($bulan == '03') Maret @elseif($bulan == '04') April @elseif($bulan == '05') Mei @elseif($bulan == '06') Juni @elseif($bulan == '07') Juli @elseif($bulan == '08') Agustus @elseif($bulan == '09') September @elseif($bulan == '10') Oktober @elseif($bulan == '11') November @elseif($bulan == '12') Desember @else @endif
            Tahun {{$tahun}}
            </h3>
            <table class="table table-hover table-responsive">
                <tr class="text-center">
                    <th class="">Tanggal<br>Kunjungan</th>
                    <th class="">Nama</th>
                    <th class="">Obat/Harga</th>
                </tr>
                <?php $harga = 0 ; ?>
                @foreach($dentalrecords as $dentalrecord)
                    @if(date(('Y'), strtotime($dentalrecord->tanggalkunjungan)) == $tahun )
                        @if(date(('m'), strtotime($dentalrecord->tanggalkunjungan)) == $bulan )
                            <tr class="">
                                <td class="">{{date(('d-m-Y'), strtotime($dentalrecord->tanggalkunjungan))}}</td>
                                <td class="">{{$dentalrecord->patient->nama}}</td>
                                <td class="" style="width:60%">
                                @foreach($dentalrecord->medicinerecords as $medicinerecord)
                                <?php $harga = $harga + $medicinerecord->harga ;?>
                                   <table class="" style="width:100%">
                                        <tr class="">
                                            <td class="" style="width:50%">{{$medicinerecord->medicine->obat}}</td>
                                            <td class="" style="width:50%">Rp. {{number_format($medicinerecord->harga, 0, ",", ".")}},-</td>
                                        </tr>
                                   </table>
                                @endforeach
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="">
                    <th class=""></th>
                    <th class=""></th>
                    <th class="">
                        <table class="" style="width:100%">
                            <tr class="bg-secondary text-white">
                                <td class="" style="width:50%">Total</td>
                                <td class="" style="width:50%">Rp. {{number_format($harga, 0, ",", ".")}},-</td>
                            </tr>
                        </table>
                    </th>
                    <th class=""></th>
                </tr>
            </table>
                
        </div>
    </div>
</div>
@endsection