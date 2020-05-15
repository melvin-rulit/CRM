<template>
    <div>
        <addnewuser-component v-if="add"></addnewuser-component>
        <showuser-component ref="getmodal"></showuser-component>

                        <date-pick :format="'YYYY,MM,DD'" :displayFormat="'DD.MM.YYYY'" v-model="qwe"></date-pick>


        <div class="card">
            <div class="card-body pb-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Логин (почта)</th>
                                <th>Должность</th>
                                <th>Филиалы</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="(user, index) in users">
                            <tr @click="getShowModal(user.id)">
                                <td>{{ user.name }}</td>
                                <td>{{ user.surname }}</td>
                                <td>{{ user.email }}</td>
                                <td><span v-for="role in user.roles" class="badge badge-info mr-2">{{ role.title }}</span></td>
                                <td><span v-for="branch in user.branches" class="badge badge-info mr-2">{{ branch.name }}</span></td>
                                <td class="text-center">
                                    <span class="fe fe-trash-2 h3 text-danger" @click="deleteUser(index, user.id, user.surname)"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePick from 'vue-date-pick';
Vue.use(DatePick);
import 'vue-date-pick/dist/vueDatePick.css';

    export default {
              components: {DatePick},

        data() {
            return {
                users: {},
                add: true,
                qwe: '',
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            getShowModal(id){
                this.$refs.getmodal.addNewUserModal(id)
            },
            fetch() {
                axios.get(`api/v2/users`)
                    .then(response => {
                        this.users = response.data.data;
                    })
            },
            deleteUser(index, id, surname){
                this.$confirm("Удалить сотрудника " + surname + " ?").then(() => {
                    this.users.splice(index,1);
                    axios.delete('api/v2/users/'+ id);
                });
            },
        },
    }
</script>
