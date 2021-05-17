<template>

    <div>

        <!-- Модальное окно Delete-roles-in-settings -->
        <b-modal id="DeleteGroups"  title="Удалить выбранную группу?"  @ok="deleteRow($event)"  centered  ok-title="Удалить">
            <p class="center">
                <b-alert class="text-center" show variant="danger">{{this.grouprow.name}}</b-alert>
            </p>
        </b-modal>
    </div>

</template>

<script>

export default {

    data() {
        return {
            groups: [],
            grouprow: '',
            otvet: '',

        }

    },

    methods: {

        showModalDeleteGroupsKassaSettings(items){
            this.grouprow = items
            this.$bvModal.show('DeleteGroups')
        },

        getAllGroups(){
            axios.get('api/v2/kassaGroups')
                .then(response => this.groups = response.data.data)
        },

        deleteRow(){
            axios.delete('api/v2/kassaGroups/' + this.grouprow.id)
                .then(response => this.otvet = response.data)
            this.$emit('get-method')
        },


    }
}

</script>

<style scoped>

</style>
