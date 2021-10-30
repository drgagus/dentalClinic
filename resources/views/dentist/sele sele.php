@foreach ($dentaltreatments as $dentaltreatment)
        <div class="row mt-1">
          <div class="col-lg-12 p-0">
            <div class="card bg-light border-dark mb-3">
              <div class="card-header font-weight-bold">Tindakan</div>
              <div class="card-body">

                <div class="row">
                    <div class="col-lg-3">
                      <label class="font-weight-bold">Element Gigi</label>
                      <p class="">{{$dentaltreatment->gigi ?? '-'}}</p>
                      <label class="font-weight-bold">Diagnosa</label>
                      <p class="">{{$dentaltreatment->diag->diagnosa ?? '-'}}</p>
                    </div>
                    <div class="col-lg-5">
                      <label class="font-weight-bold">Tindakan</label>
                      <p class="">{{$dentaltreatment->tindakan ?? '-'}}</p>
                    </div>
                    <div class="col-lg-2">
                      <label class="font-weight-bold">Before</label>
                      @if ($dentaltreatment->imagebefore)
                      <p class="" ><a href="{{asset('storage/'.$dentaltreatment->imagebefore)}}" class="" target=_blank><img src="{{asset('storage/'.$dentaltreatment->before)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                      @else
                      <p class="" ><img src="{{asset('storage/images/before/noimagebefore.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                      @endif
                    </div>
                    <div class="col-lg-2">
                      <label class="font-weight-bold">After</label>
                      @if ($dentaltreatment->imageafter)
                      <p class="" ><a href="{{asset('storage/'.$dentaltreatment->imageafter)}}" class="" target=_blank><img src="{{asset('storage/'.$dentaltreatment->after)}}" alt="" class="" style="width:100px;height:100px"></a></p>
                      @else
                      <p class="" ><img src="{{asset('storage/images/after/noimageafter.jpg')}}" alt="" class="" style="width:100px;height:100px"></p>
                      @endif
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-lg-12">
                      <label class="font-weight-bold" for="beratbadan">Tarif : </label>Rp. {{number_format($dentaltreatment->harga, 0, ",", ".")}},-
                    </div>
                </div> -->

              </div>
              <div class="card-footer bg-transparent border-dark text-right">
                  <a href="" class="btn btn-sm btn-danger">HAPUS</a>
                  <a href="/dentist/dentaltreatment/{{$dentaltreatment->id}}/edit" class="btn btn-sm btn-primary">EDIT</a>
              </div>
            </div>
          </div>
        </div>
@endforeach