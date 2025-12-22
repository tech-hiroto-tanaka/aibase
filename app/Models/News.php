<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property string $news_title
 * @property string $news_content
 * @property string $news_url
 * @property string $news_file_url
 * @property string $news_file_name
 * @property string $news_publish_start_datetime
 * @property string $news_publish_end_datetime
 * @property boolean $news_publish_status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class News extends Model
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
    protected $fillable = ['news_title', 'news_content', 'news_url', 'news_file_url', 'news_file_name', 'news_publish_start_datetime', 'news_publish_end_datetime', 'news_publish_status', 'created_at', 'updated_at', 'deleted_at'];

    public function userNew()
    {
        return $this->hasOne(UserNews::class, 'new_id', 'id');
    }

    protected $appends = ['publish_start_date_format', 'publish_end_date_format', 'publish_start_date_format_1', 'publish_end_date_format_1'];
    public function getPublishStartDateFormatAttribute()
    {
        return Carbon::parse($this->news_publish_start_datetime)->format('Y/m/d H:i');
    }
    public function getPublishEndDateFormatAttribute()
    {
        return Carbon::parse($this->news_publish_end_datetime)->format('Y/m/d H:i');
    }
    public function getPublishStartDateFormat1Attribute()
    {
        return Carbon::parse($this->news_publish_start_datetime)->format('Y.m.d');
    }
    public function getPublishEndDateFormat1Attribute()
    {
        return Carbon::parse($this->news_publish_end_datetime)->format('Y.m.d');
    }
}
