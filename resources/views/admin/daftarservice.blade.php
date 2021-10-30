@extends ('../layouts/dentalclinic')


@section('title', 'admin')


@section('navigation')
@include ('admin/navigation')
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
            </div>
        </div>

<h3>Daftar Jasa</h3>
<a href="/admin/service/create" class="btn btn-sm btn-primary">+Jasa/Tarif</a>

<div class="row">
    <div class="col-lg-8">

            <table class="table table-hover table-responsive">
            <tr class="text-center">
                <th class="">ID</th>
                <th class="">Jasa</th>
                <th class="">Tarif</th>
                <th class="">Jasa Dokter</th>
                <th class="">Diskon</th>
                <th class=""></th>
            </tr>
            @foreach ($costs as $cost)
            <tr class="">
                <td class="">#</td>
                <td class=""><a href="/admin/service/{{$cost->id}}/edit" class="text-decoration-none text-dark font-weight-bold">{{$cost->tindakan}}</a></td>
                <td class="">Rp. {{number_format($cost->harga, 0, ",", ".")}},-</td>
                <td class="text-center">{{$cost->doktergigi ?? '-'}} %</td>
                <td class="text-center">{{$cost->diskon ?? '-'}} %</td>
                <td class="">
<!-- ----awal hapus----- -->
@if (count($cost->dentaltreatments))
@else
<button type="button" class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#exampleModal{{$cost->id}}">
            hapus
            </button>
@endif
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$cost->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Jasa/Tarif</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/service/{{$cost->id}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="row">
                    <div class="col-lg-12">
                    <table class="">
                        <tr class="">
                            <td class="">Jasa</td><td class="">:</td><td class="">{{$cost -> tindakan}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Tarif</td><td class="">:</td><td class="">{{$cost -> harga}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Diskon</td><td class="">:</td><td class="">{{$cost -> diskon}} %</td>
                        </tr>
                    </table>
                    </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
<!-- ----akhir hapus----- -->
                </td>
            </tr>
            @endforeach
            </table>
            {{$costs->links()}}
    </div>
</div>

</div>
@endsection