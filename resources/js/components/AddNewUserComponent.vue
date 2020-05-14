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
<multiselect v-model="value" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
<pre class="language-json"><code>{{ value  }}</code></pre>
            <form @submit.prevent="addNewUser">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Имя</label>
                    <div class="col-sm-9">
                        <input v-model="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Телефон</label>
                    <div class="col-sm-9">
                        <input v-model="phone" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Логин</label>
                    <div class="col-sm-9">
                        <input v-model="login" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Пароль</label>
                    <div class="col-sm-9">
                        <input v-model="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Должность</label>
                    <div class="col-sm-9">
                        <dynamic-select 
                            :options="access.roles"
                            option-value="id"
                            option-text="title"
                            placeholder="Введите для поиска"
                            v-model="role" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label required">Филиалы</label>
                    <div class="col-sm-9">
                        <dynamic-select 
                            :options="access.branches"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска"
                            v-model="branch" />
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="resetForm">Отменить</button>
            <button type="submit" class="btn btn-success">Добавить</button>
        </div>
    </div>
</div>

</div>
    </div>
</template>

<script>

  import Multiselect from 'vue-multiselect'

  // register globally
Vue.use(Multiselect);
import 'vue-multiselect/dist/vue-multiselect.min.css';


    export default {
        components: { Multiselect },
        data() {
            return {
      value: [
        { name: 'Javascript', code: 'js' }
      ],
      options: [
        { name: 'Vue.js', code: 'vu' },
        { name: 'Javascript', code: 'js' },
        { name: 'Open Source', code: 'os' }
      ],
                users: {},
                access: {},
            }
        },
        methods: {
                addTag (newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      }
      this.options.push(tag)
      this.value.push(tag)
    },
            addNewUserModal(){
                $('#addNewUser').modal('show');
                this.getAtributes();
            },
            getAtributes(){
                axios.get('api/v2/getatributes')
                    .then(response => {this.access = response.data.data})
            },
            resetForm(){
                this.name = '';
                this.phone = '';
                this.login = '';
                this.password = '';
                this.role = '';
                this.access = '';
            },
        },
    }
</script>
