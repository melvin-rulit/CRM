<template>
    <div>
        <div class="modal fade bd-example-modal-lg" id="showUser" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">Карточка сотрудника</h4>
              </div>
              <div class="modal-body pb-0">
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <div>
                                <img class="hoverim photo mt-4"/>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <table class=" table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Фамилия</td>
                                            <td><input-form v-model="user.surname" name="surname" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>Имя</td>
                                            <td><input-form v-model="user.name" name="name" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>Телефон</td>
                                            <td><input-form v-model="user.phone" v-mask="'+## (###) ###-##-##'" name="phone" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><input-form v-model="user.email" name="email" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>День рождения</td>
                                            <td><input-form v-model="user.birthday" v-mask="'##.##.####'" name="birthday" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>Facebook</td>
                                            <td><input-form v-model="user.facebook" name="facebook" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>Instagram</td>
                                            <td><input-form v-model="user.instagram" name="instagram" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>О себе</td>
                                            <td><input-form v-model="user.about_as" textarea="true" name="about_as" @edit-field="editField"></input-form></td>
                                        </tr>
                                        <tr>
                                            <td>Филиал</td>
                                            <td @click="editBranch"><span v-for="item in user.branch" class="badge badge-info mr-2">{{item.name}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Роль</td>
                                            <td><span v-for="item in user.role" class="badge badge-info mr-2">{{item.title}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Последнее изменение</td>
                                            <td>{{ user.updated_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer pt-3 pb-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
              </div>
            </div>
          </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {},
            }
        },
        methods: {
            editField(e, name) {
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/users/' + this.user.id, {field_name: key, field_value: value })
            },
            editBranch() {
                alert("OK");
            },
            addNewUserModal(id){
                $('#showUser').modal('show');
                axios.get('api/v2/users/' + id)
                    .then(response => {this.user = response.data.data})
            },
        },
    }
</script>
