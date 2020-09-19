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
                    defalut() {
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
                type(type) {
                    this.defaultData();
                }
            },
            data() {
                return {
                    propsData: {expandTrigger: 'hover', multiple: true, value: 'code', label: 'area_name'},
                    value: [],
                    options: []
                }
            },
            mounted() {
                this.getAreaTree();
            },
            methods: {
                getValue(defaultValue) {
                    if (defaultValue.length === 3) {
                        let item1 = this.options.find(res => {
                            return defaultValue[0] === res.area_name;
                        });
                        if (!item1) {
                            this.value = [];
                            return
                        }
                        let item2 = item1.children.find(res => {
                            return defaultValue[1] === res.area_name;
                        });
                        if (!item2) {
                            this.value = [];
                            return
                        }
                        let item3 = item2.children.find(res => {
                            return defaultValue[2] === res.area_name;
                        });
                        if (!item3) {
                            this.value = [];
                            return
                        }
                        return [item1.code, item2.code, item3.code];
                    }
                },
                defaultData() {
                    let defaultValues = this.default;
                    if (defaultValues && this.type === 'area_name') {
                        let codes = [];
                        defaultValues.forEach(defaultValue => {
                            codes.push(this.getValue(defaultValue));
                        });
                        this.value = codes;
                    } else {
                        this.value = defaultValues;
                    }
                    this.handleChange(this.value);
                },
                getAreaTree() {
                    this.httpGet("{:urlx('area/api/getAreaTree')}", {}, (res) => {
                        if (res.status) {
                            this.options = res.data;
                            this.defaultData();
                        }
                    })
                },
                getLabel(code) {
                    if (code.length === 3) {
                        let item1 = this.options.find(res => {
                            return parseInt(code[0]) === parseInt(res.code);
                        });
                        if (!item1) {
                            return
                        }
                        let item2 = item1.children.find(res => {
                            return parseInt(code[1]) === parseInt(res.code);
                        });
                        if (!item2) {
                            return
                        }
                        let item3 = item2.children.find(res => {
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
                handleChange(codes) {
                    let a = [];
                    codes.forEach(code => {
                        a.push({
                            code,
                            label: this.getLabel(code)
                        })
                    });
                    this.$emit('change', a)
                }
            }
        });
    })
</script>