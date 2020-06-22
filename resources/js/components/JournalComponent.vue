<template>
  <div>

<!--   	а что если попробывать полностью избавится от интерфейса ? 
1,2,3,4 а на кнопке 5 - комментарий вызвать модалку ? -->

<!--     	@click="activate(n)" :class="{ active : active_el == n }"
    	
    	    activate:function(el){
        this.active_el = el;
    }, -->

    <!-- <date-picker v-model="dataVm" :editable="false" value-type="YYYY-MM-DD" format="DD.MM.YYYY"></date-picker> -->


<p @contextmenu.prevent="$refs.menu.open($event, { foo: 'bar' })">
        Right click on me
    </p>
    
    <vue-context ref="menu">
        <ul slot-scope="child">
            <li @click="onClick($event.target.innerText, child.data)">Option 1</li>
            <li @click="onClick($event.target.innerText, child.data)">Option 2</li>
        </ul>
    </vue-context>

<div class="row flex-nowrap test">
    <div v-if="halls" v-for="hall in halls" class="col-3 col-lg-3">
        <div class="card">
            <div class="card-body">
            	<a href="#" @click.prevent="getHallAtributes(hall.id)">{{ hall.name }}</a> 
				<span class="badge badge-primary ml-3 mb-2">5</span>
				<i @click="showCalendar(hall.id)" class="pointer fe fe-calendar h2 ml-3 mb-0 text-muted"></i>
            </div>
        </div>
    </div>
</div>


  <b-modal id="addChildren" centered ok-only title="Выберите ребенка для добавления в группу" @ok="handleOk">
	<dynamic-select :options="children" option-value="id" option-text="child_surname" placeholder="Введите для поиска" v-model="child" />
  </b-modal>



<!-- <div v-for="val in hall.schedule_hall">
	<span class="bg-primary text-white p-3">{{ val.time }}:00 - {{ val.programm.name }}<span class="col-auto"><i class="fe fe-plus"></i></span></span> -->
<!-- <template v-for="vals in val.programm.children"> -->
	<!-- <pre><code>{{ [vals] }}</code></pre> -->
	<!-- {{ computedUserData([vals]) }} -->
<!-- </template> -->
	<!-- {{ computedUserData(vals.journal) }} -->
	<!-- <pre><code>{{ val.programm.children.journal }}</code></pre> -->
<!-- </div> -->


<!-- <pre><code>{{ halls[0].id }} - {{ month }}</code></pre> -->



<!-- <span class="mb-2">{{ hall.id }}</span> -->


<div>

  <b-modal id="modal-xl" size="xl" ok-only>

  	<div class="row flex-nowrap test">
    <div class="col-4 col-lg-4" v-for="day in days">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">{{ day }}</div>
                </div>
            </div>

            <div class="card-body">
                <div class="card card-sm mb-2" v-for="(curr, index) in 21" v-if="index + 1 >= n">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3 col-md">
                                <b class="mb-md-0 text-primary">{{ curr }}:00</b>
                            </div>
<!-- 					        <b-form-select v-model="programmselect" :options="programms" class="m-2"></b-form-select>
					        <b-form-select v-model="timeselect" :options="time" class="m-2"></b-form-select>
					        <input class="form-control m-2" v-model="groupselect"> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  </b-modal>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered datatable datatable-User table-collection">
                    <tbody>
                        <tr>
                            <td class="pt-2 pb-2 col-3 text-center h3">
                            	<i @click="countDown" class="pointer fe fe-chevrons-left mr-3 text-muted"></i>
                            	{{ this.monthNames[new Date(this.year, this.month).getMonth() - 1] }}, {{ this.year }}
                            	<i @click="countUp" class="pointer fe fe-chevrons-right ml-3 text-muted"></i>
                            </td>
                            <td  v-for="n in dates" :style="[n.getDay() === 0 || n.getDay() === 6 ? { 'background-color': 'red', color: 'white' } : { color: 'black' },]" class="pt-2 pb-2 text-center">{{ n.getDate() }}
                            </td>
                        </tr>

						<template v-for="val in hall.schedule_hall">
						    <tr>
						        <td class="bg-primary text-white">{{ val.time }}:00 - {{ val.programm.name }}
						        <i class="fe fe-plus ml-4" @click="addChildren(hall.branch_id, val.programm.name, val.programm_id,val.category_time)"></i>
						    </td>
						    </tr>
						    <template v-for="vals in val.programm.children">
								{{ computedUserData([vals]) }}
								<tr v-for="user in selectedUsers" :key="user.id">
							        <td class="pt-2 pb-2 col-3">
							            <span class="ml-3">{{ user.surname }}</span>
							            <span class="ml-1">{{ user.name }}</span>
							            <span class="ml-4">{{ user.year }}</span>
							        </td>
							        <td v-for="(n, index) in daysInMonth" @click="alerts(index +1, user.id, user.journal[n])" class="pt-2 pb-2 text-center order-left-0 border-white grey">
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


