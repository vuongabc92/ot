<?php

namespace King\Backend\Http\Controllers;

class MapController extends BackController{

    public function index() {
        return view('backend::map.index');
    }
}
