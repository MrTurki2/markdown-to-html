<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkdownFile extends Model
{
    protected $fillable = [
        'filename',
        'markdown',
        'html'
    ];
}
