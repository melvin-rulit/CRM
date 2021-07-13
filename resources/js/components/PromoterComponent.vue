<template>
    <div>
        <header>

            <div v-if="user.avatar" class="avatar-online avatar avatar-xl">
                <b-img
                    @click="$refs.avatar.click()"
                    center
                    thumbnail
                    fluid
                    :src="siteURL + user.avatar"
                    class="avatar-img rounded-circle">
                </b-img>
            </div>

            <div v-else class="avatar avatar-xl">

                <b-img
                    center
                    thumbnail
                    fluid
                    src="http://127.0.0.1:8000/images/no_avatar.jpg"
                    alt="?"
                    class="avatar-img rounded-circle">
                </b-img>

            </div>

            <div class="avatar-online avatar avatar-xl">
                <b-img
                    center
                    thumbnail
                    fluid
                    src="/images/images_for_promouter/red.png"
                    alt="?"
                    class="avatar-img rounded-circle">
                </b-img>
            </div>

            <a><img src="/images/images_for_promouter/calendar.png"></a>
            <a><img src="/images/images_for_promouter/map-button.png"></a>
            <div class="menu-icon"><img src='/images/images_for_promouter/menu.svg'></div>
        </header>
        <main class="container-sm">
            <div class="menu">
                <img class="cross-icon" src="/images/images_for_promouter/cross.svg">
                <div class="icons">
                    <a>menu item</a>
                    <a>menu item</a>
                    <a>menu item</a>
                </div>
            </div>

            <!------------------------\  Форма  /--------------------------------->

            <div class="row">
                <div class="inputs">
                    <form @submit.prevent="send">


                        <!--------------------------- Имя ребенка ---------------------------->

                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" v-model="new_child_name" placeholder="Имя ребенка">

                        </div>

                        <div class="alert alert-warning" role="alert"
                             v-if="$v.new_child_name.$invalid || $v.new_child_surname.$invalid">
                            Имя и Фамилия ребенка обязательны для заполнения!
                        </div>

                        <!--------------------------- Фамилия ребенка ---------------------------->

                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" v-model="new_child_surname"
                                   placeholder="Фамилия ребенка">

                        </div>

                        <!--------------------  Дата  -------------------------------------->

                        <div class="form-group col-md-12">
                            <input class="form-control" type="date"
                                   v-model="new_date">

                        </div>

                        <div class="alert alert-warning" role="alert" v-if="$v.new_date.$invalid">
                            Выберите из календаря дату рождения ребенка!
                        </div>


                        <!-------------------------- Выбор Родственника -------------------------->

                        <div class="form-group col-md-12">

                            <b-form-select v-model="selected_2"
                                           :options="options_2"
                                           class="city-select"
                            ></b-form-select>

                        </div>

                        <div class="alert alert-warning" role="alert" v-if="$v.new_parent_name.$invalid">
                            Выберите близкого и укажите обязательно его имя!
                        </div>

                        <!----------------------- Вибираем имя родителя ------------------------>

                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" placeholder="Имя родителя"
                                   v-model="new_parent_name">
                        </div>

                        <!--------------------  Телефон родителя  ------------------------------>


                        <div class="form-group col-md-12">
                            <input type="tel" class="form-control" placeholder="+38 (___) ___-__-__"
                                   v-model="new_parent_phone"
                                   v-mask="'+38 (###) ###-##-##'">
                        </div>

                        <div class="alert alert-warning" role="alert" v-if="$v.new_parent_phone.$invalid">
                            Телефон родителя обязательно для заполнения!
                        </div>

                        <!------------------------  Филиал  ------------------------------------>

                        <div class="form-group col-md-12">

                            <dynamic-select
                                :options="branches"
                                option-value="id"
                                option-text="name"
                                placeholder="Список Филиалов"
                                v-model="select_branch"
                                class="city-select"/>

                        </div>

                        <div class="alert alert-warning" role="alert" v-if="$v.select_branch.$invalid">
                            Поле Филиал обязательно для заполнения!
                        </div>

                        <!------------------------  Джероло контакту  ----------------------------->

                        <div class="form-group col-md-12">

                            <dynamic-select
                                :options="sourceGroupArray"
                                option-value="id"
                                option-text="name"
                                placeholder="Джероло контакт"
                                v-model="selectGroup"
                                class="city-select"
                                @input="getSource()"/>

                        </div>

                        <div class="alert alert-warning" role="alert" v-if="$v.selectGroup.$invalid">
                            Поле Джероло контакту обязательно для заполнения!
                        </div>

                        <!------------------------  Точка авторизации   -------------------------->

                        <div class="form-group col-md-12">

                            <dynamic-select
                                :options="sourceArray"
                                option-value="id"
                                option-text="name"
                                placeholder="Точка авторизации"
                                v-model="select_source"
                                class="city-select"/>

                        </div>

                        <div class="alert alert-warning" role="alert" v-if="$v.select_source.$invalid">
                            Поле Точка авторизации обязательно для заполнения!
                        </div>

                        <!------------------------ Отправляем данные ---------------------------->

                        <button type="submit" class=" send-button btn btn-center btn btn-success mt-2"
                                v-show="!$v.$invalid">
                            Отправить
                        </button>

                    </form>
                </div>

            </div>
        </main>
    </div>
