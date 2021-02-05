<template>
    <div>
        <b-modal id="showUser" size="lg" title="Карточка сотрудника" centered hide-footer @hidden="closeModel">
            <div class="mb-3">
<!--                <div class="row card">-->
<!--                    <a href="#" class="m-2"><i class="fe fe-arrow-left h3 text-danger pr-3"></i>Назад</a>-->
<!--                </div>-->
<!--                <b-table v-if="user_history"-->
<!--                         :sort-by.sync="sortBy"-->
<!--                         :sort-desc.sync="sortDesc"-->
<!--                         sticky-header="700px"-->
<!--                         hover-->
<!--                         :items="user_history"-->
<!--                         :fields="fields">-->
<!--                </b-table>-->
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <div class="py-2">
                            <b-img
                                @click="editAvatar"
                                center
                                thumbnail
                                fluid
                                src="https://picsum.photos/250/250/?image=54"
                                alt="Image 1"
                                class="hoverim">
                            </b-img>
                        </div>
                        <b-button block squared class="mt-3">Информация</b-button>
                        <b-button block squared disabled variant="outline-secondary">Карьера</b-button>
                        <b-button @click="history" disabled block squared variant="outline-secondary">История действий</b-button>
                        <b-button v-if="can.user_delete" block squared variant="danger" @click="deleteuser">Удалить</b-button>
                    </div>
                    <div class="col-md-8">

