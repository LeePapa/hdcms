<?php
/** .-------------------------------------------------------------------
 * |    Author: 向军 <www.aoxiangjun.com>
 * |    WeChat: houdunren2018
 * |      Date: 2019-02-16
 * | Copyright (c) 2012-2019, www.houdunren.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Site;
use App\User;

class SiteRepository extends Repository
{
    protected $model = Site::class;

    public function paginate($row = 10, array $columns = ['*'], $latest = null)
    {
        if (isSuperAdmin()) {
            return parent::paginate($row, $columns, $latest);
        }
        return auth()->user()->site;
    }

    public function create(array $attributes)
    {
        $model = parent::create($attributes);
        $model->site()->save(auth()->user(), ['role' => 'admin']);
    }

    /**
     * 缓存最近操作的站点
     * @param Site $site
     * @throws \Exception
     */
    public function cacheSite(Site $site)
    {
        return cache()->forever(auth()->id() . '-site', $site);
    }

    /**
     * 获取历史编辑站点
     * @return mixed
     * @throws \Exception
     */
    public function historySite()
    {
        return cache()->rememberForever(auth()->id() . '-site', function () {
            return auth()->user()->site()->first();
        });
    }

    /**
     * 获取站点套餐
     * @param Site $site
     * @return mixed
     */
    public function packages(Site $site)
    {
        return $site->user->group->package;
    }

    public function role(Site $site, User $user)
    {
        return $site->user()->wherePivot('user_id', $user['id'])->wherePivot('site_id', $site['id']);
    }
}