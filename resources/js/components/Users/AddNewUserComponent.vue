<template>
    <div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-2">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col"></div>
                  <div class="col-auto">
                    <button class="btn btn-sm btn-success" @click="addNewUserModal">Добавить сотрудника</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

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
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Фамилия</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="surname">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Телефон</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="phone">
                    </div>
                </div>
                <div class="form-group row" :class="{ 'form-group--error': $v.login.$error &&  showErrors}">
                    <label class="col-sm-3 col-form-label required">Почта</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="$v.login.$model">
                        <span v-if="!$v.login.required && showErrors" class="text-danger h5 ml-3">* Поле обязательно для заполнения</span>
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

  import Multiselect from 'vue-multiselect'

    Vue.use(Multiselect);
    import 'vue-multiselect/dist/vue-multiselect.min.css';

    import { required, minLength } from 'vuelidate/lib/validators';

    export default {
        components: { Multiselect },
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
            login: {
                required,
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
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 5000,position: 'top-right'});
                }else{
                    if (!this.branch || !this.role){
                        Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 5000,position: 'top-right'});
                        bvModalEvt.preventDefault()
                    }else{
                        axios.post('api/v2/users', {
                            name: this.name,
                            surname: this.surname,
                            phone: this.phone,
                            login: this.login,
                            email: this.login,
                            password: this.password,
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
