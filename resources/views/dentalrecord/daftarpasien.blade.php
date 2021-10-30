@extends ('../layouts/dentalclinic')


@section('title', 'Dentist')


@section('navigation')
@include ('dentist/navigation')
@endsection



@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-6">
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-hover responsive">
            <tr class="">
                <th class="">No</th>
                <th class="">Nomor<br>Rekam Medis</th>
                <th class="">Nama</th>
                <th class="">Umur</th>
                <th class="">Alamat</th>
            </tr>
            @foreach ($patients as $patient)
            <tr class="">
                <td class="">#</td>
                <td class="">{{$patient->nomorrekammedis}}</td>
                <td class=""><a href="/dentalrecord/{{$patient->id}}" class="text-decoration-none font-weight-bold" target=_blank>{{$patient->nama}}</a></td>
                <td class=""></td>
                <td class="">{{$patient->alamat ?? '-'}}</td>
            </tr>
            @endforeach
            </table>
    </div>
</div>

</div>
@endsection