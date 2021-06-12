<template>
    <div>
        <b-modal id="showRole" size="lg" title="Роль" centered hide-footer @hidden="closeModal">
            <div class="mb-3">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body py-2">
                            <table class=" table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Название</td>
                                    <td>
                                        <input-form
                                            v-model="role.name"
                                            name="title"
                                            :gate="can.role_edit"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Доступ</td>
                                    <td>
                                        <span v-if="!showEditPermissions" v-for="item in role.permissions"
                                              class="badge badge-info mr-2">
                                            {{item.name}}
                                        </span>
                                        <multiselect
                                            v-if="showEditPermissions"
                                            v-model="role.permissions"
                                            label="name"
                                            track-by="id"
                                            :options="permissions"
                                            :multiple="true"
                                            :taggable="true"
                                            deselectLabel="Удалить"
                                            selectedLabel="Выбран"
                                        ></multiselect>

                                        <hr class="navbar-divider my-3">

                                        <!--   Кнопки управления     -->

                                        <div class="mt-3" v-if="can.role_edit">

                                            <button
                                                @click="editPermissions"
                                                :disabled="showEditPermissions"
                                                class="btn btn-sm btn-primary">Редактировать
                                            </button>
                                            <button
                                                @click="savePermissions"
                                                :disabled="!showEditPermissions"
                                                class="btn btn-sm btn-success">Сохранить
                                            </button>
                                            <button
                                                v-if="can.role_delete"
                                                style="margin-left: 180px"
                                                @click="deletePermissions"
                                                class="btn btn-sm btn-danger">Удалить Должность
                                            </button>

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
import Vue from "vue";

Vue.use(Multiselect);


export default {
    components: {Multiselect},
    data() {
        return {
            role: [],
            boxTwo: '',
            permissions: [],
            showEditPermissions: false,
        }
    },

    props: {
        can: {}
    },

    computed: {
        newPermissionsArray() {
            return this.role.permissions.slice().map(item => item.id.toString());
        },

    },

    methods: {

        showRoleModal(id) {
            axios.get('api/v2/roles/' + id)
                .then(response => {
                    this.role = response.data.data
                })

            this.$bvModal.show('showRole')
        },

        getAllPermissions() {
            axios.get('api/v2/getAllPermissions')
                .then(response => this.permissions = response.data.data)
        },

        editPermissions() {
            this.showEditPermissions = !this.showEditPermissions
            this.getAllPermissions()
        },

        savePermissions() {
            this.showEditPermissions = !this.showEditPermissions
            axios.post('api/v2/saveRole', {id: this.role.id, permissions: this.newPermissionsArray})
        },


        deletePermissions() {

            this.$bvModal.msgBoxConfirm('Вы уверены что хотите удалить эту должность ?', {
                size: 'md',
                buttonSize: 'md',
                okVariant: 'danger',
                okTitle: 'Да',
                cancelTitle: 'Нет',
                footerClass: 'p-2',
                hideHeaderClose: false,
                centered: true
            })
                .then(value => {
                    this.boxTwo = value

                    if (this.boxTwo === true) {

                        axios.post('api/v2/deleteRole', {id: this.role.id})

                        this.$bvModal.hide('showRole')

                        let loader = this.$loading.show({
                            color: '#0080ff',
                        });
                        setTimeout(() => {

                            Vue.$toast.open({
                                message: "Должность Удалена",
                                type: 'success',
                                duration: 5000,
                                position: 'top-right'
                            });

                            loader.hide()
                        }, 1000)
                    }
                })
        },

        editField(e, name) {
            const value = e.target.value;
            const key = e.currentTarget.getAttribute('name');
            axios.post('api/v2/saveRoleField', {id: this.role.id, field_name: key, field_value: value})
        },

        closeModal() {
            this.role = ''
            this.permissions = ''
            this.showEditPermissions = false
            this.$emit('get-method')
        }

    }
}
</script>
