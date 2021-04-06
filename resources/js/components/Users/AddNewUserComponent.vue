<template>
    <div>

        <!-- Модальное окно с добавлением новой роли -->
        <b-modal id="addNewUser" title="Добавление нового сотрудника" @ok="saveUser" @hidden="closeModal" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <div class="form-group row" :class="{ 'form-group--error': $v.name.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Имя</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.name.$model">
                        <span v-if="!$v.name.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                        <span v-if="!$v.name.minLength && showErrors" class="text-danger h5 ml-3">* Имя не может меньше {{$v.name.$params.minLength.min}} символа</span>
                    </div>
                </div>
                <div class="form-group row" :class="{ 'form-group--error': $v.surname.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Фамилия</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.surname.$model">
                        <span v-if="!$v.surname.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                    </div>
                </div>
                <div class="form-group row" :class="{ 'form-group--error': $v.phone.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Телефон</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-mask="'+## (###) ###-##-##'" v-model="$v.phone.$model">
                        <span v-if="!$v.phone.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                    </div>
                </div>
                <div class="form-group row" :class="{ 'form-group--error': $v.login.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Почта</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.login.$model">
                        <span v-if="!$v.login.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                        <span v-if="!$v.login.email && showErrors" class="text-danger h5 ml-3">* Почта заполнена не верно. Проверьте правильность заполнения и повторите попытку</span>
                    </div>
                </div>
                <div class="form-group row" :class="{ 'form-group--error': $v.password.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Пароль</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.password.$model">
                        <span v-if="!$v.password.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Должность</label>
                    <div class="col-sm-9">
                        <multiselect
                                v-if="access.roles"
                                v-model="role"
                                placeholder="Выберите должность"
                                label="title"
                                track-by="id"
                                :options="access.roles"
                                :multiple="true"
                                :taggable="true">
                        </multiselect>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Филиалы</label>
                    <div class="col-sm-9">
                        <multiselect
                                v-if="access.branches"
                                v-model="branch"
                                placeholder="Выберите филиал"
                                label="name"
                                track-by="id"
                                :options="access.branches"
                                :multiple="true"
                                :taggable="true">
                        </multiselect>
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

    import {TheMask} from 'vue-the-mask'

  import Multiselect from 'vue-multiselect'

    Vue.use(Multiselect);
    import 'vue-multiselect/dist/vue-multiselect.min.css';

    import { required, minLength, email } from 'vuelidate/lib/validators';

    export default {
        components: { Multiselect, TheMask },
        data() {
            return {
                name: '',
                surname: '',
                phone: '',
                login: '',
                password: '',
                role: '',
                branch: '',
                users: {},
                access: {},
                submitStatus: null,
                showErrors: false,
            }
        },

        validations: {
            name: {
                required,
                minLength: minLength(4)
            },
            surname: {
                required,
            },
            phone: {
                required,
            },
            login: {
                required,
                email
            },
            password: {
                required,
            }
        },

        computed: {
            newRoleArray(){
                return this.role.slice().map(item => item.id.toString());
            },

            newBranchArray(){
                return this.branch.slice().map(item => item.id.toString());
            },
        },

        methods: {

            addNewUserModal(){
                this.$bvModal.show('addNewUser')
                this.getAtributes();
            },
            getAtributes(){
                axios.get('api/v2/getatributes')
                    .then(response => {this.access = response.data.data})
            },

            saveUser(bvModalEvt){
                this.$v.$touch()

                if (this.$v.$invalid){
                    this.showErrors = true
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                }else{
                    if (!this.branch || !this.role){
                        Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                        bvModalEvt.preventDefault()
                    }else{
                        axios.post('api/v2/users', {
                            name: this.name,
                            surname: this.surname,
                            phone: this.phone,
                            login: this.login,
                            email: this.login,
                            password: this.password,
                            secret_id: this.password,
                            branch: this.newBranchArray,
                            role: this.newRoleArray,
                        })
                        // $('#addNewUser').modal('hide');
                        this.$emit('get-method')
                        this.$v.$reset()
                        this.showErrors = false
                    }
                }
            },

            closeModal(){
                this.name = ''
                this.surname = ''
                this.phone = ''
                this.login = ''
                this.password = ''
                this.role = ''
                this.access = ''
                this.branch = ''
                this.$v.$reset()
                this.showErrors = false
            },
        },
    }
</script>

<style >
    .form-control:focus {
        color: #12263f;
        outline: 0;
    }
</style>
