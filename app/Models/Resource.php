<?php

namespace App\Models;

use Com\Clay\Common\Libs\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use SoftDeletes;

    protected $table = 'resources';
}
