<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionLang extends Model
{
    use HasFactory;

    /**
     * @var string テーブル名
     */
    protected $table = 'collection_lang';

    protected $casts =[
        'common_items' => 'array',
        'custom_items' => 'array',
    ];
}
