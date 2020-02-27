<?php

namespace App\Servers;

use App\Models\Module;
use App\Models\Site;
use App\User;

/**
 * 模块菜单服务
 * Class ModuleMenuServer
 */
class MenuServer
{
  /**
   * 获取只拥有权限的菜单
   * @param Site $site
   *
   * @return array
   */
  public function getHasPermissionMenus(Site $site)
  {
    $modules = app(ModuleServer::class)->getSiteModule($site);
    $menus = [];
    foreach ($modules as $module) {
      $menus[$module['config']['title']] = $this->getHasPermissionModuleMenu($site, $module);
    }
    return $menus;
  }

  /**
   * 根据用户权限模块菜单
   * @param Module $module
   *
   * @return mixed
   */
  public function getUserMenu(Site $site, Module $module, User $user)
  {
    $names = $site->permissions()->where('module_id', $module['id'])->pluck('name');
    return $user->getAllPermissions()->where('site_id', 1);
  }

  /**
   * 获取拥有权限的模块菜单
   * @param Site $site
   * @param array $module
   *
   * @return array
   */
  public function getHasPermissionModuleMenu(Site $site, array $module)
  {
    $info = app(ModuleServer::class)->getModuleInfo($module['config']['name']);
    $admin = [];
    foreach ($info['menu']['admin'] as $menus) {
      $admin = array_merge($admin, $this->formatMenu($site, $module, $menus));
    }
    return $admin;
  }

  /**
   * 过滤没有权限的菜单并加菜单前缀
   * @param Site $site
   * @param array $module
   * @param array $menus
   *
   * @return array
   */
  protected function formatMenu(Site $site, array $module, array $menus)
  {
    $format = [];
    foreach ($menus as $menu) {
      if (isset($menu['permission'])) {
        $menu['permission'] = $this->addPermissionPrefix($site, $module, $menu);
        $format[] = $menu;
      }
    }
    return $format;
  }

  /**
   * 添加权限前缀
   * @param Site $site
   * @param array $module
   * @param array $menu
   *
   * @return string
   */
  protected function addPermissionPrefix(Site $site, array $module, array $menu)
  {
    return "S{$site['id']}-{$module['config']['name']}-{$menu['permission']}";
  }
}