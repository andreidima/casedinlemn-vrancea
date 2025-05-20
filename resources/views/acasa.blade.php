@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-5">
            <div class="card culoare2">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    Bine ai venit <b>{{ auth()->user()->name ?? '' }}</b>!
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Proiecte luna trecută</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ $proiecteLastMonth }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Proiecte luna curentă</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ $proiecteThisMonth }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Total Proiecte</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ $allProiecteCount }}</b>
                </div>
            </div>
        </div>
    </div> --}}
</div>

@endsection

