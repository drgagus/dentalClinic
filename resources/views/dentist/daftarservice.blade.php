@extends ('../layouts/dentalclinic')


@section('title', 'dentist')


@section('navigation')
@include ('dentist/navigation')
@endsection



@section('content')
<div class="container">

<h3>Daftar Jasa</h3>
<div class="row">
    <div class="col-lg-6">

            <table class="table table-hover responsive">
            <tr class="">
                <td class="">ID</td>
                <td class="">Jasa</td>
                <td class="">Tarif</td>
                <td class="">Diskon</td>
            </tr>
            @foreach ($costs as $cost)
            <tr class="">
                <td class="">#</td>
                <td class="font-weight-bold">{{$cost->tindakan}}</td>
                <td class="">Rp. {{number_format($cost->harga, 0, ",", ".")}},-</td>
                <td class="">{{$cost->diskon ?? '-'}} %</td>
            </tr>
            @endforeach
            </table>
    </div>
</div>

</div>
@endsection