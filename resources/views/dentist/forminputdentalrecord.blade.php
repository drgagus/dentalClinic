@extends ('../layouts/dentalclinic')


@section('title', 'Dentist')


@section('navigation')
@include ('dentist/navigation')
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        <form action="/dentist/pasien" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="patient_id" value={{$patient->id}}>

        <div class="card border-primary mb-3">
      <div class="card-header p-0">
<div class="row">
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nama
    <span class="btn btn-outline-dark">{{$patient->nama}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Umur
    <span class="btn btn-outline-dark">{{$customer->usia}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Jenis Kelamin
    <span class="btn btn-outline-dark">{{$patient->jeniskelamin}}</span>
  </li>
</ul>
</div>
<div class="col-lg-6">
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Nomor Rekam Medik
    <span class="btn btn-outline-dark">{{$patient->nomorrekammedis}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Alamat
    <span class="btn btn-outline-dark">{{$patient->alamat ?? '-'}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Tanggal
    <span class="btn btn-dark">{{date('d M Y')}}</span>
  </li>
</ul>
</div>
</div>

      </div>
      <div class="card-body text-dark">

      <div class="row">
      <div class="col-lg-6"></div>
      <div class="col-lg-6 text-right">
        <a class="btn btn-sm btn-primary" href="/dentalrecord/{{$patient->id}}" target=_blank>DentalRecord</a>
        <a class="btn btn-sm btn-primary" href="/poligigi/odontogram/create/{{$patient->id}}">Odontogram</a>
      </div>
      </div>

        <div class="row">
        <div class="col-lg-12">
          <div class="form-group">
            <label class="font-weight-bold" for="keluhanutama">Keluhan Utama</label>
            <input type="text" class="form-control" id="keluhanutama" name="keluhanutama" value="{{ old('keluhanutama') ?? $customer->keluhanutama}}">
            @error('keluhanutama')<label class="text text-danger">Keluhan utama harus diisi</label>@enderror
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <label class="font-weight-bold" for="tinggibadan" name="tinggibadan">Tinggi Badan (cm)</label>
            <input type="text" class="form-control" id="tinggibadan" name="tinggibadan" value="{{ old('tinggibadan') ?? $customer->tinggibadan}}">
            @error('tinggibadan')<label class="text text-danger">{{ $message }}</label>@enderror
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label class="font-weight-bold" for="beratbadan">Berat Badan (Kg)</label>
            <input type="text" class="form-control" id="beratbadan" name="beratbadan" value="{{ old('beratbadan') ?? $customer->beratbadan}}">
            @error('beratbadan')<label class="text text-danger">{{ $message }}</label>@enderror
          </div>
        </div>
        </div>
        
        <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="tekanandarah" name="tekanandarah">Tekanan Darah (mm/Hg)</label>
            <input type="text" class="form-control" id="tekanandarah" name="tekanandarah" value="{{ old('tekanandarah') ?? $customer->tekanandarah}}">
            @error('tekanandarah')<label class="text text-danger">Tekanan darah harus diisi</label>@enderror
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="pernafasan">Pernafasan (/menit)</label>
            <input type="text" class="form-control" id="pernafasan" name="pernafasan" value="{{ old('pernafasan') ?? $customer->pernafasan}}">
            @error('pernafasan')<label class="text text-danger">{{ $message }}</label>@enderror
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="detakjantung">Detak Jantung (/menit)</label>
            <input type="text" class="form-control" id="detakjantung" name="detakjantung" value="{{ old('detakjantung') ?? $customer->detakjantung}}">
            @error('detakjantung')<label class="text text-danger">{{ $message }}</label>@enderror
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="font-weight-bold" for="suhutubuh">Suhu Tubuh (celcius)</label>
            <input type="text" class="form-control" id="suhutubuh" name="suhutubuh" value="{{ old('suhutubuh') ?? $customer->suhutubuh}}">
            @error('suhutubuh')<label class="text text-danger">{{ $message }}</label>@enderror
          </div>
        </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
              <div class="form-group">
                <label class="font-weight-bold" for="pemeriksaansubjektif">Pemeriksaan Subjektif</label>
                <textarea class="form-control" id="pemeriksaansubjektif" rows="3" name="pemeriksaansubjektif">{{ old('pemeriksaansubjektif') }}</textarea>
                @error('pemeriksaansubjektif')<label class="text text-danger">{{ $message }}</label>@enderror
              </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="font-weight-bold" for="pemeriksaanobjektif">Pemeriksaan Objektif</label>
              <textarea class="form-control" id="pemeriksaanobjektif" rows="3" name="pemeriksaanobjektif">{{ old('pemeriksaanobjektif') }}</textarea>
              @error('pemeriksaanobjektif')<label class="text text-danger">{{ $message }}</label>@enderror
            </div>
          </div>
        </div>

        <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
              <label class="font-weight-bold" for="diagnosa">Diagnosa</label>
              <textarea class="form-control" id="diagnosa" rows="3" name="diagnosa">{{ old('diagnosa') }}</textarea>
              @error('diagnosa')<label class="text text-danger">{{ $message }}</label>@enderror
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
              <label class="font-weight-bold @error('informedconsent') text-danger @enderror" for="informedconsent">Informed Consent</label>
              <input type="file" name="informedconsent" class="form-control-file" id="informedconsent">
              </div>
        </div>
        </div>

        
        <div class="row">
          <div class="col-lg-12">
            <div class="card bg-light border-dark mb-3">
              <div class="card-header font-weight-bold">Tindakan/tarif</div>
              <div class="card-body">

                <div class="row mb-1">
                    <div class="col-lg-3">
                        <textarea class="form-control mb-3 @error('gigi1') is-invalid @enderror" id="gigi" rows="1" name="gigi1" Placeholder="--element gigi--">{{old('gigi1')}}</textarea>
                        <select name="diag_id1" id="" class="form-control mb-3 @error('diag_id1') is-invalid @enderror">
                            <option value="" class="">--diagnosa--</option>
                            @foreach ($diags as $diag)
                                <option {{ old('diag_id1')  === "$diag->id" ? 'selected':'' }} value="{{$diag->id}}">{{$diag->diagnosa}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <textarea class="form-control mb-3 @error('tindakan1') is-invalid @enderror" id="tindakan" rows="6" name="tindakan1" Placeholder="--tindakan--">{{old('tindakan1')}}</textarea>
                      </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="exampleFormControlFilebefore1" class="font-weight-bold @error('before1') text-danger @enderror">Foto Sebelum</label>
                        <input type="file" name="before1" class="form-control-file" id="exampleFormControlFilebefore1">   
                        <label for="exampleFormControlFileafter1" class="font-weight-bold  @error('after1') text-danger @enderror">Foto Sesudah</label>
                        <input type="file" name="after1" class="form-control-file" id="exampleFormControlFileafter1">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-12">
                          <select name="cost_id1" id="" class="form-control @error('cost_id1') is-invalid @enderror">
                                <option value="" class="">--tarif--</option>
                                @foreach ($costs as $cost)
                                    <option {{ old('cost_id1')  === "$cost->id" ? 'selected':'' }} value="{{$cost->id}}">{{$cost->tindakan}} - Rp.{{number_format($cost->harga, 0, ",", ".")}},-</option>
                                @endforeach
                          </select>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-12">
            <div class="card bg-light border-dark mb-3">
              <div class="card-header font-weight-bold">Tindakan/tarif</div>
              <div class="card-body">

                <div class="row">
                    <div class="col-lg-3">
                        <textarea class="form-control mb-3 @error('gigi2') is-invalid @enderror" id="gigi" rows="2" name="gigi2" Placeholder="--element gigi--">{{old('gigi2')}}</textarea>
                        <select name="diag_id2" id="" class="form-control mb-3 @error('diag_id2') is-invalid @enderror">
                            <option value="" class="">--diagnosa--</option>
                            @foreach ($diags as $diag)
                                <option {{ old('diag_id2')  === "$diag->id" ? 'selected':'' }} value="{{$diag->id}}">{{$diag->diagnosa}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <textarea class="form-control mb-3 @error('tindakan2') is-invalid @enderror" id="tindakan" rows="6" name="tindakan2" Placeholder="--tindakan--">{{old('tindakan2')}}</textarea>
                      </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="exampleFormControlFilebefore2" class="font-weight-bold @error('before2') text-danger @enderror">Foto Sebelum</label>
                        <input type="file" name="before2" class="form-control-file" id="exampleFormControlFilebefore2">
                        <label for="exampleFormControlFileafter2" class="font-weight-bold  @error('after2') text-danger @enderror">Foto Sesudah</label>
                        <input type="file" name="after2" class="form-control-file" id="exampleFormControlFileafter2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-12">
                          <select name="cost_id2" id="" class="form-control @error('cost_id2') is-invalid @enderror">
                                <option value="" class="">--tarif--</option>
                                @foreach ($costs as $cost)
                                    <option {{ old('cost_id2')  === "$cost->id" ? 'selected':'' }} value="{{$cost->id}}">{{$cost->tindakan}} - Rp.{{number_format($cost->harga, 0, ",", ".")}},-</option>
                                @endforeach
                          </select>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <label class="font-weight-bold" for="pengobatan">Obat</label>
        <div class="row">
            <div class="col-lg-3">
            @foreach ($medicines as $medicine) 
            {{$medicine->obat}} - Stok {{$medicine->jumlah}}<br>
            @endforeach
            </div>
            <div class="col-lg-9">
                <div class="form-group">
                  <textarea class="form-control" id="pengobatan" rows="3" name="pengobatan">{{ old('pengobatan') }}</textarea>
                  @error('pengobatan')<label class="text text-danger">{{ $message }}</label>@enderror
                </div>
            </div>
        </div>

      </div>
      <div class="card-footer bg-transparent border-success text-right">
      <button type="submit" class="btn btn-primary">INPUT</button>
      </div>
    </div>
    </form>
       
        </div>
    </div>
</div>

@endsection