<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $hira_first_name
 * @property string $hira_last_name
 * @property string $kata_first_name
 * @property string $kata_last_name
 * @property string $contact_phone_number
 * @property string $contact_email
 * @property string $contact_content
 * @property string $contact_agent
 * @property string $contact_ip
 * @property boolean $contact_type
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Contact extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['hira_first_name', 'hira_first_name', 'kata_first_name', 'kata_first_name', 'contact_phone_number', 'contact_email', 'contact_content', 'contact_agent', 'contact_ip', 'contact_type', 'created_at', 'updated_at', 'deleted_at'];
}
