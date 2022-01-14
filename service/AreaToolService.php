<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2022/1/14
 * Time: 10:48.
 */

namespace app\area\service;

use app\common\service\BaseService;

class AreaToolService extends BaseService
{

    const QQMAP_KEY = 'WVABZ-QNQ3G-C5AQZ-IHOFB-O5GM3-7VFBM';

    /**
     * 腾讯地图接口-根据经纬度返回省市区信息
     */
    static function getRegionByLocation(float $longitude = 0, float $latitude = 0)
    {
        try {
            $key = self::QQMAP_KEY;
            $url = "https://apis.map.qq.com/ws/geocoder/v1/?location={$latitude},{$longitude}&key={$key}&get_poi=1";
            $res = file_get_contents($url);
            $res = is_string($res) ? json_decode($res, true) : $res;

            return $res['result']['address_component'] ?? $res;
        } catch (\Exception $exception) {
            return [];
        }
    }
}