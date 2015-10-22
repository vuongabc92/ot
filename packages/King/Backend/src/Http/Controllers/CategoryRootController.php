<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\CategoryRoot;
use Validator;

/**
 * CategoryRoot Controller
 */
class CategoryRootController extends BackController{

    private $categoryRoot;

    /**
     * Constructor
     *
     * @param App\Models\CategoryRoot $categoryRoot
     */
    public function __construct(CategoryRoot $categoryRoot)
    {
        $this->categoryRoot = $categoryRoot;
    }


    /**
     * List all category root
     *
     * @return response
     */
    public function index() {

        $categoryRoot = CategoryRoot::all();

        return view('backend::category_root.index', [
            'category_root' => $categoryRoot
        ]);
    }

    /**
     * Add category root page
     *
     * @return response
     */
    public function add() {
        return view('backend::category_root.form', [
            'category_root'   => $this->categoryRoot
        ]);
    }

    /**
     * Add category root page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::category_root.form', [
            'category_root' => $this->_getCategoryRootById($id),
        ]);
    }

    /**
     * Save category root
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit         = $request->has('id');
            $categoryRoot = ($edit) ? $this->_getCategoryRootById($request->get('id')) : $this->categoryRoot;
            $rules        = $this->categoryRoot->rules();
            $messages     = $this->categoryRoot->messages();

            if ($edit && str_equal($categoryRoot->slug, $request->get('slug'))) {
                $rules = remove_rules($rules, ['slug.unique:category_root,slug']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $categoryRoot = $this->bind($categoryRoot, $request->all());
                $categoryRoot->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_category_root'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete category root
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

        $categoryRoot = $this->_getCategoryRootById($id);
        $categoryRoot->delete();

        return redirect(route('backend_category_root'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide categoryRoot
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $categoryRoot = $this->_getCategoryRootById($id);

        if ($categoryRoot->is_active) {
            $categoryRoot->is_active = false;
        } else {
            $categoryRoot->is_active = true;
        }

        $categoryRoot->save();

        return redirect(route('backend_category_root'));
    }

    /**
     * Get category root by id
     *
     * @param int $id
     *
     * @return CategoryRoot
     * @throws NotFoundHttpException
     */
    protected function _getCategoryRootById($id) {

        $categoryRoot = $this->categoryRoot->find((int) $id);

        if ($categoryRoot === null) {
            throw new NotFoundHttpException;
        }

        return $categoryRoot;
    }
}
