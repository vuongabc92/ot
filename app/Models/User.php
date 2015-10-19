<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Base implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'username' => 'required|max:32|unique:users,email',
            'email'    => 'required|email|max:128|unique:users,email',
            'password' => 'required|max:60',
            'role_id'  => 'required|exists:roles,id',
            'avatar'   => 'image',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'username.required' => _t('backend_user_msg_unreq'),
            'username.max'      => _t('backend_user_msg_unmax'),
            'username.unique'   => _t('backend_user_msg_ununi'),
            'email.required'    => _t('backend_user_msg_ereq'),
            'email.max'         => _t('backend_user_msg_emax'),
            'email.unique'      => _t('backend_user_msg_euni'),
            'email.email'       => _t('backend_user_msg_email'),
            'password.required' => _t('backend_user_msg_pareq'),
            'password.max'      => _t('backend_user_msg_pamax'),
            'role_id.required'  => _t('backend_user_msg_roreq'),
            'role_id.exists'    => _t('backend_user_msg_roexi'),
            'avatar.max'        => _t('backend_user_msg_avmax'),
            'avatar.image'      => _t('backend_user_msg_avimg'),
        ];
    }

    /**
     * Users
     *
     * @return App\Models\User
     */
    public function role() {
        return $this->belongsTo('App\Models\Role');
    }
}
