<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $company_name
 * @property string $department_name
 * @property string $contact_hira_first_name
 * @property string $contact_hira_last_name
 * @property string $contact_kata_first_name
 * @property string $contact_kata_last_name
 * @property string $contact_phone_number
 * @property string $contact_email
 * @property integer $area_id
 * @property string $contact_content
 * @property string $contact_agent
 * @property string $contact_ip
 * @property boolean $contact_type
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class CompanyContact extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_contacts';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['company_name', 'department_name', 'contact_hira_first_name', 'contact_hira_last_name', 'contact_kata_first_name', 'contact_kata_last_name', 'contact_phone_number', 'contact_email', 'area_id', 'contact_content', 'contact_agent', 'contact_ip', 'contact_type', 'created_at', 'updated_at', 'deleted_at'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
