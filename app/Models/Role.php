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
            'role' => 'required|max:32|unique:role,role',
        ];
    }
    
    /**
     * Validation rule messages
     * 
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'Name is required.',
            'name.max'      => 'Name is too long (32).',
            'role.required' => 'Role is required.',
            'role.max'      => 'Role is too long (32).',
            'role.unique'   => 'Role had already used.',
        ];
    }
}
