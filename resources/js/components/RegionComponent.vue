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
    	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4 class="modal-title" id="exampleModalLongTitle">Карточка филиала {{ branch.name }}</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
                  <div class="col ml-n2">
                        <h4 class="mb-3 name">
                          <a href="#!">{{ branch.name}}</a>
                      </h4>
                      <p class="mb-1 ml-3">Город: <span class="card-text text-muted mb-1 ml-2">{{ branch.geolocation}}</span></p>
                      <p class="mb-1 ml-3">Адрес: <span class="card-text text-muted mb-1 ml-2">{{ branch.adress}}</span></p>
                      <p class="mb-1 ml-3">Телефон: <span class="card-text text-muted mb-1 ml-2">{{ branch.phone}}</span></p>
                      <p class="mb-1 ml-3">Реквизиты: <span class="card-text text-muted mb-1 ml-2">{{ branch.phone}}</span></p>
                      <p class="mb-3 ml-3">ИП: <span class="card-text text-muted mb-1 ml-2">{{ branch.phone}}</span></p>
                </div>
    						<div class="table-responsive">
    							<table class=" table table-bordered table-hover datatable datatable-User">
    								<thead>
    									<tr>
    										<th>Название</th>
    										<th v-title="price" class="text-center"><span class="fe fe-dollar-sign h3 text-danger"></span></th>
    										<th class="text-center"><span class="fe fe-users h3 text-success"></span></th>
    										<th class="text-center"><span class="fe fe-calendar h3 text-info"></span></th>
    										<th class="text-center"><span class="fe fe-clock h3 text-primary"></span></th>
    										<th class="text-center"><span class="fe fe-battery-charging h3 text-danger"></span></th>
                                            <th v-show="buttonAdd" class="text-center bg-success" @click="addRow(), buttonAdd = !buttonAdd"><span class="fe fe-plus h3 text-white"></span></th>
    									</tr>
    								</thead>
    								<tbody>
    									<tr v-for="(product, index) in branch.products">
    										<td>{{ product.name }}</td>
    										<td class="text-center">{{ product.price }}</td>
    										<td class="text-center">{{ product.classes_total }}</td>
    										<td class="text-center">{{ product.classes_week }}</td>
    										<td class="text-center">{{ product.category_time }}</td>
    										<td class="text-center">{{ product.freezing_total }}</td>
                                            <td v-if="product.rowNew" class="text-center" v-on:click="saveProgramm"><span class="fe fe-check h3 text-success"></span></td>
                                            <td v-else="" class="text-center" v-on:click="removeRow(index)"><span class="fe fe-trash-2 h3 text-danger"></span></td>
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

import VTitle from 'v-title';

Vue.use(VTitle);


import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);

	export default{
	  props: {
	    canupdate: {
	    },
	  },
		data() {
            return{
                rowNew: '',
                buttonAdd: true,
                price: 'Базовая цена продукта',
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
            saveProgramm(){
                this.branch.products[this.branch.products.length - 1].rowNew = '';
                this.buttonAdd = true
                this.$alert("Программа добавлена");
            },
            addRow(){
               this.branch.products.push({rowNew: true, name: 'Название продукта', price: 0, classes_total: 0, classes_week: 0, category_time: 0, freezing_total: 0});
            },
            removeRow(index){
                this.$confirm("Удалить программу ?").then(() => {
                    this.branch.products.splice(index,1);
            });
               
            },
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
