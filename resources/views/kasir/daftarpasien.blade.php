@extends ('../layouts/dentalclinic')


@section('title', 'Kasir')


@section('navigation')
@include ('kasir/navigation')
@endsection



@section('content')
<div class="container">
<h3>Pasien Tanggal {{date('d M Y')}}</h3>
<div class="row">
    <div class="col-lg-6">
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-hover responsive text-center">
            <tr class="">
                <td class="">Nomor<br>Antrian</td>
                <td class="">Nomor<br>Rekam Medis</td>
                <td class="">Nama</td>
                <td class="">Selesai</td>
            </tr>
            @foreach ($dentalrecords as $dentalrecord)
            <tr class="">
                <td class="">{{$dentalrecord->patient->customer->id}}</td>
                <td class="">{{$dentalrecord->patient->nomorrekammedis}}</td>
                <td class="">
                    @if($dentalrecord->patient->customer->selesai == 4)
                    <a href="/kasir/pasien/{{$dentalrecord->id}}" class="text-decoration-none font-weight-bold">{{$dentalrecord->patient->nama}}</a>
                    @else
                    <a href="/kasir/pasien/{{$dentalrecord->id}}/edit" class="text-decoration-none font-weight-bold">{{$dentalrecord->patient->nama}}</a>
                    @endif
                </td>
                <td class="">
                    @if($dentalrecord->patient->customer->selesai == 4)
                    <div class="font-weight-bold">&#10003</div>
                    @else
                    <div class="font-weight-bold text-danger">&#120</div>
                    @endif
                </td>
            </tr>
            @endforeach
            </table>
    </div>
</div>

</div>
@endsection