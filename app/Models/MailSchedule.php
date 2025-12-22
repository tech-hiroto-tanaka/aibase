<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $mail_template_id
 * @property string $mail_from_user_name
 * @property string $mail_from_user_email
 * @property string $mail_subject
 * @property string $mail_body
 * @property string $mail_reply_to_email
 * @property integer $mail_send_number
 * @property string $mail_send_datetime
 * @property string $mail_send_file_path
 * @property string $file_name
 * @property string $mail_condition
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class MailSchedule extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mail_schedule';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['mail_template_id', 'mail_from_user_name', 'mail_from_user_email', 'mail_subject', 'mail_body', 'mail_reply_to_email', 'mail_send_number', 'mail_send_datetime', 'mail_send_file_path', 'file_name', 'mail_condition', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'mail_condition' => 'array'
    ];
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
    protected $appends = ['mail_send_datetime_format', 'is_send', 'mail_send_datetime_format1', 'files'];
    public function getMailSendDateTimeFormatAttribute(): string
    {
        return Carbon::parse($this->mail_send_datetime)->format('Y年m月d日H時i分');
    }
    public function getMailSendDateTimeFormat1Attribute(): string
    {
        return Carbon::parse($this->mail_send_datetime)->format('Y/m/d H:i');
    }
    public function getIsSendAttribute()
    {
        return Carbon::now() > Carbon::parse($this->mail_send_datetime);
    }

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'mail_template_id');
    }

    public function getFilesAttribute()
    {
        if (!$this->mail_send_file_path) {
            return [];
        }
        return [
            [
                'id' => random_int(1000, 10000),
                'name' => $this->file_name
            ]
        ];
    }
}
