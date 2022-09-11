<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['client_id', 'branch_id', 'type', 'status', 'amount', 'date'];

    function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }


}
