<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'mobile'];

    function transaction()
    {
        return $this->hasMany(Transaction::class, 'client_id', 'id');
    }
}
