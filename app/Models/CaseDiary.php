<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_number',
        'court_id',
        'party_names',
        'case_date',
        'purpose',
        'opposit_lawyer',
        'notes',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
