<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'priority',
        'category',
        'theme',
        'content',
        'deadline',
        'msg_flag',
        'mg_to_mem',
        'mem_to_mg',
        'del_flag',
    ];


    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
