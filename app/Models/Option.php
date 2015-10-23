<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Option extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'options';

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
            'key'   => 'required|max:250|unique:meta,key|alpha_dash',
            'value' => 'required|max:250',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'key.required'   => 'Key is required.',
            'key.max'        => 'Key is too long.',
            'key.unique'     => 'Key had already used.',
            'key.alpha_dash' => 'Key only contains: a-z, 0-9, "-" and "_"',
            'value.required' => 'Value is required.',
            'value.max'      => 'Value is too long.',
        ];
    }

}
