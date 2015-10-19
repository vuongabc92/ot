<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * Post Controller
 */
class PostController extends BackController{

    private $post;

    /**
     * Constructor
     *
     * @param App\Models\Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    /**
     * List all posts
     *
     * @return response
     */
    public function index($slug) {
        
        $category   = $this->_getCategoryBySlug($slug);
        $posts      = $category->posts;
        $imagePath  = config('back.post_path');

        return view('backend::post.index', [
            'posts'      => $posts,
            'slug'       => $slug,
            'image_path' => $imagePath
        ]);
    }

    /**
     * Add post page
     *
     * @return response
     */
    public function add($slug) {
        
        $this->_getCategoryBySlug($slug);
        
        return view('backend::post.form', [
            'post' => $this->post,
            'slug' => $slug
        ]);
    }

    /**
     * Add post page
     *
     * @return response
     */
    public function edit($slug, $id) {
        
        $this->_getCategoryBySlug($slug);
        
        return view('backend::post.form', [
            'post' => $this->_getPostById($id),
            'slug' => $slug
        ]);
    }

    /**
     * Save post
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
            
            $category = $this->_getCategoryBySlug($slug);
            $edit     = $request->has('id');
            $post     = ($edit) ? $this->_getPostById($request->get('id')) : $this->post;
            $rules    = $this->post->rules();
            $messages = $this->post->messages();
            
            if ($edit && $post->image !== '') {
                $rules = remove_rules($rules, 'image.required');
            }
            
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $post = $this->bind($post, $request->all());
                if ( ! $edit) {$post->created_at = new \DateTime();}
                $post->updated_at       = new \DateTime();
                $post->post_category_id = $category->id;
                
                //Upload image
                if ($request->hasFile('image')) {
                    $imagePath  = config('back.post_path');
                    $file       = $request->file('image');
                    $filename   = new FileName($imagePath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('POST_PREFIX'));
                    $filename->avatar()->group($this->_getPostImageGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($imagePath)->setName($filename->getName())->move();
                    $image = new Image($imagePath . $upload->getName());
                    $image->setDirectory($imagePath)->resizeGroup($filename->getGroup());
                    delete_file($imagePath . $upload->getName());

                    $resizes     = $image->getResizes();
                    $post->image = $resizes['small'];
                }
                
                $post->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_posts', $slug))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete post
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

        $post = $this->_getPostById($id);
        $post->delete();

        return redirect(route('backend_posts'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Toggle show hide post
     *
     * @param int $id
     *
     * @return response
     */
    public function toggleShowHide($id) {

        $post = $this->_getPostById($id);

        if ($post->is_active) {
            $post->is_active = false;
        } else {
            $post->is_active = true;
        }

        $post->save();

        return redirect(route('backend_posts'));
    }

    /**
     * Get post by id
     *
     * @param int $id
     *
     * @return Post
     * @throws NotFoundHttpException
     */
    protected function _getPostById($id) {

        $post = $this->post->find((int) $id);

        if ($post === null) {
            throw new NotFoundHttpException;
        }

        return $post;
    }
    
    /**
     * Get post category by slug
     *
     * @param string $slug
     *
     * @return PostCategory
     * @throws NotFoundHttpException
     */
    protected function _getCategoryBySlug($slug) {

        $category = PostCategory::where('slug', $slug)->first();

        if ($category === null) {
            throw new NotFoundHttpException;
        }

        return $category;
    }
    
    /**
     * Post image group to resize
     *
     * @return array
     */
    protected function _getPostImageGroup() {
        return [
            'small' => [
                'width' => _const('POST_SMALL'),
                'height' => _const('POST_SMALL')
            ]
        ];
    }
}
