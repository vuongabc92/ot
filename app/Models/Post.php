<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Post extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'name'    => 'required|max:250',
            'content' => 'required',
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
            'name.required'    => _t('backend_post_msg_nareq'),
            'name.max'         => _t('backend_post_msg_namax'),
            'content.required' => _t('backend_post_msg_coreq'),
            'image.required'   => _t('backend_post_msg_imgreq'),
            'image.image'      => _t('backend_post_msg_image'),
        ];
    }

    /**
     * Post Category
     *
     * @return App\Models\PostCategory
     */
    public function postCategory() {
        return $this->hasOne('App\Models\PostCategory');
    }
}
