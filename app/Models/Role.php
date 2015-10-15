<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Role extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

}
