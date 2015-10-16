<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\User;
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
            'users' => $users
        ]);
    }

    /**
     * Add user page
     *
     * @return response
     */
    public function add() {
        return view('backend::user.form', [
            'user'   => $this->user
        ]);
    }

    /**
     * Add user page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::user.form', [
            'user' => $this->_getUserById($id),
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

            if ($edit && str_equal($user->user, $request->get('user'))) {
                $rules = remove_rules($rules, ['user.unique:users,user']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $user = $this->bind($user, $request->all());
                if ( ! $edit) {$user->created_at = new \DateTime();}
                $user->updated_at = new \DateTime();
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
}
