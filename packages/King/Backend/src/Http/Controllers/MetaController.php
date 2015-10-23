<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\Meta;
use Validator;

/**
 * Meta Controller
 */
class MetaController extends BackController{

    private $meta;

    /**
     * Constructor
     *
     * @param App\Models\Meta $meta
     */
    public function __construct(Meta $meta)
    {
        $this->meta = $meta;
    }


    /**
     * List all metas
     *
     * @return response
     */
    public function index() {

        $metas = Meta::all();

        return view('backend::meta.index', [
            'metas' => $metas
        ]);
    }

    /**
     * Add meta page
     *
     * @return response
     */
    public function add() {
        return view('backend::meta.form', [
            'meta' => $this->meta
        ]);
    }

    /**
     * Add meta page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::meta.form', [
            'meta' => $this->_getMetaById($id),
        ]);
    }

    /**
     * Save meta
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     *
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit     = $request->has('id');
            $meta     = ($edit) ? $this->_getMetaById($request->get('id')) : $this->meta;
            $rules    = $this->meta->rules();
            $messages = $this->meta->messages();

            if ($edit && str_equal($meta->key, $request->get('key'))) {
                $rules = remove_rules($rules, ['key.unique:meta,key']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $meta = $this->bind($meta, $request->all());
                $meta->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_meta'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete meta
     *
     * @param int    $id
     * @param string $token
     *
     * @return type
     * @throws TokenMismatchException
     */
    public function delete($id, $token) {

        if (session()->token() != $token) {
            throw new TokenMismatchException;
        }

        $meta = $this->_getMetaById($id);
        $meta->delete();

        return redirect(route('backend_meta'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide meta
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $meta = $this->_getMetaById($id);

        if ($meta->is_active) {
            $meta->is_active = false;
        } else {
            $meta->is_active = true;
        }

        $meta->save();

        return redirect(route('backend_meta'));
    }

    /**
     * Get meta by id
     *
     * @param int $id
     *
     * @return Meta
     * @throws NotFoundHttpException
     */
    protected function _getMetaById($id) {

        $meta = $this->meta->find((int) $id);

        if ($meta === null) {
            throw new NotFoundHttpException;
        }

        return $meta;
    }
}
