<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Image extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'name'    => 'max:250',
            'image'   => 'required|image',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'name.max'         => _t('backend_image_msg_namax'),
            'image.required'   => _t('backend_image_msg_imgreq'),
            'image.image'      => _t('backend_image_msg_image'),
        ];
    }

    /**
     * Post Category
     *
     * @return App\Models\PostCategory
     */
    public function postCategory() {
        return $this->hasOne('App\Models\ImageCategory');
    }
}
