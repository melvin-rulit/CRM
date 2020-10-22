<template>
    <div>
        <b-modal id="showUserAccess" size="lg" title="Доступ на добавление должности" centered hide-footer @hidden="closeModal">
            <div class="mb-3">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body py-2">
                            <table class=" table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Фамилия</td>
                                    <td>{{ useraccess.name }}</td>
                                </tr>
                                <tr>
                                    <td>Доступы на добавлении должностей</td>
                                    <td>
                                        <span v-if="!showEditUserAccess" v-for="item in useraccess.useraccess" class="badge badge-info mr-2">
                                            {{item.title}}
                                        </span>
                                        <multiselect
                                            v-if="showEditUserAccess"
                                            v-model="useraccess.useraccess"
                                            label="title"
                                            track-by="id"
                                            :options="roles"
                                            :multiple="true"
                                            :taggable="true"
                                            deselectLabel="Удалить"
                                            selectedLabel="Выбран"
                                        ></multiselect>
                                        <hr class="navbar-divider my-3">
                                        <div class="mt-3">
                                            <button
                                                @click="editUserAccess"
                                                :disabled="showEditUserAccess"
                                                class="btn btn-sm btn-primary">Редактировать</button>
                                            <button
                                                @click="saveUserAccess"
                                                :disabled="!showEditUserAccess"
                                                class="btn btn-sm btn-success">Сохранить</button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>

    import Multiselect from 'vue-multiselect'

    Vue.use(Multiselect);


    export default {
        components: { Multiselect },
        data() {
            return {
                useraccess: [],
                roles: [],
                showEditUserAccess: false,
            }
        },

        computed: {
            newUserAccessArray(){
                return this.useraccess.useraccess.slice().map(item => item.id.toString());
            },

        },

        methods: {

            showModal(id){
                axios.post('api/v2/showUserAccess', {id: id})
                    .then(response => {this.useraccess = response.data.data})

                this.$bvModal.show('showUserAccess')
            },




            getAllRoles(){
                axios.get('api/v2/roles')
                    .then(response => this.roles = response.data.data)
            },

            editUserAccess() {
                this.showEditUserAccess = !this.showEditUserAccess
                this.getAllRoles()
            },

            saveUserAccess() {
                this.showEditUserAccess = !this.showEditUserAccess
                axios.post('api/v2/saveUserAccess', {user_id: this.useraccess.id, useraccess: this.newUserAccessArray})
            },

            closeModal(){
                this.showEditUserAccess = false,
                    this.useraccess = ''
                this.$emit('get-method')
            }

        }
    }
</script>
