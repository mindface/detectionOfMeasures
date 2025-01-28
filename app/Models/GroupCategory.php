<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'make_user_id',
        'title',
        'detail',
        'count_user_ids',
        'count_task_ids',
        'group_id',
    ];

    public function caseStudies()
    {
        return $this->hasMany(CaseStudy::class, 'group_id', 'group_id');
    }
}
