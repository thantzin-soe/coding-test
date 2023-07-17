<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function AssignedUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_user');
    }
}
