<template>
    <div>
        <base-modal-component ref="showmoda"></base-modal-component>
        <vue-context ref="menu">
            <li>
                <a href="#" @click.prevent="workout()" v-if="gates.journal_visit">
                    <i class="fe fe-check text-success ml-1 mr-3"></i>Занятие</a>
            </li>
            <li>
                <a href="#" @click.prevent="freezing()"><i class="fe fe-sun text-primary ml-1 mr-3"></i>Заморозка</a>
            </li>
            <li>
                <a href="#" @click.prevent="notVisit()" v-if="gates.journal_not_visit">
                    <i class="fe fe-x text-danger ml-1 mr-3"></i>Пропустил занятие</a>
            </li>
            <li>
                <a href="#" @click.prevent="newWorkout()" v-if="gates.journal_pk">
                    <i class="fe fe-alert-circle text-warning ml-1 mr-3"></i>Назначить</a>
            </li>
            <li>
                <a href="#" v-b-modal="'addNewCommentGetModal'">
                    <i class="fe fe-message-circle text-primary ml-1 mr-3"></i>Комментарий</a>
            </li>
            <li>
                <a href="#" v-b-modal="'showHistory'" @click.prevent="getHistory()">
                    <i class="fe fe-menu text-primary ml-1 mr-3"></i>Смотреть историю</a>
            </li>
        </vue-context>

        <div class="row flex-nowrap halls">
            <div v-if="halls" v-for="hall in halls" class="col-3 col-lg-3">
                <div class="card" :class="hall_id == hall.id ? 'border border-success' : ''">
                    <div class="card-body p-3">
                        <a href="#" @click.prevent="getHallAtributes(hall.id, calendar)">{{ hall.name }}</a>
                        <template v-if="hall_id == hall.id">
                            <span class="badge badge-primary ml-3 mb-2">5</span>
                            <i @click="showCalendar(hall.id)"
                               class="pointer fe fe-calendar h2 ml-3 mb-0 text-muted"></i>
                            <i @click="settingsGroup(hall.id)" class="pointer fe fe-users h2 ml-3 mb-0 text-muted"></i>
                            <i @click="editGroup(hall.id)" class="pointer fe fe-user-x h2 ml-3 mb-0 text-muted"></i>
                        </template>
                        <p class="text-muted h5 mb-1 mt-2">{{ hall.branch.name }}</p>
                        <p class="text-muted h5">{{ hall.branch.geolocation }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Добавление новой группы -->
        <b-modal id="settingsGroup" title="Добавление новой группы" centered ok-only @hidden="resetSettingsGroup"
                 @ok="OkSettingsGroup">
            <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    :state="nameState"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    label="Название группы"
                    label-for="name-input"
                    invalid-feedback="Поле обязательно для заполнения"
                >
                    <b-form-input
                        id="name-input"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                </b-form-group>

                <b-form-group
                    :state="programmState"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    label="Программа обучения"
                    label-for="name-input"
                    invalid-feedback="Поле обязательно для заполнения"
                >
                    <dynamic-select
                        :state="programmState"
                        :options="programms"
                        option-value="id"
                        option-text="name"
                        v-model="programmForGroup"
                        placeholder="Введите для поиска программы"/>
                </b-form-group>
                <div class="row">
                    <!--                    <slider-picker class="ml-6 mb-2" v-model="colors" />-->
                    <compact-picker
                        class="ml-7 mb-2"
                        v-model="colors"
                        :palette="[
                        '#006400','#8B0000','#008B8B','#FF1493','#FFA500','#FF7F50','#FFFF00','#00FFFF','#F0E68C','#000080','#4B0082','#8B4513',
'#800000','#778899','#000000'
  ]"
                    ></compact-picker>
                </div>
                <div class="p-4 my-3" :style="{ 'background-color': colors.hex }"></div>
                <b-form-group
                    label-cols-sm="4"
                    label-cols-lg="4"
                    label="Цвет текста"
                    label-for="name-input"
                >
                    <dynamic-select
                        :options="text_color_array"
                        option-value="id"
                        option-text="name"
                        v-model="text_color"
                        placeholder="Выберите цвет текста"/>
                </b-form-group>
            </form>
        </b-modal>


        <!-- Редактирование группы -->
        <b-modal id="editGroup" title="Редактирование группы" centered ok-only ok-title="Сохранить"
                 @hidden="resetEditGroup" @ok="OkEditGroup">
            <b-form-group
                label-cols-sm="4"
                label-cols-lg="4"
                label="Выберите группу"
                label-for="name-input"
                invalid-feedback="Поле обязательно для заполнения"
            >
                <dynamic-select
                    :options="editGroupModelArray"
                    option-value="id"
                    option-text="name"
                    v-model="editGroupModel"
                    placeholder="Введите для поиска программы"/>
            </b-form-group>

            <form ref="formSettingsGroup" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    :state="nameState"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    label="Название группы"
                    label-for="name-input"
                    invalid-feedback="Поле обязательно для заполнения"
                >
                    <b-form-input
                        id="name-input"
                        v-model="editGroupModel.name"
                        :state="nameState"
                        required
                    ></b-form-input>
                </b-form-group>

                <b-form-group
                    :state="programmState"
                    label-cols-sm="4"
                    label-cols-lg="4"
                    label="Программа обучения"
                    label-for="name-input"
                    invalid-feedback="Поле обязательно для заполнения"
                >
                    <select class="form-control" @change="changeProgrammValue($event)">
                        <option
                            v-for="item in programms"
                            v-if="editGroupModel.programm_id"
                            :value="item.id"
                            :selected="item.id === editGroupModel.programm_id">{{ item.name }}
                        </option>
                    </select>

                </b-form-group>

                <div class="p-2 my-3" :style="{ 'background-color': editGroupModel.color }">
                    <p class="text-center m-0 p-2" :style="{ 'color': editGroupModel.text_color }">Старый цвет ярлыка
                        группы</p>
                </div>

                <div class="row">
                    <!--                    <slider-picker class="ml-6 mb-2" v-model="colors" />-->
                    <compact-picker
                        class="ml-7 mb-2"
                        v-model="colors"
                        :palette="[
                        '#006400','#8B0000','#008B8B','#FF1493','#FFA500','#FF7F50','#FFFF00','#00FFFF','#F0E68C','#000080','#4B0082','#8B4513',
