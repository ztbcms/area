<script type="text/x-template" id="address-cascader-muti">
    <div>
        <div class="block">
            <el-cascader
                    :style="{'width':width}"
                    collapse-tags
                    clearable
                    :size="size"
                    v-model="code"
                    :options="options"
                    filterable
                    :props="{ expandTrigger: 'hover',multiple: true,value:'code',label:'area_name' }"
                    @change="handleChange">
            </el-cascader>
        </div>
    </div>
</script>
<script>
    $(function () {
        Vue.component('address-cascader-muti', {
            props: {
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
            mixins: [],
            data() {
                return {
                    code: [],
                    options: []
                }
            },
            mounted() {
                this.getAreaTree();
            },
            methods: {
                getAreaTree() {
                    this.httpGet("{:urlx('area/api/getAreaTree')}", {}, (res) => {
                        if (res.status) {
                            this.options = res.data;
                        }
                    })
                },
                getLabel(code) {
                    if (code.length === 3) {
                        let item1 = this.options.find(res => {
                            return parseInt(code[0]) === parseInt(res.code);
                        });
                        console.log('item1', item1);
                        let item2 = item1.children.find(res => {
                            return parseInt(code[1]) === parseInt(res.code);
                        });
                        console.log('item2', item2);
                        let item3 = item2.children.find(res => {
                            return parseInt(code[2]) === parseInt(res.code);
                        });
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