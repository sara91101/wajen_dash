<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDepartment extends Model
{
    use HasFactory;

    protected $fillable = [ 'ar_department', 'en_department'];

    public function blog()
    {
        return $this->hasMany(Blogs::class,"department_id");
    }
}
