@extends ('../layouts/dentalclinic')


@section('title', 'CEO')


@section('navigation')
@include ('ceo/navigation')
@endsection



@section('content')
<div class="container">
    <form action="/ceo/service" class="" method="post">
    @csrf
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <select class="form-control" id="bulan" name="bulan">
                            <option value="">--bulan--</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">Noverber</option>
                            <option value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <input type="text" class="form-control" id="tahun" name="tahun" value="{{ old('tahun') ?? date('Y')}}" Placeholder="Tahun">
                </div>
            </div>
            <div class="col-lg-1 text-right">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">OK</button>
                </div>
            </div>
        </div>
    </form>


</div>
@endsection