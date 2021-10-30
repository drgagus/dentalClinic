@extends ('../layouts/dentalclinic')


@section('title', 'CEO')


@section('navigation')
@include ('ceo/navigation')
@endsection



@section('content')
<div class="container">
    @if (session('status'))
        <div class="row">
            <div class="col-lg-6">
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif
    @error('password')
        <div class="row">
            <div class="col-lg-6">
                <div class="alert alert-danger">
                    Password CEO harus diisi
                </div>
            </div>
        </div>
    @enderror

<h3>Daftar Admin</h3>
<a href="/ceo/user/create" class="btn btn-sm btn-primary">+User</a>

<div class="row">
    <div class="col-lg-6">

            <table class="table table-hover responsive">
            <tr class="text-center">
                <td class="" rowspan="2">ID</td>
                <td class="" rowspan="2">Nama</td>
                <td class="" rowspan="2">Posisi</td>
                <td class="" rowspan="2">Username</td>
                <td class="" colspan="6">Hak Akses</td>
                
                
                
                
                
                <td class="" rowspan="2">Reset Password</td>
            </tr>
            <tr class="text-center">
                
                
                
                
                <td class="">Admin</td>
                <td class="">Pendaftaran</td>
                <td class="">Pemeriksaan</td>
                <td class="">Dental Room</td>
                <td class="">Apotek</td>
                <td class="">Kasir</td>
                
            </tr>
            @foreach ($users as $user)
            <tr class="">
                <td class="">#</td>
                <td class=""><a href="/ceo/user/{{$user->id}}/edit" class="text-decoration-none font-weight-bold">{{$user->name}}</a></td>
                <td class="">{{$user->jabatan}}</td>
                <td class="">{{$user->username}}</td>
                <td class="font-weight-bold">@if ($user->admin === 1) &#10003 @endif</td>
                <td class="font-weight-bold">@if ($user->pendaftaran === 1) &#10003 @endif</td>
                <td class="font-weight-bold">@if ($user->pemeriksaan === 1) &#10003 @endif</td>
                <td class="font-weight-bold">@if ($user->dentist === 1) &#10003 @endif</td>
                <td class="font-weight-bold">@if ($user->apotek === 1) &#10003 @endif</td>
                <td class="font-weight-bold">@if ($user->kasir === 1) &#10003 @endif</td>
                <td class="">
<!-- ----awal hapus----- -->

<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#exampleModal{{$user->id}}">
            reset
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/ceo/user/{{$user->id}}/reset" method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="">
                                <tr class="">
                                    <td class="">Nama</td><td class="">:</td><td class="">{{$user -> name}}</td>
                                </tr>
                                <tr class="">
                                    <td class="">Username</td><td class="">:</td><td class="">{{$user -> username}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" Placeholder="Ketik Password CEO">
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
    </div>
</div>

</div>
@endsection