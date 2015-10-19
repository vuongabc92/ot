<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\Post;
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
    public function index() {

        $posts = Post::all();

        return view('backend::post.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Add post page
     *
     * @return response
     */
    public function add() {
        return view('backend::post.form', [
            'post'   => $this->post
        ]);
    }

    /**
     * Add post page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::post.form', [
            'post' => $this->_getPostById($id),
        ]);
    }

    /**
     * Save post
     *
     * @param Illuminate\Http\Request $request
     *
     * @return response
     *
     * @throws \Exception
     */
    public function save(Request $request) {

        if ($request->isMethod('POST')) {

            $edit     = $request->has('id');
            $post     = ($edit) ? $this->_getPostById($request->get('id')) : $this->post;
            $rules    = $this->post->rules();
            $messages = $this->post->messages();

            if ($edit && str_equal($post->post, $request->get('post'))) {
                $rules = remove_rules($rules, ['post.unique:posts,post']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $post = $this->bind($post, $request->all());
                if ( ! $edit) {$post->created_at = new \DateTime();}
                $post->updated_at = new \DateTime();
                $post->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_posts'))->with('success', _t('backend_common_saved'));
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
}
