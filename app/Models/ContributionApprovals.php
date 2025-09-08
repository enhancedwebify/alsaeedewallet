<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContributionApprovals extends Model
{
    //
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'contribution_approvals';
    protected $guarded = [];
       // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function loanTier()
    {
        return $this->belongsTo(LoanTier::class, 'loan_tier_id');
    }
}
