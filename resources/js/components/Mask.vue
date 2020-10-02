<template>

    <input-form
        v-model="mother_surname"
        name="mother_surname"
        placeholder="+38 (926) 123-45-67"
        mask="+## (###) ###-##-##"
        @edit-field="editField">
    </input-form>

</template>

<script>
    import {TheMask} from 'vue-the-mask'
    export default {
        components: {TheMask},
        data(){
            return{
                mother_surname: '',
            }
        },

        methods:{
            editField(){

            }
        }
    }
</script>

<style scoped>

</style>
