<template>
    <div>

        <!-------------------------- Окно добавления новой операции ------------------------------>
        <b-modal id="coming" title="Новая операция" @ok="handleSubmit" @hidden="resetModal" centered ok-only
                 ok-title="Добавить">
            <div class="card-body py-0">
                <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Наименование</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Группа</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="kassaGroups"
                                v-model="group"
                                option-value="id"
                                option-text="name"
                                placeholder="Введите для поиска группы"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Филиал</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="branches"
                                v-model="dataObject.branch"
                                option-value="id"
                                option-text="name"
                                placeholder="Введите для поиска Филиала"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea v-model="coment" class="form-control" rows="3" placeholder="Коментарий"></textarea>
                    </div>
                </form>
            </div>
        </b-modal>

        <b-modal id="group" title="Новая группа" @ok="saveGroup" @hidden="resetModalGroup" centered ok-only
                 ok-title="Добавить">
            <div class="card-body py-0">
                <form>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Наименование</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="group_name">
                        </div>
                    </div>
                </form>
            </div>
        </b-modal>

                             <!--  ///// Точка авторизації \\\\   -->
        <div class="card">
            <b-tabs content-class="mt-3" justified>
                <b-tab title="Точка авторизації" @click="getSources" active>
                    <!-- Панель над фильтром -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button v-if="can.source_create" v-b-modal="'coming'"
                                                    @click="getGroupsInSource" class="btn btn-sm btn-success">Добавить
                                                источник
                                            </button>


                                        </div>

                                        <!-------------   Очистка фильтрации  ------------->
                                        <div class="col-auto">
                                            <button
                                                v-if="branches_id"
                                                @click="resetSourceModal"
                                                class="btn btn-sm btn-warning">Очистить фильтр
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-------------\   Список Филиалов для фильтрации  /------------->
                    <button
                        v-for="item in branches"
                        @click="getSource(item.id)"
                        class="btn btn-sm ml-2 mb-2"
                        :class="branches_id == item.id ? 'btn-outline-danger' : 'btn-outline-primary'">{{ item.name }}
                    </button>


                    <!-- Список клиентов -->
                    <div class="card-body pb-0">
                        <b-table

                            @row-clicked="editSource"
                            hover
                            sticky-header="700px"
                            :items="sourcess"
                            :fields="fields"
                            head-variant="light">

                        </b-table>
                    </div>
                </b-tab>

                <!--    ///// Джероло контакту \\\\\    -->
                <b-tab @click="getAllGroups" title="Джероло контакту">
                    <!-- Панель над фильтром -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button v-if="can.source_create" v-b-modal="'group'"
                                                    class="btn btn-sm btn-success">Добавить группу
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-------------\   Список Групп  /------------->
                    <div class="card-body pb-0">
                        <b-table
                            @row-clicked="editGroup"
                            hover
                            sticky-header="700px"
                            :items="groups"
                            :fields="groupsFields"
                            head-variant="light">
                        </b-table>
                    </div>
                </b-tab>
            </b-tabs>

            <!-- Окно добавления редактирования группы -->
            <b-modal id="editGroupModal" title="Изменить группу" @hidden="resetEditGroupModal" centered
                     ok-title="Сохранить" cancel-title="Отмена" @ok="updateGroup">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Название</label>
                    <div class="col-sm-9">
                        <input v-model="edit_source.name" class="form-control">
                    </div>
                </div>

                <template #modal-footer="{ ok, cancel, hide }" v-if="can.delete_source">

                    <b-button style="margin-right: 250px" size="sm" variant="outline-secondary" @click="deleteFieldGroup">
                        <b-icon icon="trash"></b-icon>
                        Удалить
                    </b-button>

                    <b-button size="sm" variant="success" @click="ok()">
                        Готово
                    </b-button>

                    <b-button size="sm" variant="danger" @click="cancel()">
                        Отмена
                    </b-button>

                </template>

            </b-modal>

            <!-- Окно добавления редактирования источника -->
            <b-modal id="editSourceModal" title="Изменить источник" @hidden="resetSourceModal()" centered
                     ok-title="Сохранить" cancel-title="Отмена" @ok="updateSource(edit_source.id)">

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Название</label>
                    <div class="col-sm-9">
                        <input v-model.trim="edit_source.name" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Джероло контакту</label>

                    <dynamic-select
                        class="col-sm-9"
                        :options="groups"
                        v-model="edit_source.gr"
                        option-value="id"
                        option-text="name"
                        placeholder="Введите для поиска Филиала"/>

                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Филиал</label>
                    <div class="col-sm-9">
                        <dynamic-select
                            :options="branches"
                            v-model="dataObject.branch"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска Филиала"/>
                    </div>
                </div>
                <div class="form-group row">
                    <textarea v-model="edit_source.coment" class="form-control" rows="3"
                              placeholder="Коментарий"></textarea>
                </div>

                <template #modal-footer="{ ok, cancel, hide }" v-if="can.delete_source">

                    <b-button style="margin-right: 250px" size="sm" variant="outline-secondary" @click="deleteFieldSource">
                        <b-icon icon="trash"></b-icon>
                        Удалить
                    </b-button>

                    <b-button size="sm" variant="success" @click="ok()">
                        Готово
                    </b-button>

                    <b-button size="sm" variant="danger" @click="cancel()">
                        Отмена
                    </b-button>

                </template>

            </b-modal>
        </div>

    </div>
