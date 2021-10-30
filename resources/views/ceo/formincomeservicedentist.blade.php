@extends ('../layouts/dentalclinic')


@section('title', 'CEO')


@section('navigation')
@include ('ceo/navigation')
@endsection



@section('content')
<div class="container">
    <form action="/ceo/income/dentist" class="" method="post">
    @csrf
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                        <option value="">--dokter gigi--</option>
                        @foreach($dentists as $dentist)
                        <option value="{{$dentist->id}}">{{$dentist->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <select class="form-control @error('bulan') is-invalid @enderror" id="bulan" name="bulan">
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
                    <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') ?? date('Y')}}" Placeholder="Tahun">
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