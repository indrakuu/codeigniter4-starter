<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Myth\Auth\Models\PermissionModel;
use Hermawan\DataTables\DataTable;

class PermissionController extends BaseController
{
    protected $permission;

    public function __construct()
    {
        $this->permission = new PermissionModel();
    }

    public function index()
    {
        $breadcrumb = [
            'title' => 'Profile',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Permission', 'url_to' => '#', 'active' => true],
            ],
        ];
        return view('admin/permission/permission-index', compact('breadcrumb'));
    }

    public function store()
    {
        $data = $this->request->getPost();
        $rules = [
            'name' => 'required|max_length[255]|is_unique[auth_permissions.name,id,' . $data['id'] . ']',
            'description' => 'max_length[255]',
        ];
        
        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if($data['id']) {
            $this->permission->update($data['id'], [
                'name'        => $data['name'],
                'description' => $data['description'],
            ]);
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Permission updated successfully']);
            }

            return redirect()->back()->with('message', 'Permission updated successfully');
        }else{
            $this->permission->save([
                'name'        => $data['name'],
                'description' => $data['description'],
            ]);
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' =>'success', 'message' => 'Permission has been created successfully']);
        
        }
        return redirect()->back()->with('message', 'Permission has been created successfully');
    }

    public function show($id){
        if ($this->request->isAJAX()) {
            $permission = $this->permission->find($id);
            return $this->response->setJSON(['status' =>'success', 'message' => $permission]);
        }
        return route_to('permission.index');
    }

    public function delete($id){
        $this->permission->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' =>'success','message' => 'Permission deleted successfully']);
        }

        return redirect()->back()->with('message', 'Permission deleted successfully');
    }

    public function searchPermission(){
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('auth_permissions')->select('id, name, description')->orderBy('name', 'asc');
            return DataTable::of($builder)
            ->filter(function ($builder, $request){
                if ($request->permission) {
                    $builder->like('name', $request->permission);
                }
            })
            ->addNumbering()
            ->add('action', function($row){
                return 
                '<button id="edit" data-id="'.$row->id.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger" id="delete" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
            })  
            ->toJson(true);
        }
    }   
}