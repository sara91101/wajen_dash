<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [ 'page'];

    public function subPage()
    {
        return $this->hasMany(SubPage::class, 'page_id');
    }
}
