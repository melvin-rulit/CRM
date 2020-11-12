<template>
    <div>

        <!-- Модальное окно с добавлением новой роли -->
        <b-modal id="addNewUser" title="Добавление нового клиента" @ok="saveUser" @hidden="closeModal" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <div class="form-group row" :class="{ 'form-group--error': $v.new_child_surname.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Имя</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.new_child_surname.$model">
                        <span v-if="!$v.new_child_surname.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                        <span v-if="!$v.new_child_surname.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.new_child_surname.$params.minLength.min}} символа</span>
                    </div>
                </div>

                <div class="form-group row" :class="{ 'form-group--error': $v.new_child_name.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Имя</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.new_child_name.$model">
                        <span v-if="!$v.new_child_name.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                        <span v-if="!$v.new_child_name.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.new_child_name.$params.minLength.min}} символа</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Отчество</label>
                    <div class="col-sm-9">
                        <input v-model.trim="new_child_middle_name" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Филиал</label>
                    <div class="col-sm-9">
                        <dynamic-select :options="branches" option-value="id" option-text="name" placeholder="Введите для поиска" v-model="branch" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Менеджер</label>
                    <div class="col-sm-9">
                        <dynamic-select :options="users" option-value="id" option-text="surname" placeholder="Введите для поиска" v-model="manager" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Тренер</label>
                    <div class="col-sm-9">
                        <dynamic-select :options="users" option-value="id" option-text="surname" placeholder="Введите для поиска" v-model="instructor" />
                    </div>
                </div>

            </div>
        </b-modal>
    </div>
    </div>

    </div>
    </div>
</template>

<script>

    import DynamicSelect from 'vue-dynamic-select'
    Vue.use(DynamicSelect)

    import Multiselect from 'vue-multiselect'

    Vue.use(Multiselect);
    import 'vue-multiselect/dist/vue-multiselect.min.css';

    import { required, minLength } from 'vuelidate/lib/validators';

    export default {
        components: { Multiselect },
        data() {
            return {
                new_child_surname: '',
                new_child_name: '',
                new_child_middle_name: '',
                branch: [],
                manager: [],
                instructor: [],
                submitStatus: null,
                showErrors: false,
            }
        },

        validations: {
            new_child_surname: {
                required,
                minLength: minLength(4)
            },
            new_child_name: {
                required,
                minLength: minLength(4)
            },
        },


        methods: {

            getBranches(){
                axios.get('api/v2/getbranches')
                    .then(response => this.branches = response.data.data)
            },

            getUsers(){
                axios.get('api/v2/getusers')
                    .then(response => this.users = response.data.data)
            },

            addNewUserModal(){
                this.$bvModal.show('addNewUser')
                this.getBranches()
                this.getUsers()
            },




            saveUser(bvModalEvt){
                this.$v.$touch()

                if (this.$v.$invalid){
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 5000,position: 'top-right'});
                }else{
                    if (!this.branch){
                        Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 5000,position: 'top-right'});
                        bvModalEvt.preventDefault()
                    }else{
                        axios.post('api/v2/addnewuser', {
                            child_surname: this.new_child_surname,
                            child_name: this.new_child_name,
                            child_middle_name: this.new_child_middle_name,
                            manager: this.manager ? this.manager.id : null,
                            instructor: this.instructor ? this.instructor.id : null,
                            branch: this.branch.id
                        })
                        Vue.$toast.open({message: 'Клиент успешно добавлен',type: 'success',duration: 5000,position: 'top-right'}),
                        this.$emit('get-method')
                        this.$v.$reset()
                        this.showErrors = false
                    }
                }
            },

            closeModal(){
                this.new_child_surname = '',
                    this.new_child_name = '',
                    this.new_child_middle_name = '',
                    this.branch = '',
                    this.manager = '',
                    this.instructor = '',
                this.$v.$reset()
                this.showErrors = false
            },
        },
    }
</script>
