### 地区管理



#### 行政地区

##### 获取定位（基于腾讯地图）

引用php模板文件
```html
// 根据引用的文件，填写路径
{include file="/components/get-location"}

//组件引用 
<get-location @confirm="confirmLocation" :show="show" @close="show=false"></get-location>
```
**PS: 需要在get-location 组件中设置 key **
key 申请地址 [https://lbs.qq.com/](https://lbs.qq.com/)
```
<!-- 注意 KEY 的取值  -->
<script charset="utf-8" src="https://map.qq.com/api/gljs?v=1.exp&key=WVABZ-QNQ3G-C5AQZ-IHOFB-O5GM3-*****"></script>

// 注意 KEY 的取值
const key = "WVABZ-QNQ3G-C5AQZ-IHOFB-O5GM3-*****"
```


##### 单选

引用php模板文件
```html
// 根据引用的文件，填写路径
{include file="/components/address-cascader"}

//组件引用 
<address-cascader :default='[120000,120100,120103]' type="code" width="200px" size="medium" @change="handleChange"></address-cascader>
```
组件参数

|参数|类型|说明|
| :-----------: | :-----------: | :-----------: |
|type|string|定义值类型，code，area_name|
|default|array|默认值，type=code 传code数组，code=area_name 传name数组|
|width|string|input宽度|
|size|string|组件类型大小，medium / small / mini|

事件

```js
handleChange: function(e) {
  // {"code":[120000,120100,120103],"name":["天津市","天津市","河西区"]}
  console.log(e);
}
```

##### 多选

引用php模板文件
```html
// 根据引用的文件，填写路径
{include file="/components/address-cascader-muti"}

//组件引用 
<address-cascader-muti :default='[["北京市","北京市","西城区"],["北京市","北京市","石景山区"]]' type="area_name" width="200px" size="medium" @change="handleMutiChange"></address-cascader-muti>
```
组件参数

|参数|类型|说明|
| :-----------: | :-----------: | :-----------: |
|type|string|定义值类型，code，area_name|
|default|array|默认值（二维数组），type=code 传code数组，code=area_name 传name数组|
|width|string|input宽度|
|size|string|组件类型大小，medium / small / mini|

事件

```js
handleMutiChange: function(e) {
  //[{"code":[110000,110100,110101],"label":["北京市","北京市","东城区"]},{"code":[110000,110100,110102],"label":["北京市","北京市","西城区"]}]
  console.log(e);
}
```

