<?php

namespace Modules\BackEnd\Logic\Foundation\Authendication;

use Modules\BackEnd\Entities\Foundation\Authendication\AuthModel;
use Illuminate\Support\Facades\Route;
use Modules\BackEnd\Logic\AbstractLogic;
use Modules\BackEnd\Entities\Foundation\Role\RoleModel;
use Modules\BackEnd\Exceptions\AppException;

class AuthLogic extends AbstractLogic
{

    public function __construct($data = [])
    {
        $this->data = $data;
        parent::__construct();
    }

    /**
     * setModel
     */
    public function setModel()
    {
        return new AuthModel($this->data);
    }

    /**
     * getUiMenu
     *
     */
    public function getUiMenu()
    {
        $pear_menu = session('pear_menu');

        if (!empty($pear_menu)) {
            return $pear_menu;
        }

        $this->setAuth();
        $auth_id = get_auth();

        if (empty($auth_id)) {
            return [];
        }

        $auth_menu = idAsKey($this->model->getAuthMenu(), 'id');
        $categorized_id = $this->categorizedId($auth_menu, $auth_id);
        $pear_menu = $this->buildPearMenu($auth_menu, $categorized_id);
        session(['auth_menu' => $auth_menu]);
        session(['pear_menu' => $pear_menu]);
        return $pear_menu;
    }

    function setAuth()
    {
        $auth_id = (new RoleModel())->getAuthId();
        set_auth(explode(',', $auth_id['auth_id']));
    }

    public function categorizedId($auth, $auth_id)
    {
        $grand = [];
        $parent = [];
        $child = [];

        foreach ($auth_id as $v) {
            $p_id = $auth[$v]['p_id'] ?? 0;
            $g_id = $auth[$p_id]['p_id'] ?? 0;

            switch (true) {
                case $p_id == 0:
                    array_push($grand, (int)$v);
                    break;
                case $g_id == 0:
                    array_push($grand, $p_id);
                    $parent[$p_id][] = (int)$v;
                    break;
                default:
                    array_push($grand, $g_id);
                    $parent[$g_id][] = (int)$p_id;
                    $child[$p_id][] = (int)$v;
                    break;
            }
        }

        $menu_ids = array_column($auth, 'id');
        foreach ($grand as $k => $v) {
            if (!in_array($v, $menu_ids)) {
                if (isset($grand[$k])) {
                    unset($grand[$k]);
                }
                if (isset($parent[$v])) {
                    foreach ($parent[$v] as $pv) {
                        if (isset($child[$pv])) {
                            unset($child[$pv]);
                        }
                    }
                    unset($parent[$v]);
                }
            }
        }

        foreach ($parent as $k => $v) {
            $parent[$k] = array_unique($v);
        }

        foreach ($child as $k => $v) {
            $child[$k] = array_unique($v);
        }

        return [
            'grand' => array_unique($grand),
            'parent' => $parent,
            'child' => $child,
        ];
    }
    /**
     * pearMenuDesign
     *
     * @return void
     */
    private function pearMenuDesign($auth_menu)
    {
        return [
            'id' => $auth_menu->id,
            'title' => $auth_menu->title,
            'icon' => $auth_menu->icon,
            'type' => $auth_menu->type,
            'sort' => $auth_menu->sort,
            'href' => (empty($auth_menu->href) || !Route::has($auth_menu->href)) ? '' : parse_url(route($auth_menu->href))['path'],
            'openType' => "_iframe",
        ];
    }
    /**
     * buildPearMenu
     *
     * @param  mixed $auth_menu
     */
    private function buildPearMenu($auth_menu, $categorized_id)
    {
        foreach ($categorized_id['grand'] as $gk => $vg) {
            $gs[$gk] = $auth_menu[$vg]['sort'];
            $grand[$gk] = $this->pearMenuDesign($auth_menu[$vg]);
            if ($categorized_id['parent'][$vg] ?? false) {
                foreach ($categorized_id['parent'][$vg] as $pk => $vp) {
                    $ps[$pk] = $auth_menu[$vp]['sort'];
                    $parent[$pk] = $this->pearMenuDesign($auth_menu[$vp]);
                    if ($categorized_id['child'][$vp] ?? false) {
                        $child = [];
                        foreach ($categorized_id['child'][$vp] as $ck => $vc) {
                            $cs[$ck] = $auth_menu[$vc]['sort'];
                            $child[] = $this->pearMenuDesign($auth_menu[$vc]);
                        }
                        array_multisort($cs, SORT_ASC, $child);
                        $parent[$pk]['children'] = array_values($child);
                    }
                }
                array_multisort($ps, SORT_ASC, $parent);
                $grand[$gk]['children'] = array_values($parent);
            }
        }
        array_multisort($gs, SORT_ASC, $grand);
        return array_values($grand);
    }

    public function legalAuth()
    {
        $auth_menu = session('auth_menu');
        $id = $this->categorizedId($auth_menu, array_column($auth_menu, 'id'));
        $auth_menu = $this->withMenu($id, $auth_menu);

        foreach ($id['grand'] as $v) {
            if ($v == $this->data['id']) {
                return [];
            }
        }
        foreach ($id['parent'] as $k => $v) {
            if (in_array($this->data['id'], $v)) {
                return ['auth_menu' => $auth_menu['grand'], 'upLevel' => $k];
            }
        }
        foreach ($id['child'] as $k => $v) {
            if (in_array($this->data['id'], $v)) {
                return ['auth_menu' => $auth_menu['parent'], 'upLevel' => $k];
            }
        }
    }


    private function withMenu($id, $menu)
    {
        $grand = [];
        $parent = [];

        foreach ($id['grand'] as $v) {
            array_push($grand, $menu[$v]);
        }
        foreach ($id['parent'] as $v) {
            foreach ($v as $vv) {
                array_push($parent, $menu[$vv]);
            }
        }
        return [
            'grand' => $grand,
            'parent' => $parent,
        ];
    }

    public function update()
    {
        session()->forget('pear_menu');
        return parent::update();
    }

    public function update_status()
    {
        if ($this->getOne()->is_disable == 0) {
            throw new AppException('不可禁用');
        }
        $auth = $this->getMany()->toArray();
        $id = $this->data['id'];
        $child = array_filter($auth, function ($value) use ($id) {
            return $value['p_id'] == $id;
        });
        $child_ids = array_column($child, 'id');
        $grand_child = array_filter($auth, function ($value) use ($child_ids) {
            return in_array($value['p_id'], $child_ids);
        });
        $ids = array_column(array_merge([['id' => $id]], $child, $grand_child), 'id');
        session()->forget('pear_menu');
        return $this->model->where('is_disable', 1)->whereIn('id', $ids)->update(['status' => $this->data['status']]);
    }
}
