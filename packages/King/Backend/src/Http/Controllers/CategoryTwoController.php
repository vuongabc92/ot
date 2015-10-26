<?php

namespace King\Backend\Http\Controllers;

use Symfony\Comptwont\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\CategoryTwo;
use App\Models\CategoryOne;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * CategoryTwo Controller
 */
class CategoryTwoController extends BackController{

    /**
     *
     * @var App\Models\CategoryTwo
     */
    private $categoryTwo;

    private $upload_path;

    /**
     * Constructor
     *
     * @param App\Models\CategoryTwo $categoryTwo
     */
    public function __construct(CategoryTwo $categoryTwo)
    {
        $this->categoryTwo = $categoryTwo;
        $this->upload_path = config('back.image_two_path');
    }


    /**
     * List all category two
     *
     * @return response
     */
    public function index() {

        $categoryTwo = CategoryTwo::paginate(config('back.default_pagination'));

        return view('backend::category_two.index', [
            'category_two' => $categoryTwo,
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Add category two page
     *
     * @return response
     */
    public function add() {

        $categoryTwo = ['' => _t('backend_ct_select_co')];

        foreach (CategoryOne::all() as $category) {
            $categoryTwo[$category->id] = $category->name;
        }

        return view('backend::category_two.form', [
            'category_one' => $categoryTwo,
            'category_two' => $this->categoryTwo,
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Add category two page
     *
     * @param int    $id
     *
     * @return response
     */
    public function edit($id) {

        $categoryTwo = ['' => _t('backend_ct_select_co')];

        foreach (CategoryOne::all() as $category) {
            $categoryTwo[$category->id] = $category->name;
        }

        return view('backend::category_two.form', [
            'category_one' => $categoryTwo,
            'category_two' => $this->_getCategoryTwoById($id),
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Save category two
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit            = $request->has('id');
            $categoryTwo     = ($edit) ? $this->_getCategoryTwoById($request->get('id')) : $this->categoryTwo;
            $categoryTwoCopy = clone $categoryTwo;
            $rules           = $this->categoryTwo->rules();
            $messages        = $this->categoryTwo->messages();

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $categoryTwo = $this->bind($categoryTwo, $request->all());
                 if ( ! $edit) {$categoryTwo->created_at = new \DateTime();}
                $categoryTwo->updated_at = new \DateTime();
                $categoryTwo->generateSlug();

                //Upload image
                if ($request->hasFile('image')) {
                    $imagePath  = $this->upload_path;
                    $file       = $request->file('image');
                    $filename   = new FileName($imagePath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('CATEGORY_TWO_PREFIX'));
                    $filename->avatar()->group($this->_getImageTwoGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                    $imageResize = new Image($imagePath . $upload->getName());
                    $imageResize->setDirectory($imagePath)->resizeGroup($filename->getGroup());

                    delete_file($imagePath . $upload->getName());

                    if ($edit) {
                        delete_file($imagePath . $categoryTwoCopy->image);
                    }

                    $resizes            = $imageResize->getResizes();
                    $categoryTwo->image = $resizes['small'];
                }
                $categoryTwo->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_category_two'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete category two
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

        $categoryTwo = $this->_getCategoryTwoById($id);
        $imagePath   = $this->upload_path;

        delete_file($imagePath . $categoryTwo->image);

        $categoryTwo->delete();

        return redirect(route('backend_category_two'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide categoryTwo
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $categoryTwo = $this->_getCategoryTwoById($id);

        if ($categoryTwo->is_active) {
            $categoryTwo->is_active = false;
        } else {
            $categoryTwo->is_active = true;
        }

        $categoryTwo->save();

        return redirect(route('backend_category_two'));
    }

    /**
     * Get category two by id
     *
     * @param int $id
     *
     * @return CategoryTwo
     * @throws NotFoundHttpException
     */
    protected function _getCategoryTwoById($id) {

        $categoryTwo = $this->categoryTwo->find((int) $id);

        if ($categoryTwo === null) {
            throw new NotFoundHttpException;
        }

        return $categoryTwo;
    }

    /**
     * Image image group to resize
     *
     * @return array
     */
    protected function _getImageTwoGroup() {
        return [
            'small' => [
                'width' => _const('IMAGE_TWO_SMALL'),
                'height' => _const('IMAGE_TWO_SMALL')
            ]
        ];
    }
}
