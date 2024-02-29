<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Models\GroupModel;

class RoleController extends BaseController
{
    protected $roles;

    public function __construct()
    {
        $this->roles = new GroupModel();
        
    }
    public function index()
    {
        $breadcrumb = [
            'title' => 'Profile',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Role', 'url_to' => '#', 'active' => true],
            ],
        ];

        return  view('admin/role/role-index', compact('breadcrumb'));
    }


    public function create(){

        $breadcrumb = [
            'title' => 'Profile',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Role', 'url_to' => 'role.index', 'active' => false],
                ['title' => 'Create', 'url_to' => '#', 'active' => true],
            ],
        ];

        $permissions = $this->authorize->permissions();
        return view('admin/role/role-create', compact('breadcrumb', 'permissions'));
    }


    public function store(){
        $data = $this->request->getPost();
        $rules = [
            'name' => 'required|max_length[255]|is_unique[auth_groups.name]',
            'description' => 'max_length[255]',
            'permission'  => 'required',
        ];
        
        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transBegin();
        try {   
            $id = $this->authorize->createGroup(url_title($data['name']), $data['description']);

            foreach ($data['permission'] as $value) {
                $this->authorize->addPermissionToGroup($value, $id);
            }
            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $e->getMessage()]);
            }
            return redirect()->back()->with('errors', $e->getMessage());
        }


        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Role created successfully', 'redirect' => route_to('role.index')]);
        }

        return redirect()->back()->with('message', 'Role created successfully');
    }

    public function show($id){
        $breadcrumb = [
            'title' => 'Detail Role',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Role', 'url_to' => 'role.index', 'active' => false],
                ['title' => 'Detail Role', 'url_to' => '#', 'active' => true],
            ],
        ];

        $role = new GroupModel();
        $data = $role->find($id);
    
        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $permissions = $this->authorize->permissions();
        $permission = $this->authorize->groupPermissions($id);

        return view('admin/role/role-detail', compact('breadcrumb', 'data', 'permissions', 'permission'));
    }


    public function update($id){
        $data = $this->request->getPost();
        $rules = [
            'name' => 'required|max_length[255]|is_unique[auth_groups.name,id,'.$id.']',
            'description' => 'max_length[255]',
            'permission'  =>'required',
        ];
        
        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try{
            $this->authorize->updateGroup($id, url_title($data['name']), $data['description']);
            $this->db->table('auth_groups_permissions')->where('group_id', $id)->delete();
            foreach ($data['permission'] as $value) {
                $this->authorize->addPermissionToGroup($value, $id);
            }

            $this->db->transCommit();
        }catch (\Exception $e) {
            $this->db->transRollback();

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $e->getMessage()]);
            }
            return redirect()->back()->with('errors', $e->getMessage());
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Role updated successfully', 'redirect' => route_to('role.index')]);
        }

        return redirect()->back()->with('message', 'Role updated successfully');
    }

    public function delete($id){
        if(!$this->authorize->deleteGroup($id)){
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Role deleted failed']);
            }
            return redirect()->back()->with('errors', 'Role deleted failed');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' =>'success','message' => 'Role deleted successfully']);
        }

        return redirect()->back()->with('message', 'Role deleted successfully');
    }


    public function searchRole(){
        if($this->request->isAJAX()) {
           $db = db_connect();
           $builder = $db->table('auth_groups')->select('id, name, description')->orderBy('name', 'ASC');
           return DataTable::of($builder)
               ->filter(function ($builder, $request){
                   if($request->role) {
                        $builder->like('name', $request->role);
                }
            })
            ->addNumbering()
            ->add('action', function($row){
                return 
                '<a href="'.route_to('role.show', $row->id).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <button class="btn btn-sm btn-danger" id="delete" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
            })  
            ->toJson(true);
        }
    }
}