@extends ('../layouts/dentalclinic')


@section('title', 'pendaftaran')


@section('navigation')
@include ('pendaftaran/navigation')
@endsection



@section('content')
<div class="container">
<h3>Data Pasien</h3>
<div class="row">
    <div class="col-lg-6">
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-hover responsive">
            <tr class="">
                <td class="">ID</td>
                <td class="">Nama</td>
                <td class="">Nomor<br>Rekam Medis</td>
                <td class="">Alamat</td>
            </tr>
            @foreach ($patients as $patient)
            <tr class="">
                <td class="">#</td>
                <td class=""><a href="/pendaftaran/pasien/{{$patient->id}}" class="text-decoration-none font-weight-bold text-dark">{{$patient->nama}}</a></td>
                <td class="">{{$patient->nomorrekammedis}}</td>
                <td class="">{{$patient->alamat ?? '-'}}</td>
            </tr>
            @endforeach
            </table>
    </div>
</div>

</div>
@endsection