<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['blog_id','ar_keyword','en_keyword'];

    public function blogs()
    {
        return $this->belongsTo(Blogs::class,'blog_id');
    }
}
