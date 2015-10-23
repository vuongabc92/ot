<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\CategoryOne;
use App\Models\CategoryRoot;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * CategoryOne Controller
 */
class CategoryOneController extends BackController{

    /**
     *
     * @var App\Models\CategoryOne
     */
    private $categoryOne;

    private $upload_path;

    /**
     * Constructor
     *
     * @param App\Models\CategoryOne $categoryOne
     */
    public function __construct(CategoryOne $categoryOne)
    {
        $this->categoryOne = $categoryOne;
        $this->upload_path = config('back.image_one_path');
    }


    /**
     * List all category one
     *
     * @param string $slug
     *
     * @return response
     */
    public function index($slug) {

        $category    = $this->_getCategoryBySlug($slug);
        $categoryOne = $category->categoryOnes;

        return view('backend::category_one.index', [
            'category_one' => $categoryOne,
            'slug'         => $slug,
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Add category one page
     *
     * @param string $slug
     *
     * @return response
     */
    public function add($slug) {

        $this->_getCategoryBySlug($slug);

        return view('backend::category_one.form', [
            'category_one' => $this->categoryOne,
            'slug'         => $slug,
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Add category one page
     *
     * @param string $slug
     * @param int    $id
     *
     * @return response
     */
    public function edit($slug, $id) {

        $this->_getCategoryBySlug($slug);

        return view('backend::category_one.form', [
            'category_one' => $this->_getCategoryOneById($id),
            'slug'         => $slug,
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Save category one
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     * @throws \Exception
     */
    public function save(Request $request, $slug) {

        if ($request->isMethod('POST')) {

            $category        = $this->_getCategoryBySlug($slug);
            $edit            = $request->has('id');
            $categoryOne     = ($edit) ? $this->_getCategoryOneById($request->get('id')) : $this->categoryOne;
            $categoryOneCopy = clone $categoryOne;
            $rules           = $this->categoryOne->rules();
            $messages        = $this->categoryOne->messages();

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $categoryOne = $this->bind($categoryOne, $request->all());
                 if ( ! $edit) {$categoryOne->created_at = new \DateTime();}
                $categoryOne->updated_at        = new \DateTime();
                $categoryOne->category_root_id = $category->id;

                //Upload image
                if ($request->hasFile('image')) {
                    $imagePath  = $this->upload_path;
                    $file       = $request->file('image');
                    $filename   = new FileName($imagePath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('CATEGORY_ONE_PREFIX'));
                    $filename->avatar()->group($this->_getImageOneGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                    $imageResize = new Image($imagePath . $upload->getName());
                    $imageResize->setDirectory($imagePath)->resizeGroup($filename->getGroup());

                    delete_file($imagePath . $upload->getName());

                    if ($edit) {
                        delete_file($imagePath . $categoryOneCopy->image);
                    }

                    $resizes            = $imageResize->getResizes();
                    $categoryOne->image = $resizes['small'];
                }
                $categoryOne->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_category_one', $slug))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete category one
     *
     * @param int    $id
     * @param string $token
     *
     * @return type
     * @throws TokenMismatchException
     */
    public function delete($slug, $id, $token) {

        if (session()->token() != $token) {
            throw new TokenMismatchException;
        }

        $this->_getCategoryBySlug($slug);

        $categoryOne = $this->_getCategoryOneById($id);
        $imagePath   = $this->upload_path;

        delete_file($imagePath . $categoryOne->image);

        $categoryOne->delete();

        return redirect(route('backend_category_one', $slug))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide categoryOne
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($slug, $id) {

        $categoryOne = $this->_getCategoryOneById($id);

        if ($categoryOne->is_active) {
            $categoryOne->is_active = false;
        } else {
            $categoryOne->is_active = true;
        }

        $categoryOne->save();

        return redirect(route('backend_category_one', $slug));
    }

    /**
     * Get category one by id
     *
     * @param int $id
     *
     * @return CategoryOne
     * @throws NotFoundHttpException
     */
    protected function _getCategoryOneById($id) {

        $categoryOne = $this->categoryOne->find((int) $id);

        if ($categoryOne === null) {
            throw new NotFoundHttpException;
        }

        return $categoryOne;
    }

    /**
     * Get image category by slug
     *
     * @param string $slug
     *
     * @return CategoryRoot
     * @throws NotFoundHttpException
     */
    protected function _getCategoryBySlug($slug) {

        $category = CategoryRoot::where('slug', $slug)->first();

        if ($category === null) {
            throw new NotFoundHttpException;
        }

        return $category;
    }

    /**
     * Image image group to resize
     *
     * @return array
     */
    protected function _getImageOneGroup() {
        return [
            'small' => [
                'width' => _const('IMAGE_ONE_SMALL'),
                'height' => _const('IMAGE_ONE_SMALL')
            ]
        ];
    }
}
