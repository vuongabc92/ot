<?php

namespace King\Backend\Http\Controllers;

use Illuminate\Http\Request;

trait Back {

    public $object;
    public $imagePath;
    public $view;

    /**
     * Listing all objects
     *
     * @return Response
     */
    public function index() {

        $pagingConfig = $this->getPagingConfig();
        $object       = $this->object->orderBy('weight', 'DESC')->paginate($pagingConfig);
        $view         = $this->view . 'index';

        return view($view, [
            'data'       => $object,
            'image_path' => $this->imagePath
        ]);
    }

    /**
     * Adding new oblect
     *
     * @return Response
     */
    public function add(){}

    /**
     * Editing an object
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id){}

    /**
     * Saving an object
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function save(Request $request){}

    /**
     * Deleting an object
     *
     * @param int    $id
     * @param string $token
     *
     * @return Response
     */
public function delete($id, $token){}

    /**
     * Deleting list objects
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function deleteSelected(Request $request){}

    /**
     * Toggle show hide an object
     *
     * @param int $id
     *
     * @return Response
     */
    public function toggleShowHide($id){}

    /**
     * Get paging config
     *
     * @return int
     */
    public function getPagingConfig() {
        return config('back.default_pagination');
    }
}
