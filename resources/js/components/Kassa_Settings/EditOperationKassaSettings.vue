<template>
    <div>
        <b-modal title="Измините данные Операции" @ok="editOperation" @hidden="resetModal" centered ok-only
                 ok-title="Готово" v-model="modalShow">

            <div class="radio-group-toggle mb-5 text-center">
                <input class="mx-3" type="checkbox" id="comin" value="1" v-model="dataObject.comin">
                <label for="comin">Приход</label>
                <input class="mx-3" type="checkbox" id="out" value="1" v-model="dataObject.out">
                <label for="out">Расход</label>
                <input class="mx-3" type="checkbox" id="cash" value="1" v-model="dataObject.cash">
                <label for="cash">Наличные</label>
                <input class="mx-3" type="checkbox" id="beznal" value="1" v-model="dataObject.beznal">
                <label for="beznal">Экваринг</label>


            </div>

            <div class="card-body py-0">

                <div class="form-group row ">
                    <label class="col-sm-3">Название</label>
                    <div class="col-sm-8 " style="margin-left: 13px;">
                        <input-form
                            v-model="operationField.name"
                            name="name"
                            @edit-field="editField"
                            :gate="can.kassa_add_operation_type">

                        </input-form>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Касса</label>
                    <div class="col-sm-9">
                        <dynamic-select
                            :options="branches"
                            v-model="dataObject.branch"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска кассы"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Группа</label>
                    <div class="col-sm-9">
                        <dynamic-select
                            :options="group"
                            v-model="dataObject.groupid"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска группы"/>
                    </div>
                </div>

                <div class="form-group row">
                            <textarea

                                placeholder="Примечание"
                                class="form-control"
                                v-model="dataObject.coment"
                                @blur="event => editField(event, 'coment')"
                                rows="3"
                                name="coment">

                            </textarea>
                </div>

            </div>

            <template #modal-footer="{ ok, cancel, hide }">

                <b-button style="margin-right: 250px" size="sm" variant="outline-secondary" @click="deleteField">
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
</template>

<script>

import Vue from "vue";

export default {

    data() {
        return {
            branches: [],
            branch: '',
            group: '',
            groupid: '',
            operationField: '',
            can: '',
            boxTwo: '',
            comment: '',
            operation_types: [],
            modalShow: false,
            dataObject: {},
            inComin_Data_1: '',
            inComin_Data_2: '',

        }

    },

    props: {
        can: {}
    },

    methods: {

        //--------------------------------- Открытие модалки -----------------------------//

        showModalEditOperationKassaSettings(items) {
            this.operationField = items
            this.modalShow = true
            this.group = ''

            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
            axios.get('api/v2/kassaGroups')
                .then(response => this.group = response.data.data)
            axios.post('api/v2/kassaSettingsGetOperationData', {id: this.operationField.id})
                .then(response => this.dataObject = response.data.data)

            //.. Записываем первоначальные данные в переменные ( для дальнейшей их сверке )
            this.inComin_Data_1 = this.dataObject.branch.id
            this.inComin_Data_2 = this.dataObject.groupid.id
        },

//-------------------------- Изменяем поля: Касса и Группа -----------------------------------//

        editOperation() {

            //.. Делаем отправку данных если только введенные данные отличаются от изначальных
            if (this.dataObject.branch.id !== this.inComin_Data_1) {

                axios.post('api/v2/kassaSettingsEditOperationKassa', {
                    field_id: this.operationField.id,
                    field_value: this.dataObject.branch.id,
                    field_name: 'branch_id'
                })

            }

            //.. Делаем отправку данных если только введенные данные отличаются от изначальных
            else if (this.dataObject.groupid.id !== this.inComin_Data_2) {

                axios.post('api/v2/kassaSettingsEditOperationKassa', {
                    field_id: this.operationField.id,
                    field_value: this.dataObject.groupid.id,
                    field_name: 'group_id'
                })


            }


            //------------------------------ Изменяем чекбоксы  ----------------------------------//

            if (this.dataObject.cash) {

                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "cash",
                    field_value: this.dataObject.cash,
                })
                this.$emit('get-method')

            } else {
                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "cash",
                    field_value: 0,
                })
                this.$emit('get-method')
            }

            if (this.dataObject.beznal) {

                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "beznal",
                    field_value: this.dataObject.beznal,
                })
                this.$emit('get-method')

            } else {
                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "beznal",
                    field_value: 0,
                })
                this.$emit('get-method')
            }

            if (this.dataObject.comin) {

                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "coming",
                    field_value: this.dataObject.comin,
                })
                this.$emit('get-method')

            } else {
                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "coming",
                    field_value: 0,
                })
                this.$emit('get-method')
            }

            if (this.dataObject.out) {

                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "out",
                    field_value: this.dataObject.out,
                })
                this.$emit('get-method')

            } else {
                axios.post('api/v2/kassaSettingsEditOperationCheckbox', {
                    field_id: this.operationField.id,
                    field_name: "out",
                    field_value: 0,
                })
                this.$emit('get-method')
            }


        },

        //-------------------- Изменяем имя операции и комментарий ----------------------------//

        editField(e, name, type) {

            if (type) {
                axios.post('api/v2/kassaSettingsEditOperationName', {
                    field_id: this.operationField.id,
                    field_name: name,
                    field_value: e
                })
            } else {
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.post('api/v2/kassaSettingsEditOperationName', {
                    field_id: this.operationField.id,
                    field_name: key,
                    field_value: value
                })
            }

            if (name === 'coment') {

                setTimeout(() => {

                    Vue.$toast.open({
                        message: 'Коментарий обновлен',
                        type: 'success',
                        duration: 5000,
                        position: 'top-right'
                    });


                },1000)

            } else {

                setTimeout(() => {

                    Vue.$toast.open({
                        message: 'Имя операции обновлено',
                        type: 'success',
                        duration: 5000,
                        position: 'top-right'
                    });

                },1000)

            }

            this.$emit('get-method')

        },


        //--------------------------------- Удаляем операцию -----------------------------//

        deleteField() {

            this.$bvModal.msgBoxConfirm('Вы уверены что хотите удалить операцию ( ' + this.dataObject.name + ' ) ?'  , {
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

                        axios.delete('api/v2/kassaOperations/' + this.operationField.id)

                        this.modalShow = false
                        this.$emit('get-method')

                        let loader = this.$loading.show({
                            color: '#0080ff',
                        });
                        setTimeout(() => {

                            Vue.$toast.open({
                                message: "Операция удалена",
                                type: 'success',
                                duration: 5000,
                                position: 'top-right'
                            });


                            loader.hide()
                        }, 1000)
                    }
                })

        },


        //--------------------------- Очищаем данные при закрытие модалки --------------------//

        resetModal() {
            this.branch = ''
            this.inComin_Data_1 = ''
            this.inComin_Data_2 = ''
        },

    }
}

</script>

<style scoped>

</style>

