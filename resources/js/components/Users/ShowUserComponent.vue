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
                                <img class="hoverim photo"/>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <table class=" table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Фамилия</td>
                                            <td>{{ user.surname }}</td>
                                        </tr>
                                        <tr>
                                            <td>Имя</td>
                                            <td>{{ user.name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Телефон</td>
                                            <td>{{ user.phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ user.email }}</td>
                                        </tr>
                                        <tr>
                                            <td>День рождения</td>
                                            <td>{{ user.birthday }}</td>
                                        </tr>
                                        <tr>
                                            <td>Facebook</td>
                                            <td>{{ user.facebook }}</td>
                                        </tr>
                                        <tr>
                                            <td>Instagram</td>
                                            <td>{{ user.instagram }}</td>
                                        </tr>
                                        <tr>
                                            <td>Филиал</td>
                                            <span class="badge badge-info mr-2">Старший администратор</span>
                                        </tr>
                                        <tr>
                                            <td>Роль</td>
                                            <span class="badge badge-info mr-2">Старший администратор</span>
                                        </tr>
                                        <tr>
                                            <td>О себе</td>
                                            <td>{{ user.obout_us }}</td>
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
            addNewUserModal(id){
                $('#showUser').modal('show');
                axios.get('api/v2/users/' + id)
                    .then(response => {this.user = response.data.data})
            },
        },
    }
</script>
