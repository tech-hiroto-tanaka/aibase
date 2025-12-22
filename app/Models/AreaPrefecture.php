<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $area_id
 * @property integer $prefecture_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Area $area
 * @property Prefecture $prefecture
 */
class AreaPrefecture extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['area_id', 'prefecture_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prefecture()
    {
        return $this->hasOne(Prefecture::class, 'id', 'prefecture_id');
    }
}
