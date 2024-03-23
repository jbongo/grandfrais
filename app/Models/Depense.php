<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * Get the typedepense that owns the Depense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typedepense()
    {
        return $this->belongsTo(Typedepense::class);
    }

}