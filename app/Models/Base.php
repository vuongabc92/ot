<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Base extends Model {

    public function generateSlug($i = '') {
        
        $slug = str_slug($this->name) . $i;
        if ($this->slug !== null) {
            $find = $this->where('slug', $slug)->where('slug', '!=', $this->slug)->first();
        } else {
            $find = $this->where('slug', $slug)->first();
        }
        
        while ($find !== null) {
            $i    = ((int) $i) + 1;
            $slug = $this->generateSlug($i);
        }
        
        $this->slug = $slug;
    }
}
