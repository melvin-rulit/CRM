<template>
    <div>

        <button class="btn btn-success btn-sm" @click="getAll()">Получить</button>


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
            test: '456'
        }
    },

    mounted() {

    },

    methods: {
        getAll(){
            axios.get('api/v2/getTest')
                .then(response => this.get = response.data)
        },

    }
}

</script>

<style scoped>

</style>
