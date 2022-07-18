<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionDetail extends Model
{
    use HasFactory;

    /**
     * @var string テーブル名
     */
    protected $table = 'collection_details';

    public $timestamps = false;

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'collection_id', 'lang_code', 'item_id', 'item_value'
    ];

}
