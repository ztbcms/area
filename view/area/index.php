<div>
    <div id="app" v-cloak>
        <el-card>
            <get-location @confirm="confirmLocation" :show="show" @close="show=false"></get-location>
            <div>
                <el-button type="primary" @click="show=true">选择定位</el-button>
            </div>
            <div style="margin-top: 10px">
                <el-form :inline="true">
                    <el-form-item label="结果">
                        {{address}}
                    </el-form-item>
                </el-form>
            </div>
        </el-card>
        <div style="margin-top: 20px">
            <el-card>
                <h3>地址选择</h3>
                <el-form :inline="true">
                    <el-form-item label="值类型">
                        <el-radio v-model="valueType" label="code">code</el-radio>
                        <el-radio v-model="valueType" label="area_name">name</el-radio>
                    </el-form-item>
                </el-form>
                <el-form :inline="true">
                    <el-form-item label="单选">
                        <address-cascader :default='[120000,120100,120103]' :type="valueType" width="200px"
                                          size="medium"
                                          @change="handleChange"></address-cascader>
                    </el-form-item>
                    <el-form-item label="多选">
                        <address-cascader-muti :default='[["北京市","北京市","西城区"],["北京市","北京市","石景山区"]]' :type="valueType"
                                               width="200px"
                                               size="medium"
                                               @change="handleMutiChange"></address-cascader-muti>
                    </el-form-item>
                </el-form>
                <el-form :inline="true">
                    <el-form-item label="结果">
                        {{ result }}
                    </el-form-item>
                </el-form>
            </el-card>
        </div>
    </div>
</div>


{include file="/components/get-location"}
{include file="/components/address-cascader"}
{include file="/components/address-cascader-muti"}
<script>
    $(function () {
        new Vue({
            el: "#app",
            data: function () {
                return {
                    show: false,
                    valueType: 'area_name',
                    value: [],
                    options: [],
                    result: "",
                    address: {}
                };
            },
            mounted: function () {
            },
            methods: {
                confirmLocation: function (e) {
                    console.log('confirmLocation', e)
                    this.address = e
                },
                handleMutiChange: function (e) {
                    //[{"code":[110000,110100,110101],"label":["北京市","北京市","东城区"]},{"code":[110000,110100,110102],"label":["北京市","北京市","西城区"]}]
                    console.log(e);
                    this.result = JSON.stringify(e)
                },
                handleChange: function (e) {
                    // {"code":[120000,120100,120103],"name":["天津市","天津市","河西区"]}
                    console.log(e);
                    this.result = JSON.stringify(e)
                }
            }
        })
    })
</script>