<template>
	<div>
		<div class="collapse" id="filter">
    <div class="card card-body">
        <div class="row mb-3">
            <div class="col-12">
                <form class="d-flex justify-content-around">
                    <div class="filter">
                        <input v-model="surname" class="form-control" placeholder="Фамилия">
                    </div>
                    <div class="filter">
                        <input v-model="name" class="form-control" placeholder="Имя">
                    </div>
                    <div class="filter">
                        <input v-model="birthday" class="form-control" placeholder="Год рождения">
                    </div>
                    <div class="submit">
                        <button type="submit" @click.prevent="fetch" class="btn btn-success" :disabled="busy">
                            <i v-if="busy" class="fa fa-spin fa-spinner"></i>
                            Фильтр
                        </button>
                    </div>
                    <div class="submit">
                        <button type="submit" @click.prevent="reset" class="btn btn-primary" :disabled="busy">
                            Сброс
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
	</div>
</template>


<script>
    export default {
    	props: ['onLogin'],
        data() {
            return {
            	articles: [],
                name: null,
                is_active: null,
                birthday: null,
                manager: null,
                users: [],
                busy: false,
            }
        },

        methods: {
            reset() {
                this.name = null;
                this.is_active = null;
                this.birthday = null;
                this.manager = null;
                this.fetch();
            },

            fetch() {
                this.busy = true;
                axios.get(`api/v2/filter`, {
                    params: {
                        surname: this.surname,
                        name: this.name,
                        birthday: this.birthday,
                    }
                })
                    .then(response => {

                        this.articles = response.data;
                        this.busy = false;
                          this.onLogin(this.articles)
                    })
            },
        },

        mounted() {
            // this.fetch();
        }
    }
</script>