</template>

<script>

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.use(VueToast);


import {required, minLength, between} from 'vuelidate/lib/validators'
import Vue from "vue";


export default {


    data() {
        return {

            selected_1: '',
            selected_2: 'мother_name',


            options_2: [
                {text: 'Мать', value: 'мother_name'},
                {text: 'Отец', value: 'father_name'},
                {text: 'Родственник', value: 'other_relative_name'},
            ],

            new_child_name: null,
            new_child_surname: null,
            new_parent_name: null,
            new_parent_phone: null,
            new_date: null,
            branches: '',
            select_branch: null,
            selectGroup: null,
            sourceGroupArray: [],
            select_source: null,
            sourceArray: [],
            siteURL: "http://127.0.0.1:8000/",
            user: '',


        }
    },

    validations: {

        new_child_name: {
            required,

        },
        new_child_surname: {
            required,

        },
        new_parent_name: {
            required,

        },
        new_parent_phone: {
            required,

        },
        new_date: {
            required,

        },
        select_branch: {
            required,

        },
        selectGroup: {
            required,

        },
        select_source: {
            required,

        },


    },

    beforeCreate() {

        axios.get('api/v2/getbranches')
            .then(response => this.branches = response.data.data)

        axios.get('api/v2/getSourceGroupBaseModal')
            .then(response => {
                this.sourceGroupArray = response.data.data
            })

        axios.get('api/v2/getUserName')
            .then(response => this.user = response.data)

    },

    methods: {

        getSource() {

            axios.post('api/v2/getSourceInGroup', {group_id: this.selectGroup.id})
                .then(response => {
                    this.sourceArray = response.data.data
                })
        },

        send() {

            if (this.selected_2 === "мother_name") {

                axios.post('api/v2/addnewuser', {
                    child_name: this.new_child_name,
                    child_surname: this.new_child_surname,
                    mother_name: this.new_parent_name,
                    mother_phone: this.new_parent_phone,
                    birthday: this.new_date,
                    branch: this.select_branch.id,
                    source: this.select_source.id,

                }).finally(() => (this.reset()))

            } else if (this.selected_2 === "father_name") {

                axios.post('/api/v2/addnewuser', {
                    child_name: this.new_child_name,
                    child_surname: this.new_child_surname,
                    father_name: this.new_parent_name,
                    father_phone: this.new_parent_phone,
                    birthday: this.new_date,
                    branch: this.select_branch.id,
                    source: this.select_source.id,


                }).finally(() => (this.reset()))

            } else {

                axios.post('/api/v2/addnewuser', {
                    child_name: this.new_child_name,
                    child_surname: this.new_child_surname,
                    other_relative_name: this.new_parent_name,
                    other_relative_phone: this.new_parent_phone,
                    birthday: this.new_date,
                    branch: this.select_branch.id,
                    source: this.select_source.id,


                }).finally(() => (this.reset()))
            }

            let loader = this.$loading.show({
                color: '#0080ff',
            });
            setTimeout(() => {
                loader.hide()

                Vue.$toast.open({
                    message: 'Ребенок успешно добавлен в Базу',
                    type: 'success',
                    duration: 5000,
                    position: 'top'
                });

            }, 1000)


        },

        reset() {
            this.select_branch = '',
                this.new_parent_phone = '',
                this.new_child_name = '',
                this.new_child_surname = '',
                this.new_parent_name = '',
                this.selected_2 = 'мother_name',
                this.new_date = ''
            this.selectGroup = ''
            this.select_source = ''
        },
    },
}
</script>


