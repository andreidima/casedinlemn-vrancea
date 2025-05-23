@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-5">
            <div class="card culoare2">
                <div class="card-header">Dashboard</div>

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
    <div class="row">
    <div class="col-6 mb-3 mx-auto">
        <div class="card culoare2">
        <div class="card-header text-center">
            Produse cu stoc scăzut
        </div>
        <div class="card-body p-2">
            @if($lowStock->isEmpty())
            <p class="text-center mb-0">Nicio alertă de stoc scăzut.</p>
            @else
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr>
                    <th>Produs</th>
                    <th class="text-end">Stoc</th>
                    <th class="text-end">Prag minim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStock as $p)
                    <tr>
                        <td>{{ $p->nume }}</td>
                        <td class="text-end">{{ $p->cantitate }}</td>
                        <td class="text-end">{{ $p->prag_minim }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @endif
        </div>
        </div>
    </div>
    </div>


</div>

@endsection

