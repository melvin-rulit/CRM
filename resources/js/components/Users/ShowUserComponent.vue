<template>
    <div>
        <b-modal id="showUser" size="lg" title="Карточка сотрудника" centered hide-footer @hidden="closeModel">
            <b-tabs v-model="tabIndex">
                <b-tab>
                    <div class="mb-3">
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
                                <b-button @click="career('career')" block squared variant="outline-secondary">Карьера</b-button>
                                <b-button @click="history('history')" block squared variant="outline-secondary">История действий
                                </b-button>
                                <b-button v-if="can.user_delete" block squared variant="danger" @click="deleteuser">
                                    Удалить
                                </b-button>
                                <b-button @click="kits" block squared variant="info">ТВЦ</b-button>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body py-2">
                                    <table class=" table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>Фамилия</td>
                                            <td>
                                                <input-form
                                                    v-model="user.surname"
                                                    name="surname"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Имя</td>
                                            <td>
                                                <input-form
                                                    v-model="user.name"
                                                    name="name"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Телефон</td>
                                            <td>
                                                <input-form
                                                    v-model="user.phone"
                                                    mask="+## (###) ###-##-##"
                                                    name="phone"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <input-form
                                                    v-model="user.email"
                                                    name="email"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>День рождения</td>
                                            <td>
                                                <input-form
                                                    v-model="user.birthday"
                                                    name="birthday"
                                                    datePicker="true"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Facebook</td>
                                            <td>
                                                <input-form
                                                    v-model="user.facebook"
                                                    name="facebook"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Instagram</td>
                                            <td>
                                                <input-form
                                                    v-model="user.instagram"
                                                    name="instagram"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>О себе</td>
                                            <td>
                                                <input-form
                                                    v-model="user.about_as"
                                                    textarea="true"
                                                    name="about_as"
                                                    :gate="can.user_edit"
                                                    @edit-field="editField">
                                                </input-form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Филиал</td>
                                            <td>
                                        <span v-if="!showEditBranch" v-for="item in user.branch"
                                              class="badge badge-info mr-2">
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
                                                        class="btn btn-sm btn-primary">Редактировать
                                                    </button>
                                                    <button
                                                        @click="saveBranch"
                                                        :disabled="!showEditBranch"
                                                        class="btn btn-sm btn-success">Сохранить
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Должность</td>
                                            <td>
                                        <span v-if="!showEditRole" v-for="item in user.role"
                                              class="badge badge-info mr-2">
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
                                                        class="btn btn-sm btn-primary">Редактировать
                                                    </button>
                                                    <button
                                                        @click="saveRole"
                                                        :disabled="!showEditRole"
                                                        class="btn btn-sm btn-success">Сохранить
                                                    </button>
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
                                        <tr v-if="can.user_show_password">
                                            <td>Пароль</td>
                                            <td class="text-danger">{{ user.secret_id }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-tab>

                            <!--  Вывод истории действий  -->
                <b-tab>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <button @click="tabIndex = 0" class="btn btn-primary btn-sm">Назад</button>
                        </div>
                    </div>

                    <b-table v-if="user_history"
                             :sort-by.sync="sortBy"
                             :sort-desc.sync="sortDesc"
                             sticky-header="700px"
                             hover
                             :items="user_history"
                             :fields="fields">
                    </b-table>
                </b-tab>

                <b-tab>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <button @click="tabIndex = 0" class="btn btn-primary btn-sm">Назад</button>
                        </div>
                    </div>

                    <p v-if="kits" v-for="kit in user_kits" :key="kit.id" class="mb-2">
                        {{ kit.date }} - Выдано - {{ kit.article }} {{ kit.quantity }} шт. {{ kit.surname }} {{ kit.name
                        }} - {{ kit.comment }}
                    </p>
                </b-tab>

            </b-tabs>
        </b-modal>
    </div>
</template>

<script>

    import Multiselect from 'vue-multiselect'
    import Loading from 'vue-loading-overlay';
    Vue.use(Loading, {
        color: '#007BFF',
        width: 35,
        height: 35,
    });


    Vue.use(Multiselect);
    // import 'vue-multiselect/dist/vue-multiselect.min.css';


    export default {
        components: { Multiselect },
        data() {
            return {
                fullPage: false,
                tabIndex: 0,
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
                user_kits: [],
                roletest: '',
                items: [
                    {name: 'MacDonald', id: 40},
                    {name: 'Shaw', id: 21},
                    {name: 'Wilson', id: 89},
                    {name: 'Carney', id: 38}
                ],
                fields: [
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
                datatest:'',
            }
        },

        props: {
            can: {}
        },

        computed: {
            newBranchArray() {
                return this.user.branch.slice().map(item => item.id.toString());
            },

            newRoleArray() {
                this.datatest = this.user.role
                return this.user.role.slice().map(item => item.id.toString());
            },

            dataTest(){
                return this.datatest.slice(-1);
            },

        },

        methods: {

            getAllBranches() {
                axios.get('api/v2/getAllBranches')
                    .then(response => this.branches = response.data)
            },

            getAllRoles() {
                axios.get('api/v2/getAllRoles')
                    .then(response => this.roles = response.data)
            },

            // Костыль события, если призодит type (datePicker), то выполняем блок именно для него
            editField(e, name, type) {
                if (type) {
                    axios.put('api/v2/users/' + this.user.id, {field_name: name, field_value: e})
                } else {
                    const value = e.target.value;
                    const key = e.currentTarget.getAttribute('name');
                    axios.put('api/v2/users/' + this.user.id, {field_name: key, field_value: value})
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
                axios.post('api/v2/saveRoles', {user_id: this.user.id, roles: this.newRoleArray, lastRole: this.dataTest})
            },

            editAvatar() {
                alert("Изменение аватара временно не доступно");
            },

            deleteuser() {
                alert("Удаление сотрудника временно ограниченно");
            },

        //---------------------  Показ истории при нажитии "Карьера" -------------------------//

            async career(history_type){


                try {
                    let loader = this.$loading.show({
                        container: this.fullPage ? null : this.$refs.formContainer,
                        canCancel: true,
                    });

                        let res = await axios.post('api/v2/history', {user_id: this.user.id, history_type: history_type})

                    if (res.status == 200) {
                        this.user_history = res.data.data
                        this.tabIndex = 1
                        loader.hide()
                    }
                    return res.data.data
                } catch (err) {
                    console.error(err);
                }

            },

            //------------  Показ истории при нажитии "История действий" -----------------//

            async history(history_type) {
                try {
                    let loader = this.$loading.show({
                        container: this.fullPage ? null : this.$refs.formContainer,
                        canCancel: true,
                    });

                        let res = await axios.post('api/v2/history', {
                            user_id: this.user.id,
                            history_type: history_type
                        })

                    if (res.status == 200) {
                        this.user_history = res.data.data
                        this.tabIndex = 1
                        loader.hide()
                    }
                    return res.data.data
                } catch (err) {
                    console.error(err);
                }
            },

            async kits() {
                try {
                    let loader = this.$loading.show({
                        container: this.fullPage ? null : this.$refs.formContainer,
                        canCancel: true,
                    });

                    let res = await axios.post('api/v2/getUserKit', {user_id: this.user.id})

                    if (res.status == 200) {
                        this.user_kits = res.data.data
                        this.tabIndex = 2
                        loader.hide()
                    }
                    return res.data.data
                } catch (err) {
                    console.error(err);
                }
            },


            addNewUserModal(id) {
                axios.get('api/v2/users/' + id)
                    .then(response => {
                        this.user = response.data.data
                    })

                this.$bvModal.show('showUser')
            },

            closeModel() {
                this.user_history = []
                this.showEditBranch = false,
                    this.showEditRole = false
                this.$emit('get-method')
                this.tabIndex = 0
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
