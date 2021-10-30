@extends ('../layouts/dentalclinic')


@section('title', 'pendaftaran')


@section('navigation')
@include ('pendaftaran/navigation')
@endsection



@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-6">
            @error('patient_id')
            <div class="alert alert-info"><strong>Pasien sudah terdaftar</strong></div>
            @enderror
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
    </div>
</div>

<div class="row mb-1 mt-1">
    <div class="col-lg-6 d-flex">
        <a href="/pendaftaran/pasien/{{$patient->id}}" class="btn btn-sm btn-primary mr-1">DETAIL</a>
        <a href="/pendaftaran/pasien/{{$patient->id}}/edit" class="btn btn-sm btn-warning mr-1">EDIT</a>
<!-- ----awal hapus----- -->
@if (count($dentalrecords))
@else
            <button type="button" class="btn btn-sm btn-danger mr-1" data-toggle="modal" data-target="#exampleModal">
            HAPUS
            </button>
@endif
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/pendaftaran/pasien/{{$patient->id}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="row">
                    <div class="col-lg-12">
                    <table class="">
                        <tr class="">
                            <td class="">Nomor Rekam Medis</td><td class="">:</td><td class="">{{$patient -> nomorrekammedis}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Nomor NIK</td><td class="">:</td><td class="">{{$patient -> nik}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Nama</td><td class="">:</td><td class="">{{$patient -> nama}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Jenis Kelamin</td><td class="">:</td><td class="">{{$patient -> jeniskelamin}}</td>
                        </tr>
                        <tr class="">
                            <td class="">Alamat</td><td class="">:</td><td class="">{{$patient -> alamat ?? '-'}}</td>
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
                <form action="/pendaftaran/customer" method="post">
                @csrf
                <input type="hidden" name="patient_id" value="{{$patient->id}}">
                <button type="submit" class="btn btn-sm btn-outline-dark">Berobat</button>
                </form>
    </div>
</div>

    <div class="row mb-3">
        <div class="col-lg-6">
                <table class="table table-hover">
                    <tr>
                    <th scope="col">NIK</th>
                    <td scope="col">{{$patient -> nik ?? '-'}}</td>
                    </tr>
                    <tr>
                    <th scope="col">Nama</th>
                    <td scope="col">{{$patient -> nama ?? '-'}}</td>
                    </tr>
                    <tr>
                    <th scope="col">Jenis Kelamin</th>
                    <td scope="col">{{$patient -> jeniskelamin ?? '-'}}</td>
                    </tr>
                    <tr>
                    <th scope="col">Tempat, Tanggal Lahir</th>
                    <td scope="col">{{$patient -> tempatlahir ?? ''}} {{date('d M Y', strtotime($patient->tanggallahir)) ?? '-'}}</td>
                    </tr>
                    <tr>
                    <th scope="col">Usia</th>
                    <td scope="col">{{$usia['tahun'].$usia['bulan'].$usia['hari']}}</td>
                    </tr>
                    <tr>
                    <th scope="col">Agama</th>
                    <td scope="col">{{$patient -> agama ?? '-'}}</td>
                    </tr>
                    <tr class="border-bottom">
                    <th scope="col">Pendidikan</th>
                    <td scope="col">{{$patient -> pendidikan ?? '-'}}</td>
                    </tr>
                    <tr class="border-bottom">
                    <th scope="col">Pekerjaan</th>
                    <td scope="col">{{$patient -> pekerjaan ?? '-'}}</td>
                    </tr>
                    <tr class="border-bottom">
                    <th scope="col">Alamat</th>
                    <td scope="col">{{$patient -> alamat ?? '-'}}</td>
                    </tr>
                    <tr class="border-bottom">
                    <th scope="col">Nomor Handphone</th>
                    <td scope="col">{{$patient -> nomortelepon ?? '-'}}</td>
                    </tr>
                </table>

        </div>
    </div>
</div>
@endsection