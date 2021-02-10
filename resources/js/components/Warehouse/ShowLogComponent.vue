<template>
    <b-modal id="showLogModal" hide-footer size="lg" title="Логи склада" centered @hidden="closeModal">
        <div class="card mt-3 fix-height">
            <div class="card-body">
                <p v-if="logs" v-for="log in logs" :key="log.id" class="mb-2">
                    {{ log.date }} - {{ log.user }} - {{ log.comment }}
                </p>
            </div>
        </div>
    </b-modal>
</template>

<script>

    import Loading from 'vue-loading-overlay';
    Vue.use(Loading, {
        color: '#007BFF',
        width: 35,
        height: 35,
    });

    export default {
        data() {
            return {
                fullPage: false,
                logs: [],
            }
        },

        methods: {

            async showLog(id) {
                try {
                    let loader = this.$loading.show({
                        container: this.fullPage ? null : this.$refs.formContainer,
                        canCancel: true,
                    });

                    let res = await axios.post('api/v2/warehouseLog', {id: id})

                    if (res.status == 200) {
                        this.logs = res.data.data
                        loader.hide()
                        this.$bvModal.show('showLogModal')
                    }

                } catch (err) {
                    console.error(err);
                }
            },

            closeModal(){
                this.logs = []
            }
        },
    }
</script>

<style scoped>
    .form-control:focus {
        color: #12263f;
        outline: 0;
    }
</style>
