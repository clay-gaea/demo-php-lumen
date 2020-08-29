<?php

namespace App\Models;

use Com\Clay\Common\Libs\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DeptUser extends Model
{
    use SoftDeletes;

    protected $table = 'department_users';
}
