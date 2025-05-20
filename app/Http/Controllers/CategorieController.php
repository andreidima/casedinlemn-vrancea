<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Http\Requests\CategorieRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->session()->forget('returnUrl');

        $searchNume = trim($request->searchNume);

        $categorii = Categorie::when($searchNume, function ($query, $searchNume) {
                return $query->where('nume', 'LIKE', "%{$searchNume}%");
            })
            ->latest()
            ->simplePaginate(25);

        return view('categorii.index', compact('categorii', 'searchNume'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->session()->get('returnUrl') ?:
            $request->session()->put('returnUrl', url()->previous());

        return view('categorii.save')->with([
            'preFilledFields' => $request->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request)
    {
        $data = $request->validated();

        $categorie = Categorie::create($data);

        return redirect(
            $request->session()->get('returnUrl', route('categorii.index'))
        )->with('status', 'Categoria <strong>' . e($categorie->nume) . '</strong> a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Categorie $categorie)
    {
        $request->session()->get('returnUrl') ?:
            $request->session()->put('returnUrl', url()->previous());

        return view('categorii.show', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Categorie $categorie)
    {
        $request->session()->get('returnUrl') ?:
            $request->session()->put('returnUrl', url()->previous());

        return view('categorii.save', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request, Categorie $categorie)
    {
        $data = $request->validated();

        $categorie->update($data);

        return redirect(
            $request->session()->get('returnUrl', route('categorii.index'))
        )->with('status', 'Categoria <strong>' . e($categorie->nume) . '</strong> a fost actualizată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Categorie $categorie)
    {
        if ($categorie->produse()->exists()) {
            return back()->with('error', 'Categoria nu poate fi ștearsă deoarece este asociată cu unul sau mai multe produse.');
        }

        $categorie->delete();

        return back()->with('status', 'Categoria <strong>' . e($categorie->nume) . '</strong> a fost ștearsă cu succes!');
    }
}
