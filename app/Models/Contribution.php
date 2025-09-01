<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Contribution extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'contributions';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
