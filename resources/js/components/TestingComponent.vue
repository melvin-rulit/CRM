<template>
    <div>
        <label class="typo__label">Tagging</label>
        <multiselect
            v-model="branches"
            tag-placeholder="Add this as new tag"
            placeholder="Search or add a tag"
            label="name"
            track-by="id"
            :options="permissions"
            :multiple="true"
            :taggable="true"
            @tag="addTag"
            deselectLabel="Удалить"
            selectedLabel="Выбран"
        ></multiselect>
        <p v-for="branch in branches">{{ branch.name }}</p>
    </div>
</template>

<script>

    import Multiselect from 'vue-multiselect'

export default {

    components: {
        Multiselect
    },

    data () {
        return {
            branches: [],
            permissions: [],
        }
    },

    mounted() {
        this.getPermisions()
        this.getAllPermisions()
    },

    methods: {
        getAllPermisions(){
            axios.get('api/v2/getAllPermisions')
                .then(response => this.permissions = response.data)
        },

        getPermisions(){
            axios.get('api/v2/getPermisions')
                .then(response => this.branches = response.data)
        },

        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
        }
    }
}

</script>

<style scoped>
    .multiselect, .multiselect__input, .multiselect__single {
        font-size: 14px;
    }

    .multiselect__option--selected {
        font-weight: 100;
        background: red;

    }
    .multiselect__option {
        padding: 10px;
    }

    .multiselect__tag{
        background: red;
    }

</style>
