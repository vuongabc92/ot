<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\Image as Picture;
use App\Models\ImageCategory;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * Image Controller
 */
class ImageController extends BackController{

    private $image;

    /**
     * Constructor
     *
     * @param App\Models\Image $image
     */
    public function __construct(Picture $image)
    {
        $this->image = $image;
    }


    /**
     * List all images
     *
     * @return response
     */
    public function index($slug) {

        $category   = $this->_getCategoryBySlug($slug);
        $images     = $category->images;
        $imagePath  = config('back.image_one_path');

        return view('backend::image.index', [
            'images'     => $images,
            'slug'       => $slug,
            'image_path' => $imagePath
        ]);
    }

    /**
     * Add image page
     *
     * @return response
     */
    public function add($slug) {

        $this->_getCategoryBySlug($slug);

        return view('backend::image.form', [
            'image' => $this->image,
            'slug'  => $slug
        ]);
    }

    /**
     * Add image page
     *
     * @return response
     */
    public function edit($slug, $id) {

        $this->_getCategoryBySlug($slug);

        return view('backend::image.form', [
            'image' => $this->_getImageById($id),
            'slug' => $slug
        ]);
    }

    /**
     * Save image
     *
     * @param Illuminate\Http\Request $request
     * @param string                  $slug
     *
     * @return response
     *
     * @throws \Exception
     */
    public function save(Request $request, $slug) {

        if ($request->isMethod('POST')) {

            $category  = $this->_getCategoryBySlug($slug);
            $edit      = $request->has('id');
            $image     = ($edit) ? $this->_getImageById($request->get('id')) : $this->image;
            $imageCopy = clone $image;
            $rules     = $this->image->rules();
            $messages  = $this->image->messages();

            if ($edit && $image->image !== '') {
                $rules = remove_rules($rules, 'image.required');
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $image = $this->bind($image, $request->all());
                if ( ! $edit) {$image->created_at = new \DateTime();}
                $image->updated_at        = new \DateTime();
                $image->image_category_id = $category->id;

                //Upload image
                if ($request->hasFile('image')) {
                    $imagePath  = config('back.image_one_path');
                    $file       = $request->file('image');
                    $filename   = new FileName($imagePath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('IMAGE_PREFIX'));
                    $filename->avatar()->group($this->_getImageImageGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                    $imageResize = new Image($imagePath . $upload->getName());
                    $imageResize->setDirectory($imagePath)->resizeGroup($filename->getGroup());

                    delete_file($imagePath . $upload->getName());

                    if ($edit) {
                        delete_file($imagePath . $imageCopy->image);
                        delete_file($imagePath . $imageCopy->thumbnail);
                    }

                    $resizes          = $imageResize->getResizes();
                    $image->image     = $resizes['big'];
                    $image->thumbnail = $resizes['small'];
                }

                $image->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_images', $slug))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete image
     *
     * @param string $slug
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

        $image      = $this->_getImageById($id);
        $imagePath = config('back.image_path');

        delete_file($imagePath . $image->image);
        delete_file($imagePath . $image->thubnail);

        $image->delete();

        return redirect(route('backend_images', $slug))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide image
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($slug, $id) {

        $this->_getCategoryBySlug($slug);

        $image = $this->_getImageById($id);

        if ($image->is_active) {
            $image->is_active = false;
        } else {
            $image->is_active = true;
        }

        $image->save();

        return redirect(route('backend_images', $slug));
    }

    /**
     * Get image by id
     *
     * @param int $id
     *
     * @return Image
     * @throws NotFoundHttpException
     */
    protected function _getImageById($id) {

        $image = $this->image->find((int) $id);

        if ($image === null) {
            throw new NotFoundHttpException;
        }

        return $image;
    }

    /**
     * Get image category by slug
     *
     * @param string $slug
     *
     * @return ImageCategory
     * @throws NotFoundHttpException
     */
    protected function _getCategoryBySlug($slug) {

        $category = ImageCategory::where('slug', $slug)->first();

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
    protected function _getImageImageGroup() {
        return [
            'small' => [
                'width' => _const('IMAGE_SMALL_W'),
                'height' => _const('IMAGE_SMALL_H')
            ],
            'big' => [
                'width' => _const('IMAGE_BIG_W'),
                'height' => _const('IMAGE_BIG_H')
            ]
        ];
    }
}