<!--                        <b-table-->
<!--                            sticky-header="700px"-->
<!--                            :items="kassa_operations"-->
<!--                            :fields="fields"-->
<!--                            head-variant="light">-->
<!--                            <template v-slot:cell(status)="row">-->
<!--                                <span :style="{ color: row.item.color }">{{ row.item.status }}</span>-->
<!--                            </template>-->
<!--                            <template v-slot:cell(step)="row">-->
<!--                                <span :style="{ color: row.item.steps_color }">{{ row.item.steps }}</span>-->
<!--                            </template>-->
<!--                            <template v-slot:cell(next_call_date)="row">-->
<!--                                <span>{{ row.item.call_date }}</span>-->
<!--                            </template>-->
<!--                        </b-table>-->

                        <div class="card-body py-2">
                            <table class=" table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Фамилия</td>
                                    <td><input-form
                                        v-model="user.surname"
                                        name="surname"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Имя</td>
                                    <td><input-form
                                        v-model="user.name"
                                        name="name"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Телефон</td>
                                    <td><input-form
                                        v-model="user.phone"
                                        mask="+## (###) ###-##-##"
                                        name="phone"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input-form
                                        v-model="user.email"
                                        name="email"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>День рождения</td>
                                    <td><input-form
                                        v-model="user.birthday"
                                        name="birthday"
                                        datePicker="true"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Facebook</td>
                                    <td><input-form
                                        v-model="user.facebook"
                                        name="facebook"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Instagram</td>
                                    <td><input-form
                                        v-model="user.instagram"
                                        name="instagram"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>О себе</td>
                                    <td><input-form
                                        v-model="user.about_as"
                                        textarea="true"
                                        name="about_as"
                                        @edit-field="editField">
                                    </input-form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Филиал</td>
                                    <td>
                                        <span v-if="!showEditBranch" v-for="item in user.branch" class="badge badge-info mr-2">
                                            {{item.name}}
                                        </span>
                                        <multiselect
                                            v-if="showEditBranch"
                                            v-model="user.branch"
                                            label="name"
                                            track-by="id"
                                            :options="branches"
                                            :multiple="true"
                                            :taggable="true"
                                            deselectLabel="Удалить"
                                            selectedLabel="Выбран"
                                        ></multiselect>
                                        <hr class="navbar-divider my-3">
                                        <div class="mt-3" v-if="can.user_branch">
                                            <button
                                                @click="editBranch"
                                                :disabled="showEditBranch"
                                                class="btn btn-sm btn-primary">Редактировать</button>
                                            <button
                                                @click="saveBranch"
                                                :disabled="!showEditBranch"
                                                class="btn btn-sm btn-success">Сохранить</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Роль</td>
                                    <td>
                                        <span v-if="!showEditRole" v-for="item in user.role" class="badge badge-info mr-2">
                                        {{item.title}}
                                    </span>
                                        <multiselect
                                            v-if="showEditRole"
                                            v-model="user.role"
                                            label="title"
                                            track-by="id"
                                            :options="roles"
                                            :multiple="true"
                                            :taggable="true"
                                            deselectLabel="Удалить"
                                            selectedLabel="Выбран"
                                        ></multiselect>
                                        <hr class="navbar-divider my-3">
                                        <div class="mt-3" v-if="can.user_role">
                                            <button
                                                @click="editRole"
                                                :disabled="showEditRole"
                                                class="btn btn-sm btn-primary">Редактировать</button>
                                            <button
                                                @click="saveRole"
                                                :disabled="!showEditRole"
                                                class="btn btn-sm btn-success">Сохранить</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Последнее изменение</td>
                                    <td>{{ user.updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>Последний раз в сети</td>
                                    <td>{{ user.last_online_at }}</td>
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
    // import 'vue-multiselect/dist/vue-multiselect.min.css';


    export default {
        components: { Multiselect },
        data() {
            return {
                can: '',
                arrays: ["1", "2", "3"],
                showEditBranch: false,
                showEditRole: false,
                branches: [],
                roles: [],
                user: {},
                infoModal: {
                    title: '',
                    content: ''
                },
                user_history: [],
                roletest: '',
                items: [
                    { name: 'MacDonald', id: 40 },
                    { name: 'Shaw', id: 21 },
                    { name: 'Wilson', id: 89 },
                    { name: 'Carney', id: 38 }
                ],
                fields: [
                    {
                        key: 'id',
                        label: 'ID',
                    },
                    {
                        key: 'message',
                        label: 'Действие',
                    },
                    {
                        key: 'created_at',
                        label: 'Дата',
                    },
                ],
                sortBy: 'created_at',
                sortDesc: true,
            }
        },

        props: {
            can: {}
        },

        computed: {
            newBranchArray(){
                return this.user.branch.slice().map(item => item.id.toString());
            },

            newRoleArray(){
                return this.user.role.slice().map(item => item.id.toString());
            }
        },

        methods: {

            getAllBranches(){
                axios.get('api/v2/getAllBranches')
                    .then(response => this.branches = response.data)
            },

            getAllRoles(){
                axios.get('api/v2/getAllRoles')
                    .then(response => this.roles = response.data)
            },

            // Костыль события, если призодит type (datePicker), то выполняем блок именно для него
            editField(e, name, type) {
                if (type){
                    axios.put('api/v2/users/' + this.user.id, {field_name: name, field_value: e })
                }else{
                    const value = e.target.value;
                    const key = e.currentTarget.getAttribute('name');
                    axios.put('api/v2/users/' + this.user.id, {field_name: key, field_value: value })
                }
            },

            editBranch() {
                this.showEditBranch = !this.showEditBranch
                this.getAllBranches()
            },

            saveBranch() {
                this.showEditBranch = !this.showEditBranch
                axios.post('api/v2/saveBranches', {user_id: this.user.id, branches: this.newBranchArray})
            },

            editRole() {
                this.showEditRole = !this.showEditRole
                this.getAllRoles()
            },

            saveRole() {
                this.showEditRole = !this.showEditRole
                axios.post('api/v2/saveRoles', {user_id: this.user.id, roles: this.newRoleArray})
            },

            editAvatar() {
                alert("Изменение аватара временно не доступно");
            },

            deleteuser() {
                alert("Удаление сотрудника временно ограниченно");
            },


            history(){
                axios.post('api/v2/history/' ,{ user_id: this.user.id })
                    .then(response => {this.user_history = response.data.data})
            },

            addNewUserModal(id){
                axios.get('api/v2/users/' + id)
                    .then(response => {this.user = response.data.data})

                this.$bvModal.show('showUser')
            },

            closeModel(){
                this.user_history = []
                this.showEditBranch = false,
                    this.showEditRole = false
                this.$emit('get-method')
            }
        },
    }
</script>

<style scoped>

    .table td, .table th {
        padding: 10px;
    }

    .hoverim:hover{
        opacity: 0.5;
        cursor: pointer;
    }

    .not-photo{
        display: flex;
        width: 250px;
        height: 250px;
        border-radius: 0px;
        font: 100px / 250px Helvetica, Arial, sans-serif;
        align-items: center;
        justify-content: center;
        text-align: center;
        user-select: none;
        background-color: rgb(255, 193, 7);
        color: rgb(255, 255, 255);
    }

    .photo{
        display: flex;
        width: 250px;
        height: 250px;
        border-radius: 0px;
    }

    .multiselect__tags {
        font-size: 12px;
    }
</style>
