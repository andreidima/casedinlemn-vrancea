@extends('layouts.app')

@section('content')

<div class="container py-5">
    <h2 class="mb-4">Actualizează stoc pentru: {{ $produs->nume }}</h2>

@include('errors.errors')

{{-- Current stock display --}}
<div class="mb-4">
    <span class="fw-bold">Stoc curent:</span>
    <span class="fs-4">{{ $produs->cantitate ?? 0 }}</span>
</div>

<div class="row g-4">
    {{-- Intrare în stoc (green) --}}
    <div class="col-md-6">
        <div class="card border-success h-100">
            <div class="card-header bg-success text-white">
                Intrare în stoc
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('inventar.update', $produs) }}" novalidate
                    onsubmit="disableSubmit(this)"
                >
                    @csrf
                    <input type="hidden" name="tip" value="intrare">

                    <div class="mb-3">
                        <label for="cantitate_intrare" class="form-label">Cantitate</label>
                        <input
                            type="number"
                            name="cantitate"
                            id="cantitate_intrare"
                            class="form-control @error('cantitate') is-invalid @enderror"
                            min="1"
                            value="{{ old('cantitate') }}"
                            required>
                        @error('cantitate')
                            @if(old('tip') === 'intrare')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @endif
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">Adaugă</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Ieșire din stoc (red) --}}
    <div class="col-md-6">
        <div class="card border-danger h-100">
            <div class="card-header bg-danger text-white">
                Ieșire din stoc
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('inventar.update', $produs) }}" novalidate
                    onsubmit="disableSubmit(this)"
                >
                    @csrf
                    <input type="hidden" name="tip" value="iesire">

                    <div class="mb-3">
                        <label for="cantitate_iesire" class="form-label">Cantitate</label>
                        <input
                            type="number"
                            name="cantitate"
                            id="cantitate_iesire"
                            class="form-control @error('cantitate') is-invalid @enderror"
                            min="1"
                            value="{{ old('cantitate') }}"
                            required>
                        @error('cantitate')
                            @if(old('tip') === 'iesire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @endif
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nr_comanda" class="form-label">Număr comandă</label>
                        <input
                            type="text"
                            name="nr_comanda"
                            id="nr_comanda"
                            class="form-control @error('nr_comanda') is-invalid @enderror"
                            value="{{ old('nr_comanda') }}">
                        @error('nr_comanda')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-danger w-100">Scoate</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<script>
  /**
   * Disable all submit buttons in the form to prevent double-submits.
   * You could also hide them instead (form.querySelector('button').style.display = 'none').
   */
  function disableSubmit(form) {
    const buttons = form.querySelectorAll('button[type="submit"]');
    buttons.forEach(btn => {
      btn.disabled = true;
      btn.innerText = 'Se procesează…';  // optional: give the user feedback
    });
  }
</script>

@endsection
