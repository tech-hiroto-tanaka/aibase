<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $job_code
 * @property string $job_name
 * @property string $job_cost
 * @property string $job_match_skill
 * @property string $job_period
 * @property boolean $type_of_job
 * @property string $office_towns
 * @property mixed $genres
 * @property mixed $areas
 * @property mixed $skills
 * @property mixed $desired_costs
 * @property mixed $features
 * @property string $job_publish_start_date
 * @property string $job_publish_end_date
 * @property boolean $job_publish_status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Job extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['job_code', 'job_name', 'job_cost', 'job_match_skill', 'job_period', 'type_of_job', 'office_towns', 'genres', 'areas', 'skills', 'desired_costs', 'features', 'job_publish_start_date', 'job_publish_end_date', 'job_publish_status', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'genres' => 'array',
        'areas' => 'array',
        'skills' => 'array',
        'desired_costs' => 'array',
        'features' => 'array',
        'prefectures' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
    protected $appends = ['publish_start_date_format', 'publish_end_date_format'];
    public function getPublishEndDateFormatAttribute()
    {
        return Carbon::parse($this->job_publish_end_date)->format('Y/m/d H:i');
    }
    public function getPublishStartDateFormatAttribute()
    {
        return Carbon::parse($this->job_publish_start_date)->format('Y/m/d H:i');
    }

    public function favorite()
    {
        return $this->hasOne(Favorite::class);
    }

    public function users()
    {
        return $this->hasOne('App\Models\Application');
    }
}
