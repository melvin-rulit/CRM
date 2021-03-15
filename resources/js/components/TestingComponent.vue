<template>
    <div>

        <button class="btn btn-success btn-sm" @click="getAll()">Получить</button>

        <input type="radio" id="one" value="Один" v-model="picked" @change="all">
        <label for="one">Один</label>
        <br>
        <input type="radio" id="two" value="Два" v-model="picked">
        <label for="two">Два</label>
        <br>
        <span>Выбрано: {{ picked }}</span>

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
            picked: ''
        }
    },

    mounted() {

    },

    methods: {
        all(){
            alert('666')
        },

        getAll(){
            axios.get('api/v2/getTest')
                .then(response => this.get = response.data)
        },

    }
}

</script>

<style scoped>

</style>
