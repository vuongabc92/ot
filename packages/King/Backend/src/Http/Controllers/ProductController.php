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
class ProductController extends BackController{

    private $product;

    private $image_path;
    /**
     * Constructor
     *
     * @param App\Models\Product $product
     */
    public function __construct(Product $product)
    {
        $this->product     = $product;
        $this->image_path = config('back.products_path');
    }


    /**
     * List all products
     *
     * @return response
     */
    public function index() {

        $products   = Product::paginate(config('back.default_pagination'));

        return view('backend::product.index', [
            'products'   => $products,
            'image_path' => $this->image_path
        ]);
    }

    /**
     * Add product page
     *
     * @return response
     */
    public function add() {

        return view('backend::product.form', [
            'product'    => $this->product,
            'categories' => $this->_getCategory(2),
            'image_path' => $this->image_path
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
            'image_path' => $this->image_path
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
            $product     = ($edit) ? $this->_getProductById($request->get('id')) : $this->product;
            $productCopy = clone $product;
            $rules       = $this->product->rules();
            $messages    = $this->product->messages();

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
                if ($request->hasFile('image')) {
                    $imagePath = $this->image_path;
                    $file      = $request->file('image');
                    $filename  = new FileName($imagePath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('PRODUCT_PREFIX'));
                    $filename->avatar()->group($this->_getProductImageGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                    $image = new Image($imagePath . $upload->getName());
                    $image->setDirectory($imagePath)->resizeGroup($filename->getGroup());

                    delete_file($imagePath . $upload->getName());

                    if ($edit && check_file($imagePath . $productCopy->image)) {
                        delete_file($imagePath . $productCopy->image);
                    }

                    $resizes        = $image->getResizes();
                    $product->image = $resizes['small'];
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
     * @return type
     * @throws TokenMismatchException
     */
    public function delete($id, $token) {

        if (session()->token() != $token) {
            throw new TokenMismatchException;
        }

        $product   = $this->_getProductById($id);
        $imagePath = $this->image_path;

        if (check_file($imagePath . $product->image)) {
            delete_file($imagePath . $product->image);
        }

        $product->delete();

        return redirect(route('backend_products'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide product
     *
     * @param int $id
     *
     * @return response
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

        $product = $this->product->find((int) $id);

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
