@extends ('../layouts/dentalclinic')


@section('title', 'CEO')


@section('navigation')
@include ('ceo/navigation')
@endsection



@section('content')
<div class="container">

    <div class="row mb-5">
        <div class="col-lg-12">
            <h3 class="">{{$user->name}}</h3>
            <h3 class="">Bulan 
            @if ($bulan == '01' ) Januari @elseif($bulan == '02') Februari @elseif($bulan == '03') Maret @elseif($bulan == '04') April @elseif($bulan == '05') Mei @elseif($bulan == '06') Juni @elseif($bulan == '07') Juli @elseif($bulan == '08') Agustus @elseif($bulan == '09') September @elseif($bulan == '10') Oktober @elseif($bulan == '11') November @elseif($bulan == '12') Desember @else @endif
            Tahun {{$tahun}}
            </h3>
            <table class="table table-hover table-responsive">
                <tr class="text-center">
                    <th class="">Tanggal<br>Kunjungan</th>
                    <th class="">Nama</th>
                    <th class="">Tindakan/Jasa</th>
                </tr>
                <?php $jasadokter = 0 ;?>
                @foreach($dentalrecords as $dentalrecord)
                    @if(date(('Y'), strtotime($dentalrecord->tanggalkunjungan)) == $tahun )
                        @if(date(('m'), strtotime($dentalrecord->tanggalkunjungan)) == $bulan )
                            <tr class="">
                                <td class="">{{date(('d-m-Y'), strtotime($dentalrecord->tanggalkunjungan))}}</td>
                                <td class="">{{$dentalrecord->patient->nama}}</td>
                                <td class="" >
                                @foreach($dentalrecord->dentaltreatments as $dentaltreatment)
                                <?php $jasadokter = $jasadokter + $dentaltreatment->doktergigi ;?>
                                   <table class="table" style="width:100%">
                                        <tr class="">
                                            <td class="" style="width:60%">{{$dentaltreatment->cost->tindakan}}</td>
                                            <td class="" style="width:40%">Rp. {{number_format($dentaltreatment->doktergigi, 0, ",", ".")}},-</td>
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
                                <td class="" style="width:60%">Total</td>
                                <td class="" style="width:40%">Rp. {{number_format($jasadokter, 0, ",", ".")}},-</td>
                            </tr>
                        </table>
                    </th>
                </tr>
            </table>
                
        </div>
    </div>
</div>
@endsection