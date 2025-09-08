<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Loan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'loans';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function guarantor()
    {
        return $this->belongsTo(User::class, 'guarantor_id');
    }

    public function loanTier()
    {
        return $this->belongsTo(LoanTier::class);
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }
}
