<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $job_id
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Job $job
 * @property User $user
 */
class Application extends Model
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
    protected $fillable = ['user_id', 'job_id', 'status', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function userEmailSortable($query, $direction)
    {
        return $query->orderBy('users.email', $direction);
    }
    public function jobCodeSortable($query, $direction)
    {
        return $query->orderBy('jobs.job_code', $direction);
    }
    public function jobNameSortable($query, $direction)
    {
        return $query->orderBy('jobs.job_name', $direction);
    }
    public function startDateSortable($query, $direction)
    {
        return $query->orderBy('jobs.job_publish_start_date', $direction);
    }
    public function endDateSortable($query, $direction)
    {
        return $query->orderBy('jobs.job_publish_end_date', $direction);
    }
}
