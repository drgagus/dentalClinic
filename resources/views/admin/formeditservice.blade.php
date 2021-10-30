@extends ('../layouts/dentalclinic')


@section('title', 'Admin')


@section('navigation')
@include ('admin/navigation')
@endsection



@section('content')
<div class="container">
        <div class="row">
            <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Tambah Jasa/Tarif</div>

                <div class="card-body">
                    <form method="POST" action="/admin/service/{{$service->id}}/edit">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label for="tindakan" class="col-md-4 col-form-label text-md-right">Jasa</label>

                            <div class="col-md-6">
                                <input id="tindakan" type="text" class="form-control @error('tindakan') is-invalid @enderror" name="tindakan" value="{{ old('tindakan') ?? $service->tindakan}}" autocomplete="tindakan" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="harga" class="col-md-4 col-form-label text-md-right">Tarif (Rp.)</label>

                            <div class="col-md-6">
                                <input id="harga" type="harga" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') ?? $service->harga}}" autocomplete="harga">

                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="doktergigi" class="col-md-4 col-form-label text-md-right">Jasa Dokter Gigi (%)</label>

                            <div class="col-md-6">
                                <input id="doktergigi" type="doktergigi" class="form-control @error('doktergigi') is-invalid @enderror" name="doktergigi" value="{{ old('doktergigi') ?? $service->doktergigi}}" autocomplete="Jasa dokter gigi">

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="diskon" class="col-md-4 col-form-label text-md-right">Diskon (%)</label>

                            <div class="col-md-6">
                                <input id="diskon" type="diskon" class="form-control @error('diskon') is-invalid @enderror" name="diskon" value="{{ old('diskon') ?? $service->diskon}}" autocomplete="diskon">

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    EDIT
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>        
    </div>
</div>
@endsection