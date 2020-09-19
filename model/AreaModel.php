<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2020-09-19
 * Time: 09:56.
 */

namespace app\area\model;

use Think\Model;

class AreaModel extends Model
{
    protected $name = 'tp6_area';

    /**
     * 获取下级
     * @return \think\model\relation\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'pcode', 'code')->field(['area_name', 'code', 'pcode']);
    }
}