<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function scopeSearch($query, $search)
    {
        $member_id = $search['name'] ?? '';
        $category = $search['category'] ?? '';
        $theme = $search['theme'] ?? '';

        $query->when($member_id, function($query, $member_id) {
            $query->where('user_id', $member_id);
        }) ;

        $query->when($category, function($query, $category) {
            $query->where('category', 'like', "%$category%");
        });

        if($theme !== null) {
            $theme_split = mb_convert_kana($theme, 's');
            $theme_split2 = preg_split('/[\s]+/', $theme_split);
            foreach($theme_split2 as $value) {
                $query->when($value, function($query, $value) {
                    $query->where('theme', 'like', "%$value%");
                });
            }
        }
        return $query;
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
