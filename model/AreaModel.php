<?php
/**
 * User: zhlhuang
 */

namespace app\area\model;

use Think\Model;

class AreaModel extends Model
{
    protected $name = 'area_area';

    /**
     * 获取下级
     * @return \think\model\relation\HasMany
     */
    public function children()
    {
        return $this->hasMany(AreaModel::class, 'pcode', 'code')->field(['area_name', 'code', 'pcode']);
    }
}