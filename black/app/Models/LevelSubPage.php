<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelSubPage extends Model
{
    use HasFactory;

    protected $fillable = [ 'sub_page_id','level_id'];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function subPage()
    {
        return $this->belongsTo(SubPage::class, 'sub_page_id');
    }

}
