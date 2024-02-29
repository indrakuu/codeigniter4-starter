<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\PermissionModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Entities\User;

class UserController extends BaseController
{
    protected $users;
    protected $session;
    public function __construct()
    {
        $this->users = new UserModel();
        $this->session = service('session');
    }

    public function index()
    {
        $breadcrumb = [
            'title' => 'User',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'User', 'url_to' => '#', 'active' => true],
            ],
        ];

        return view('admin/user/user-index', compact('breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            'title' => 'Create User',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'User', 'url_to' => 'user.index', 'active' => false],
                ['title' => 'Create User', 'url_to' => '#', 'active' => true],
            ],
        ];

        $permissions = $this->authorize->permissions();
        $roles =$this->authorize->groups();

        return view('admin/user/user-create', compact('breadcrumb', 'permissions', 'roles'));
    }

    public function store()
    {
        $data = $this->request->getPost();
        $rules = [
            'fullname' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|strong_password',
            'permission' =>'required',
            'role' =>'required',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $id = $this->users->insert(new User([
                'fullname' => $data['fullname'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]));

            foreach ($data['permission'] as $permission) {
                $this->authorize->addPermissionToUser($permission, $id);
            }

            foreach ($data['role'] as $role) {
                $this->authorize->addUserToGroup($id, $role);
            }
            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $e->getMessage()]);
            }
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }

        if ($this->request->isAJAX()) {
            $this->session->setFlashdata('message', 'User created successfully');
            return $this->response->setJSON(['status' => 'success', 'message' => 'User created successfully', 'redirect' => route_to('user.index')]);
        }

        return redirect()->back()->with('message', 'User created successfully');
    }


    public function show($id){
        $breadcrumb = [
            'title' => 'Detail User',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'User', 'url_to' => 'user.index', 'active' => false],
                ['title' => 'Detail User', 'url_to' => '#', 'active' => true],
            ],
        ];

        $user = new UserModel();
        $data = $user->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $permissions = $this->authorize->permissions();
        $permission  = (new PermissionModel())->getPermissionsForUser($id);
        $roles       = $this->authorize->groups();
        $role        = (new GroupModel())->getGroupsForUser($id);

        return view('admin/user/user-profile', compact('breadcrumb', 'data', 'permissions', 'permission', 'roles', 'role'));
    }

    public function update($id){
        $data = $this->request->getPost();
        $rules = [
            'fullname' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,' . $id . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'permission'   => 'required',
            'role'         => 'required',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $user = new User();

            $user->fullname = $data['fullname'];
            $user->username = $data['username'];
            $user->email = $data['email'];

            $this->users->skipValidation(true)->update($id, $user);
            $this->db->table('auth_users_permissions')->where('user_id', $id)->delete();
            
            foreach ($data['permission'] as $permission) {
                $this->authorize->addPermissionToUser($permission, $id);
            }

            $this->db->table('auth_groups_users')->where('user_id', $id)->delete();

            foreach ($data['role'] as $role) {
                $this->authorize->addUserToGroup($id, $role);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $e->getMessage()]);
            }
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }


        if ($this->request->isAJAX()) {
            $this->session->setFlashdata('message', 'Profile updated successfully');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Profile updated successfully', 'redirect' => route_to('user.index')]);
        }

        return redirect()->back()->with('message', 'Profile updated successfully');
    }

    public function changePassword($id){
        $breadcrumb = [
            'title' => 'Change Password',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'User', 'url_to' => 'user.index', 'active' => false],
                ['title' => 'Change Password', 'url_to' => '#', 'active' => true],
            ],
        ];

        $user = new UserModel();
        $data = $user->find($id);
        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/user/user-change-password', compact('breadcrumb', 'data'));
    }

    public function updatePassword($id){
        $data = $this->request->getPost();
        $rules = [
            'new_password' => 'required|strong_password',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User();
        $user->password = $data['new_password'];

        $this->users->skipValidation(true)->update($id, $user);
        if ($this->request->isAJAX()) {
            $this->session->setFlashdata('message', 'Password updated successfully');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Password updated successfully', 'redirect' => route_to('user.index')]);
        }
        return redirect()->back()->with('message', 'Password updated successfully');
    }

    public function delete($id){
        $this->users->delete($id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'User deleted successfully']);
        }

        return redirect()->back()->with('message', 'User deleted successfully');
    }

    public function searchUser(){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('users')->select('id, fullname, username, email, created_at')->orderBy('created_at', 'desc');

            return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if ($request->fullname) {
                    $builder->like('fullname', $request->fullname);
                }

                if ($request->username) {
                    $builder->like('username', $request->username);
                }

                if ($request->email) {
                    $builder->like('email', $request->email);
                }

                if ($request->created_at) {
                    $date = strtotime($request->created_at);
                    $date = date('Y-m-d', $date);
                    $builder->like('created_at', $date);
                }
            })
            ->addNumbering()
            ->add('action', function($row){
                return 
                '<a href="'.route_to('user.show', $row->id).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <button class="btn btn-sm btn-danger" id="delete" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';

            })
            ->edit('created_at', function($row){
                return date('l, d F Y', strtotime($row->created_at));
            })
            ->toJson(true);
        }
    }
}