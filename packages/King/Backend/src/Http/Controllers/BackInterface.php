<?php

namespace King\Backend\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Describes a basic controller.
 */
interface BackInterface {

    /**
     * Listing all objects
     *
     * @return Response
     */
    public function index();

    /**
     * Adding new oblect
     *
     * @return Response
     */
    public function add();

    /**
     * Editing an object
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id);

    /**
     * Saving an object
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function save(Request $request);

    /**
     * Deleting an object
     *
     * @param int    $id
     * @param string $token
     *
     * @return Response
     */
    public function delete($id, $token);

    /**
     * Deleting list objects
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function deleteSelected(Request $request);

    /**
     * Toggle show hide an object
     *
     * @param int $id
     *
     * @return Response
     */
    public function toggleShowHide($id);

}