'#800000','#778899','#000000'
  ]"
                    ></compact-picker>
                </div>

                <div v-if="colors.hex" class="p-2 my-3" :style="{ 'background-color': colors.hex }">
                    <p class="text-center m-0 text-white p-2">Новый цвет ярлыка группы</p>
                </div>

                <div v-else="" class="p-2 my-3" :style="{ 'background-color': editGroupModel.color }">
                    <p class="text-center m-0 p-2" :style="{ 'color': newTextColor }">Новый цвет ярлыка группы</p>
                </div>


                <select class="form-control" @change="changeTextColorValue($event)">
                    <option
                        v-for="item in text_color_array"
                        v-if="editGroupModel.programm_id"
                        :value="item.value"
                        :selected="item.value === editGroupModel.text_color">{{ item.name }}
                    </option>
                </select>

            </form>
        </b-modal>


        <b-modal id="addChildren" centered ok-only title="Выберите ребенка для добавления в группу" @ok="handleOk">
            <dynamic-select :options="children" option-value="id" option-text="child_surname"
                            placeholder="Введите для поиска" v-model="child"/>
        </b-modal>


        <!-- Окно добавления комментария после присвоения статуса не посетил тренировку -->
        <b-modal id="comment" title="Введите комментарий" centered ok-title="Добавить" cancel-title="Отмена"
                 @ok="addComent">
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group label-for="name-input">
                    <b-form-textarea id="textarea" v-model="comment"></b-form-textarea>
                </b-form-group>
            </form>
        </b-modal>

        <!-- Окно добавления нового комментария -->
        <b-modal id="addNewCommentGetModal" title="Добавить комментарий" centered ok-title="Добавить"
                 cancel-title="Отмена" @ok="addNewComent">
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group label-for="name-input">
                    <b-form-textarea id="textarea" v-model="newComment"></b-form-textarea>
                </b-form-group>
            </form>
        </b-modal>

        <!-- Окно просмотра истории -->
        <b-modal id="showHistory" size="lg" title="История" scrollable centered hide-footer>
            <div class="card-body">
                <p v-if="comments" v-for="comment in comments" :key="comment.id" class="mb-2">
                    {{ comment.date }} - {{ comment.user }} - {{ comment.comment }}
                </p>
            </div>
        </b-modal>

        <!-- Окно с расписанием -->
        <b-modal id="modal-xl" hide-footer @hidden="resetModalXl">
            <div class="row flex-nowrap test">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <dynamic-select
                                v-if="!isAdd"
                                :options="days"
                                option-value="id"
                                option-text="name"
                                @input="daySelect"
                                class="mb-4"
                                v-model="selectDayInModalXl"
                                placeholder="День недели"/>

                            <div class="card card-sm mb-2"
                                 v-for="(schedul, index) in schedule"
                                 :key="index"
                                 :style="{ 'background-color': schedul.group.color}">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md">
                                            <div class="container">
                                                <div class="row" :style="{ 'color':  schedul.group.text_color }">
                                                    <div class="col-md-2">
                                                        <span>{{
                                                                schedul.time
                                                            }}:{{ resultMinute(schedul.minute) }}</span>
                                                    </div>
                                                    <div class="col-md-4">{{ schedul.group.name }}</div>

                                                    <div class="col-md-4">{{ schedul.group.programm.name }}</div>

                                                    <div class="col-md-1">
                                                        <b-badge pill variant="primary">{{
                                                                schedul.children_count
                                                            }}
                                                        </b-badge>
                                                    </div>
                                                    <div class="col-md-1" v-if="gates.journal_chart_delete">
                                                        <a href="#" @click.prevent="deleteSchedule(schedul.id)">
                                                            <i class="fe fe-trash-2 text-danger ml-1 mr-3"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" v-if="isAdd">
                                <div class="row align-items-center">
                                    <div class="col-3 col-md">
                                        <dynamic-select
                                            class="pb-2"
                                            :options="GroupInHall"
                                            option-value="id"
                                            option-text="name"
                                            v-model="GroupModel"
                                            placeholder="Выберите группу"/>

                                        <dynamic-select
                                            class="pb-2"
                                            :options="categoryTime"
                                            option-value="id"
                                            option-text="name"
                                            v-model="categoryTimeModel"
                                            placeholder="Выберите категорию времени"/>

                                        <dynamic-select
                                            class="pb-2"
                                            :options="times"
                                            option-value="id"
                                            option-text="name"
                                            v-model="TimeModel"
                                            placeholder="Выберите часы"/>

                                        <dynamic-select
                                            class="pb-2"
                                            :options="min"
                                            option-value="id"
                                            option-text="name"
                                            v-model="TimeMinuteModel"
                                            placeholder="Выберите минуты"/>

                                        <b-button size="sm" variant="success" class="mt-2" @click="saveSchedule">
                                            Сохранить
                                        </b-button>
                                        <b-button size="sm" variant="danger" class="mt-2" @click="cancelSchedule">
                                            Отменить
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                            <b-button v-if="!isAdd && selectDayInModalXl && gates.journal_chart_add" size="sm"
                                      variant="primary" class="mt-2" @click="addSchedule">Добавить
                            </b-button>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>


        <div class="row">
            <div class="col-12">
                <!--        <div class="card">-->
                <!--            <div class="card-body">-->
                <!--                <date-picker-->
                <!--                    v-model="calendar"-->
                <!--                    :editable="false"-->
                <!--                    value-type="YYYY,MM,DD"-->
                <!--                    format="DD.MM.YYYY"-->
                <!--                    @change="changeSelect">-->
                <!--                </date-picker>-->
                <!--            </div>-->
                <!--        </div>-->
                <div class="card" @contextmenu.prevent="$refs.menu.open">
                    <div class="card-body">
                        <table class="table table-bordered datatable datatable-User table-collection">
                            <tbody>
                            <tr>
                                <td class="pt-2 pb-2 col-3 text-center h3">
                                    <i @click="countDown" class="float-left pl-4 pointer fe fe-chevrons-left mr-3"></i>
                                    {{ this.monthNames[this.month - 1] }}, {{ this.year }}
                                    <i @click="countUp" class="float-right pr-4 pointer fe fe-chevrons-right ml-3"></i>
                                </td>

                                <td @click="changeSelect(n, $event), active = index"
                                    v-for="(n, index) in dates"
                                    :class="[index + 1 == date && month == new Date().getMonth() + 1 ? 'bg-success text-white' : 'white', index === active ? 'bg-primary text-white' : 'white']"
                                    :style="[n.getDay() === 0 || n.getDay() === 6 ? { 'background-color': 'red', color: 'white' } : { color: 'black' },]"
                                    class="pt-2 pb-2 text-center">{{ n.getDate() }}
                                </td>
                            </tr>

                            <tr>
                                <td class="pt-2 pb-2 col-3 text-center h3 text-muted"></td>
                                <td v-for="(n, index) in dates" class="text-muted">{{ getWeekDay(n.getDate()) }}</td>
                            </tr>

                            <template v-for="val in hall.schedule_hall">
                                <tr>
                                    <!--                                    Тут нужно исправить, если кликаешь по добавить в группу то вызывается все равно getUserInGroup-->
                                    <td @click="getUserInGroup(val.group_id)"
                                        :style="{ 'background-color': val.group.color, 'color': val.group.text_color }"
                                        data-toggle="collapse"
                                        :data-target="'#group_' + val.id"
                                        class="accordion-toggle">
                                        {{ val.time }}:{{ resultMinute(val.minute) }} - {{ val.group.name }}
                                        <div class="float-right">
                                            <i class="fe fe-plus"
                                               @click="addChildren(hall.branch_id, val.group.name, val.group_id, val.category_time)"></i>
                                            <i class="fe fe-chevron-down ml-3"></i>
                                        </div>
                                    </td>
                                </tr>

                                <template v-if="getUserInGroupArray" class="collapse" :id="'group_' + val.group_id">
                                    <tr v-if="user.group_id == val.group_id" v-for="(user, index) in computedSelect">
                                        <td @click="BaseModal(user.id)" class="pt-2 pb-2 col-3"
                                            :id="'tooltip-target-1' + user.id">
                                            <span class="ml-3">{{ index + 1 }}.</span>
                                            <span class="ml-3">{{ user.surname }}</span>
                                            <span class="ml-1">{{ user.name }}</span>
                                            <b-tooltip :target="'tooltip-target-1' + user.id" triggers="hover"
                                                       placement="left">
                                                <b-avatar :src="siteURL + user.avatar" size="6rem"></b-avatar>
                                                <br>
                                                <p class="text-center font-weight-bold">{{ user.parent_type }}</p>
                                                <span class="ml-3">{{ user.parent_surname }}</span>
                                                <span class="ml-1">{{ user.parent_name }}</span>
                                                <p class="ml-1 pt-1">{{ user.parent_phone }}</p>
                                            </b-tooltip>
                                        </td>
                                        <td v-for="(n, index) in daysInMonth"
                                            @click.right="alerts(index +1, user.id, user.journal[n])"
                                            class="pt-2 pb-2 text-center border-left-0 border-white"
                                            :class="index === active ? 'white' : 'grey'">
                                            <i v-if="user.journal[n]" :class="user.journal[n]"></i>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import Vue from 'vue';
