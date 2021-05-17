<template>
<div>
    <b-modal id="EditGroups" title="Новая группа" @ok="editGroup" @hidden="resetModalGroup" centered ok-only ok-title="Добавить">
        <div class="card-body py-0">
            <form>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Наименование</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="group_name">
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
            </form>
        </div>
    </b-modal>
</div>
</template>

<script>

export default {

    data() {
        return {
            branches: [],
            branch: '',
            group: '',
            grouprow: '',

        }

    },

    methods: {

        showModalEditGroupsKassaSettings(items){
            this.grouprow = items
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
            this.$bvModal.show('EditGroups')
        },

        getBranches(){
            axios.get('api/v2/getbranches')
                .then(response => this.branches = response.data.data)
        },

        getAllGroups(){
            axios.get('api/v2/kassaGroups')
                .then(response => this.groups = response.data.data)
        },

        editGroup(){
            axios.post('api/v2/kassaSettingsEditGroups', {branch_id: this.grouprow.id, field_value: this.branch.id, field_name: 'branch_id'})
            this.$emit('get-method')
            this.branch = ''
        },


    }
}

</script>

<style scoped>

</style>

