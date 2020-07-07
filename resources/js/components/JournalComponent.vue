<template>
  <div>


									<!-- {{ sheduling.map(index_day => index_day.find(i => i.id === 8)) }} -->

									<!-- {{ sheduling[index_day].find( e => e.id === curr) }} -->



											<!-- {{ sheduling[1].find(item => item.id === curr) }} -->

<!-- 											<p>Hall id: {{ hall_id }}</p>
											<p>Day: {{ index_day + 1 }}</p>
											<p>Time: {{ curr }}</p> -->


<!-- <pre><code>{{ sheduling[0] }}</code></pre> -->
<!-- <pre v-if="getUserInGroupArray"><code>{{ computedSelect }}</code></pre> -->
<!-- <span v-if="schedule"><pre><code>{{ schedule.find(item => item.time === 8) }}</code></pre></span> -->
<!-- {{ sheduling[0].map(a => a.find(i => i.id === 8)) }} -->

<!-- <p v-if="sheduling[0].find(item => item.id === 9)">{{ sheduling[0].find(item => item.id === 9).id }}</p> -->

<!-- <pre><code>{{ sheduling1 }}</code></pre> -->


<button class="btn btn-success" @click="redirect">REDIRECT</button>

<vue-context ref="menu">
        <li><a href="#" @click.prevent="workout()"><i class="fe fe-check text-success ml-1 mr-3"></i>Занятие</a></li>
        <li><a href="#" @click.prevent="freezing()"><i class="fe fe-sun text-primary ml-1 mr-3"></i>Заморозка</a></li>
        <li><a href="#" @click.prevent="notVisit()"><i class="fe fe-x text-danger ml-1 mr-3"></i>Пропустил занятие</a></li>
        <li><a href="#" @click.prevent="newWorkout()"><i class="fe fe-alert-circle text-warning ml-1 mr-3"></i>Тренировка</a></li>
        <li><a href="#" v-b-modal="'addNewCommentGetModal'"><i class="fe fe-message-circle text-primary ml-1 mr-3"></i>Комментарий</a></li>
</vue-context>

<div class="row flex-nowrap halls">
    <div v-if="halls" v-for="hall in halls" class="col-3 col-lg-3">
        <div class="card" :class="hall_id == hall.id ? 'border border-success' : 'not-active'">
            <div class="card-body">
                <a href="#" @click.prevent="getHallAtributes(hall.id, calendar)">{{ hall.name }}</a>
                <span class="badge badge-primary ml-3 mb-2">5</span>
                <i v-if="hall_id == hall.id" @click="showCalendar(hall.id)" class="pointer fe fe-calendar h2 ml-3 mb-0 text-muted"></i>
                <i v-if="hall_id == hall.id" @click="settingsGroup(hall.id)" class="pointer fe fe-users h2 ml-3 mb-0 text-muted"></i>
            </div>
        </div>
    </div>
</div>

<b-modal id="settingsGroup" centered ok-only @hidden="resetSettingsGroup" @ok="OkSettingsGroup">
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
          placeholder="Введите для поиска программы" />
        </b-form-group>
      </form>
</b-modal>


<b-modal id="addChildren" centered ok-only title="Выберите ребенка для добавления в группу" @ok="handleOk">
    <dynamic-select :options="children" option-value="id" option-text="child_surname" placeholder="Введите для поиска" v-model="child" />
</b-modal>


<!-- Окно добавления комментария после присвоения статуса не посетил тренировку -->
<b-modal id="comment" title="Введите комментарий" centered ok-title="Добавить" cancel-title="Отмена" @ok="addComent">
    <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group label-for="name-input" invalid-feedback="Name is required">
            <b-form-textarea id="textarea" v-model="comment"></b-form-textarea>
        </b-form-group>
    </form>
</b-modal>

<!-- Окно добавления нового комментария -->
<b-modal id="addNewCommentGetModal" title="Добавить комментарий" centered ok-title="Добавить" cancel-title="Отмена" @ok="addNewComent">
    <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group label-for="name-input" invalid-feedback="Name is required">
            <b-form-textarea id="textarea" v-model="newComment"></b-form-textarea>
        </b-form-group>
    </form>