import {VueContext} from 'vue-context';
import 'vue-context/src/sass/vue-context.scss';

import {Slider, Compact} from 'vue-color'

var colors = {
    hsl: {h: 182.66009852216752, s: 0.5, l: 0.5, a: 1},
    hsv: {h: 182.66009852216752, s: 0.66, v: 0.75, a: 1},
    rgba: {r: 25, g: 77, b: 51, a: 1},
    a: 1
}

export default {
    components: {
        VueContext,
        'slider-picker': Slider,
        'compact-picker': Compact,
    },
    data() {
        return {
            gates: [],
            text_color: '',
            colors,
            selectedUsers: [],
            monthNames: [
                "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
                "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
            ],

            text_color_array: [
                {id: 1, value: '#ffffff', name: 'Белый'},
                {id: 2, value: '#000000', name: 'Черный'},
            ],

            times: [
                {id: 8, name: "8"},
                {id: 9, name: "9"},
                {id: 10, name: "10"},
                {id: 11, name: "11"},
                {id: 12, name: "12"},
                {id: 13, name: "13"},
                {id: 14, name: "14"},
                {id: 15, name: "15"},
                {id: 16, name: "16"},
                {id: 17, name: "17"},
                {id: 18, name: "18"},
                {id: 19, name: "19"},
                {id: 20, name: "20"},
                {id: 21, name: "21"},
                {id: 22, name: "22"},
            ],

            days: [
                {id: 1, name: "Понедельник"},
                {id: 2, name: "Вторник"},
                {id: 3, name: "Среда"},
                {id: 4, name: "Четверг"},
                {id: 5, name: "Пятница"},
                {id: 6, name: "Суббота"},
                {id: 7, name: "Воскресенье"},
            ],

            categoryTime: [
                {id: 1, name: "1"},
                {id: 2, name: "2"},
                {id: 3, name: "3"},
                {id: 4, name: "4"},
                {id: 5, name: "5"},
            ],

            programms: [],
            gr: '',
            txt_color: '',
            selected: '',

            time: [
                "1", "2", "3", "4"
            ],
            siteURL: "http://83.220.172.19/",
            halls: [],
            children: [],
            child: '',
            hall: {
                schedule_hall: {},
                programm: {},
            },
            schedule: [],
            getUserInGroupArray: [],
            namegroup: '',
            programm_id: '',
            group_id: '',
            category_time: '',
            dataVm: '',
            n: 8,
            year: '',
            month: '',
            date: '',
            activeGroup_id: '',
            calendar: '',
            row: null,
            rowid: null,
            comment: '',
            newComment: '',
            name: '',
            nameState: null,
            programmState: null,
            hall_id: '',
            submittedNames: [],
            programmForGroup: '',
            DaySelect: '',
            categoryTimeModel: '',
            TimeModel: '',
            TimeMinuteModel: '',
            GroupModel: '',
            ProgrammModel: '',
            timeCurrent: '',
            isAdd: false,
            activeDay2: false,
            editGroupModel: '',
            editGroupModelArray: [],
            selectDayInModalXl: '',
            active: null,
            comments: null,
            group_pk: '',
        }
    },

    created() {

        axios.get('api/v2/getGates')
            .then(response => this.gates = response.data)

        this.getHalls();

        // Получаем глобально значение дня, месяца и года
        var D = new Date();
        this.month = D.getMonth() + 1;
        this.year = D.getFullYear();
        this.date = D.getDate();
        this.dateDay = D.getDay();
        this.calendar = D.getFullYear() + ',' + ('0' + (D.getMonth() + 1)).slice(-2) + ',' + ('0' + D.getDate()).slice(-2)
    },

    computed: {

        computedSelect() {
            return this.getUserInGroupArray.reduce((res, item) => {
                const tempItem = {
                    id: item.id,
                    name: item.child_name,
                    surname: item.child_surname,
                    avatar: item.avatar,
                    parent_surname: item.parent_surname,
                    parent_name: item.parent_name,
                    parent_type: item.parent_type,
                    parent_phone: item.parent_phone,
                    group_id: item.group_id,
                    year: item.year,
                    journal: {}
                }

                tempItem.journal = item.journal.reduce((carry, {day, icon}) => {
                    carry[day] = icon;
                    return carry;
                }, {});
                res.push(tempItem)
                return res;
            }, []);

        },

        min() {
            return new Array(60).fill(0)
                .map((_, idx) => ({id: idx, name: `${idx}`.padStart(2, 0)}))
        },

        // Получаем количество дней в месяце
        daysInMonth(month, year) {
            return new Date(this.year, this.month, 0).getDate();
        },

        dates() {
            return new Array(this.daysInMonth).fill(1).map((_, index) => new Date(this.year, this.month - 1, index + 1))
        },

        newTextColor() {
            return this.txt_color ? this.txt_color : this.editGroupModel.text_color
        }

    },

    methods: {

        resultMinute(minute) {

            var str = minute.toString()

            if (minute == 0) {
                return '00'
            } else if (str.length == 1) {
                return '0' + minute
            }
            return str
        },

        changeProgrammValue(event) {
            this.gr = event.target.value
        },

        changeTextColorValue(event) {
            this.txt_color = event.target.value
        },

        BaseModal(id) {
            this.$refs.showmoda.showModa(id)
        },

        getHistory() {
            axios.post('api/v2/showHistory', {base_id: this.rowid}).then(response => this.comments = response.data.data)
        },

        // Получаем сокращеное название дня по дате
        getWeekDay(day) {
            var date = new Date(this.year, this.month - 1, day);
            var day = date.getDay();
            var days = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
            return days[day];
        },

        activeTime(curr) {
            this.timeCurrent = curr
        },

        deleteSchedule(id) {
            // this.$alert("Вы уверены что хотите удалить группу из расписания ?")

            axios.post('api/v2/deleteSchedule', {
                id: id,
            })

            this.schedule = this.schedule.filter(item => item.id != id);

            return this.schedule
        },

        addSchedule() {
            this.isAdd = true
        },

        cancelSchedule() {
            this.isAdd = false
            this.categoryTimeModel = ''
            this.GroupModel = ''
            this.TimeModel = ''
            this.ProgrammModel = ''
        },

        /*
            Сохраняем новое расписание , получаем новый массив рассписания и очищаем данные
         */
        saveSchedule() {

            if (!this.categoryTimeModel.id || !this.GroupModel.id) {
                this.$alert("Группа и категория времени обязательна для заполнения")
                return null
            }

            axios.post('api/v2/saveSchedule', {
                hall_id: this.hall_id,
                day: this.selectDayInModalXl.id,
                time: this.TimeModel.id,
                minute: this.TimeMinuteModel.id,
                category_time: this.categoryTimeModel.id,
                group_id: this.GroupModel.id
            })
                .then(response => this.schedule = response.data.data)

            this.isAdd = false
            this.categoryTimeModel = ''
            this.GroupModel = ''
            this.TimeModel = ''
            this.TimeMinuteModel = ''
            this.ProgrammModel = ''
        },

        checkFormValidity() {
            const valid = this.$refs.formSettingsGroup.checkValidity()
            this.nameState = valid
            return valid
        },

        resetSettingsGroup() {
            this.name = ''
            this.programmForGroup = ''
            this.nameState = null
            this.programmState = null
            this.text_color = ''
        },

        OkSettingsGroup(bvModalEvt) {
            bvModalEvt.preventDefault()
            this.handleSubmit()
        },

        handleSubmit() {

            if (!this.checkFormValidity()) {
                return
            }

            this.submittedNames.push(this.name)

            this.$nextTick(() => {

                if (!this.programmForGroup) {
                    Vue.$toast.open({
                        message: 'Не выбрана программа',
                        type: 'error',
                        duration: 5000,
                        position: 'top-right'
                    })
                    return null
                }

                if (!this.colors.hex) {
                    Vue.$toast.open({
                        message: 'Не выбран цвет программы',
                        type: 'error',
                        duration: 5000,
                        position: 'top-right'
                    })
                    return null
                }

                axios.post('api/v2/journal_groups', {
                    hall_id: this.hall_id,
                    name: this.name,
                    programm_id: this.programmForGroup.id,
                    color: this.colors.hex,
                    text_color: this.text_color.value,
                })

                this.$bvModal.hide('settingsGroup')
                Vue.$toast.open({
                    message: 'Группа успешно добавлена',
                    type: 'success',
                    duration: 5000,
                    position: 'top-right'
                });

            })
        },

        /*
            Запрос на оасписания из выбора дня недели
         */
        daySelect() {
            this.activeDay2 = true
            axios.post('api/v2/schedule', {
                hall_id: this.hall_id,
                day: this.selectDayInModalXl.id
            })
                .then(response => this.schedule = response.data.data)
        },

        /*
            Очищаем массив schedule , v-modal выбора дня недели, статус кнопки добавления нового рассписания и статус activeDay2 - статус выбраного дня и v-model группы, программы, категории времени и обновляем список групп, мало ли что то добавилось а мы не знаем
         */
        resetModalXl() {
            this.schedule = []
            this.selectDayInModalXl = ''
            this.isAdd = false
            this.activeDay2 = false
            this.categoryTimeModel = ''
            this.GroupModel = ''
            this.ProgrammModel = ''

            this.getHallAtributes(this.hall_id, this.calendar)
        },


        /*
            Списания тернировки
         */
        workout() {

            var D = new Date();

            // Если дата меньше текущей возвращаем null
            // Ниже было до изменение в трелло
            // if ( (this.row < D.getDate() && this.month <= D.getMonth() + 1) || this.month < D.getMonth() + 1) {


            // Раскоментировать код ниже если нужно вернуть запрет на проставлении тренировки задним числом
            // if ( this.row == D.getDate() && this.month == D.getMonth() + 1 ){

            axios.post('api/v2/workout', {
                base_id: this.rowid,
                day: this.row,
                month: this.month,
                year: this.year
            })

                .then((response) => {
                    response.data.response == "success" ? this.getUserInGroup(this.activeGroup_id) : this.$alert(response.data.response)
                });
            // } else {

            // this.$alert("Назначить посещение тренировки раньше или позже текущей даты - невозможно")
            // }


        },

        /*
            Списания заморозки
         */
        freezing() {

            // this.row >= D.getDate() && this.month >= D.getMonth() + 1 ?
            axios.post('api/v2/freezing', {
                base_id: this.rowid,
                day: this.row,
                month: this.month,
                year: this.year
            })
                .then((response) => {
                    response.data.response == "success" ? this.getUserInGroup(this.activeGroup_id) : this.$alert(response.data.response)
                })
            // : this.$alert("Выбраная Вами дата меньше текущей");
        },

        /*
            Проверяем совпадает ли текущая дата с выбранной ячейкой, если да то вызываем модальное окно с добавлением комментраия addComent()
         */
        notVisit() {
            // Тут закоментировали проверку на запрет установки статуса Не посетил на любой день кроме текущего
            // var D = new Date();
            // this.row == D.getDate() && this.month == D.getMonth() + 1 ? this.$bvModal.show('comment') : this.$alert("Выбраная Вами дата не совпадает с текущей");
            // Вместо этого тупо пропускаем и вызываем окно
            this.$bvModal.show('comment')
        },

        /*
            Не посетил тренировку
         */
        addComent() {
            if (this.comment) {
                axios.post('api/v2/notVisit', {
                    base_id: this.rowid,
                    day: this.row,
                    month: this.month,
                    year: this.year,
                    comment: this.comment
                })

                    .then((response) => {

                        response.data.response == "success" ? this.getUserInGroup(this.activeGroup_id) : this.$alert(response.data.response)

                    });
                this.comment = ''
            } else {
                this.$alert("Клиент пропустил занятие. Укажите причину");
            }
        },
        /*
            Назначена тренировка
         */
        newWorkout() {
            var D = new Date();

            // Если дата меньше текущей возвращаем null
            if ((this.row < D.getDate() && this.month <= D.getMonth() + 1) || this.month < D.getMonth() + 1) {
                this.$alert("Назначить тренировку раньше текущей даты - невозможно")
                return null
            }

            axios.post('api/v2/newWorkout', {
                base_id: this.rowid,
                day: this.row,
                month: this.month,
                year: this.year
            })
                .then((response) => {
                    // Если в ответе получаем success, то обновляемся, если нет, то выдаем сообщение с ошибкой
                    response.data == "success" ? this.getUserInGroup(this.activeGroup_id) : this.$alert("Ребенок уже посетил/пропустил тренировку. Назначьте пробную тренировку на другое время")

                });
        },

        /*
            Добавляем комментарий
         */
        addNewComent() {

            // Если новый комментарий не пустой, то отправляем, следом очищаем поле комментарий
            if (this.newComment) {
                axios.post('api/v2/addNewComent', {base_id: this.rowid, comment: this.newComment})
                this.getUserInGroup(this.activeGroup_id)
                Vue.$toast.open({
                    message: 'Комментарий успешно добавлен',
                    type: 'success',
                    duration: 1000,
                    position: 'top-right'
                });
                this.newComment = ''
            } else {
                this.$alert("Комментарий не может быть пустым");
            }

        },


        // 	Метод принимает id группы и получает клиентов в этой группе, если группа не пуста то записывает результат в массив, иначе сообщение
        getUserInGroup(group_id) {
            this.activeGroup_id = group_id
            axios.post('api/v2/getuseringroup', {group_id: group_id, year: this.year, month: this.month})

                .then((response) => {
                    response.data != 'error' ? this.getUserInGroupArray = response.data.data :

                        Vue.$toast.open({
                            message: 'Нет клиентов в этой группе',
                            type: 'error',
                            duration: 1000,
                            position: 'top-right'
                        });

                });
        },

        // Метод получает v-model календаря и вызвает getHallAtributes с параметрами текущего активного зала и дня недели
        changeSelect(date, event) {
            // let elem = document.querySelectorAll('td');

            // if( elem.style.backgroundColor == "red") { // что-то нашлось, коллекция не пустая
            //     event.target.style.backgroundColor = "red";
            // }


            // let elements = document.querySelectorAll('td > last-child');
            //
            // for (let elem of elements) {
            //     alert(elem.innerHTML); // "тест", "пройден"
            // }

            // event.target.addClass("testik");
            // event.target.style.backgroundColor = "red";


            this.getHallAtributes(this.hall_id, date)
            this.calendar = date
        },

        // Получаем список существующих залов и при условии наличии узнаем id первого элемента из массива и передаем параметр в метод, вместе с текущей датой
        getHalls() {
            axios.get('api/v2/halls')
                .then(response => this.halls = response.data.data)
            if (this.halls) {
                setTimeout(() => {
                    this.halls ? this.getHallAtributes(this.halls[0].id, this.calendar) : null;
                }, 600)
            }

        },

        // Запускаем эмулятор загрузки, получаем атрибуты зала по его id (убрал эмулятор загрузки)
        getHallAtributes(hall, day) {
            var D = new Date(day);

            this.hall_id = hall

            // let loader = this.$loading.show({
            //     container: this.fullPage ? null : this.$refs.formContainer,
            //     color: '#0080ff',
            // });
            axios.post('api/v2/showhall', {hall_id: hall, day: D.getDay() == 0 ? 7 : D.getDay()})
                .then(response => this.hall = response.data.data)
            setTimeout(() => {
                // loader.hide()
                if (this.hall.schedule_hall.length == 0) {
                    Vue.$toast.open({
                        message: 'Нет занятий на этот день',
                        type: 'info',
                        duration: 1000,
                        position: 'top-right'
                    });
                }
            }, 500)
            this.getUserInGroupArray = ''
        },

        // Открываем модальное окно настройки рассписания зала, получаем группы в текущем зале
        showCalendar(hall) {
            this.$bvModal.show('modal-xl')

            axios.post('api/v2/getGroupInHall', {hall_id: this.hall_id})
                .then(response => this.GroupInHall = response.data)
        },

        // Открываем модальное окно настройки группы, получаем программы в текущем филиале
        settingsGroup(hall) {
            this.$bvModal.show('settingsGroup')
            axios.post('api/v2/showprogramms', {branch_id: this.hall.branch_id})
                .then(response => this.programms = response.data)
        },

        // Открываем модальное окно редактирования группы, получаем программы в текущем филиале
        editGroup(hall) {
            this.$bvModal.show('editGroup')
            axios.post('api/v2/getEditingGroup', {hall_id: this.hall_id})
                .then(response => this.editGroupModelArray = response.data)

            axios.post('api/v2/showprogramms', {branch_id: this.hall.branch_id})
                .then(response => this.programms = response.data)
        },

        resetEditGroup() {
            this.editGroupModel = ''
            this.programmForGroup = ''
            this.gr = ''
            this.txt_color = ''
        },

        OkEditGroup() {
            if (!this.editGroupModel) {
                this.$alert("Не выбрана ни одна группа для изменения");
                return false
            }
            if (!this.editGroupModel.name) {
                this.$alert("Имя группы не может быть пустым");
                return false
            }


            axios.put('api/v2/journal_groups/' + this.editGroupModel.id, {
                name: this.editGroupModel.name,
                color: this.colors.hex ? this.colors.hex : this.editGroupModel.color,
                programm_id: this.gr ? this.gr : this.editGroupModel.programm_id,
                text_color: this.txt_color ? this.txt_color : this.editGroupModel.text_color
            })
            Vue.$toast.open({
                message: 'Группа успешно изменена',
                type: 'success',
                duration: 1000,
                position: 'top-right'
            });

            this.colors.hex = ''
            this.editGroupModel.color = ''
            this.getHallAtributes(this.hall_id, this.calendar)

        },

        handleOk(bvModalEvt) {
            axios.post('api/v2/getPkProgramm', {id: this.group_id})
                .then(response => this.group_pk = response.data)


            setTimeout(() => {
                if (this.child.contracts.length == 0 && this.group_pk != 2) {
                    this.$alert("Нет активных контрактов у ребенка, добавление в группу невозможно").then(() => {
                    });
                    return null
                }

                if (this.child.contracts.length > 1) {
                    this.$alert("у ребенка больше одного активного контракта, обратитесь к администратору").then(() => {
                    });
                    return null
                }

                // if (this.child.contracts[0].category_time != this.category_time) {
                //     this.$alert("Категория времени группы не соответствует категории времени активного контракта").then(() => {});
                //     return null
                // }

                if (this.child.group_id === this.group_id) {
                    this.$alert("Клиент уже состоит в этой группе").then(() => {
                    });
                    return null
                }

                if (this.child.group_id) {
                    this.$confirm("Клиент уже состоит в группе " + this.child.group.name + " вы уверены что хотите переместить в группу " + this.namegroup).then(() => {

                        if (!this.gates.journal_transfer_group) {
                            Vue.$toast.open({
                                message: 'Нет прав для перевода в другую группу',
                                type: 'error',
                                duration: 2000,
                                position: 'top-right'
                            });
                            return null
                        }

                        axios.post('api/v2/saveClientInGroup', {id: this.child.id, group_id: this.group_id})

                        this.getHallAtributes(this.hall_id, this.calendar)

                        Vue.$toast.open({
                            message: 'Клиент успешно добавлен',
                            type: 'success',
                            duration: 1000,
                            position: 'top-right'
                        });
                    });
                    return null
                }

                if (this.child) {
                    axios.post('api/v2/saveClientInGroup', {id: this.child.id, group_id: this.group_id})
                    this.getHallAtributes(this.hall_id, this.calendar)
                    Vue.$toast.open({
                        message: 'Клиент успешно добавлен',
                        type: 'success',
                        duration: 1000,
                        position: 'top-right'
                    });
                }
            }, 200)

        },

        // Принимает id Филиала, имя программы обучения и делает запрос на детей состоящийся в этом филиале
        addChildren(id, name, group_id, category_time) {
            this.namegroup = name
            this.group_id = group_id
            this.category_time = category_time

            axios.post('api/v2/addClientInGroup', {id: id})
                .then(response => this.children = response.data.data)

            this.$bvModal.show('addChildren')
        },

        alerts(row, id, selectedDays) {
            this.row = row
            this.rowid = id
        },

        countUp: function () {
            this.month += 1

            if (this.month > 12) {
                this.month = 1
                this.year++
            }

            this.getUserInGroup(this.activeGroup_id)

        },

        countDown: function () {
            this.month -= 1

            if (this.month < 1) {
                this.month = 12
                this.year--
            }

            this.getUserInGroup(this.activeGroup_id)
        },

    }
}

