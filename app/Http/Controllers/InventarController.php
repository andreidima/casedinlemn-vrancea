<?php
namespace App\Http\Controllers;

use App\Models\Produs;
use App\Models\MiscareStoc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventarController extends Controller
{
    /**
     * Show either intrări (delta>0) or ieșiri (delta<0), with filters.
     */
    public function index(Request $request, string $tip)
    {
        // ensure $tip is valid
        if (! in_array($tip, ['intrari', 'iesiri'])) {
            abort(404);
        }

        // grab filter inputs
        $searchProdus       = $request->query('searchProdus');
        $searchUser         = $request->query('searchUser');
        $searchIntervalData = $request->query('searchIntervalData');
        $searchNrComanda    = $request->query('searchNrComanda');

        // base query
        $query = MiscareStoc::with(['produs','user'])
            ->when($tip === 'intrari',
                fn($q) => $q->where('delta','>',0),
                fn($q) => $q->where('delta','<',0)
            )
            ->when($searchProdus, fn($q) =>
                $q->whereHas('produs', fn($q2) =>
                    $q2->where('nume','like', "%{$searchProdus}%")
                )
            )
            ->when($searchUser, fn($q) =>
                $q->where('user_id', $searchUser)
            )
            ->when($searchIntervalData, function ($q, $searchIntervalData) {
                $dates = explode(',', $searchIntervalData);
                $q->whereBetween('created_at', [$dates[0] ?? null, $dates[1] ?? null]);
            })
            ->when($tip === 'iesiri' && $searchNrComanda, function($q) use ($searchNrComanda) {
                $q->where('nr_comanda', 'LIKE', $searchNrComanda);
            });

        $movements = $query
            ->orderBy('created_at','desc')
            ->simplePaginate(25)
            ->withQueryString();

        // for the user filter dropdown
        $users = User::select('id','name')
            ->where('id', '>', 1) // se sare pentru user 1, Andrei Dima
            ->orderBy('name')->get();

        return view('miscari.index', compact(
            'movements','tip',
            'searchNrComanda', 'searchProdus','searchUser','searchIntervalData','users'
        ));
    }

    /**
     * Display the stock-adjustment UI (the target of the QR scan).
     *
     * @param  \App\Models\Produs  $produs
     * @return \Illuminate\View\View
     */
    public function show(Produs $produs)
    {
        return view('inventar.show', compact('produs'));
    }

    /**
     * Handle the stock‐adjustment submission and log the movement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produs        $produs
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Produs $produs)
    {
        $rules = [
            'tip'         => 'required|in:intrare,iesire',
            'cantitate'   => 'required|integer|min:1',
        ];
        if ($request->tip === 'iesire') {
            $rules['nr_comanda'] = 'required|string|max:50';
        }

        $data = $request->validate($rules);

        // Compute the signed delta
        $delta = $data['tip'] === 'intrare'
            ? $data['cantitate']
            : - $data['cantitate'];

        $newQty = $produs->cantitate + $delta;

        if ($newQty < 0) {
            return back()
                ->withErrors(['cantitate' => 'Nu puteți scoate mai multe produse decât aveți în stoc.'])
                ->withInput();
        }

        DB::transaction(function () use ($produs, $delta, $data) {
            MiscareStoc::create([
                'produs_id'     => $produs->id,
                'user_id'       => Auth::id(),
                'delta'         => $delta,
                'nr_comanda'  => $data['nr_comanda'] ?? null,
            ]);
            $produs->update(['cantitate' => $produs->cantitate + $delta]);
        });

        return back()->with('status', 'Stocul a fost actualizat cu succes.');
    }

    /**
     * Undo (anulează) the given movement by creating the inverse record.
     */
    public function undo(MiscareStoc $miscare)
    {
        DB::transaction(function () use ($miscare) {
            // 1) Roll back the quantity change
            $produs = $miscare->produs;
            // Subtract the original delta: if delta was +5, subtract 5; if -3, add 3
            $produs->cantitate -= $miscare->delta;

            $produs->save();

            // 2) Remove the movement record
            $miscare->delete();
        });

        return back()->with('status', 'Mișcare anulată și ștersă cu succes.');
    }

}
