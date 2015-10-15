<?php

namespace King\Backend\Http\Controllers;

class RoleController extends BackController{

    public function index() {
        return view('backend::role.index');
    }
}