<style scoped>

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.main-logo {
    width: 500px;
    margin: 45px auto;
}

.inputs {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    width: 100%;
}

.inputs input {
    height: 95px;
    text-align: center;
    border: 2px solid #044510;
    font-size: 28px;
    letter-spacing: 4px;
    border-radius: 5px;
}

.button {
    height: 95px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: none;
    background: #044510;
    color: #f7f8f9;
    text-transform: uppercase;
    letter-spacing: 5px;
    font-size: 48px;
    font-weight: bold;
    line-height: normal;
}

.login-button {
    width: calc(100% - 30px);
    margin: 0 auto 20px;
}

.forgot-password-button {
    border: none;
    background: inherit;
    color: #044510;
    text-decoration: underline;
    letter-spacing: 2px;
    font-size: 28px;
}

header {
    margin: 45px;
    justify-content: space-between;
    display: flex;
    align-items: center;
}

header .menu-icon img {
    width: 78px;
}

.menu {
    position: absolute;
    background: #fff;
    height: 100%;
    top: 0;
    width: 100%;
    left: 0;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    z-index: 9;
}

.menu.open {
    display: flex;
}

.menu a {
    font-size: 48px;
    margin-bottom: 45px;
    color: #044510;
}

.menu .icons {
    display: flex;
    flex-direction: column;
}

.cross-icon {
    position: absolute;
    top: 45px;
    right: 45px;
    transform: rotate(45deg);
    width: 78px;
}

/*.inputs div {*/
/*    display: flex;*/
/*    justify-content: space-between;*/
/*}*/

/*.inputs div:not(.form-group) input:first-child {*/
/*    width: 75%;*/
/*}*/

/*.inputs div:not(.form-group) input:last-child {*/
/*    width: 20%;*/
/*}*/

.city-select {
    border: 2px solid #044510;
    height: 95px;
    font-size: 18px;
}

.city-select option {
    font-size: 12px;
}

.conversation-block {
    display: flex;
    flex-direction: column;
    border: 1px solid #044510;
    padding: 0;
    border-radius: 10px;
    width: calc(100% - (calc(var(--bs-gutter-x) / 2) + (var(--bs-gutter-x) / 2)));
    margin: 45px auto;
}

.conversation-block button {
    background: none;
    height: 80px;
    font-size: 44px;
    color: #8a8b90;
    border: none;
    border-top: 1px solid #044510;
    position: relative;
}

.conversation-block button:before {
    content: '';
    background-image: url(/images/images_for_promouter//arrow.png);
    width: 50px;
    height: 50px;
    display: block;
    background-repeat: no-repeat;
    background-position: center;
    background-color: #044510;
    border-radius: 50%;
    background-size: 50%;
    position: absolute;
    top: 50%;
    right: 5%;
    transform: translate(0%, -50%);
}

.message-block {
    padding: 25px;
    max-height: 21vh;
    overflow: scroll;
}

.sender-block {
    display: flex;
    align-items: flex-end;
    margin-bottom: 45px;
}

.receiver-block {
    display: flex;
    align-items: flex-end;
    margin-bottom: 45px;
    flex-direction: row-reverse;
}

.sender-block img {
    width: 80px;
    margin-right: 25px;
}

.receiver-block img {
    width: 80px;
    margin-left: 25px;
}

.sender-block p, .receiver-block p {
    margin: 0;
    border: 1px solid #044510;
    font-size: 22px;
    padding: 15px;
}

.send-button {
    margin-bottom: 0;
}

.map-image {
    width: 100%;
}

.shedule-header {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 45px;
}

.shedule-header img {
    width: 60px;
    margin-right: 25px;
}

.shedule-header p {
    margin: 0;
    font-size: 60px;
    text-decoration: underline;
    letter-spacing: 5px;
}

.shedule-block {
    padding: 0 25px;
}

.shedule-block p {
    font-size: 36px;
    letter-spacing: 2px;
}

@media (min-width: 992px) {
    html, body {
        overflow: visible;
        max-width: 540px;
        margin: 0 auto;
    }
}

@media (min-width: 576px) {
    .modal-dialog-centered {
        max-width: 90%;
    }
}

.btn-center {
    margin-left: 30%;
}


</style>
