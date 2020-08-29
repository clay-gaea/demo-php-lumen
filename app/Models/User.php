<?php

namespace App\Models;

use Com\Clay\Common\Libs\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';
}
