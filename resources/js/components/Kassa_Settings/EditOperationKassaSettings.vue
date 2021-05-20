<template>
    <div>
        <b-modal title="Измините данные Операции" @ok="editOperation" @hidden="resetModal" centered ok-only ok-title="Готово" v-model="modalShow">

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
                                v-model="branch"
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
                                v-model="groupid"
                                option-value="id"
                                option-text="name"
                                placeholder="Введите для поиска группы"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Комментарий</label>
                        <div class="col-sm-8" style="margin-left: 13px;">
                            <textarea
                                class="form-control"
                                placeholder="Введите новый комментарий"
                                v-model="comment"
                                @blur="event => editField(event, 'coment')"
                                rows="3"
                                name="coment"
                            >
                                  </textarea>
                        </div>
                    </div>

            </div>

            <template #modal-footer="{ ok, cancel, hide }">

                <b-button style= "margin-right: 250px" size="sm" variant="outline-secondary" @click="deleteField">
                    <b-icon icon="trash" ></b-icon> Удалить
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
            comment: '',
            operation_types: [],
            modalShow: false
        }

    },

    created() {
        this.getOperationTypes()

    },

    methods: {

        showModalEditOperationKassaSettings(items) {
            this.operationField = items
            this.modalShow = true
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
            axios.get('api/v2/kassaGroups')
                .then(response => this.group = response.data.data)

        },


        editOperation() {

            if (this.branch) {

                axios.post('api/v2/kassaSettingsEditOperationKassa', {
                    field_id: this.operationField.id,
                    field_value: this.branch.id,
                    field_name: 'branch_id'
                })

                Vue.$toast.open({message: 'Касса обновлена', type: 'success', duration: 5000, position: 'top-right'});
            }

            if (this.groupid) {

                axios.post('api/v2/kassaSettingsEditOperationKassa', {
                    field_id: this.operationField.id,
                    field_value: this.groupid.id,
                    field_name: 'group_id'
                })

                Vue.$toast.open({message: 'Группа обновлена', type: 'success', duration: 5000, position: 'top-right'});

            }


            this.$emit('get-method')

            this.branch = ''
            this.group = ''
            this.groupid = ''
            this.groupid = ''
            this.comment = ''

        },

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
        },

        getOperationTypes() {
            axios.get('api/v2/operation_type')
                .then(response => {
                    this.operation_types = response.data.data, this.can = response.data.can
                })
        },

        //--------------------------------- Удаляем операцию -----------------------------//

        deleteField(){
            axios.delete('api/v2/kassaOperations/' + this.operationField.id)
            Vue.$toast.open({message: 'Операция удалена' ,type: 'success',duration: 5000,position: 'top-right'});
            this.modalShow = false
            this.$emit('get-method')
        },

        resetModal(){
            this.branch = ''
        },

    }
}

</script>

<style scoped>

</style>

