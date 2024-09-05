<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPage extends Model
{
    use HasFactory;

    protected $fillable = [ 'page_id','sub_page'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function subPageOperation()
    {
        return $this->hasMany(SubPageOperation::class,"sub_page_id");
    }

    public function levelSubPage()
    {
        return $this->hasMany(LevelSubPage::class,"sub_page_id");
    }
}