</b-modal>

<b-modal id="modal-xl" ok-only @hidden="resetModalXl">
    <div class="row flex-nowrap test">
        <div class="col-12 col-lg-12" v-for="(day, index_day) in days">
            <div class="card">
<!--                 <div class="card-header">
                    <div class="row align-items-center">
                        <a href="#" class="col">{{ day }}</a>
                    </div>
                </div> -->
                <div class="card-body">

        <dynamic-select 
		  v-if="!isAdd"
          :options="days2" 
          option-value="id" 
          option-text="name"  
          @input="daySelect"
          class="mb-4"
          v-model="selectDayInModalXl"
          placeholder="День недели" />

                    <div class="card card-sm mb-2" v-for="(curr, index) in 21" v-if="index + 1 >= n">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-3 col-md">
                                    <a v-if="!isAdd && activeDay2" v-b-toggle="'collapse_' + index_day + '_' + index" href="#" @click.prevent="activeTime(curr)" class=" mb-md-0 text-primary">{{ curr }}:00</a>
                                    <span v-if="isAdd || !activeDay2">{{ curr }}:00</span>
                                    <span v-if="schedule.find(item => item.time === curr)">
                                    <span v-if="schedule.find(item => item.time === curr).time === curr " class="text-success ml-3">●</span>
                                    </span>
                                </div>
                            </div>

								<b-collapse :id="'collapse_' + index_day + '_' + index" accordion="my-accordion" class="mt-2">

<!-- 									<dynamic-select 
								      v-show="isAdd"
								      class="pb-2"
							          :options="groups" 
							          option-value="id" 
							          option-text="name"  
							          v-model="ProgrammModel"
							          placeholder="Выберите группу" />
							        </b-form-group> -->

							        <dynamic-select
								      v-if="isAdd"
								      class="pb-2"
							          :options="GroupInHall" 
							          option-value="id" 
							          option-text="name"  
							          v-model="GroupModel"
							          placeholder="Выберите группу" />
							        </b-form-group>

							        <dynamic-select
								      v-if="isAdd"
								      class="pb-2"
							          :options="categoryTime" 
							          option-value="id" 
							          option-text="name"  
							          v-model="categoryTimeModel"
							          placeholder="Выберите категорию времени" />
							        </b-form-group>

									<ul class="list-group" v-if="schedule.find(item => item.time === curr)">
<!-- 										<a href="#" @click.prevent="test" class="list-group-item list-group-item-action pt-3 pb-3">
											<i class="fe fe-users text-primary text-bold mr-3"></i>
											{{ schedule.find(item => item.time === curr).total_children }}
										</a> -->
										<a href="#" class="list-group-item list-group-item-action pt-3 pb-3">
											<i class="fe fe-users text-danger text-bold mr-3"></i>
											{{ schedule.find(item => item.time === curr).group.name }}
										</a>
										<a href="#" class="list-group-item list-group-item-action pt-3 pb-3">
											<i class="fe fe-clock text-success text-bold mr-3"></i>
											{{ schedule.find(item => item.time === curr).category_time }}
										</a>
									</ul>

	<!-- <b-button v-if="schedule.find(item => item.time === curr)" size="sm" variant="warning" class="mt-2">Редактировать</b-button> -->
	<b-button v-if="schedule.find(item => item.time === curr)" size="sm" variant="danger" class="mt-2" @click="deleteSchedule">Удалить</b-button>
	<b-button v-if="!schedule.find(item => item.time === curr)" size="sm" variant="primary" class="mt-2" @click="addSchedule">Добавить</b-button>
	<b-button v-if="isAdd" size="sm" variant="success" class="mt-2" @click="saveSchedule">Сохранить</b-button>
	<b-button v-if="isAdd" size="sm" variant="danger" class="mt-2" @click="cancelSchedule">Отменить</b-button>


								</b-collapse>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</b-modal>



