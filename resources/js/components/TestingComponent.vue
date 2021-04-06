<template>
    <div>

        <button class="btn btn-success btn-sm" @click="getAll()">Получить</button>

        <input type="text" v-model="input1">
        <input type="text" v-model="input2">

        Количество: {{ get.length }}
        <pre><code>{{ get }}</code></pre>

    </div>
</template>

<script>



export default {

    components: {

    },

    data () {
        return {
            get: [],
            test: '456',
            picked: '',
            input1: '',
            input2: '',
        }
    },

    mounted() {

    },

    methods: {
        all(){
            alert('666')
        },

        getAll(){
            axios.post('api/v2/getTest', {name: this.input1, surname: this.input2})
                .then(response => this.get = response.data)
        },

    }
}

</script>

<style scoped>

</style>
