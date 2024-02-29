<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupMenuModel extends Model
{
    protected $table            = 'groups_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = ['group_id', 'menu_id'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function menuHasRole()
    {
        // We need cache this menu ?
        if (!$found = cache(user()->id.'_group_menu')) {
            $found = $this->db->table('menus')
                ->select('menus.id, menus.parent_id, menus.active, menus.title, menus.icon, menus.route')
                ->join('groups_menu', 'menus.id = groups_menu.menu_id', 'left')
                ->join('auth_groups', 'groups_menu.group_id = auth_groups.id', 'left')
                ->join('auth_groups_users', 'auth_groups.id = auth_groups_users.group_id', 'left')
                ->join('users', 'auth_groups_users.user_id = users.id', 'left')
                ->where(['users.id' => user()->id, 'menus.active' => 1])
                ->orderBy('menus.sequence', 'asc')
                ->groupBy('menus.id')
                ->get()
                ->getResultObject();

            cache()->save(user()->id.'_group_menu', $found, 300);
        }

        return $found;
    }
}
