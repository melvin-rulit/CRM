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
<button class="btn btn-success" @click="redirect2">REDIRECT2</button>

  </div>
</template>

<script>



  export default {

    data() {
    	return {

    	}
    },



    methods: {


	      redirect(){
			axios.get('api/v2/redirect/')
	      },

	      redirect2(){
			axios.get('api/v2/redirect/')
	      },

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