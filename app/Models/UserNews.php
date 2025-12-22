<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $new_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class UserNews extends Model
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
    protected $fillable = ['user_id', 'new_id', 'created_at', 'updated_at', 'deleted_at'];
}
