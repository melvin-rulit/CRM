<template>
    <div>
        <div class="collapse" id="filter">
            <div class="card card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <form class="d-flex justify-content-around">
                            <div class="filter">
                                <input v-model="surname" type="text" class="form-control" placeholder="Фамилия">
                            </div>
                            <div class="filter">
                                <input v-model="name" type="text" class="form-control" placeholder="Имя">
                            </div>
                            <div class="filter">
                                <input v-model="birthday" type="text" class="form-control" placeholder="Год рождения">
                            </div>
                            <div class="submit">
                                <button type="submit" @click.prevent="fetch" class="btn btn-primary" :disabled="busy">
                                    <i v-if="busy" class="fa fa-spin fa-spinner"></i>
                                    Фильтр
                                </button>
                            </div>
                            <div class="submit">
                                <button type="submit" @click.prevent="reset" class="btn btn-default" :disabled="busy">
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