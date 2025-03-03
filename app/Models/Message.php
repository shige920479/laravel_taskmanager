<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'comment',
        'sender',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
