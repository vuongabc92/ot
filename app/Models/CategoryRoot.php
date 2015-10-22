<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class CategoryRoot extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_root';

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
            'slug' => 'required|max:250',
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
            'name.max'      => 'Name is too long.',
            'slug.required' => 'Slug is required.',
            'slug.max'      => 'Slug is too long.',
        ];
    }
}
