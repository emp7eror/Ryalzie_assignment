<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $table = 'branches';
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address'];

    function branch()
    {
        return $this->hasMany(Transaction::class, 'branch_id', 'id');
    }
}
