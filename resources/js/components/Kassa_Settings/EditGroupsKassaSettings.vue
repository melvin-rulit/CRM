<template>
    <div>
        <b-modal id="EditGroups" title="Измините данные группы" @ok="editGroup" @hidden="resetModalGroup" centered ok-only
                 ok-title="Готово">

            <div class="card-body py-0">
                <form>

                            <div class="form-group row ">
                                <label class="col-sm-3 col-form-label">Наименование</label>
                                <div class="col-sm-8 form-control" style="margin-left: 13px;">
                                    <input-form
                                        v-model="grouprow.name"
                                        name="name"
                                        @edit-field="editField"
                                        :gate="can.kassa_add_operation_type">

                                    </input-form>
                                </div>
                            </div>
                            <div class="form-group row ">
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
            grouprow: '',
            group_name: '',
            can: '',
            operation_types: [],
            value: '',


        }

    },

    created() {
        this.getOperationTypes()
    },

    methods: {

        showModalEditGroupsKassaSettings(items) {
            this.grouprow = items
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
            this.$bvModal.show('EditGroups')
        },

        getBranches() {
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
        },

        getAllGroups() {
            axios.get('api/v2/kassaGroups')
                .then(response => this.groups = response.data.data)
        },

        editGroup() {
            axios.post('api/v2/kassaSettingsEditGroupsKassa', {
                row_id: this.grouprow.id,
                field_value: this.branch.id,
                field_name: 'branch_id'
            })
            Vue.$toast.open({message: 'Группа обновлена', type: 'success', duration: 5000, position: 'top-right'});
            this.$emit('get-method')
            this.branch = ''
            this.group = ''
        },

        editField(e, name, type) {

            if (type) {
                axios.post('api/v2/kassaSettingsEditGroupsName', {user_id: this.user.id, field_name: name, field_value: e})
            } else {
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.post('api/v2/kassaSettingsEditGroupsName', {row_id: this.grouprow.id, field_name: key, field_value: value})
                Vue.$toast.open({message: 'Имя Группы обновлено', type: 'success', duration: 5000, position: 'top-right'});
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

