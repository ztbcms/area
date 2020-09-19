<script type="text/x-template" id="address-cascader">
    <div>
        <div class="block">
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
    </div>
</script>
<script>
    $(function () {
        Vue.component('address-cascader', {
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
            watch: {
                type(type) {
                    this.defaultData();
                }
            },
            template: '#address-cascader',
            data() {
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
            mounted() {
                this.getAreaTree();
            },
            methods: {
                defaultData() {
                    let defaultValue = this.default;
                    if (defaultValue && this.type === 'area_name') {
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
                            let code = [item1.code, item2.code, item3.code];
                            console.log('code', code);
                            this.value = code;
                        }
                    } else {
                        this.value = defaultValue;
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
                handleChange(code) {
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
                        let name = [item1.area_name, item2.area_name, item3.area_name];
                        this.$emit('change', {code, name})
                    } else {
                        this.$emit('change', {code, name: []})
                    }

                }
            }
        });
    })
</script>