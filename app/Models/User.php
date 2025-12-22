<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property integer $id
 * @property string $hira_first_name
 * @property string $hira_last_name
 * @property string $kata_first_name
 * @property string $kata_last_name
 * @property string $email
 * @property string $password
 * @property string $birthday
 * @property boolean $gender
 * @property string $phone_number
 * @property integer $area_id
 * @property string $desired_work_type
 * @property string $experience_skills_from_date
 * @property string $experience_skills_detail
 * @property string $nearest_station_name
 * @property string $other_requests
 * @property string $email_verified_at
 * @property string $reset_password_token
 * @property string $reset_password_token_expire
 * @property string $last_login_at
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends Authenticatable
{
    use HasFactory, SoftDeletes, Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['hira_first_name', 'hira_last_name', 'kata_first_name', 'kata_last_name', 'email', 'password', 'birthday', 'gender', 'phone_number', 'area_id', 'desired_work_type', 'experience_skills_from_date', 'experience_skills_detail', 'nearest_station_name', 'other_requests', 'email_verified_at', 'reset_password_token', 'reset_password_token_expire', 'last_login_at', 'remember_token', 'created_at', 'updated_at', 'deleted_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $appends = ['birthday_date_format', 'experience_skills_from_date_format'];

    public function getBirthdayDateFormatAttribute()
    {
        return Carbon::parse($this->birthday)->format('Y/m/d');
    }

    public function getExperienceSkillsFromDateFormatAttribute()
    {
        return $this->experience_skills_from_date ? Carbon::parse($this->experience_skills_from_date)->format('Y/m/d') : null;
    }

    protected $hidden = [
        'password',
        'remember_token',
        'reset_password_token',
        'reset_password_token_expire',
        'last_login_at'
    ];

    public function applications()
    {
        return $this->hasOne('App\Models\Application');
    }
    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }

    public $sortable = ['name', 'name_kata', 'email', 'created_at', 'gender'];
    public function nameSortable($query, $direction)
    {
        return $query->orderBy(DB::raw('CONCAT(hira_first_name, "　", hira_last_name)'), $direction);
    }
    public function nameKataSortable($query, $direction)
    {
        return $query->orderBy(DB::raw('CONCAT(kata_first_name, "　", kata_last_name)'), $direction);
    }
}
