<script type="text/x-template" id="address-cascader-city">
    <div class="area-address-cascader-city">
        <el-cascader
                :style="{'width':width}"
                clearable
                :size="size"
                :value="value"
                :options="options"
                filterable
                :props="propsData"
                @change="handleChange">
        </el-cascader>
    </div>
</script>
<script>
    $(function () {
        Vue.component('address-cascader-city', {
            template: '#address-cascader-city',
            props: {
                default: {
                    type: Array,
                    default: function () {
                        return [];
                    }
                },
                type: {
                    type: String,
                    default: "code"
                },
                size: {
                    type: String,
                    default: "small"
                },
                width: {
                    type: String,
                    default: "300px"
                }
            },
            watch: {
                type: function () {
                    this.defaultData();
                }
            },
            data: function () {
                return {
                    value: [],
                    propsData: {
                        expandTrigger: 'hover',
                        value: "code",
                        label: 'area_name'
                    },
                    options: []
                }
            },
            mounted: function () {
                this.getAreaTree();
            },
            methods: {
                defaultData: function () {
                    var defaultValue = this.default;
                    if (defaultValue && this.type === 'area_name') {
                        if (defaultValue.length === 2) {
                            var item1 = this.options.find(function (res) {
                                return defaultValue[0] === res.area_name;
                            });
                            console.log('item1', this.default)
                            if (!item1) {
                                this.value = [];
                                return
                            }
                            var item2 = item1.children.find(function (res) {
                                return defaultValue[1] === res.area_name;
                            });
                            if (!item2) {
                                this.value = [];
                                return
                            }
                            var code = [item1.code, item2.code];
                            console.log('code', code);
                            this.value = code;
                        }
                    } else {
                        this.value = defaultValue;
                    }
                    this.handleChange(this.value);
                },
                getAreaTree: function () {
                    var that = this
                    this.httpGet("{:api_url('/area/api/getAreaCityTree')}", {}, function (res) {
                        if (res.status) {
                            that.options = res.data;
                            that.defaultData();
                        }
                    })
                },
                handleChange: function (code) {
                    if (code.length === 2) {
                        var item1 = this.options.find(function (res) {
                            return parseInt(code[0]) === parseInt(res.code);
                        });
                        if (!item1) {
                            return
                        }
                        var item2 = item1.children.find(function (res) {
                            return parseInt(code[1]) === parseInt(res.code);
                        });
                        if (!item2) {
                            return
                        }
                        var name = [item1.area_name, item2.area_name];
                        this.$emit('change', {code: code, name: name})
                    } else {
                        this.$emit('change', {code: code, name: []})
                    }
                }
            }
        });
    })
</script>