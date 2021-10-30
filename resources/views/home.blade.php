@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- <div class="card-header bg-dark text-white">{{ __('Dashboard') }}</div> -->
                <div class="card-body p-0 rounded">
                    <div class="list-group">
                        <a href="{{route('ceo')}}" class="list-group-item list-group-item-action font-weight-bold">CEO/OWNER</a>
                        <a href="{{route('admin')}}" class="list-group-item list-group-item-action list-group-item-dark font-weight-bold text-white" style="background:blue">Admin</a>
                        <a href="{{route('pendaftaran')}}" class="list-group-item list-group-item-action list-group-item-secondary font-weight-bold" style="background:salmon">Pendaftaran</a>
                        <a href="{{route('pemeriksaan')}}" class="list-group-item list-group-item-action list-group-item-success font-weight-bold">Pemeriksaan</a>
                        <a href="{{route('dentist')}}" class="list-group-item list-group-item-action list-group-item-danger font-weight-bold" style="background:yellow">Dental Room</a>
                        <a href="{{route('apotek')}}" class="list-group-item list-group-item-action list-group-item-warning font-weight-bold text-dark" style="background:#ff1493">Apotek</a>
                        <a href="{{route('kasir')}}" class="list-group-item list-group-item-action list-group-item-info font-weight-bold text-warning" style="background:red">Kasir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
