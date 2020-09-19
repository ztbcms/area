<script type="text/x-template" id="address-cascader">
    <div>
        <div class="block">
            <el-cascader
                    :style="{'width':width}"
                    clearable
                    :size="size"
                    v-model="code"
                    :options="options"
                    filterable
                    :props="{ expandTrigger: 'hover' ,value:'code',label:'area_name'}"
                    @change="handleChange">
            </el-cascader>
        </div>
    </div>
</script>
<script>
    $(function () {
        Vue.component('address-cascader', {
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
            template: '#address-cascader',
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
                handleChange(code) {
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
                        let name = [item1.area_name, item2.area_name, item3.area_name];
                        this.$emit('change', {code, name})
                    } else {
                        this.$emit('change', {code: [], code: []})
                    }

                }
            }
        });
    })
</script>