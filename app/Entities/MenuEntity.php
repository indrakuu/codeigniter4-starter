<?php

namespace App\Entities;

use App\Models\MenuModel;
use CodeIgniter\Entity\Entity;

class MenuEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function activate()
    {
        $this->attributes['active'] = 1;

        return $this;
    }

    public function deactivate()
    {
        $this->attributes['active'] = 0;

        return $this;
    }

    public function isActivated(): bool
    {
        return isset($this->attributes['active']) && $this->attributes['active'] == true;
    }

    public function sequence(): int
    {
        return (new MenuModel())->selectMax('sequence')->get()->getRow()->sequence;
    }
}
