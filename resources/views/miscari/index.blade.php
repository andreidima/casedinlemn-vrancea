@extends('layouts.app')

@section('content')

<div class="mx-3 px-3 card" style="border-radius: 40px;">
    <div class="row card-header align-items-center" style="border-radius: 40px 40px 0 0;">
        <div class="col-lg-3">
            <span class="badge culoare1 fs-5">
                <i class="fa-solid fa-list me-1"></i>
                {{ $tip === 'intrari' ? 'Intrări în stoc' : 'Ieșiri din stoc' }}
            </span>
        </div>

    {{-- Search form --}}
    <div class="col-lg-6">
        <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
            @csrf
            <div class="row mb-2 custom-search-form justify-content-center">
                <div class="col-lg-4">
                    <input
                        type="text"
                        class="form-control rounded-3"
                        id="searchProdus"
                        name="searchProdus"
                        placeholder="Produs"
                        value="{{ $searchProdus }}">
                </div>
                <div class="col-lg-3">
                    <select
                        name="searchUser"
                        id="searchUser"
                        class="form-control rounded-3">
                        <option value="">Toți utilizatorii</option>
                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}"
                                {{ $searchUser == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="datePicker" class="col-lg-5 d-flex align-items-center">
                    <label for="searchIntervalData" class="mb-0 ps-3">Data</label>
                    <vue-datepicker-next
                        id="searchIntervalData"
                        data-veche="{{ $searchIntervalData }}"
                        nume-camp-db="searchIntervalData"
                        tip="date"
                        range="range"
                        value-type="YYYY-MM-DD"
                        format="DD.MM.YYYY"
                        :latime="{ width: '210px' }"
                    ></vue-datepicker-next>
                </div>
            </div>
            <div class="row custom-search-form justify-content-center">
                <div class="col-lg-4 mb-2">
                    <button
                        class="btn btn-sm w-100 btn-primary text-white border border-dark rounded-3"
                        type="submit">
                        <i class="fas fa-search me-1"></i>Caută
                    </button>
                </div>
                <div class="col-lg-4 mb-2">
                    <a
                        class="btn btn-sm w-100 btn-secondary text-white border border-dark rounded-3"
                        href="{{ url()->current() }}"
                        role="button">
                        <i class="far fa-trash-alt me-1"></i>Resetează
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Placeholder for add button or actions --}}
    <div class="col-lg-3 text-end">
        {{-- Optional button --}}
    </div>
</div>

{{-- Card Body --}}
<div class="card-body px-0 py-3">
    @include('errors.errors')

    <div class="table-responsive rounded">
        <table class="table table-striped table-hover rounded">
            <thead class="text-white">
                <tr>
                    <th class="text-white culoare2"><i class="fa-solid fa-hashtag"></i></th>
                    <th class="text-white culoare2"><i class="fa-solid fa-box me-1"></i> Produs</th>
                    <th class="text-white culoare2"><i class="fa-solid fa-layer-group me-1"></i> Cantitate</th>
                    <th class="text-white culoare2"><i class="fa-solid fa-user me-1"></i> Utilizator</th>
                    <th class="text-white culoare2"><i class="fa-solid fa-calendar-days me-1"></i> Data</th>
                    <th class="text-white culoare2 text-end"><i class="fa-solid fa-cogs me-1"></i> Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr>
                        <td>{{ ($movements->currentPage() - 1) * $movements->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $m->produs->nume }}</td>
                        <td>{{ abs($m->delta) }}</td>
                        <td>{{ $m->user->name }}</td>
                        <td>{{ $m->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-end">
                            <button
                                type="button"
                                class="btn btn-sm btn-warning text-white"
                                data-bs-toggle="modal"
                                data-bs-target="#anuleazaMiscare{{ $m->id }}"
                                title="Anulează">
                                <i class="fa-solid fa-rotate-left me-1"></i>Anulează
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            <i class="fa-solid fa-exclamation-circle me-1"></i>
                            Nu există mișcări.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <nav>
        <ul class="pagination justify-content-center">
            {{ $movements->withQueryString()->links() }}
        </ul>
    </nav>
</div>

</div>

{{-- Modal de confirmare pentru anularea unei mișcări --}}
@foreach($movements as $m)
    <div
        class="modal fade text-dark"
        id="anuleazaMiscare{{ $m->id }}"
        tabindex="-1"
        role="dialog"
        aria-labelledby="anuleazaMiscare{{ $m->id }}Label"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-warning">
            <h5 class="modal-title text-white" id="anuleazaMiscare{{ $m->id }}Label">
            <i class="fa-solid fa-rotate-left me-1"></i>
            Anulează mișcare
            </h5>
            <button
            type="button"
            class="btn-close bg-white"
            data-bs-dismiss="modal"
            aria-label="Close">
            </button>
        </div>
        <div class="modal-body text-start">
            Ești sigur că dorești să anulezi mișcarea de
            <strong>{{ abs($m->delta) }}</strong> bucăți pentru produsul
            <strong>{{ $m->produs->nume }}</strong>
            din {{ $m->created_at->format('d.m.Y H:i') }}?
        </div>
        <div class="modal-footer">
            <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Renunță
            </button>
            <form method="POST" action="{{ route('miscari.anuleaza', $m) }}">
            @csrf
            <button
                type="submit"
                class="btn btn-warning text-white">
                <i class="fa-solid fa-rotate-left me-1"></i>Anulează
            </button>
            </form>
        </div>
        </div>
    </div>
    </div>
@endforeach

@endsection
