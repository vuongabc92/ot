<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use Validator;

/**
 * PostCategory Controller
 */
class PostCategoryController extends BackController{

    private $postCategory;

    /**
     * Constructor
     *
     * @param App\Models\PostCategory $postCategory
     */
    public function __construct(PostCategory $postCategory)
    {
        $this->postCategory = $postCategory;
    }


    /**
     * List all post categorys
     *
     * @return response
     */
    public function index() {

        $postCategories = PostCategory::all();

        return view('backend::post_category.index', [
            'post_categories' => $postCategories
        ]);
    }

    /**
     * Add post category page
     *
     * @return response
     */
    public function add() {
        return view('backend::post_category.form', [
            'post_category'   => $this->postCategory
        ]);
    }

    /**
     * Add post category page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::post_category.form', [
            'post_category' => $this->_getPostCategoryById($id),
        ]);
    }

    /**
     * Save post category
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit         = $request->has('id');
            $postCategory = ($edit) ? $this->_getPostCategoryById($request->get('id')) : $this->postCategory;
            $rules        = $this->postCategory->rules();
            $messages     = $this->postCategory->messages();

            if ($edit && str_equal($postCategory->slug, $request->get('slug'))) {
                $rules = remove_rules($rules, ['slug.unique:post_categories,slug']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $postCategory = $this->bind($postCategory, $request->all());
                $postCategory->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_post_categories'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete post category
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

        $postCategory = $this->_getPostCategoryById($id);
        $postCategory->delete();

        return redirect(route('backend_post_categories'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide postCategory
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $postCategory = $this->_getPostCategoryById($id);

        if ($postCategory->is_active) {
            $postCategory->is_active = false;
        } else {
            $postCategory->is_active = true;
        }

        $postCategory->save();

        return redirect(route('backend_post_categories'));
    }

    /**
     * Get post category by id
     *
     * @param int $id
     *
     * @return PostCategory
     * @throws NotFoundHttpException
     */
    protected function _getPostCategoryById($id) {

        $postCategory = $this->postCategory->find((int) $id);

        if ($postCategory === null) {
            throw new NotFoundHttpException;
        }

        return $postCategory;
    }
}
