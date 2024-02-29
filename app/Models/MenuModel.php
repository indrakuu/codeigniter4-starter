<?php

namespace App\Models;

use App\Entities\MenuEntity;
use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = MenuEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = ['parent_id', 'active', 'title', 'icon', 'route', 'sequence'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'title'       => 'required|min_length[10]|max_length[60]',
        'parent_id'   => 'required',
        'active'      => 'required',
        'icon'        => 'required',
        'route'       => 'required',
        'groups_menu' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = true;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $beforeUpdate   = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterInsert = ['deleteCacheMenu'];
    protected $afterUpdate = ['deleteCacheMenu'];
    protected $afterDelete = ['deleteCacheMenu'];

    public function getMenuById($id)
    {
        return $this->db->DBDriver === 'Postgre'
            ? $this->getMenuDRiverPostgre($id)
            : $this->getMenuDriverMySQLi($id);
    }

    public function getMenu()
    {
        return $this->db->table('menus')
            ->select('id, title as text')
            ->orderBy('sequence', 'asc')
            ->get()
            ->getResultArray();
    }


    public function getRole()
    {
        return $this->db->table('auth_groups')
            ->select('id, name as text')
            ->get()
            ->getResultArray();
    }

    private function getMenuDriverMySQLi($id)
    {
        return $this->db->table('menus')
            ->select("menus.id, menus.parent_id, menus.active, menus.title, menus.icon, menus.route, groups_menu.menu_id, group_concat(groups_menu.group_id SEPARATOR '|') as group_id")
            ->join('groups_menu', 'menus.id = groups_menu.menu_id', 'left')
            ->join('auth_groups', 'groups_menu.group_id = auth_groups.id', 'left')
            ->where('menus.id', $id)
            ->get()
            ->getRow();
    }

    private function getMenuDRiverPostgre($id)
    {
        return $this->db->table('menus')
            ->select("menus.id, menus.parent_id, menus.active, menus.title, menus.icon, menus.route, groups_menu.menu_id, array_to_string(array_agg(groups_menu.group_id),'|') as group_id")
            ->join('groups_menu', 'menus.id = groups_menu.menu_id', 'left')
            ->join('auth_groups', 'groups_menu.group_id = auth_groups.id', 'left')
            ->where('menus.id', $id)
            ->groupBy(['menus.id', 'groups_menu.menu_id'])
            ->get()
            ->getRow();
    }

    protected function deleteCacheMenu()
    {
        if (cache(user()->id.'_group_menu')) {
            cache()->delete(user()->id.'_group_menu');
        }
    }

}