// getHallAtributes - Принимает id зала и делает запрос на получение программ обучения и всех основных данных
// showCalendar - Принимает id зала и отображает модальное окно с настройками расписания зала (shedule_hall)
</script>


<style scoped>

.vc-compact {
    width: 305px;
}

.test {
    min-height: 500px;
}

.pointer {
    cursor: pointer;
}

.table td, .table th {
    padding: 10px;
    font-size: 14px;
}

.halls {
    overflow-x: auto;
}

.save, .close {
    font-size: 40px;
    margin: 5px;
    float: right;
    color: gray;
}

.save:hover, .close:hover, .days:hover {
    cursor: pointer;
    transition: all .35s ease;
}

.save:hover {
    color: black;
}

.close:hover {
    color: red;
}

.rspn {
    width: 100%;
    text-align: left;
    border-spacing: 0;
}

.rspn td, .rspn th {
    padding: 10px 0px 5px 5px;
}

.days {
    color: gray;
}

.days:hover {
    color: black;
    text-decoration: underline;
}

.program, .timecat {
    border-radius: 5px;
    font-size: 12px;
    font-family: arial;
}

.time {
    border-left: 2px solid gray;
}

td.grey {
    background-color: #f8f9fa
}

td:hover {
    background-color: white;
}

.danger {
    background-color: red;
    color: white;
}

ul.sub-menu {
    position: absolute;
    background: #fff;
    z-index: 1000;
    border: solid 1px #d5e1e4;
    border-radius: 4px;
    background-color: #fff;
    -webkit-box-shadow: 0 18px 20px rgba(72, 93, 99, 0.3);
    box-shadow: 0 18px 20px rgba(72, 93, 99, 0.3);
    padding: 8px 0;
}

ul.sub-menu li {
    display: block;
}

ul.sub-menu li {
    font-size: 16px;
}

ul.sub-menu li a {
    display: block;
    padding: 6px 11px;
    color: #3d3d3d;
    font-weight: bold;
}

ul.sub-menu li a:hover {
    background-color: #f8f9fa
}


.v-context, .v-context ul {
    font-size: 14px
}

.v-context > li > a, .v-context ul > li > a {
    padding: 3px 8px
}

.modal-body {
    padding-bottom: 0
}

.active {
    border-color: red
}

.wihgt_col {
    padding: 0;
    width: 35px;
    height: 35px;
}

</style>
