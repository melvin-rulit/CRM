<template>

    <div>

        <!-- Модальное окно Delete Operations Kassa-Settings -->

        <b-modal id="DeleteOperations"  title="Удалить выбранную операцию?"  @ok="deleteRow($event)"  centered  ok-title="Удалить">
            <p class="center">
                <b-alert class="text-center" show variant="danger">{{this.operationsrow.name}}</b-alert>
            </p>
        </b-modal>
    </div>

</template>

<script>

import Vue from "vue";

export default {

    data() {
        return {
            groups: [],
            operationsrow: '',
            otvet: '',

        }

    },

    methods: {

        showModalDeleteOperationsKassaSettings(items){
            this.operationsrow = items
            this.$bvModal.show('DeleteOperations')
        },

    //--------------------------------- Вытягиваем Группы ------------------------//

        getAllGroups(){
            axios.get('api/v2/kassaGroups')
                .then(response => this.groups = response.data.data)
        },

    //--------------------------------- Удаляем операцию -----------------------------//

        deleteRow(){
            axios.delete('api/v2/kassaOperations/' + this.operationsrow.id)
            Vue.$toast.open({message: 'Операция удалена' ,type: 'success',duration: 5000,position: 'top-right'});
            this.$emit('get-method')
        },


    }
}

</script>

<style scoped>

</style>
