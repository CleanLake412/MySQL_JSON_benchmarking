<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCollection extends Model
{
    use HasFactory;

    /**
     * @var string テーブル名
     */
    protected $table = 'm_collection';

    protected $primaryKey = 'collection_id';

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'collection_genre_id', 'main_image_id', 'is_public'
    ];

}
