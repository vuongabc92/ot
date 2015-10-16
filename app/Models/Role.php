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

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:32',
            'role' => 'required|max:32|unique:roles,role',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required' => _t('backend_role_msg_name_req'),
            'name.max'      => _t('backend_role_msg_name_max'),
            'role.required' => _t('backend_role_msg_role_req'),
            'role.max'      => _t('backend_role_msg_role_max'),
            'role.unique'   => _t('backend_role_msg_role_exist'),
        ];
    }

    /**
     * Users
     *
     * @return App\Models\User
     */
    public function users() {
        return $this->hasMany('App\Models\User');
    }
}