<div class="row">
    <div class="col-12">
    	<div class="card">
    		<div class="card-body">
    			    <date-picker 
                      v-model="calendar" 
                      :editable="false" 
                      value-type="YYYY,MM,DD" 
                      format="DD.MM.YYYY"
                      @change="changeSelect">
                    </date-picker>
    		</div>
    	</div>
        <div class="card" @contextmenu.prevent="$refs.menu.open">
            <div class="card-body">
                <table class="table table-bordered datatable datatable-User table-collection">
                    <tbody>
                        <tr>
                            <td class="pt-2 pb-2 col-3 text-center h3">
                            	<!-- <i @click="countDown" class="pointer fe fe-chevrons-left mr-3 text-muted"></i> -->
                            	{{ this.monthNames[new Date(this.year, this.month).getMonth() - 1] }}, {{ this.year }}
                            	<!-- <i @click="countUp" class="pointer fe fe-chevrons-right ml-3 text-muted"></i> -->
                            </td>
                            <td  v-for="(n, index) in dates" :class="index + 1 == date && month == new Date().getMonth() + 1 ? 'bg-success text-white' : 'white'" :style="[n.getDay() === 0 || n.getDay() === 6 ? { 'background-color': 'red', color: 'white' } : { color: 'black' },]" class="pt-2 pb-2 text-center">{{ n.getDate() }}
                            </td>
                        </tr>

						<template v-for="val in hall.schedule_hall">
						    <tr>
						        <td @click="getUserInGroup(val.id)" data-toggle="collapse" :data-target="'#group_' + val.id" class="accordion-toggle bg-primary text-white">{{ val.time }}:00 - {{ val.group.name }}
						        <i class="fe fe-plus ml-4" @click="addChildren(hall.branch_id, val.group.name, val.group_id, val.category_time)"></i>
						    </td>
						    </tr>

							<template v-if="getUserInGroupArray" class="collapse" :id="'group_' + val.id">
								<tr v-if="user.group_id == val.id" v-for="(user, index) in computedSelect">
							        <td class="pt-2 pb-2 col-3">
							            <span class="ml-3">{{ index + 1 }}.</span>
							            <span class="ml-3">{{ user.surname }}</span>
							            <span class="ml-1">{{ user.name }}</span>
							        </td>
							        <td v-for="(n, index) in daysInMonth" 
							        @click.right="alerts(index +1, user.id, user.journal[n])" 
							        class="pt-2 pb-2 text-center border-left-0 border-white"
							        :class="index + 1 == date && month == new Date().getMonth() + 1 ? 'white' : 'grey'">
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
import { VueContext } from 'vue-context';
import 'vue-context/src/sass/vue-context.scss';

  export default {
  	components: {
        VueContext
    },
    data() {
    	return {
    		selectedUsers: [],
    		monthNames: [
	    		"Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
	      		"Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
    		],
    		days: [
	    		"Понедельник"
    		],

    		days2: [
	    		{id:1, name: "Понедельник"}, 
	    		{id:2, name: "Вторник"}, 
	    		{id:3, name: "Среда"}, 
	    		{id:4, name: "Четверг"}, 
	    		{id:5, name: "Пятница"}, 
	    		{id:6, name: "Суббота"}, 
	    		{id:7, name: "Воскресенье"}, 
    		],

    		categoryTime: [
	    		{id:1, name: "1"}, 
	    		{id:2, name: "2"}, 
	    		{id:3, name: "3"}, 
	    		{id:4, name: "4"}, 
	    		{id:5, name: "5"}, 
    		],

    		programms: [],

    		time: [
	    		"1", "2", "3", "4"
    		],
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
	        GroupModel: '',
	        ProgrammModel: '',
	        timeCurrent: '',
	        isAdd: false,
	        activeDay2: false,
    	}
    },

	  created() {
	  	// document.addEventListener('keydown', this.onKeyDown)

	  	this.getHalls();


	  	// Получаем глобально значение дня, месяца и года
		var D = new Date();
	  	this.month = D.getMonth() + 1;
	  	this.year = D.getFullYear();
	  	this.date = D.getDate();
	  	this.dateDay = D.getDay();
	  	this.calendar =  D.getFullYear() + ',' + ('0' + (D.getMonth() + 1)).slice(-2) + ',' + ('0' + D.getDate()).slice(-2) 

	  	// this.getHallAtributes(1);
	  	

	    // this.selectedUsers = this.users.reduce((res, item) => {
	    //   const tempItem = {
	    //     id: item.id,
	    //     name: item.name,
	    //     year: item.year,
	    //     days: {}
	    //   }
	      
	    //   tempItem.days = item.days.reduce((carry, {day, name}) => {
	    //     carry[day] = name;
	    //     return carry;
	    //   }, {});
	    //   res.push(tempItem)
	    //   return res;
	    // }, []);
	    // 
	  },

     computed: {


	computedSelect(){
		return this.getUserInGroupArray.reduce((res, item) => {
	      const tempItem = {
	        id: item.id,
	        name: item.child_name,
	        surname: item.child_surname,
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

    	daysInMonth(month,year) {
    		return new Date(this.year, this.month, 0).getDate();
    	},
    	dates() {
      		return new Array(this.daysInMonth).fill(1).map((_, index) => new Date(this.year, this.month - 1, index + 1))
    	}
     },

    methods: {


	      redirect(){
			axios.get('api/v2/redirect/')
	      },

    	activeTime(curr){
    		this.timeCurrent = curr
    	},

    	deleteSchedule(){
    		axios.post('api/v2/deleteSchedule/', {hall_id: this.hall_id, day: this.selectDayInModalXl.id, time: this.timeCurrent})
			.then(response => this.schedule = response.data.data)
    	},

    	addSchedule(){
    		this.isAdd = true
    	},

    	cancelSchedule(){
    		this.isAdd = false

    		this.categoryTimeModel = ''
	        this.GroupModel = ''
	        this.ProgrammModel = ''
    	},

    	/*
    		Сохраняем новое расписание , получаем новый массив рассписания и очищаем данные
    	 */
    	saveSchedule(){

    		if(!this.categoryTimeModel.id || !this.GroupModel.id){
    			this.$alert("Группа и категория времени обязательна для заполнения")
        		return null
    		}

	        axios.post('api/v2/saveSchedule/', {hall_id: this.hall_id, day: this.selectDayInModalXl.id, time: this.timeCurrent, category_time: this.categoryTimeModel.id, group_id: this.GroupModel.id})
			.then(response => this.schedule = response.data.data)

    		this.isAdd = false
    		this.categoryTimeModel = ''
	        this.GroupModel = ''
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
	          this.$bvModal.hide('settingsGroup')

	          axios.post('api/v2/groups/', {hall_id: this.hall_id, name: this.name, programm_id: this.programmForGroup.id})
	          Vue.$toast.open({message: 'Группа успешно добавлена',type: 'success',duration: 5000,position: 'top-right'});

	        })
	      },

    	/*
    		Запрос на оасписания из выбора дня недели
    	 */
	      daySelect(){
	      	this.activeDay2 = true
			axios.post('api/v2/schedule/', {hall_id: this.hall_id, day: this.selectDayInModalXl.id})
			.then(response => this.schedule = response.data.data)
	      },

	      /*
    		Очищаем массив schedule , v-modal выбора дня недели, статус кнопки добавления нового рассписания и статус activeDay2 - статус выбраного дня и v-model группы, программы, категории времени
    	 */
	      resetModalXl(){
	      	this.schedule = []
	      	this.selectDayInModalXl = ''
	      	this.isAdd = false
	      	this.activeDay2 = false
	      	this.categoryTimeModel = ''
	        this.GroupModel = ''
	        this.ProgrammModel = ''
	      },


    	/*
    		Списания тернировки
    	 */
        workout () {

        	var D = new Date();

        	// Если дата меньше текущей возвращаем null
        	if ( (this.row < D.getDate() && this.month <= D.getMonth() + 1) || this.month < D.getMonth() + 1) {
        		this.$alert("Назначить посещение тренировки раньше текущей даты - не возможно")
        		return null
        	}

            axios.post('api/v2/workout/' , {base_id : this.rowid, day: this.row, month: this.month, year: this.year })
            
			.then((response) => {
				response.data.response == "success" ? this.getHallAtributes(this.hall.id) : this.$alert(response.data.response)
			});
		 
        },

    	/*
    		Списания заморозки
    	 */
        freezing () {
        	var D = new Date();

        	this.row == D.getDate() && this.month == D.getMonth() + 1 ? 
        		axios.post('api/v2/freezing/' , {base_id : this.rowid, day: this.row, month: this.month, year: this.year })
        	.then((response) => {

				response.data.response == "success" ? this.getHallAtributes(this.hall.id) : this.$alert(response.data.response)
				
			})
        	: this.$alert("Выбраная Вами дата не совпадает с текущей");

		    // this.getHallAtributes(this.hall.id);
        },

    	/*
    		Проверяем совпадает ли текущая дата с выбранной ячейкой, если да то вызываем модальное окно с добавлением комментраия addComent()
    	 */
        notVisit () {
        	var D = new Date();
        	this.row == D.getDate() && this.month == D.getMonth() + 1 ? this.$bvModal.show('comment') : this.$alert("Выбраная Вами дата не совпадает с текущей");
        },

        /*
    		Не посетил тренировку
    	 */
    	addComent(){
    		if (this.comment) {    			
	            axios.post('api/v2/notVisit/' , {base_id : this.rowid, day: this.row, month: this.month, year: this.year, comment: this.comment})

			.then((response) => {

				response.data.response == "success" ? this.getHallAtributes(this.hall.id) : this.$alert(response.data.response)

			});
	    		// Очистить поле коментария
    		}else{   			
	    		this.$alert("Клиент пропустил занятие. Укажите причину");
    		}
    	},
    	/*
    		Назначена тренировка
    	 */
        newWorkout () {
        	var D = new Date();

        	// Если дата меньше текущей возвращаем null
        	if ( (this.row < D.getDate() && this.month <= D.getMonth() + 1) || this.month < D.getMonth() + 1) {
        		this.$alert("Назначить тренировку раньше текущей даты - не возможно")
        		return null
        	}

        	axios.post('api/v2/newWorkout/' , {base_id : this.rowid, day: this.row, month: this.month, year: this.year })
		    .then((response) => {

		    // Если в ответе получаем success, то обновляемся, если нет, то выдаем сообщение с ошибкой
			response.data == "success" ? this.getUserInGroup(this.activeGroup_id) : this.$alert("Ребенок уже посетил/пропустил тренировку. Назначьте пробную тренировку на другое время")

			});
        },

         /*
    		Добавляем комментарий
    	 */
        addNewComent(){

        	// Если новый комментарий не пустой, то отправляем
        	if (this.newComment) {
        		axios.post('api/v2/addNewComent/' , {base_id : this.rowid, comment: this.newComment})
        		this.getHallAtributes(this.hall.id);
        		Vue.$toast.open({message: 'Комментарий успешно добавлен',type: 'success',duration: 5000,position: 'top-right'});
        	}else{
	        	this.$alert("Комментарий не может быть пустым");
        	}

        },



    //      /*
    // 		Реализация управления статусами из клавиатуры
    // 	 */
    // 	onKeyDown(e){
		  // if (event.code == 'Digit1' && (event.ctrlKey || event.metaKey)) {

		  //   axios.post('api/v2/updatetest/' , {base_id : this.rowid, day: this.row, icon: 'fe fe-alert-circle text-warning'})
		  //   this.getHallAtributes(this.hall.id);
		  // }
		  // if (event.code == 'Digit2') {
		    
		  //   axios.post('api/v2/updatetest/' , {base_id : this.rowid, day: this.row, icon: 'fe fe-sun text-primary'})
		  //   this.getHallAtributes(this.hall.id);
		  // }
    // 	},
    // 	

    // 	Метод принимает id группы и получает клиентов в этой группе, если группа не пуста то записывает результат в массив, иначе сообщение
    	getUserInGroup(group_id){
    		this.activeGroup_id = group_id
    		axios.post('api/v2/getuseringroup/', {group_id: group_id})

    		.then((response) => {
				response.data != 'error' ? this.getUserInGroupArray = response.data.data : 

				Vue.$toast.open({message: 'Нет клиентов в этой группе' ,type: 'error',duration: 5000,position: 'top-right'});

			});
    	},

    	// Метод получает v-model календаря и вызвает getHallAtributes с параметрами текущего активного зала и дня недели 
    	changeSelect(){

    		this.getHallAtributes(this.hall_id, this.calendar)
    	},

    	// computedUserData(vals) {
	    // 	this.selectedUsers = vals.reduce((res, item) => {
		   //    const tempItem = {
		   //      id: item.id,
		   //      surname: item.child_surname,
		   //      name: item.child_name,
		   //      year: item.age,
		   //      journal: {}
		   //    }
		      
		   //    tempItem.journal = item.journal.reduce((carry, {day, icon}) => {
		   //      carry[day] = icon;
		   //      return carry;
		   //    }, {});
		   //    res.push(tempItem)
		   //    return res;
		   //  }, []);
    	// },

    	// Получаем список существующих залов и при условии наличии узнаем id первого элемента из массива и передаем параметр в метод
    	getHalls() {
    		axios.get('api/v2/halls')
            .then(response => this.halls = response.data.data)
            if (this.halls) {
                setTimeout(() => {
                	this.halls ? this.getHallAtributes(this.halls[0].id) : null;
                },500) 	
            }

    	},

    	// Запускаем эмулятор загрузки, получаем атрибуты зала по его id
    	getHallAtributes(hall, day) {
    		    		var D = new Date(day);

    		this.hall_id = hall
		    let loader = this.$loading.show({
              container: this.fullPage ? null : this.$refs.formContainer,
              color: '#0080ff',
            });
    		axios.post('api/v2/showhall/' , {hall_id: hall, day: D.getDay() == 0 ? 7 :  D.getDay()})
    		.then(response => this.hall = response.data.data)
                setTimeout(() => {
                    loader.hide()
                    },500) 
                this.getUserInGroupArray = ''
    	},

    	// Открываем модальное окно настройки рассписания зала
    	showCalendar(hall) {
    		this.$bvModal.show('modal-xl')

    		axios.post('api/v2/getGroupInHall/' , {hall_id: this.hall_id})
    		.then(response => this.GroupInHall = response.data)
    	},

    	// Открываем модальное окно настройки группы
    	settingsGroup(hall) {
    		this.$bvModal.show('settingsGroup')
    		axios.post('api/v2/showprogramms', {branch_id: this.hall.branch_id})
    		.then(response => this.programms = response.data)
    		// this.halls[0].id
    	},

    	resetModalSettingsGroup(){
    		alert("CLOSING")
    	},

	    handleOk(bvModalEvt) {
			if (this.child.contracts.length == 0) {
					this.$alert("Нет активных контрактов у ребенка, добавление в группу не возможно").then(() => {});
						return null
			}

			if (this.child.contracts.length > 1) {
					this.$alert("у ребенка больше одного активного контракта, обратитесь к администратору").then(() => {});
						return null
			}

			if (this.child.contracts[0].category_time != this.category_time) {
					this.$alert("Категория времени группы не соответствует категории времени активного контракта").then(() => {});
						return null
			}

			if (this.child.group_id === this.group_id) {
					this.$alert("Клиент уже состоит в этой группе").then(() => {});
						return null
			}

	    	if (this.child.group_id) {
	    		this.$confirm("Клиент уже состоит в группе " + this.child.group.name + " вы уверены что хотите переместить в группу " + this.namegroup).then(() => {
	    			axios.post('api/v2/savetest', {id: this.child.id, group_id: this.group_id})
	    			this.getHallAtributes(this.hall_id, this.calendar)
	    			Vue.$toast.open({message: 'Клиент успешно добавлен',type: 'success',duration: 5000,position: 'top-right'});
                });
                return null
	    	}

			if (this.child) {
			    	axios.post('api/v2/savetest', {id: this.child.id, group_id: this.group_id})
	            this.getHallAtributes(this.hall_id, this.calendar)
	            Vue.$toast.open({message: 'Клиент успешно добавлен',type: 'success',duration: 5000,position: 'top-right'});
			}


	    },

    	addChildren(id, name, group_id, category_time) {
    		this.namegroup = name
    		this.group_id = group_id
    		this.category_time = category_time

    		axios.post('api/v2/gettest/' , {id : id})
    		.then(response => this.children = response.data.data)

    		this.$bvModal.show('addChildren')
    	},

    	alerts(row, id, selectedDays) {
    		this.row = row
    		this.rowid = id
			// selectedDays ? alert('Колонка- '+ row + ' Ребенок- ' + id + ' Что то заполненно') : alert('Колонка- '+ row + ' Ребенок- ' + id)
			// axios.post('api/v2/updatetest/' , {base_id : id, day: row, icon: 'fe fe-alert-circle text-warning'})
			// this.getHallAtributes(this.hall.id);
    	},
    	countUp: function(){
          	this.month +=1

          	if (this.month > 12) {
          		this.month = 1
          	}

        },
        countDown: function(){
          	this.month -=1

          	if (this.month < 1) {
          		this.month = 12
          	}
        }
    }
  }

  		// addChildren - Принимает id Филиала, имя программы обучения и делает запрос на детей состоящийся в этом филиале
  		// getHallAtributes - Принимает id зала и делает запрос на получение программ обучения и всех основных данных 
  		// showCalendar - Принимает id зала и отображает модальное окно с настройками расписания зала (shedule_hall)
</script>




<style>

.halls{
	overflow-x: auto;
}

.save, .close{
	font-size: 40px;
	margin: 5px;
	float: right;
	color:gray;
}

.save:hover, .close:hover, .days:hover{
	cursor: pointer;
	transition: all .35s ease;
}

.save:hover {color: black;}

.close:hover{color: red;}

.rspn{
	width: 100%;
	text-align: left; 
	border-spacing: 0;
}

.rspn td, .rspn th{
	padding:10px 0px 5px 5px;
}

.days{
		color: gray;
}

.days:hover{color: black; text-decoration: underline;}

.program, .timecat{
	border-radius: 5px;
	font-size: 12px;
	font-family: arial;
}

.time{
	border-left: 2px solid gray;
}

td.grey{
	background-color: #f8f9fa
}

td:hover{
	background-color: white;
}

.danger{
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


.v-context, .v-context ul{
	font-size: 14px
}

.v-context > li > a, .v-context ul > li > a{
	padding: 3px 8px
}

.modal-body{
	padding-bottom: 0
}

.active{
	border-color: red
}


</style>

<!-- 		<div class="row flex-nowrap test">

			<div v-for="n in 20" class="col-3 col-lg-3">
			    <div class="card">
			        <div class="card-body">
							<select class="program form-control">
					            <option v-for="s in 4" value="value">Значение {{s}}</option>
					        </select>
			        </div>
			    </div>
			</div> -->


<!-- 			<table class="rspn">
			<tr>	
				<th colspan="3"><a class="days">Понедельник</a></th>
				<th colspan="3"><a class="days">Вторник</a></th>
				<th colspan="3"><a class="days">Среда</a></th>
				<th colspan="3"><a class="days">Четверг</a></th>
				<th colspan="3"><a class="days">Пятница</a></th>
				<th colspan="3"><a class="days">Суббота</a></th>
				<th colspan="3"><a class="days">Воскресенье</a></th>
			</tr>
				<tr v-for="(curr, index) in 21" v-if="index + 1 >= n">
					<template v-for="k in 7">
					    <td class="time">{{ curr }}:00</td>
					    <td>
					        <select class="program form-control">
					            <option v-for="s in 4" value="value">Значение {{s}}</option>
					        </select>
					    </td>
					    <td>
					        <select class="timecat form-control">
					            <option v-for="d in 4" value="value">{{d}}</option>
					        </select>
					    </td>
					</template>
				</tr>
			</table> -->
		<!-- </div> -->