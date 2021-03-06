<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class PostCategory extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_categories';

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
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:post_categories,slug|alpha_dash',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required'   => 'Name is required.',
            'name.max'        => 'Name is too long.',
            'slug.required'   => 'Slug is required.',
            'slug.max'        => 'Slug is too long.',
            'slug.unique'     => 'Slug had already used.',
            'slug.alpha_dash' => 'Slug only contains: a-z, 0-9, "-" and "_"',
        ];
    }

}
