<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = ['nom','user_id', 'date_debut', 'date_fin'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
