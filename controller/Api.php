<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2020-09-19
 * Time: 11:19.
 */

namespace app\area\controller;


use app\area\model\AreaModel;
use app\BaseController;

class Api extends BaseController
{
    /**
     * 获取地区树形结构
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\response\Json
     */
    function getAreaTree()
    {
        $areas = AreaModel::where('pcode', 0)->field(['area_name', 'code', 'pcode'])
            ->with(['children.children'])
            ->cache(3600)
            ->select();
        return json(self::createReturn(true, $areas, 'ok'));
    }
}