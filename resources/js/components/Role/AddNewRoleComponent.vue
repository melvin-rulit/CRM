<template>
    <div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-2">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col"></div>
                  <div class="col-auto">
                    <button class="btn btn-sm btn-success" @click="addNewRoleModal">Добавить должность</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Модальное окно с добавлением новой роли -->
        <b-modal id="role" title="Новая должность" @ok="saveRole" @hidden="resetModal" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Имя</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Доступы</label>
                        <div class="col-sm-9">
                            <multiselect
                                v-model="permission"
                                placeholder="Выберите доступ"
                                label="name"
                                track-by="id"
                                :options="permissions"
                                :multiple="true"
                                :taggable="true">
                            </multiselect>
                        </div>
                    </div>
                </form>
            </div>
        </b-modal>

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
                permission: '',
                permissions: [],
            }
        },

        computed: {
            newRoleArray(){
                return this.permission.slice().map(item => item.id.toString());
            },
        },

        methods: {
            addNewRoleModal(){
                this.$bvModal.show('role')
                this.getAllPermissions();
            },

            getAllPermissions(){
                axios.get('api/v2/getAllPermissions')
                    .then(response => {this.permissions = response.data.data})
            },

            saveRole(bvModalEvt){
                if (!this.permission || !this.name){
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 5000,position: 'top-right'});
                    return false
                }
                axios.post('api/v2/roles', {title: this.name, permissions: this.newRoleArray})
                this.$emit('get-method')
            },

            resetModal(){
                this.name = '';
                this.permission = '';
            },
        },
    }
</script>
