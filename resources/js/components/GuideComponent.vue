<template>
    <div>

        <b-modal id="coming" title="Новая операция" @ok="handleSubmit" @hidden="resetModal" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Наименование</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Группа</label>
                        <div class="col-sm-9">
                            <dynamic-select
                                :options="kassaGroups"
                                v-model="group"
                                option-value="id"
                                option-text="name"
                                placeholder="Введите для поиска группы"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea v-model="coment" class="form-control" rows="3" placeholder="Коментарий"></textarea>
                    </div>
                </form>
            </div>
        </b-modal>

        <b-modal id="group" title="Новая группа" @ok="saveGroup" @hidden="resetModalGroup" centered ok-only ok-title="Добавить">
            <div class="card-body py-0">
                <form>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Наименование</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="group_name">
                        </div>
                    </div>
                </form>
            </div>
        </b-modal>

        <div class="card">
            <b-tabs content-class="mt-3" justified>
                <b-tab title="Источники" @click="getSource" active>
                    <!-- Панель над фильтром -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button v-b-modal="'coming'" @click="getGroupsInSource" class="btn btn-sm btn-success">Добавить источник</button>
                                        </div>
                                        <div class="col-auto">
<!--                                            <button class="btn btn-sm btn-info">Фильтр</button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Список клиентов -->
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="700px"
                            :items="sourcess"
                            :fields="fields"
                            head-variant="light">
                            <template v-slot:cell(coming)="row">
                                <span v-if="row.item.coming" class="text-success">●</span>
                            </template>
                            <template v-slot:cell(out)="row">
                                <span v-if="row.item.out" class="text-success">●</span>
                            </template>
                            <template v-slot:cell(cash)="row">
                                <span v-if="row.item.cash" class="text-success">●</span>
                            </template>
                            <template v-slot:cell(beznal)="row">
                                <span v-if="row.item.beznal" class="text-success">●</span>
                            </template>
                        </b-table>
                    </div>
                </b-tab>
                <b-tab @click="getAllGroups" title="Группы источников">
                    <!-- Панель над фильтром -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <button v-b-modal="'group'" class="btn btn-sm btn-success">Добавить группу</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <b-table
                            hover
                            sticky-header="700px"
                            :items="groups"
                            :fields="groupsFields"
                            head-variant="light">
                        </b-table>
                    </div>
                </b-tab>
            </b-tabs>
        </div>

    </div>
</template>

<script>
    import Vue from "vue";

    export default {
        data() {
            return{
                name: '',
                group_name: '',
                coment: '',
                branch: '',
                group: '',
                branches: [],
                groups: [],
                kassaGroups: [],
                sourcess: [],
                fields: [
                    {
                        key: 'name',
                        label: 'Название',
                    },
                    {
                        key: 'group',
                        label: 'Группа',
                    },
                ],
                groupsFields: [
                    {
                        key: 'name',
                        label: 'Название',
                    },
                ],
            }
        },

        created(){
            this.getSource()
        },

        methods: {

            resetModal(){
                this.name = ''
                this.group = ''
                this.coment = ''
            },

            resetModalGroup(){
                this.group_name = ''
            },


            handleSubmit(bvModalEvt){
                if (!this.group.id || !this.name) {
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                } else {
                    axios.post('api/v2/source', {
                        name: this.name,
                        group_id: this.group.id,
                        coment: this.coment,
                    })

                    Vue.$toast.open({message: 'Источник добавлен' ,type: 'success',duration: 1000,position: 'top-right'});
                    this.getSource()
                }
            },

            saveGroup(bvModalEvt){

                if (!this.group_name) {
                    bvModalEvt.preventDefault()
                    Vue.$toast.open({message: 'Заполните все необходимые поля' ,type: 'error',duration: 1000,position: 'top-right'});
                } else {
                    axios.post('api/v2/sourceGroups', {
                        name: this.group_name,
                    })

                    Vue.$toast.open({message: 'Группа добавлена' ,type: 'success',duration: 1000,position: 'top-right'});
                    this.getAllGroups()
                }

            },

            getGroupsInSource(){
                axios.get('api/v2/sourceGroups')
                    .then(response => this.kassaGroups = response.data.data)
            },

            getSource(){
                axios.get('api/v2/source')
                    .then(response => this.sourcess = response.data.data)
            },

            getAllGroups(){
                axios.get('api/v2/sourceGroups')
                    .then(response => this.groups = response.data.data)
            }

        }
    }
</script>