</template>

<script>
import Vue from "vue";

export default {
    data() {
        return {
            can: '',
            edit_group: '',
            edit_source: '',
            gr: '',
            name: '',
            boxTwo: '',
            group_name: '',
            coment: '',
            group: '',
            branches_id: '',
            branches: [],
            dataObject: {},
            groups: [],
            kassaGroups: [],
            sourcess: [],
            fields: [
                {
                    key: 'name',
                    label: 'Название',
                },
                {
                    key: 'group',
                    label: 'Группа',
                },

            ],
            groupsFields: [
                {
                    key: 'name',
                    label: 'Название',
                },
            ],
        }
    },

    created() {
        this.getSources()
        this.getBranches()
        this.branches_id = ''
    },

    methods: {

        editSource(index) {
            if (this.can.source_edit) {
                this.$bvModal.show('editSourceModal')
                this.edit_source = index
                this.getAllGroups()
            }
        },
        //--------------------------------- Изменить Источник -----------------------------------//

        updateSource(id) {
            axios.put('api/v2/source/' + id, {
                name: this.edit_source.name,
                group_id: this.edit_source.gr.id,
                branch_id: this.dataObject.branch.id,
                coment: this.edit_source.coment,
            })
            Vue.$toast.open({message: "Источник Обновлен", type: 'success', duration: 5000, position: 'top-right'});

        },


        changeSourceValue(event) {

            this.gr = event.target.value
        },

        //-------------------- Открываем окно редактирования группы -----------------------------//

        editGroup(index) {
            if (this.can.source_edit) {
                this.$bvModal.show('editGroupModal')
                this.edit_source = index
            }
        },

        //--------------------------------- Обновляем имя группы -----------------------------//

        updateGroup() {
            axios.put('api/v2/sourceGroups/' + this.edit_source.id, {
                name: this.edit_source.name,
            })
            Vue.$toast.open({message: "Группа Обновлена", type: 'success', duration: 5000, position: 'top-right'});
        },


        //--------------------------------- Добавляем новый источник -----------------------------//

        handleSubmit(bvModalEvt) {
            if (!this.group.id || !this.name) {
                bvModalEvt.preventDefault()
                Vue.$toast.open({
                    message: 'Заполните все необходимые поля',
                    type: 'error',
                    duration: 1000,
                    position: 'top-right'
                });
            } else {
                axios.post('api/v2/source', {
                    name: this.name,
                    group_id: this.group.id,
                    branch_id: this.dataObject.branch.id,
                    coment: this.coment,
                })

                Vue.$toast.open({message: 'Источник добавлен', type: 'success', duration: 1000, position: 'top-right'});


            }
        },

        //------------------------------ Добавляем новую группу ---------------------------//
        saveGroup(bvModalEvt) {

            if (!this.group_name) {
                bvModalEvt.preventDefault()
                Vue.$toast.open({
                    message: 'Заполните все необходимые поля',
                    type: 'error',
                    duration: 1000,
                    position: 'top-right'
                });
            } else {
                axios.post('api/v2/sourceGroups', {
                    name: this.group_name,
                })

                Vue.$toast.open({message: 'Группа добавлена', type: 'success', duration: 1000, position: 'top-right'});
                this.getAllGroups()
            }

        },

        //-------------------------- Получаем список групп ----------------------------//

        getGroupsInSource() {
            axios.get('api/v2/sourceGroups')
                .then(response => this.kassaGroups = response.data.data)
        },

        getSource(id) {
            this.branches_id = id
            axios.post('api/v2/sourceBranch', {id: id})
                .then(response => {
                    this.sourcess = response.data.data, this.can = response.data.can
                })
        },

        getBranches() {
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)


        },

        //------------------------ Удаление Источника ----------------------------------//

        deleteFieldSource() {

            this.$bvModal.msgBoxConfirm('Вы уверены что хотите удалить источник ( ' + this.edit_source.name + ' ) ?'  , {
                size: 'lg',
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

                         axios.delete('api/v2/source/' + this.edit_source.id)

                        this.getSources()
                        this.$bvModal.hide('editSourceModal')

                        let loader = this.$loading.show({
                            color: '#0080ff',
                        });
                        setTimeout(() => {

                            Vue.$toast.open({
                                message: "Источник удален ",
                                type: 'success',
                                duration: 5000,
                                position: 'top-right'
                            });


                            loader.hide()
                        }, 1000)
                    }
                })
        },

        //--------------------------- Удаление Группы ----------------------------------//

        deleteFieldGroup() {

            this.$bvModal.msgBoxConfirm('Вы уверены что хотите удалить группу ( ' + this.edit_source.name + ' ) ?'  , {
                size: 'lg',
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

                        axios.delete('api/v2/sourceGroups/' + this.edit_source.id)

                        this.getGroupsInSource()
                        this.$bvModal.hide('editGroupModal')

                        let loader = this.$loading.show({
                            color: '#0080ff',
                        });
                        setTimeout(() => {

                            Vue.$toast.open({
                                message: "Группа удалена ",
                                type: 'success',
                                duration: 5000,
                                position: 'top-right'
                            });


                            loader.hide()
                        }, 1000)
                    }
                })
        },


        //------------------------------ //// Точка авторизації \\\\ -----------------------------//
        getSources() {
            axios.get('api/v2/source')
                .then(response => {
                    this.sourcess = response.data.data, this.can = response.data.can
                })

        },

        //------------------------------- //// Джероло контакту \\\\ ---------------------------//

        getAllGroups() {
            axios.get('api/v2/sourceGroups')
                .then(response => {
                    this.groups = response.data.data, this.can = response.data.can
                })

            this.branches_id = ''
        },

        //--------------------------------- Reset ----------------------------------------//

        resetEditGroupModal() {
            this.getAllGroups()
        },

        resetModal() {
            this.name = ''
            this.group = ''
            this.coment = ''
            this.branches_id = ''
            this.dataObject = {}
            this.getSources()
        },

        resetModalGroup() {
            this.group_name = ''
        },

        resetSourceModal() {
            this.gr = ''
            this.edit_source = ''
            this.branches_id = ''
            this.dataObject = {}
            this.getSources()
        },

    }

}
</script>
