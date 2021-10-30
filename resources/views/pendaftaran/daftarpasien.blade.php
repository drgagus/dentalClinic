@extends ('../layouts/dentalclinic')


@section('title', 'pendaftaran')


@section('navigation')
@include ('pendaftaran/navigation')
@endsection



@section('content')
<div class="container">
<h3>Pasien Tanggal {{date('d M Y', strtotime(now()))}}</h3>
<div class="row">
    <div class="col-lg-6">
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table table-hover responsive">
            <tr class="">
                <td class="">Nomor<br>Antrian</td>
                <td class="">Nomor<br>Rekam Medis</td>
                <td class="">Nama</td>
                <td class="">Usia</td>
                <td class=""></td>
            </tr>
            @foreach ($customers as $customer)
            <tr class="">
                <td class="">{{$customer->id}}</td>
                <td class="">{{$customer->patient->nomorrekammedis}}</td>
                <td class=""><a href="/pendaftaran/pasien/{{$customer->patient_id}}" class="text-decoration-none font-weight-bold">{{$customer->patient->nama}}</a></td>
                <td class="">{{$customer->usia}}</td>
                <td class="">
<!-- ----awal hapus----- -->
@if ($customer->selesai == null )
            <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal{{$customer->id}}">
            hapus
            </button>
@else 
@endif

            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/pendaftaran/customer/{{$customer->id}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="row">
                    <div class="col-lg-12">
                    <table class="">
                        <tr class="">
                            <td class="">Nomor Antrian</td><td class="">:</td><td class="">{{$customer->id}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Nomor Rekam Medis</td><td class="">:</td><td class="">{{$customer->patient -> nomorrekammedis}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Nama</td><td class="">:</td><td class="">{{$customer->patient -> nama}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Jenis Kelamin</td><td class="">:</td><td class="">{{$customer->patient -> jeniskelamin}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Usia</td><td class="">:</td><td class="">{{$customer->usia}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Alamat</td><td class="">:</td><td class="">{{$customer->patient -> alamat ?? '-'}}</td>
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

            <!-- ----awal truncate----- -->
            <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
            hapus
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Seluruh Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/pendaftaran/truncate" method="post">
                    @csrf
                    @method('delete')
                    <div class="row">
                    <div class="col-lg-12">
                            Yakin Hapus Semua ?
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
<!-- ----akhir truncate----- -->
    </div>
</div>

</div>
@endsection