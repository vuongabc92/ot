<?php

namespace King\Backend\Http\Controllers;

use App\Models\Role;

class RoleController extends BackController{

    public function index() {

        $roles = Role::all();
        
        return view('backend::role.index', array(
            'roles' => $roles
        ));
    }
}
