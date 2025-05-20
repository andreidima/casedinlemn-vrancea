@extends ('layouts.app')

@section('content')
<div class="mx-3 px-3 card" style="border-radius: 40px 40px 40px 40px;">
    <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
        <div class="col-lg-3">
            <span class="badge culoare1 fs-5">
                <i class="fa-solid fa-tags me-1"></i>
                Categorii
            </span>
        </div>

        {{-- Search form --}}
        <div class="col-lg-6">
            <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
                @csrf
                <div class="row mb-1 custom-search-form justify-content-center">
                    <div class="col-lg-6">
                        <input type="text" class="form-control rounded-3" id="searchNume" name="searchNume" placeholder="Nume" value="{{ $searchNume }}">
                    </div>
                </div>
                <div class="row custom-search-form justify-content-center">
                    <div class="col-lg-4">
                        <button class="btn btn-sm w-100 btn-primary text-white border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                    </div>
                    <div class="col-lg-4">
                        <a class="btn btn-sm w-100 btn-secondary text-white border border-dark rounded-3" href="{{ url()->current() }}" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Button to add new category --}}
        <div class="col-lg-3 text-end">
            <a class="btn btn-sm btn-success text-white border border-dark rounded-3 col-md-8" href="{{ url()->current() }}/adauga" role="button">
                <i class="fas fa-plus-square text-white"></i> Adaugă Categorie
            </a>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body px-0 py-3">

        @include ('errors.errors')

        <div class="table-responsive rounded">
            <table class="table table-striped table-hover rounded">
                <thead class="text-white rounded">
                    <tr class="thead-danger" style="padding:2rem">
                        <th class="text-white culoare2"><i class="fa-solid fa-hashtag"></i></th>
                        <th class="text-white culoare2"><i class="fa-solid fa-tag me-1"></i> Nume</th>
                        <th class="text-white culoare2 text-end"><i class="fa-solid fa-cogs me-1"></i> Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorii as $categorie)
                        <tr>
                            <td>
                                {{ ($categorii->currentpage() - 1) * $categorii->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $categorie->nume }}</td>
                            <td>
                                <div class="d-flex justify-content-end py-0">
                                    <a href="{{ $categorie->path() }}" class="flex me-1">
                                        <span class="badge bg-success" title="Vizualizează"><i class="fa-solid fa-eye"></i></span>
                                    </a>
                                    <a href="{{ $categorie->path('edit') }}" class="flex me-1">
                                        <span class="badge bg-primary" title="Modifică"><i class="fa-solid fa-edit"></i></span>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#stergeCategorie{{ $categorie->id }}" title="Șterge Categorie">
                                        <span class="badge bg-danger" title="Șterge"><i class="fa-solid fa-trash"></i></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                <i class="fa-solid fa-exclamation-circle me-1"></i> Nu s-au găsit categorii în baza de date.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center">
                {{ $categorii->appends(Request::except('page'))->links() }}
            </ul>
        </nav>
    </div>
</div>

{{-- Modals to delete categories --}}
@foreach ($categorii as $categorie)
    <div class="modal fade text-dark" id="stergeCategorie{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="stergeCategorieLabel{{ $categorie->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="stergeCategorieLabel{{ $categorie->id }}">
                        <i class="fa-solid fa-tag me-1"></i> Categorie: {{ $categorie->nume }}
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    Ești sigur că vrei să ștergi această categorie?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>
                    <form method="POST" action="{{ $categorie->path('destroy') }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger text-white">
                            <i class="fa-solid fa-trash me-1"></i> Șterge Categorie
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
