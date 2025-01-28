<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'title',
        'detail',
        'group_id',
        'case_number',
    ];

    protected $primaryKey = 'case_number';
    public $incrementing = true;
    protected $keyType = 'int';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groupCategory()
    {
        return $this->belongsTo(GroupCategory::class, 'group_id', 'group_id');
    }
}
