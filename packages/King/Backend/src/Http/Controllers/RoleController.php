<?php

namespace King\Backend\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;

/**
 * Role Controller
 */
class RoleController extends BackController{

    private $role;

    /**
     * Constructor
     *
     * @param App\Models\Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }


    /**
     * List all roles
     *
     * @return response
     */
    public function index() {

        $roles = Role::all();

        return view('backend::role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Add role page
     *
     * @return response
     */
    public function add() {
        return view('backend::role.form', [
            'role'   => $this->role
        ]);
    }

    /**
     * Add role page
     *
     * @return response
     */
    public function edit($id) {

        return view('backend::role.form', [
            'role' => $this->_getRoleById($id),
        ]);
    }

    /**
     * Save role
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
            $role     = ($edit) ? $this->_getRoleById($request->get('id')) : $this->role;
            $rules    = $this->role->rules();
            $messages = $this->role->messages();

            if ($edit && str_equal($role->role, $request->get('role'))) {
                $rules = remove_rules($rules, ['role.unique:roles,role']);
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator, 'all');
            }

            try {
                $role = $this->bind($role, $request->all());
                if ( ! $edit) {$role->created_at = new \DateTime();}
                $role->updated_at = new \DateTime();
                $role->save();

            } catch (Exception $ex) {
                throw new \Exception(_t('backend_common_opp') . $ex->getMessage());
            }

            return redirect(route('backend_roles'))->with('success', _t('backend_common_saved'));
        }
    }

    /**
     * Delete role
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

        $role = $this->_getRoleById($id);
        $role->delete();

        return redirect(route('backend_roles'))->with('success', _t('backend_common_deleted'));
    }
    
    /**
     * Toggle show hide role
     * 
     * @param int $id
     * 
     * @return response
     */
    public function toggleShowHide($id) {
        
        $role = $this->_getRoleById($id);
        
        if ($role->is_active) {
            $role->is_active = false;
        } else {
            $role->is_active = true;
        }
        
        $role->save();
        
        return redirect(route('backend_roles'));
    }

    /**
     * Get role by id
     *
     * @param int $id
     *
     * @return Role
     * @throws NotFoundHttpException
     */
    protected function _getRoleById($id) {

        $role = $this->role->find((int) $id);

        if ($role === null) {
            throw new NotFoundHttpException;
        }

        return $role;
    }
}
