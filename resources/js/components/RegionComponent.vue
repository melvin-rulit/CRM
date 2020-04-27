<template>
	<div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card mb-2">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h4 class="card-header-title">Регионы и филиалы</h4>
							</div>
							<div class="col-auto">
								<button v-if="canupdate" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addNewRegion">Добавить регион</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

    <!-- Модальное окно добавлением нового региона -->
    <div class="modal fade" id="addNewRegion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4 class="modal-title" id="exampleModalLongTitle">Добавление нового региона</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body pb-0">
					<form @submit.prevent="addNewRegion">
			    		<div class="col-md form-group">
						  <label class="form-control-label required">Название региона</label>
						  <input class="form-control" v-model.trim="name" required>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
						<button type="submit" class="btn btn-success">Добавить</button>
					</div>
					</form>
    			</div>
    		</div>
    	</div>
    </div>


    <!-- Модальное окно добавлением нового филиала -->
    <div class="modal fade" id="addNewBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4 class="modal-title" id="exampleModalLongTitle">Добавление нового филиала</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body pb-0">
					<form @submit.prevent="addNewBranch">
			    		<div class="col-md form-group">
						  <label class="form-control-label required">Название филиала</label>
						  <input class="form-control" v-model.trim="name" required>
						</div>
						<div class="col-md form-group">
						  <label class="form-control-label required">Город</label>
						  <input class="form-control" v-model.trim="town" required>
						</div>
						<div class="col-md form-group">
						  <label class="form-control-label required">Адресс</label>
						  <input class="form-control" v-model.trim="adress" required>
						</div>
						<div class="col-md form-group">
						  <label class="form-control-label required">Телефон</label>
						  <input class="form-control" placeholder="+38 (926) 123-45-67" v-mask="'+## (###) ###-##-##'" v-model.trim="phone" required>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
						<button type="submit" class="btn btn-success">Добавить</button>
					</div>
					</form>
    			</div>
    		</div>
    	</div>
    </div>


    <!-- Модальное окно добавлением нового региона -->
    <div class="modal fade" id="getbranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4 class="modal-title" id="exampleModalLongTitle">Карточка филиала</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
    				<div class="card container">
    					<p>{{ branch.name}}</p>
    					<p>{{ branch.geolocation}}</p>
    					<p>{{ branch.adress}}</p>
    					<p>{{ branch.phone}}</p>
    				</div>
    						<div class="table-responsive">
    							<table class=" table table-bordered table-hover datatable datatable-User">
    								<thead>
    									<tr>
    										<th>Название</th>
    										<th class="text-center"><span class="fe fe-dollar-sign h3 text-danger"></span></th>
    										<th class="text-center"><span class="fe fe-users h3 text-success"></span></th>
    										<th class="text-center"><span class="fe fe-calendar h3 text-info"></span></th>
    										<th class="text-center"><span class="fe fe-clock h3 text-primary"></span></th>
    										<th class="text-center"><span class="fe fe-battery-charging h3 text-danger"></span></th>
    									</tr>
    								</thead>
    								<tbody>
    									<tr v-for="product in branch.products">
    										<td>{{ product.name }}</td>
    										<td class="text-center">{{ product.price }}</td>
    										<td class="text-center">{{ product.classes_total }}</td>
    										<td class="text-center">{{ product.classes_week }}</td>
    										<td class="text-center">{{ product.category_time }}</td>
    										<td class="text-center">{{ product.freezing_total }}</td>
    									</tr>
    								</tbody>
    							</table>
    						</div>
    			</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
				</div>
    		</div>
    	</div>
    </div>



    <div class="row flex-nowrap test">
    	<div class="col-4 col-lg-4" v-for="region in regions">
    		<div class="card">
    			<div class="card-header">
    				<div class="row align-items-center">
    					<div class="col">
    						{{ region.name }}
    					</div>
    					<div class="col-auto">
    						<!-- <a href="#" style="color: #e6b00d" class="btn h2 fe fe-edit mb-0"></a> -->
    					</div>
    				</div>
    			</div>

    			<div class="card-body">
    				<div class="card card-sm mb-2 pointer" @click="getBranch(branch.id)" v-for="branch in region.branches">
    					<div class="card-body">
    						<div class="row align-items-center">
    							<div class="col-12 col-md">
    								<a href="#" class="mb-md-0">
    									{{ branch.name }}
    								</a>
    							</div>
    							<div class="col-auto">
    								<!-- <a href="#" style="color: #e6b00d" class="h2 fe fe-edit mb-0"></a> -->
    							</div>
    						</div>
    					</div>    		   
    				</div>
    				<p v-if="region.branches.length == 0" class="text-center pt-3">В регионе нет филиалов</p>
    				<div class="text-center pt-2">    				
    					<button class="btn btn-sm btn-success center-block" @click="getModalBranch(region.id)">Добавить филиал</button>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>


	</div>
</template>


<script>

	export default{
	  props: {
	    canupdate: {
	    },
	  },
		data() {
            return{
            	regions: {
                     branches: [],
                },
                branch: {},
                region_id: '',
            }
        },
        created(){
            this.getRegion();
        },
        methods: {
        	getModalBranch(region_id){
        		$('#addNewBranch').modal('show');
        		this.region_id = region_id;
        	},
        	getBranch(id){
        		$('#getbranch').modal('show');
        		axios.get('api/v2/branches/' + id)
                .then(response => this.branch = response.data.data)
                .finally(() => console.log('Филиал успешно загружен'));
        	},
        	getRegion(){
        		axios.get('api/v2/regions')
                .then(response => this.regions = response.data.data)
                .finally(() => console.log('Регионы успешно загружены'));
        	},
        	addNewRegion(){
        		$('#addNewRegion').modal('hide');
        		$(document.body).removeClass("modal-open");
				$(".modal-backdrop.show").hide();
        		axios.post('api/v2/regions',{
        			name: this.name,
        		})
        		.then(response => this.responsesuccess = response.data)
        		.finally(() => (this.getRegion()))
        		setTimeout(() => {
                  		Vue.$toast.open({message: 'Регион успешно добавлен',type: 'success',duration: 5000,position: 'top-right'
                	});
        		}, 500)
        	},
        	addNewBranch(){
        		$('#addNewBranch').modal('hide');
        		$(document.body).removeClass("modal-open");
				$(".modal-backdrop.show").hide();
        		axios.post('api/v2/branches',{
        			name: this.name,
        			geolocation: this.town,
        			adress: this.adress,
        			phone: this.phone,
        			region_id: this.region_id,
        		})
        		.then(response => this.responsesuccess = response.data)
        		.finally(() => (this.getRegion()))
        		setTimeout(() => {
                  		Vue.$toast.open({message: 'Филиал успешно добавлен',type: 'success',duration: 5000,position: 'top-right'
                	});
        		}, 500)
        	},
        },
	}
</script>

<style type="text/css">
.pointer {
    cursor: pointer;
}
</style>
