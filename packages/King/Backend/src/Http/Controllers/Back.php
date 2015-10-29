<?php

namespace King\Backend\Http\Controllers;

use Illuminate\Http\Request;

trait Back {

    private $_object;
    private $_image;
    private $_view;
    private $_paging;

    public function setObject($object) {

        $this->_object = $object;

        return $this;
    }

    public function getObject() {
        return $this->_object;
    }

    public function setImage($image) {

        $this->_image = $image;

        return $this;
    }

    public function getImagePath() {
        return $this->_imagePath;
    }

    public function setView($view) {

        $this->_view = $view;

        return $this;
    }

    public function getView() {
        return $this->_view;
    }

    public function setPaging($paging) {

        $this->_paging = $paging;

        return $this;
    }

    public function getPaging() {
        return $this->_paging;
    }

    /**
     * Listing all objects
     *
     * @return Response
     */
    public function index() {

        $paging = $this->getPaging();
        $object = $this->_object->orderBy('weight', 'DESC')->paginate($paging);
        $view   = $this->_view . '.index';

        return view($view, [
            'lists'      => $object,
            'image_path' => $this->_image
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

}