<!-- <ul class="sub-menu">
    <li>
        <a href="javascript:void(0)"><i class="fe fe-check text-success"></i></a>
        <a href="javascript:void(0)"><i class="fe fe-x text-danger"></i></a>
        <a href="javascript:void(0)"><i class="fe fe-sun text-primary"></i></a>
        <a href="javascript:void(0)"><i class="fe fe-alert-circle text-warning"></i></a>
    </li>
</ul> -->


  </div>
</template>

<script>

import Vue from 'vue';
import { VueContext } from 'vue-context';

  export default {
  	    components: {
        VueContext
    },
    data() {
    	return {
    		selectedUsers: [],
    		        options: [
          { value: 'A', text: 'Option A (from options prop)' },
          { value: 'B', text: 'Option B (from options prop)' }
        ],
    		monthNames: [
	    		"Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
	      		"Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
    		],
    		days: [
	    		"Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"
    		],

    		programms: [
	    		"Зирка Лева", "Вперед до зирок", "Мастер команды"
    		],

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
            namegroup: '',
            programm_id: '',
            category_time: '',
            dataVm: '',
    		n: 8,
    		year: 2020,
    		month: 6,
    		row: null,
    		rowid: null,
    	}
    },

	  created() {
	  	document.addEventListener('keydown', this.onKeyDown)

	  	this.getHalls();
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
	  },

     computed: {
    	daysInMonth(month,year) {
    		return new Date(this.year, this.month, 0).getDate();
    	},
    	dates() {
      		return new Array(this.daysInMonth).fill(1).map((_, index) => new Date(this.year, this.month - 1, index + 1))
    	}
     },

    methods: {
    	        onClick (text, data) {
            alert(`You clicked ${text}!`);
            console.log(data);
            // => { foo: 'bar' }
        },
    	onKeyDown(e){
		  if (event.code == 'Digit1' && (event.ctrlKey || event.metaKey)) {

		    axios.post('api/v2/updatetest/' , {base_id : this.rowid, day: this.row, icon: 'fe fe-alert-circle text-warning'})
		    this.getHallAtributes(this.hall.id);
		  }
		  if (event.code == 'Digit2') {
		    
		    axios.post('api/v2/updatetest/' , {base_id : this.rowid, day: this.row, icon: 'fe fe-sun text-primary'})
		    this.getHallAtributes(this.hall.id);
		  }
    	},
    	computedUserData(vals) {
	    	this.selectedUsers = vals.reduce((res, item) => {
		      const tempItem = {
		        id: item.id,
		        surname: item.child_surname,
		        name: item.child_name,
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
    	getHallAtributes(hall) {
		    let loader = this.$loading.show({
              container: this.fullPage ? null : this.$refs.formContainer,
              color: '#0080ff',
            });
    		axios.get('api/v2/halls/' + hall)
    		.then(response => this.hall = response.data.data)
                setTimeout(() => {
                    loader.hide()
                    },500) 
    	},

    	// Открываем модальное окно настройки рассписания зала
    	showCalendar(hall) {
    		this.$bvModal.show('modal-xl')
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

			if (this.child.programm_id === this.programm_id) {
					this.$alert("Ребенок уже состоит в этой группе").then(() => {});
						return null
			}

	    	if (this.child.programm_id) {
	    		this.$confirm("Ребенок уже состоит в группе " + this.child.programm.name + " вы уверены что хотите переместить в группу " + this.namegroup).then(() => {
	    			axios.post('api/v2/savetest', {id: this.child.id, programm_id: this.programm_id})
	    			this.getHallAtributes(this.hall.id);
	    			Vue.$toast.open({message: 'Ребенок успешно добавлен',type: 'success',duration: 5000,position: 'top-right'});
                });
                return null
	    	}

			if (this.child) {
			    	axios.post('api/v2/savetest', {id: this.child.id, programm_id: this.programm_id})
	            this.getHallAtributes(this.hall.branch_id);
	            Vue.$toast.open({message: 'Ребенок успешно добавлен',type: 'success',duration: 5000,position: 'top-right'});
			}


	    },

    	addChildren(id, name, programm_id, category_time) {
    		this.namegroup = name
    		this.programm_id = programm_id
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
        },
        countDown: function(){
          	this.month -=1
        }
    }
  }

  		// addChildren - Принимает id Филиала, имя программы обучения и делает запрос на детей состоящийся в этом филиале
  		// getHallAtributes - Принимает id зала и делает запрос на получение программ обучения и всех основных данных 
  		// showCalendar - Принимает id зала и отображает модальное окно с настройками расписания зала (shedule_hall)
</script>




<style>

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