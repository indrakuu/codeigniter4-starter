<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\MenuEntity;
use App\Models\GroupMenuModel;
use App\Models\MenuModel;
use CodeIgniter\API\ResponseTrait;

class MenuController extends BaseController
{
    use ResponseTrait;
    
    protected $menu;
    protected $groupsMenu;
    protected $session;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->groupsMenu = new GroupMenuModel();
        $this->session = service('session');
    }

    public function index()
    {
        $breadcrumb = [
            'title' => 'Menu',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => false],
                ['title' => 'Menu', 'url_to' => '#', 'active' => true],
            ],
        ];

        if ($this->request->isAJAX()) {
            return $this->respond(['data' => nestable()]);
        }

        $roles = $this->authorize->groups();
        $menus = $this->menu->orderBy('sequence', 'asc')->findAll();


        return view('admin/menu/menu-index', compact('breadcrumb', 'menus', 'roles'));
    }


    public function store(){
        $data = $this->request->getPost();

        $rules = [
            'icon'        => 'required|min_length[5]|max_length[55]',
            'route'       => 'required|max_length[255]',
            'title'       => 'required|min_length[2]|max_length[255]',
            'groups_menu' => 'required',
        ];

        if (!$this->validate($rules)) {

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $menu = new MenuEntity();
            $menu->title = $data['title'];
            $menu->icon = $data['icon'];
            $menu->route = $data['route'];
            $menu->sequence = $menu->sequence() + 1;

            $id = $this->menu->insert($menu);

            foreach ($data['groups_menu'] as $groups) {
                $this->groupsMenu->insert([
                    'group_id' => $groups,
                    'menu_id'  => $id,
                ]);
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
            $this->session->setFlashdata('message', 'Menu created successfully');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Menu created successfully', 'redirect' => route_to('menu.index')]);
        }

        return redirect()->back()->with('message', 'Menu created successfully');
    }

    public function show($id)
    {
        if ($this->request->isAJAX()) {
            $found = $this->menu->getMenuById($id);
            if ($found->id == null) {
                return $this->response->setJSON(['status' => 'error', 'errors' => 'The menu not found or already deleted']);
            }

            return $this->response->setJSON(['status' => 'success', 'messages' => 
            [
                'data'  => $found,
                'roles' => $this->menu->getRole(),
            ]]);
        }

        return redirect()->route('menu.index');
    }


    public function update($id){
        $data = $this->request->getPost();

        $rules = [
            'active'      => 'required|numeric',
            'icon'        => 'required|min_length[5]|max_length[55]',
            'route'       => 'required|max_length[255]',
            'title'       => 'required|min_length[2]|max_length[255]',
            'groups_menu' => 'required',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $menu = new MenuModel();
            $menu->update($id, [
                'active'    => $data['active'],
                'title'     => $data['title'],
                'icon'      => $data['icon'],
                'route'     => $data['route'],
            ]);

            $this->db->table('groups_menu')->where('menu_id', $id)->delete();

            foreach ($data['groups_menu'] as $groups) {
                $this->groupsMenu->insert([
                    'group_id' => $groups,
                    'menu_id'  => $id,
                ]);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'errors' => $e->getMessage()]);
            }
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }

        if ($this->request->isAJAX()) {
            $this->session->setFlashdata('message', 'Menu updated successfully');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Menu updated successfully', 'redirect' => route_to('menu.index')]);
        }

        return redirect()->back()->with('message', 'Menu updated successfully');
    }

    public function listMenu(){
        $data = $this->request->getJSON();
        $menu = new MenuEntity();

        $this->db->transBegin();

        try {
            $i = 1;
            foreach ($data as $item) {
                if (isset($item->parent_id)) {
                    $menu->parent_id = $item->parent_id;
                    $menu->sequence = $i++;
                } else {
                    $menu->parent_id = 0;
                    $menu->sequence = $i++;
                }

                $this->menu->update($item->id, $menu);
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
            $this->session->setFlashdata('message', 'Menu updated successfully');
            return $this->response->setJSON(['status' => 'success', 'message' => 'Menu updated successfully', 'redirect' => route_to('menu.index')]);
        }

        return redirect()->back()->with('message', 'Menu updated successfully');
    }


    public function delete($id){
        $this->menu->delete($id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' =>'success','message' => 'Permission deleted successfully', 'redirect' => route_to('menu.index')]);
        }

        return redirect()->back()->with('message', 'Permission deleted successfully');
    }
}