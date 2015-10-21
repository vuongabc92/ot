<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Meta extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meta';

    /**
     * No timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'key'      => 'required|max:250|unique:meta,key|alpha_dash',
            'key_name' => 'required|max:250',
            'value'    => 'required|max:250',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'key.required'      => 'Key is required.',
            'key.max'           => 'Key is too long.',
            'key.unique'        => 'Key had already used.',
            'key.alpha_dash'    => 'Key only contains: a-z, 0-9, "-" and "_"',
            'key_name.required' => 'Key name is required.',
            'key_name.max'      => 'Key name is too long.',
            'value.required'    => 'Value is required.',
            'value.max'         => 'Value is too long.',
        ];
    }

}
