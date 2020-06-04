<template>
  <div>

<div class="row flex-nowrap test">
    <div v-for="zal in zals" class="col-4 col-lg-4">
        <div class="card">
            <div class="card-body">
            	{{ zal.name }} 
				<span class="badge badge-primary ml-3 mb-2">{{ zal.notification }}</span>
				<i @click="showCalendar" class="pointer fe fe-calendar h2 ml-3 mb-0 text-muted"></i>
            </div>
        </div>
    </div>
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
                        <tr>
                            <td class="bg-primary text-white">11:00 - Зирка лева</td>
                        </tr>

						<tr v-for="user in selectedUsers">
						    <td class="pt-2 pb-2 col-3">
						        <span class="ml-3">{{ user.name }}</span>
						        <span class="ml-4">{{ user.year }}</span>
						    </td>
						    <td v-for="(n, index) in daysInMonth" @click="alerts(index +1, user.id, user.days[n])" class="pt-2 pb-2 text-center order-left-0 border-white grey">
						    	<i v-if="user.days[n]" :class="user.days[n]"></i>
						        <!-- {{user.days[n] ? user.days[n] : ''}} -->
						    </td>
						</tr>
                        <tr>
                            <td class="bg-success text-white">12:00 - Зирка лева</td>
                        </tr>
                        <tr>
                            <td class="bg-danger text-white">13:00 - Зирка лева</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<ul class="sub-menu">
    <li>
        <a href="javascript:void(0)"><i class="fe fe-check text-success"></i></a>
        <a href="javascript:void(0)"><i class="fe fe-x text-danger"></i></a>
        <a href="javascript:void(0)"><i class="fe fe-sun text-primary"></i></a>
        <a href="javascript:void(0)"><i class="fe fe-alert-circle text-warning"></i></a>
    </li>
</ul>

<!-- <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/jurnal.css">


<i class="fa fa-times close"></i>
<i class="fa fa-floppy-o save"></i>

<table class="rspn">
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
		        <select class="program">
		            <option v-for="s in 4" value="value">Значение {{s}}</option>
		        </select>
		    </td>
		    <td>
		        <select class="timecat">
		            <option v-for="d in 4" value="value">{{d}}</option>
		        </select>
		    </td>
		</template>
	</tr>
</table>
 -->


  </div>
</template>

<script>

  export default {
    data() {
    	return {
    		selectedUsers: [],
			users: [
			      {
			        "id": "45",
			        "name": "Соколовская Оксана",
			        "year": "4.6",
			         days: [
			            {
			              "day": "8",
			              "name": "fe fe-sun text-primary",
			            },
			            {
			              "day": "11",
			              "name": "fe fe-x text-danger",
			            },
			            {
			              "day": "19",
			              "name": "fe fe-sun text-primary",
			            },
			         ],
			      },
			      {
			        "id": "22",
			        "name": "Давидов Максим",
			        "year": "11.6",
			         days: [
			            {
			              "day": "12",
			              "name": "fe fe-x text-danger",
			            },
			            {
			              "day": "18",
			              "name": "fe fe-sun text-primary",
			            },
			            {
			              "day": "3",
			              "name": "fe fe-alert-circle text-warning",
			            },
			         ],
			      },
			      {
			        "id": "39",
			        "name": "Козлов Вячеслав",
			        "year": "8.8",
			         days: [
			            {
			              "day": "6",
			              "name": "fe fe-sun text-primary",
			            },
			            {
			              "day": "21",
			              "name": "fe fe-alert-circle text-warning",
			            },
			            {
			              "day": "30",
			              "name": "fe fe-sun text-primary",
			            },
			         ],
			      },
			    ],
    		monthNames: [
	    		"Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
	      		"Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
    		],
    		zals: [
                {id: '45', name: 'Большой зал', notification: '10'}, 
                {id: '14', name: 'Средний зал', notification: '12'}, 
                {id: '11', name: 'Малый зал', notification: '3'},
            ],
    		// children: [
      //           {id: '12', name: 'Соколовская Шлюха', year: '4,6'}, 
      //           {id: '22', name: 'Давидов Максим', year: '12,8'}, 
      //           {id: '39', name: 'Козлов Вячеслав', year: '3,3'},
      //       ],
    		n: 8,
    		year: 2020,
    		month: 6,
    	}
    },

	  created() {
	    this.selectedUsers = this.users.reduce((res, item) => {
	      const tempItem = {
	        id: item.id,
	        name: item.name,
	        year: item.year,
	        days: {}
	      }
	      
	      tempItem.days = item.days.reduce((carry, {day, name}) => {
	        carry[day] = name;
	        return carry;
	      }, {});
	      res.push(tempItem)
	      return res;
	    }, []);
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
    	showCalendar() {
			alert('Рассписание программ обучения ')
    	},

    	alerts(row, id, selectedDays) {
			selectedDays ? alert('Колонка- '+ row + ' Ребенок- ' + id + ' Что то заполненно') : alert('Колонка- '+ row + ' Ребенок- ' + id)
    	},
    	countUp: function(){
          	this.month +=1
        },
        countDown: function(){
          	this.month -=1
        }
    }
  }
</script>


<style type="text/css">

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