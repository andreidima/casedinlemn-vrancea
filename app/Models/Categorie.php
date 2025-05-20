<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categorii';
    protected $guarded = [];

    protected $casts = [
    ];

    public function path($action = 'show')
    {
        return match ($action) {
            'edit' => route('categorii.edit', $this->id),
            'destroy' => route('categorii.destroy', $this->id),
            default => route('categorii.show', $this->id),
        };
    }

    /**
     * Get all of the produse for the Categorie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produse(): HasMany
    {
        return $this->hasMany(Produs::class, 'categorie_id');
    }
}
