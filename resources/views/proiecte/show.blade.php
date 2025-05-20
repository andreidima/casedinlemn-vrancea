@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow-lg" style="border-radius: 40px;">
                {{-- Header --}}
                <div class="border border-secondary p-2 culoare2" style="border-radius: 40px 40px 0 0;">
                    <span class="badge text-light fs-5">
                        <i class="fa-solid fa-folder me-1"></i> Detalii Proiect
                    </span>
                </div>

                <div class="card-body border border-secondary p-4" style="border-radius: 0 0 40px 40px;">

                    {{-- Section 1: Contractare --}}
                    <div class="row mb-4">
                        <h4 class="col-12 mb-3">1. Contractare</h4>
                        <div class="col-md-6 mb-2"><strong>Tema de proiectare:</strong> {{ $proiect->tema_de_proiectare }}</div>
                        <div class="col-md-6 mb-2"><strong>Contract:</strong> {{ $proiect->contract ?? '-' }}</div>
                        <div class="col-md-6 mb-2"><strong>Ofertă:</strong> {{ $proiect->oferta ?? '-' }}</div>
                        <div class="col-md-6 mb-2"><strong>Plăți:</strong> {{ $proiect->plati ?? '-' }}</div>
                    </div>

                    {{-- Section: Clienți --}}
                    <div class="row mb-4">
                        <h4 class="col-12 mb-3">Clienți</h4>
                        <div class="col-12">
                            @forelse($proiect->clienti as $client)
                                {{ $loop->iteration }}.
                                <a href="{{ $client->path() }}">{{ $client->nume }}</a>
                                @if($client->pivot->observatii)
                                    - {{ $client->pivot->observatii }}
                                @endif
                                <br>
                            @empty
                                <span class="text-muted">Fără clienți.</span>
                            @endforelse
                        </div>
                    </div>

                    {{-- Section 2: Proiectare --}}
                    <div class="row mb-4">
                        <h4 class="col-12 mb-3">2. Proiectare</h4>

                        {{-- Obținere Certificat Urbanism --}}
                        <div class="col-md-6 mb-2">
                            <strong>Obținere Certificat Urbanism:</strong>
                            {{ $proiect->obtinere_certificat_urbanism ?? '-' }}
                        </div>

                        {{-- DTAC slots --}}
                        <div class="col-12 mt-3"><strong>DTAC</strong></div>
                        @foreach(['arhitectura','structura','instalatii'] as $part)
                            <div class="col-md-4 mb-2">
                                <strong>{{ ucfirst($part) }}:</strong><br>
                                @php
                                    $tag = "dtac_{$part}";
                                @endphp
                                @forelse($proiect->membri->filter(fn($m) => $m->pivot->tip === $tag) as $membru)
                                    &bull; {{ $membru->nume }}
                                    @if($membru->pivot->observatii)
                                        ({{ $membru->pivot->observatii }})
                                    @endif
                                    <br>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>
                        @endforeach

                        {{-- PTh slots --}}
                        <div class="col-12 mt-3"><strong>PTh</strong></div>
                        @foreach(['arhitectura','structura','instalatii'] as $part)
                            <div class="col-md-4 mb-2">
                                <strong>{{ ucfirst($part) }}:</strong><br>
                                @php
                                    $tag = "pth_{$part}";
                                @endphp
                                @forelse($proiect->membri->filter(fn($m) => $m->pivot->tip === $tag) as $membru)
                                    &bull; {{ $membru->nume }}
                                    @if($membru->pivot->observatii)
                                        ({{ $membru->pivot->observatii }})
                                    @endif
                                    <br>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>
                        @endforeach

                        {{-- DTOE --}}
                        <div class="col-md-6 mt-3 mb-2">
                            <strong>DTOE:</strong> {{ $proiect->dtoe ?? '-' }}
                        </div>
                    </div>

                    {{-- Section 3: Avize --}}
                    <div class="row mb-4">
                        <h4 class="col-12 mb-3">3. Avize</h4>
                        @foreach([
                            'certificat_de_urbanism'             => 'Certificat de Urbanism',
                            'alimentare_cu_apa'                   => 'Alimentare cu Apă',
                            'canalizare'                          => 'Canalizare',
                            'transport_urban'                     => 'Transport Urban',
                            'nomenclator'                         => 'Nomenclator',
                            'alimentare_cu_energie_electrica'     => 'Alimentare cu Energie Electrică',
                            'gaze_naturale'                       => 'Gaze Naturale',
                            'telefonizare'                        => 'Telefonizare',
                            'salubritate'                         => 'Salubritate',
                            'alimentare_cu_energie_termica'       => 'Alimentare cu Energie Termică',
                            'isu'                                 => 'ISU',
                            'dsp'                                 => 'DSP',
                            'dsv'                                 => 'DSV',
                            'anif'                                => 'ANIF',
                            'ospa'                                => 'OSPA',
                            'apia'                                => 'APIA',
                            'daj'                                 => 'DAJ',
                            'mediu'                               => 'Mediu',
                            'arie_protejata'                      => 'Arie Protejată',
                            'studiu_geotehnic'                    => 'Studiu Geotehnic',
                            'studiu_topo'                         => 'Studiu Topo',
                            'verificare_tehnica_structura'       => 'Verificare Tehnică Structură',
                            'verificare_tehnica_instalatii'      => 'Verificare Tehnică Instalații',
                            'dovada_oar'                          => 'Dovadă OAR',
                            'ipj'                                 => 'IPJ',
                            'cj'                                  => 'CJ',
                            'conpet'                              => 'CONPET',
                            'cfr'                                 => 'CFR',
                            'sga'                                 => 'SGA',
                            'nzeb'                                => 'NZEB',
                            'saer'                                => 'SAER',
                            'expertiza_tehnica'                  => 'Expertiză Tehnică',
                        ] as $field => $label)
                            <div class="col-md-6 mb-2">
                                <strong>{{ $label }}:</strong> {{ $proiect->{$field} ?? '-' }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Section 4: Urmărire --}}
                    <div class="row mb-4">
                        <h4 class="col-12 mb-3">4. Urmărire</h4>
                        @foreach([
                            'notare_ac_la_ocpi'                   => 'Notare A.C. la OCPI',
                            'comunicare_incepere_lucrari_ziar'    => 'Comunicare Începere Lucrări Ziar',
                            'comunicare_incepere_lucrari_isc'     => 'Comunicare Începere Lucrări ISC',
                            'comunicare_incheiere_lucrari_primarie'=> 'Comunicare Încheiere Lucrări Primărie',
                            'dirigentie_santier'                  => 'Dirigenție Șantier',
                            'receptie_depunere_documentatie'       => 'Recepție (depunere documentație)',
                            'edificare_depunere_documentatie'      => 'Edificare (depunere documentație)',
                            'inscriere_constructie'                => 'Înscriere Construcție',
                        ] as $field => $label)
                            <div class="col-md-6 mb-2">
                                <strong>{{ $label }}:</strong> {{ $proiect->{$field} ?? '-' }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Files --}}
                    <div class="row mb-4">
                        <h4 class="col-12 mb-3">Fișiere</h4>
                        <div class="col-12">
                            @forelse($proiect->fisiere as $fisier)
                                {{ $loop->iteration }}.
                                <a href="{{ route('fisiere.view', $fisier->id) }}" target="_blank">
                                    {{ $fisier->nume_fisier }}
                                </a><br>
                            @empty
                                <span class="text-muted">Fără fișiere.</span>
                            @endforelse
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('proiecte.edit', ['proiectTip' => $proiectTip->slug, 'proiect' => $proiect->id]) }}"
                           class="btn btn-primary text-white me-3 rounded-3">
                            <i class="fa-solid fa-edit"></i> Modifică
                        </a>
                        <a href="{{ Session::get('returnUrl', route('proiecte.index', $proiectTip->slug)) }}"
                           class="btn btn-secondary rounded-3">
                            <i class="fa-solid fa-arrow-left"></i> Înapoi
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
