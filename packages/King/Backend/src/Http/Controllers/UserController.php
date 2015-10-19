<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Helpers\Upload;
use App\Helpers\FileName;
use App\Helpers\Image;
use Validator;

/**
 * User Controller
 */
class UserController extends BackController{

    private $user;

    /**
     * Constructor
     *
     * @param App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * List all users
     *
     * @return response
     */
    public function index() {

        $users = User::all();

        return view('backend::user.index', [
            'users'       => $users,
            'avatar_path' => config('back.avatar_path')
        ]);
    }
    
    /**
     * List all users
     *
     * @return response
     */
    public function usersByRole($role_id) {
        
        $role = Role::find($role_id);
        if ($role === null) {
            throw new NotFoundHttpException;
        }
        
        return view('backend::user.index', [
            'users'       => $role->users,
            'avatar_path' => config('back.avatar_path')
        ]);
    }

    /**
     * Add user page
     *
     * @return response
     */
    public function add() {
        
        $roles = ['' => _t('backend_user_select_role')];
        
        foreach (Role::all() as $role) {
            $roles[$role->id] = $role->name;
        }
        
        return view('backend::user.form', [
            'user'  => $this->user,
            'roles' => $roles,
        ]);
    }

    /**
     * Add user page
     *
     * @return response
     */
    public function edit($id) {

        $roles = ['' => _t('backend_user_select_role')];
        
        foreach (Role::all() as $role) {
            $roles[$role->id] = $role->name;
        }
        
        return view('backend::user.form', [
            'user'  => $this->_getUserById($id),
            'roles' => $roles,
        ]);
    }

    /**
     * Save user
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
            $user     = ($edit) ? $this->_getUserById($request->get('id')) : $this->user;
            $rules    = $this->user->rules();
            $messages = $this->user->messages();

            if ($edit && str_equal($user->username, $request->get('username'))) {
                $rules = remove_rules($rules, ['username.unique:users,username']);
            }
            
            if ($edit && str_equal($user->email, $request->get('email'))) {
                $rules = remove_rules($rules, ['email.unique:users,email']);
            }
            
            if ($edit) {
                $rules = remove_rules($rules, ['password.required']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $except = [];
                if ($request->password === '') {
                    $except = ['password'];
                }
                
                $user = $this->bind($user, $request->all(), $except);
                if ( ! $edit) {$user->created_at = new \DateTime();}
                $user->updated_at = new \DateTime();
                
                //Upload avatar
                if ($request->hasFile('avatar')) {
                    $avatarPath = config('back.avatar_path');
                    $file       = $request->file('avatar');
                    $filename   = new FileName($avatarPath, $file->getClientOriginalExtension());
                    $filename->avatar()->generate();
                    $filename->setPrefix(_const('AVATAR_PREFIX'));
                    $filename->avatar()->group($this->_getAvatarGroup(), false);
                    $upload = new Upload($file);
                    $upload->setDirectory($avatarPath)->setName($filename->getName())->move();
                    $image = new Image($avatarPath . $upload->getName());
                    $image->setDirectory($avatarPath)->resizeGroup($filename->getGroup());
                    delete_file($avatarPath . $upload->getName());

                    $resizes      = $image->getResizes();
                    $user->avatar = $resizes['small'];
                }
                
                $user->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_users'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete user
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

        $user = $this->_getUserById($id);
        $user->delete();

        return redirect(route('backend_users'))->with('success', _t('backend_common_deleted'));
    }

    /**
     * Get user by id
     *
     * @param int $id
     *
     * @return User
     * @throws NotFoundHttpException
     */
    protected function _getUserById($id) {

        $user = $this->user->find((int) $id);

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        return $user;
    }
    
    /**
     * Avatar group to resize
     *
     * @return array
     */
    protected function _getAvatarGroup() {
        return [
            'small' => [
                'width' => _const('AVATAR_SMALL'),
                'height' => _const('AVATAR_SMALL')
            ]
        ];
    }
}
