<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
class LoanTier extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'loan_tiers';
    // protected $guarded = [];
}

