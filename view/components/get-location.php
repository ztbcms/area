{include file="/components/address-cascader-city"}
<script type="text/x-template" id="get-location">
    <div class="area-get-location">
        <el-dialog
                title="定位选择"
                width="800px"
                :visible="show" @close="$emit('close')">
            <div>
                <div>
                    <el-container>
                        <el-header>
                            <el-form :inline="true" class="demo-form-inline">
                                <el-form-item>
                                    <address-cascader-city :default="['广东省','广州市']" type="area_name" width="200px"
                                                           size="medium"
                                                           @change="handleChange"></address-cascader-city>
                                </el-form-item>
                                <el-form-item>
                                    <el-input clearable v-model="keyword" placeholder="请输入搜索内容"></el-input>
                                </el-form-item>
                                <el-form-item>
                                    <el-input disabled v-model="location" placeholder="坐标"></el-input>
                                </el-form-item>
                                <el-form-item>
                                    <el-button type="primary" @click="onSubmit">查询</el-button>
                                </el-form-item>
                            </el-form>
                        </el-header>
                        <el-container>
                            <el-aside width="200px">
                                <div style="height: 450px;width: 200px">
                                    <el-menu
                                            @select="selectAddress"
                                            :default-active="default_active"
                                            class="el-menu-vertical-demo">
                                        <el-menu-item v-for="(item,index) in address_list" :index="index+''">
                                            <div slot="title">
                                                <div>{{item.title}}</div>
                                            </div>
                                        </el-menu-item>
                                    </el-menu>
                                </div>
                            </el-aside>
                            <el-main>
                                <div style="width: 500px;height: 450px" id="container"></div>
                            </el-main>
                        </el-container>
                    </el-container>
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="$emit('close')">取 消</el-button>
                <el-button type="primary" @click="confirmEvent">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</script>
<!-- 注意 KEY 的取值  -->

<?php $qqmap_key = \app\area\service\AreaToolService::QQMAP_KEY; ?>
<script charset="utf-8" src="https://map.qq.com/api/gljs?v=1.exp&key={$qqmap_key}"></script>
<script>
    var map
    var marker
    $(function () {
        Vue.component('get-location', {
            template: '#get-location',
            props: {
                show: {
                    type: Boolean,
                    default: false
                }
            },
            watch: {
                show: function (value) {
                    if (value && !map) {
                        var _this = this
                        setTimeout(function () {
                            _this.initMap()
                        }, 1000)
                    }
                }
            },
            data: function () {
                return {
                    key: "{$qqmap_key}",
                    keyword: "",
                    city: "",
                    address_list: [],
                    address: {},
                    location: "",
                    default_active: "0",
                }
            },
            mounted: function () {
            },
            methods: {
                confirmEvent: function () {
                    if (!this.address.title) {
                        this.$message.error('请选择坐标位置')
                        return
                    }
                    this.$emit('confirm', this.address)
                    this.$emit('close')
                },
                initMap: function () {
                    var _this = this
                    map = new TMap.Map("container", {
                        zoom: 16,
                        center: new TMap.LatLng(23.130047, 113.26351)
                    });
                    marker = new TMap.MultiMarker({
                        id: "marker-layer", //图层id
                        map: map,
                        styles: { //点标注的相关样式
                            "marker": new TMap.MarkerStyle({
                                "width": 35,
                                "height": 35,
                                "anchor": {x: 16, y: 32},
                                "src": "data:image/png;base64,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"
                            })
                        }
                    });
                    //绑定点击事件
                    map.on("click", function (evt) {
                        var lat = evt.latLng.getLat().toFixed(6);
                        var lng = evt.latLng.getLng().toFixed(6);
                        console.log(lat + "," + lng)
                        _this.searchAddressNearby(lat, lng)
                    })
                },
                selectLocation: function (item) {
                    if (item.location) {
                        var lat = item.location.lat
                        var lng = item.location.lng
                        var center = new TMap.LatLng(lat, lng);//设置中心点坐标
                        console.log(item.title, lat, lng)
                        map.setCenter(center)
                        //初始化marker
                        var geometries = [{ //点标注数据数组
                            "id": "demo",
                            "styleId": "marker",
                            "position": new TMap.LatLng(lat, lng),
                            "properties": {
                                "title": "marker"
                            }
                        }]
                        marker.setGeometries(geometries)
                        this.location = lat + "," + lng
                        this.address = {
                            title: item.title,
                            address: item.address,
                            location: item.location
                        }
                    }
                },
                selectAddress: function (e) {
                    console.log('selectAddress', e)
                    var address = this.address_list[parseInt(e)]
                    if (address) {
                        this.selectLocation(address)
                    }
                },
                handleChange: function (e) {
                    this.city = e.name[1]
                },
                searchAddress: function () {
                    var _this = this
                    if (!this.keyword) {
                        this.$message.error('请输入关键词')
                        return
                    }
                    var url = "https://apis.map.qq.com/ws/place/v1/search?callback=?&output=jsonp&keyword=" + encodeURIComponent(this.keyword) + "&boundary=region(" + this.city + ",0)&key=" + this.key
                    $.getJSON(url, function (res) {
                        console.log('res', res)
                        if (res.status === 0) {
                            _this.address_list = res.data
                            _this.default_active = "0"
                            if (_this.address_list.length > 0) {
                                _this.selectLocation(_this.address_list[0])
                            }
                        }
                    })
                },
                searchAddressNearby: function (lat, lng) {
                    var _this = this
                    var url = "https://apis.map.qq.com/ws/geocoder/v1/?location=" + lat + "," + lng + "&callback=?&output=jsonp&key=" + key
                    $.getJSON(url, function (res) {
                        console.log('res', res)
                        if (res.status === 0) {
                            if (_this.keyword === '') {
                                _this.keyword = res.result.address
                            }
                            _this.selectLocation({
                                title: res.result.address,
                                address: res.result.address,
                                location: res.result.location
                            })
                        }
                    })
                },
                onSubmit: function () {
                    this.searchAddress()
                }
            },
        });
    })
</script>