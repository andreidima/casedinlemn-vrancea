<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produs extends Model
{
    use HasFactory;

    protected $table = 'produse';
    protected $guarded = [];

    protected $casts = [
        'data_procesare' => 'date',
        'cantitate' => 'integer',
        'prag_minim' => 'integer',
        'lungime' => 'float',
        'latime' => 'float',
        'grosime' => 'float',
        'pret' => 'float',
    ];

    public function path($action = 'show')
    {
        return match ($action) {
            'edit' => route('produse.edit', $this->id),
            'destroy' => route('produse.destroy', $this->id),
            default => route('produse.show', $this->id),
        };
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }


    /** 1️⃣ Define the one-to-many relationship to stock-movements */
    public function miscariStoc(): HasMany
    {
        return $this->hasMany(MiscareStoc::class, 'produs_id');
    }
    /**
     * 2️⃣ On “deleting”, clean up all related movements in code
     *    (instead of DB-cascade) so you can inject any extra logic if needed.
     */
    protected static function booted()
    {
        static::deleting(function (Produs $produs) {
            // delete all movements before the product is removed
            $produs->miscariStoc()->delete();
        });
    }
}
