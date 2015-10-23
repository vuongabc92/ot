<?php

namespace King\Backend\Http\Controllers;

use Symfony\Compthreent\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\CategoryThree;
use App\Models\CategoryTwo;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * CategoryThree Controller
 */
class CategoryThreeController extends BackController{

    /**
     *
     * @var App\Models\CategoryThree
     */
    private $categoryThree;

    private $upload_path;

    /**
     * Constructor
     *
     * @param App\Models\CategoryThree $categoryThree
     */
    public function __construct(CategoryThree $categoryThree)
    {
        $this->categoryThree = $categoryThree;
        $this->upload_path = config('back.image_three_path');
    }


    /**
     * List all category three
     *
     * @return response
     */
    public function index() {

        $categoryThree = CategoryThree::paginate(config('back.default_pagination'));

        return view('backend::category_three.index', [
            'category_three' => $categoryThree,
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Add category three page
     *
     * @return response
     */
    public function add() {

        $categoryTwo = ['' => _t('backend_cth_select_ct')];

        foreach (CategoryTwo::all() as $category) {
            $categoryTwo[$category->id] = $category->name;
        }

        return view('backend::category_three.form', [
            'category_two'   => $categoryTwo,
            'category_three' => $this->categoryThree,
            'image_path'     => $this->upload_path
        ]);
    }

    /**
     * Add category three page
     *
     * @param int    $id
     *
     * @return response
     */
    public function edit($id) {

        $categoryTwo = ['' => _t('backend_cth_select_ct')];

        foreach (CategoryTwo::all() as $category) {
            $categoryTwo[$category->id] = $category->name;
        }

        return view('backend::category_three.form', [
            'category_two' => $categoryTwo,
            'category_three' => $this->_getCategoryThreeById($id),
            'image_path'   => $this->upload_path
        ]);
    }

    /**
     * Save category three
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit            = $request->has('id');
            $categoryThree     = ($edit) ? $this->_getCategoryThreeById($request->get('id')) : $this->categoryThree;
            $categoryThreeCopy = clone $categoryThree;
            $rules           = $this->categoryThree->rules();
            $messages        = $this->categoryThree->messages();

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $categoryThree = $this->bind($categoryThree, $request->all());
                 if ( ! $edit) {$categoryThree->created_at = new \DateTime();}
                $categoryThree->updated_at = new \DateTime();

                //Upload image
                if ($request->hasFile('image')) {
                    $imagePath  = $this->upload_path;
                    $file       = $request->file('image');
                    $filename   = new FileName($imagePath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('CATEGORY_THREE_PREFIX'));
                    $filename->avatar()->group($this->_getImageThreeGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                    $imageResize = new Image($imagePath . $upload->getName());
                    $imageResize->setDirectory($imagePath)->resizeGroup($filename->getGroup());

                    delete_file($imagePath . $upload->getName());

                    if ($edit) {
                        delete_file($imagePath . $categoryThreeCopy->image);
                    }

                    $resizes              = $imageResize->getResizes();
                    $categoryThree->image = $resizes['small'];
                }
                $categoryThree->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_category_three'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete category three
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

        $categoryThree = $this->_getCategoryThreeById($id);
        $imagePath   = $this->upload_path;

        delete_file($imagePath . $categoryThree->image);

        $categoryThree->delete();

        return redirect(route('backend_category_three'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide categoryThree
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $categoryThree = $this->_getCategoryThreeById($id);

        if ($categoryThree->is_active) {
            $categoryThree->is_active = false;
        } else {
            $categoryThree->is_active = true;
        }

        $categoryThree->save();

        return redirect(route('backend_category_three'));
    }

    /**
     * Get category three by id
     *
     * @param int $id
     *
     * @return CategoryThree
     * @throws NotFoundHttpException
     */
    protected function _getCategoryThreeById($id) {

        $categoryThree = $this->categoryThree->find((int) $id);

        if ($categoryThree === null) {
            throw new NotFoundHttpException;
        }

        return $categoryThree;
    }

    /**
     * Image image group to resize
     *
     * @return array
     */
    protected function _getImageThreeGroup() {
        return [
            'small' => [
                'width' => _const('IMAGE_TWO_SMALL'),
                'height' => _const('IMAGE_TWO_SMALL')
            ]
        ];
    }
}
