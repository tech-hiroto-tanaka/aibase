<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $mail_name
 * @property string $mail_from_user_name
 * @property string $mail_from_user_email
 * @property string $mail_subject
 * @property string $mail_body
 * @property string $mail_reply_to_email
 * @property string $mail_send_file_path
 * @property string $file_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class MailTemplate extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mail_template';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['mail_name', 'mail_from_user_name', 'mail_from_user_email', 'mail_subject', 'mail_body', 'mail_reply_to_email', 'mail_send_file_path', 'file_name', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['files'];

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
