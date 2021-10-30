@extends ('../layouts/dentalclinic')


@section('title', 'Dentist')


@section('navigation')
@include ('dentist/navigation')
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
                <td class=""><a href="/dentist/pasien/{{$dentalrecord->id}}" class="text-decoration-none font-weight-bold">{{$dentalrecord->patient->nama}}</a></td>
                <td class=""><div class="font-weight-bold">&#10003</div></td>
            </tr>
            @endforeach
            @foreach ($customers as $customer)
            <tr class="">
                <td class="">{{$customer->id}}</td>
                <td class="">{{$customer->patient->nomorrekammedis}}</td>
                <td class=""><a href="/dentist/pasien/create/{{$customer->id}}" class="text-decoration-none font-weight-bold">{{$customer->patient->nama}}</a></td>
                <td class=""><div class="font-weight-bold text-danger">&#120</div></td>
            </tr>
            @endforeach
            </table>
    </div>
</div>

</div>
@endsection