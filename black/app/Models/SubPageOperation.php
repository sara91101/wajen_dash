<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPageOperation extends Model
{
    use HasFactory;

    protected $fillable = [ 'sub_page_id','operation'];

    public function subPage()
    {
        return $this->belongsTo(SubPage::class, 'sub_page_id');
    }
}
