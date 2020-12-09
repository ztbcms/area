<script type="text/x-template" id="address-cascader">
    <div class="area-address-cascader">
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
        Vue.component('address-cascader', {
            template: '#address-cascader',
            props: {
                default: {
                    type: Array,
                    defalut: function () {
                        return [];
                    }
                },
                type: {
                    type: String,
                    defalut: "code"
                },
                size: {
                    type: String,
                    defalut: "small"
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
                        if (defaultValue.length === 3) {
                            var item1 = this.options.find(function (res) {
                                return defaultValue[0] === res.area_name;
                            });
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
                            var item3 = item2.children.find(function (res) {
                                return defaultValue[2] === res.area_name;
                            });
                            if (!item3) {
                                this.value = [];
                                return
                            }
                            var code = [item1.code, item2.code, item3.code];
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
                    this.httpGet("{:api_url('/area/api/getAreaTree')}", {}, function (res) {
                        if (res.status) {
                            that.options = res.data;
                            that.defaultData();
                        }
                    })
                },
                handleChange: function (code) {
                    if (code.length === 3) {
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
                        var item3 = item2.children.find(function (res) {
                            return parseInt(code[2]) === parseInt(res.code);
                        });
                        if (!item3) {
                            return
                        }
                        var name = [item1.area_name, item2.area_name, item3.area_name];
                        this.$emit('change', {code: code, name: name})
                    } else {
                        this.$emit('change', {code: code, name: []})
                    }
                }
            }
        });
    })
</script>