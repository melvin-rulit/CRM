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

        <!-- Модальное окно с добавлением нового сотрудника -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Добавление нового сотрудника</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="addNewUser">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Имя</label>
                    <div class="col-sm-9">
                        <input v-model="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Фамилия</label>
                    <div class="col-sm-9">
                        <input v-model="surname" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Телефон</label>
                    <div class="col-sm-9">
                        <input v-model="phone" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Логин (почта)</label>
                    <div class="col-sm-9">
                        <input v-model="login" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Пароль</label>
                    <div class="col-sm-9">
                        <input type="password" v-model="password" class="form-control" required>
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
                <pre><code>{{ newRole }}</code></pre>
                <p @click="pushq">Добавить array</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="resetForm">Отменить</button>
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
    </div>
</template>

<script>

  import Multiselect from 'vue-multiselect'

    Vue.use(Multiselect);
    import 'vue-multiselect/dist/vue-multiselect.min.css';


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
                newRole: [],
            }
        },
        methods: {
            pushq(){
                  this.role.forEach((value, key) => {
                  this.newRole.push(value.id);
              });
            },
            addNewUserModal(){
                $('#addNewUser').modal('show');
                this.getAtributes();
            },
            getAtributes(){
                axios.get('api/v2/getatributes')
                    .then(response => {this.access = response.data.data})
            },

            addNewUser(){
                axios.post('api/v2/users', {
                    name: this.name,
                    surname: this.surname,
                    phone: this.phone,
                    login: this.login,
                    email: this.login,
                    password: this.password,
                    branch: this.branch,
                    role: this.newRole,
                })
            },
            resetForm(){
                this.name = '';
                this.surname = '';
                this.phone = '';
                this.login = '';
                this.password = '';
                this.role = '';
                this.access = '';
            },
        },
    }
</script>
