<?php

namespace King\Backend\Http\Controllers;

class IndexController extends BackController{

    public function index() {
        return view('backend::index.index');
    }
}
