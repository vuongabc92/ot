<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\ImageCategory;
use Validator;

/**
 * ImageCategory Controller
 */
class ImageCategoryController extends BackController{

    private $imageCategory;

    /**
     * Constructor
     *
     * @param App\Models\ImageCategory $imageCategory
     */
    public function __construct(ImageCategory $imageCategory)
    {
        $this->imageCategory = $imageCategory;
    }


    /**
     * List all image categorys
     *
     * @return response
     */
    public function index() {

        $imageCategories = ImageCategory::all();

        return view('backend::image_category.index', [
            'image_categories' => $imageCategories
        ]);
    }

    /**
     * Add image category page
     *
     * @return response
     */
    public function add() {
        return view('backend::image_category.form', [
            'image_category'   => $this->imageCategory
        ]);
    }

    /**
     * Add image category page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::image_category.form', [
            'image_category' => $this->_getImageCategoryById($id),
        ]);
    }

    /**
     * Save image category
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit         = $request->has('id');
            $imageCategory = ($edit) ? $this->_getImageCategoryById($request->get('id')) : $this->imageCategory;
            $rules        = $this->imageCategory->rules();
            $messages     = $this->imageCategory->messages();

            if ($edit && str_equal($imageCategory->slug, $request->get('slug'))) {
                $rules = remove_rules($rules, ['slug.unique:image_categories,slug']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $imageCategory = $this->bind($imageCategory, $request->all());
                $imageCategory->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_image_categories'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete image category
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

        $imageCategory = $this->_getImageCategoryById($id);
        $imageCategory->delete();

        return redirect(route('backend_image_categories'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide imageCategory
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $imageCategory = $this->_getImageCategoryById($id);

        if ($imageCategory->is_active) {
            $imageCategory->is_active = false;
        } else {
            $imageCategory->is_active = true;
        }

        $imageCategory->save();

        return redirect(route('backend_image_categories'));
    }

    /**
     * Get image category by id
     *
     * @param int $id
     *
     * @return ImageCategory
     * @throws NotFoundHttpException
     */
    protected function _getImageCategoryById($id) {

        $imageCategory = $this->imageCategory->find((int) $id);

        if ($imageCategory === null) {
            throw new NotFoundHttpException;
        }

        return $imageCategory;
    }
}
