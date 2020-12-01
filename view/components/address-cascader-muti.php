<script type="text/x-template" id="address-cascader-muti">
    <div>
        <div class="block">
            <el-cascader
                    :style="{'width':width}"
                    collapse-tags
                    clearable
                    :size="size"
                    :value="value"
                    :options="options"
                    filterable
                    :props="propsData"
                    @change="handleChange">
            </el-cascader>
        </div>
    </div>
</script>
<script>
    $(function () {
        Vue.component('address-cascader-muti', {
            props: {
                default: {
                    type: Array,
                    defalut: function() {
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
            template: '#address-cascader-muti',
            watch: {
                type: function() {
                    this.defaultData();
                }
            },
            data: function() {
                return {
                    propsData: {expandTrigger: 'hover', multiple: true, value: 'code', label: 'area_name'},
                    value: [],
                    options: []
                }
            },
            mounted: function() {
                this.getAreaTree();
            },
            methods: {
                getValue: function(defaultValue) {
                    if (defaultValue.length === 3) {
                        var item1 = this.options.find(res => {
                            return defaultValue[0] === res.area_name;
                        });
                        if (!item1) {
                            this.value = [];
                            return
                        }
                        var item2 = item1.children.find(res => {
                            return defaultValue[1] === res.area_name;
                        });
                        if (!item2) {
                            this.value = [];
                            return
                        }
                        var item3 = item2.children.find(res => {
                            return defaultValue[2] === res.area_name;
                        });
                        if (!item3) {
                            this.value = [];
                            return
                        }
                        return [item1.code, item2.code, item3.code];
                    }
                },
                defaultData: function() {
                    var that = this
                    var defaultValues = this.default;
                    if (defaultValues && this.type === 'area_name') {
                        var codes = [];
                        defaultValues.forEach(function(defaultValue) {
                            codes.push(that.getValue(defaultValue));
                        });
                        this.value = codes;
                    } else {
                        this.value = defaultValues;
                    }
                    this.handleChange(this.value);
                },
                getAreaTree: function() {
                    var that = this
                    this.httpGet("{:api_url('/area/api/getAreaTree')}", {}, function(res) {
                        if (res.status) {
                            that.options = res.data;
                            that.defaultData();
                        }
                    })
                },
                getLabel: function(code) {
                    if (code.length === 3) {
                        var item1 = this.options.find(res => {
                            return parseInt(code[0]) === parseInt(res.code);
                        });
                        if (!item1) {
                            return
                        }
                        var item2 = item1.children.find(res => {
                            return parseInt(code[1]) === parseInt(res.code);
                        });
                        if (!item2) {
                            return
                        }
                        var item3 = item2.children.find(res => {
                            return parseInt(code[2]) === parseInt(res.code);
                        });
                        if (!item3) {
                            return
                        }
                        return [item1.area_name, item2.area_name, item3.area_name];
                    } else {
                        return {code: [], detail: []};
                    }
                },
                handleChange: function(codes) {
                    var that = this
                    var a = [];
                    codes.forEach(function(code) {
                        a.push({
                            code: code,
                            label: that.getLabel(code)
                        })
                    });
                    this.$emit('change', a)
                }
            }
        });
    })
</script>