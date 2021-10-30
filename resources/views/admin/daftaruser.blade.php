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

<h3>Daftar User</h3>
<a href="/admin/user/create" class="btn btn-sm btn-primary">+User</a>

<div class="row">
    <div class="col-lg-12">

            <table class="table table-hover table-responsive">
            <tr class="text-center">
                <td class="" rowspan="2">ID</td>
                <td class="" rowspan="2">Nama</td>
                <td class="" rowspan="2">Posisi</td>
                <td class="" rowspan="2">Username</td>
                <td class="" colspan="5">Hak Akses</td>
                
                
                
                
                
                <td class="" rowspan="2">Reset Password</td>
            </tr>
            <tr class="text-center">
                
                
                
                
                <td class="">Pendaftaran</td>
                <td class="">Pemeriksaan</td>
                <td class="">Dental Room</td>
                <td class="">Apotek</td>
                <td class="">Kasir</td>
                
            </tr>
            @foreach ($users as $user)
            <tr class="">
                <td class="">#</td>
                <td class=""><a href="/admin/user/{{$user->id}}/edit" class="text-decoration-none text-dark font-weight-bold">{{$user->name}}</a></td>
                <td class="">{{$user->jabatan}}</td>
                <td class="">{{$user->username}}</td>
                <td class="">@if ($user->pendaftaran === 1) &#10003 @endif</td>
                <td class="">@if ($user->pemeriksaan === 1) &#10003 @endif</td>
                <td class="">@if ($user->dentist === 1) &#10003 @endif</td>
                <td class="">@if ($user->apotek === 1) &#10003 @endif</td>
                <td class="">@if ($user->kasir === 1) &#10003 @endif</td>
                <td class="text-center">
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
                    <form action="/admin/user/{{$user->id}}/reset" method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="">
                                <tr class="">
                                    <td class="">Nama</td><td class="">:</td><td class="">{{$user -> name}}</td>
                                </tr>
                                <tr class="">
                                    <td class="">Posisi</td><td class="">:</td><td class="">{{$user -> jabatan}}</td>
                                </tr>
                                <tr class="">
                                    <td class="">Username</td><td class="">:</td><td class="">{{$user -> username}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" Placeholder="Ketik Password Admin">
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