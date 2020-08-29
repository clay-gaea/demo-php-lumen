<?php

namespace App\Models;

use Com\Clay\Common\Libs\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'departments';

    public function users()
    {
        return $this->belongsToMany(User::class, 'department_users', 'department_id', 'user_id');
    }
}
