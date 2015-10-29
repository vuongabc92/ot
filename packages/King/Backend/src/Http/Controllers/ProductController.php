<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryOne;
use App\Models\CategoryTwo;
use App\Models\CategoryThree;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * Product Controller
 */
class ProductController extends BackController implements BackInterface{


    private $_product;

    private $_imagePath;

    private $_productImages;

    /**
     * Constructor
     *
     * @param App\Models\Product $product
     */
    public function __construct(Product $product)
    {
        $this->_product       = $product;
        $this->_imagePath     = config('back.products_path');
        $this->_productImages = config('back.product_images');

        $this->object = $product;
        $this->imagePath = config('back.products_path');
        $this->view = 'backend::product.';
    }


    /**
     * List all products
     *
     * @return response
     */
    public function index() {
        $products = $this->_product->orderBy('weight', 'DESC')->paginate(config('back.default_pagination'));

        return view('backend::product.index', [
            'products'   => $products,
            'image_path' => $this->_imagePath
        ]);
    }

    /**
     * Add product page
     *
     * @return response
     */
    public function add() {

        return view('backend::product.form', [
            'product'    => $this->_product,
            'categories' => $this->_getCategory(2),
            'image_path' => $this->_imagePath
        ]);
    }

    /**
     * Add product page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::product.form', [
            'product'    => $this->_getProductById($id),
            'categories' => $this->_getCategory(2),
            'image_path' => $this->_imagePath
        ]);
    }

    /**
     * Save product
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     *
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit        = $request->has('id');
            $imagePath   = $this->_imagePath;
            $product     = ($edit) ? $this->_getProductById($request->get('id')) : $this->_product;
            $productCopy = clone $product;
            $rules       = $this->_product->rules();
            $messages    = $this->_product->messages();

            if ($edit && str_equal($product->slug, $request->get('slug'))) {
                $rules = remove_rules($rules, ['slug.unique:products,slug']);
            }

            if ( ! $edit) {
                $rules = remove_rules($rules, 'slug.required');
            }

            if ($edit && $product->image !== '') {
                $rules = remove_rules($rules, 'image.required');
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $product = $this->bind($product, $request->all());
                if ( ! $edit) {$product->created_at = new \DateTime();}
                $product->updated_at = new \DateTime();
                $product->generateSlug();

                //Upload image
                foreach ($this->_productImages as $one) {

                    $fileName = 'image';
                    if ($one) {
                        $fileName .= '_' . $one;
                    }

                    if ($request->hasFile($fileName)) {

                        $file = $request->file($fileName);
                        $filename = new FileName($imagePath, $file->getClientOriginalExtension());
                        $filename->avatar()->generate();
                        $filename->setPrefix(_const('PRODUCT_PREFIX'));
                        $filename->avatar()->group($this->_getProductImageGroup(), false);
                        $upload = new Upload($file);
                        $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                        $image = new Image($imagePath . $upload->getName());
                        $image->setDirectory($imagePath)->resizeGroup($filename->getGroup());

                        delete_file($imagePath . $upload->getName());

                        $resizes = $image->getResizes();
                        $product->$fileName = json_encode([
                            'small'  => $resizes['small'],
                            'medium' => $resizes['medium']
                        ]);

                        if ($edit) {
                            $images = json_decode($productCopy->$fileName);
                            delete_file([
                                $imagePath . $images->small,
                                $imagePath . $images->medium,
                            ]);
                        }
                    }
                }

                $product->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_products'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete product
     *
     * @param int    $id
     * @param string $token
     *
     * @return Response
     * @throws TokenMismatchException
     */
    public function delete($id, $token) {

        if (session()->token() != $token) {
            throw new TokenMismatchException;
        }

        $product   = $this->_getProductById($id);
        $imagePath = $this->_imagePath;

        foreach ($this->_productImages as $one) {

            $fileName = 'image';
            if ($one) {
                $fileName .= '_' . $one;
            }

            $images = json_decode($product->$fileName);
            delete_file([
                $imagePath . $images->small,
                $imagePath . $images->medium,
            ]);
        }

        $product->delete();

        return redirect(route('backend_products'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Delete list selected users
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteSelected(Request $request) {

        if($request->isMethod('POST')) {

            $ids       = $request->get('list_checked');
            $products  = Product::whereIn('id', $ids)->get();
            $imagePath = $this->_imagePath;

            foreach ($products as $product) {
                foreach ([0] as $one) {

                    $fileName = 'image';
                    if ($one) {
                        $fileName .= '_' . $one;
                    }

                    $images = json_decode($product->$fileName);
                    delete_file([
                        $imagePath . $images->small,
                        $imagePath . $images->medium,
                    ]);
                }

                $product->delete()->with('success', _t('backend_common_deleted'));;
            }
        }

        return redirect(route('backend_products'));
    }

    /**
     * Toggle show hide product
     *
     * @param int $id
     *
     * @return Response
     */
    public function toggleShowHide($id) {

        $product = $this->_getProductById($id);

        if ($product->is_active) {
            $product->is_active = false;
        } else {
            $product->is_active = true;
        }

        $product->save();

        return redirect(route('backend_products'));
    }

    /**
     * Get product by id
     *
     * @param int $id
     *
     * @return Product
     * @throws NotFoundHttpException
     */
    protected function _getProductById($id) {

        $product = $this->_product->find((int) $id);

        if ($product === null) {
            throw new NotFoundHttpException;
        }

        return $product;
    }

    /**
     * Product image group to resize
     *
     * @return array
     */
    protected function _getProductImageGroup() {
        return [
            'small' => [
                'width' => _const('PRODUCT_SMALL'),
                'height' => _const('PRODUCT_SMALL')
            ],
            'medium' => [
                'width' => _const('PRODUCT_MEDIUM'),
                'height' => _const('PRODUCT_MEDIUM')
            ]
        ];
    }

    protected function _getCategory($type = 1) {

        $default = ['' => _t('backend_product_pick_cat')];

        switch($type) {
            case 1:
                $categories = CategoryOne::all();
                break;
            case 2:
                $categories = CategoryTwo::all();
                break;
            case 3:
                $categories = CategoryThree::all();
                break;
        }

        foreach ($categories as $category) {
            $default[$category->id] = $category->name;
        }

        return $default;
    }
}
