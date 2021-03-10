<?php
/**
 * User: zhlhuang
 */

namespace app\area\controller;


use app\area\model\AreaModel;
use app\BaseController;
use think\facade\Cache;

class Api extends BaseController
{
    /**
     * 获取地区树形结构
     *
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    function getAreaTree()
    {
        $cache_key = __CLASS__.__METHOD__;
        $res = Cache::get($cache_key);
        if ($res) {
            return json(self::createReturn(true, $res));
        }
        $areas = AreaModel::where('pcode', 0)->field(['area_name', 'code', 'pcode'])
            ->with(['children.children'])
            ->select()->toArray();
        Cache::set($cache_key, $areas);
        return json(self::createReturn(true, $areas));
    }

    /**
     * 获取地区树形结构（城市）
     *
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    function getAreaCityTree()
    {
        $cache_key = __CLASS__.__METHOD__;
        $res = Cache::get($cache_key);
        if ($res) {
            return json(self::createReturn(true, $res));
        }
        $areas = AreaModel::where('pcode', 0)->field(['area_name', 'code', 'pcode'])
            ->with(['children'])
            ->select()->toArray();
        Cache::set($cache_key, $areas);
        return json(self::createReturn(true, $areas));
    }
}