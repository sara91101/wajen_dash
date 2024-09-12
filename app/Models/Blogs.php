<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    protected $fillable = ['starred','department_id', 'ar_title', 'en_title', 'ar_details', 'en_details', 'image'];

    public function department()
    {
        return $this->belongsTo(BlogDepartment::class,"department_id");
    }

    public function keyword()
    {
        return $this->hasMany(Keyword::class,'blog_id');
    }

}
