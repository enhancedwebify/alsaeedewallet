<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Contribution; // <-- ADD THIS LINE

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'full_name',
    //     'email',
    //     'id_number',
    //     'password',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function loanTier()
    {
        return $this->belongsTo(LoanTier::class);
    }
    public function approvals()
    {
        return $this->hasMany(ContributionApprovals::class, 'user_id');
    }
    // User has many contributions
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
    // User has many loans
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // User can be a guarantor for many loans
    public function guarantorsFor()
    {
        return $this->hasMany(Loan::class, 'guarantor_id');
    }
}
