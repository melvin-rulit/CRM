<template>
    <div>

        <button class="btn btn-success btn-sm" @click="getAll()">Получить</button>

        <img :src="`/disease_history/${test}/`">IMG</img>

        <pre><code>{{ get }}</code></pre>

        <p>{{ get.user_show }}</p>
    </div>
</template>

<script>



export default {

    components: {

    },

    data () {
        return {
            get: '',
            test: '456'
        }
    },

    mounted() {

    },

    methods: {
        getAll(){
            axios.get('api/v2/getTest')
                .then(response => this.get = response.data.data)
        },

    }
}

</script>

<style scoped>

</style>
