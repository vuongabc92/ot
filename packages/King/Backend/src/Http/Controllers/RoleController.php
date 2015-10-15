<?php

namespace King\Backend\Http\Controllers;

use App\Models\Role;

/**
 * Role Controller
 */
class RoleController extends BackController{

    /**
     * List all roles
     * 
     * @return response
     */
    public function index() {

        $roles = Role::all();
        
        return view('backend::role.index', [
            'roles' => $roles
        ]);
    }
    
    public function add() {
        return view('backend::role.add');
    }
}
