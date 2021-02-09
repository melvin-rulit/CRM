<template>
        <b-modal id="addWarehouse" title="Добавление склада" centered ok-title="Сохранить" @hidden="closeModal" cancel-title="Отмена" @ok="saveWarehouse">
            <div class="form-group row" :class="{ 'form-group--error': $v.name.$error &&  showErrors}">
                <label class="col-sm-3 col-form-label">Название</label>
                <div class="col-sm-9">
                    <input class="form-control" v-model="$v.name.$model">
                    <span v-if="!$v.name.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                    <span v-if="!$v.name.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.name.$params.minLength.min}} символа</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Регион</label>
                <div class="col-sm-9">
                    <dynamic-select
                        :options="regions"
                        v-model="region"
                        option-value="id"
                        option-text="name"
                        @input="getBranches"
                        placeholder="Введите для поиска региона"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Филиал</label>
                <div class="col-sm-9">
                    <input class="form-control" v-if="!region" disabled>
                    <dynamic-select
                        v-if="region"
                        :options="branches"
                        v-model="branch"
                        option-value="id"
                        option-text="name"
                        @input="getUsers"
                        placeholder="Введите для поиска филиала"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Сотрудник</label>
                <div class="col-sm-9">
                    <input class="form-control" v-if="!branch" disabled>
                    <dynamic-select
                        v-if="branch"
                        :options="users"
                        v-model="user"
                        option-value="id"
                        option-text="name"
                        placeholder="Введите для поиска сотрудника"/>
                </div>
            </div>
            <div class="form-group row">
                <textarea class="form-control" v-model="description" rows="3" placeholder="Описание"></textarea>
            </div>
        </b-modal>
</template>

<script>

    import { required, minLength } from 'vuelidate/lib/validators';

    export default {
        data() {
            return {
                showErrors: false,
                name: '',
                branch: '',
                branches: [],
                region: '',
                regions: [],
                user: '',
                users: [],
                user: '',
                suppliers: [],
                supplier: '',
                description: '',
            }
        },

        validations: {
            name: {
                required,
                minLength: minLength(4)
            },
        },

        methods: {

            showModal(){
                this.$bvModal.show('addWarehouse')
                this.getRegions()
            },

            getRegions(){
                axios.get('api/v2/getRegionsWarehouse')
                    .then(response => {this.regions = response.data})
            },

            getBranches(){
                this.branches = []
                this.branch = ''
                axios.post('api/v2/getBranchesWarehouse', {id: this.region.id})
                    .then(response => {this.branches = response.data})
            },

            getUsers(){
                this.users = []
                this.user = ''
                axios.post('api/v2/getUsersWarehouse', {id: this.branch.id})
                    .then(response => {this.users = response.data.data})
            },

            getSuppliers(){
                this.suppliers = []
                this.supplier = ''
                axios.get('api/v2/suppliers')
                    .then(response => {this.suppliers = response.data.data})
            },

            saveWarehouse(bvModalEvt){
                this.$v.$touch()

                if (this.$v.$invalid){
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                }else{
                    if (!this.branch || !this.user){
                        Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                        bvModalEvt.preventDefault()
                    }else{
                        axios.post('api/v2/warehouses', {
                            name: this.name,
                            branch_id: this.branch.id,
                            user_id: this.user.id,
                            supplier: this.supplier.id,
                            description: this.description,
                        })
                        Vue.$toast.open({message: 'Склад создан' ,type: 'success',duration: 1000,position: 'top-right'});
                        this.$emit('get-method')
                        this.$v.$reset()
                        this.showErrors = false
                    }
                }
            },

            closeModal(){
                this.name = ''
                this.description = ''
                this.branch = '',
                this.branches = [],
                    this.region = '',
                    this.regions = [],
                    this.user = '',
                    this.users = [],
                    this.supplier = '',
                    this.suppliers = [],
                this.$v.$reset()
                this.showErrors = false
            }
        },
    }
</script>

<style scoped>
    .form-control:focus {
        color: #12263f;
        outline: 0;
    }
</style>
