<template>
    <div>
        <b-modal id="showUser" size="lg" title="Карточка сотрудника" centered hide-footer @hidden="closeModel">
            <div class="mb-3">
<!--                <div class="row card">-->
<!--                    <a href="#" class="m-2"><i class="fe fe-arrow-left h3 text-danger pr-3"></i>Назад</a>-->
<!--                </div>-->
                <b-table v-if="user_history"
                         :sort-by.sync="sortBy"
                         :sort-desc.sync="sortDesc"
                         sticky-header="700px"
                         hover
                         :items="user_history"
                         :fields="fields">
                </b-table>
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <div class="py-2">
                            <b-img
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
                        <b-button @click="history" block squared variant="outline-secondary">История действий</b-button>
                        <b-button block squared variant="danger">Удалить</b-button>
                    </div>
                    <div class="col-md-8">
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
                                        v-mask="'+## (###) ###-##-##'"
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
                                    <td @click="editBranch">
                                        <span v-for="item in user.branch" class="badge badge-info mr-2">
                                            {{item.name}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Роль</td>
                                    <td><span v-for="item in user.role" class="badge badge-info mr-2">
                                        {{item.title}}
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Последнее изменение</td>
                                    <td>{{ user.updated_at }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <multiselect
                                v-model="user.branch"
                                placeholder="Выберите филиал"
                                label="name"
                                track-by="id"
                                :options="items"
                                :multiple="true"
                                :taggable="true">
                            </multiselect>
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
    import 'vue-multiselect/dist/vue-multiselect.min.css';


    export default {
        components: { Multiselect },
        data() {
            return {
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
        methods: {
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
                alert("OK");
            },

            history(){
                axios.post('api/v2/history/' ,{ user_id: this.user.id })
                    .then(response => {this.user_history = response.data.data})
            },

            addNewUserModal(id){
                this.$bvModal.show('showUser')
                axios.get('api/v2/users/' + id)
                    .then(response => {this.user = response.data.data})
            },

            closeModel(){
                this.user_history = []
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
</style>
