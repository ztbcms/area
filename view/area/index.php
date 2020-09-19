<div>
    <div id="app">
        <el-card>
            <h3>地址选择</h3>
            <el-form :inline="true">
                <el-form-item label="单选">
                    <address-cascader width="200px" size="medium" @change="handleChange"></address-cascader>
                </el-form-item>
                <el-form-item label="多选">
                    <address-cascader-muti width="200px" size="medium"
                                           @change="handleMutiChange"></address-cascader-muti>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</div>
{include file="/components/address-cascader"}
{include file="/components/address-cascader-muti"}
<script>
    $(function () {
        new Vue({
            el: "#app",
            data() {
                return {
                    value: [],
                    options: []
                };
            },
            mounted() {
            },
            methods: {
                handleMutiChange(e) {
                    //[{"code":[110000,110100,110101],"label":["北京市","北京市","东城区"]},{"code":[110000,110100,110102],"label":["北京市","北京市","西城区"]}]
                    console.log(e);
                },
                handleChange(e) {
                    // {"code":[120000,120100,120103],"name":["天津市","天津市","河西区"]}
                    console.log(e);
                }
            }
        })
    })
</script>