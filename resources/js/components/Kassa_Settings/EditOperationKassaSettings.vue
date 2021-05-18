<template>
    <div>
        <b-modal id="EditOperations" title="Измините данные Операции" @ok="editOperation" @hidden="resetModalGroup" centered ok-only
                 ok-title="Готово">

            <div class="card-body py-0">
                <form>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Название</label>
                        <div class="col-sm-8 form-control" style="margin-left: 13px;">
                            <input-form
                                v-model="grouprow.name"
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
                                placeholder = "Введите новый комментарий"
                                class="form-comment"
                                v-model="comment"
                                @blur="event => editField(event, 'coment')"
                                rows="3"
                                name="coment"
                            >
                                  </textarea>
                        </div>
                    </div>

                </form>
            </div>

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
            grouprow: '',
            can: '',
            comment: '',
            operation_types: [],

        }

    },

    created() {
        this.getOperationTypes()

    },

    methods: {

        showModalEditOperationKassaSettings(items) {
            this.grouprow = items
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
            axios.get('api/v2/kassaGroups')
                .then(response => this.group = response.data.data)
            this.$bvModal.show('EditOperations')
        },


        editOperation() {


            axios.post('api/v2/kassaSettingsEditOperationKassa', {
                    row_id: this.grouprow.id,
                    field_value: this.branch.id,
                    field_name: 'branch_id'
            })
            axios.post('api/v2/kassaSettingsEditOperationKassa', {
                    row_id: this.grouprow.id,
                    field_value: this.groupid.id,
                    field_name: 'group_id'
            })

                Vue.$toast.open({message: 'Данные обновлены', type: 'success', duration: 5000, position: 'top-right'});
                 this.$emit('get-method')

            this.branch = ''
            this.group = ''
            this.groupid = ''
            this.groupid = ''
            this.comment = ''

        },

        editField(e, name, type) {

            if (type) {
                axios.post('api/v2/kassaSettingsEditOperationName', {user_id: this.user.id, field_name: name, field_value: e})
            } else {
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.post('api/v2/kassaSettingsEditOperationName', {row_id: this.grouprow.id, field_name: key, field_value: value})
                // Vue.$toast.open({message: 'Имя Операции обновлено', type: 'success', duration: 5000, position: 'top-right'});
            }
        },

        getOperationTypes() {
            axios.get('api/v2/operation_type')
                .then(response => {
                    this.operation_types = response.data.data, this.can = response.data.can
                })
        },

    }
}

</script>

<style scoped>

</style>

