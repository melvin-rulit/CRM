<template>
	<div>
	<div class="row">
      <div class="col-lg-12">
        <div class="card mb-2">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col">
              </div>
              <div class="col-auto">
                <a class="btn btn-sm btn-success" data-toggle="modal" href="#" data-target="#addNewProduct">Добавить новый продукт</a>
                <a class="btn btn-sm btn-success" href="#" @click="api">Посмотреть api</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Модальное окно добавлением нового продукта -->
    <div class="modal fade" id="addNewProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4 class="modal-title" id="exampleModalLongTitle">Добавление нового продукта</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body pb-0">
					<form @submit.prevent="addNewProduct">
			    		<div class="col-md form-group">
						  <label class="form-control-label required">Название программы</label>
						  <input class="form-control" v-model.trim="name" required>
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								<label class="form-control-label required">Цена</label>
								<input v-mask="'######'" v-model.trim="price" class="form-control" required>
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label required">Цена прописью</label>
								<input v-model.trim="price_title" class="form-control" required>
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label required">Количество тренеровок</label>
								<input v-mask="'##'" v-model.trim="classes_total" class="form-control" required>
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label required">Тренеровок в неделю</label>
								<input v-mask="'##'" v-model.trim="classes_week" class="form-control" required>
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label required">Категория времени</label>
								<input v-mask="'######'" v-model.trim="category_time" class="form-control" required>
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label required">Количество заморозок</label>
								<input v-mask="'##'" v-model.trim="freezing_total" class="form-control" required>
							</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn btn-success">Добавить</button>
					</div>
					</form>
    			</div>
    		</div>
    	</div>
    </div>


	<div class="card container">
		<div class="card-body pb-0">
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
					<tbody v-for="products in productsData">
						<tr v-for="product in products" :class="[product.active ? false : 'not_active']">
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
	</div>

</div>
</template>


<script>

import Avatar from 'vue-avatar'

import { required, minLength } from 'vuelidate/lib/validators'

	export default{
		data() {
            return{
            	productsData:[],
            	products:[],
            	responsesuccess: [],
            	image: '',
            }
        },
        components: {
    		Avatar
  		},
        created(){
            this.getProducts();
        },
        methods: {
        	fileInput(){
        		let form = new FormData();
        		form.append('image');
        		axios.post('api/v2/image', form)
        	},
        	alert(){
        		alert("OK");
        	},
            api(){
                axios.get('api/v2/regions')
            },
        	getProducts(){
        		axios.get('api/v2/products')
                .then(response => this.productsData = response.data.data)
                .finally(() => console.log('Контракты успешно загружены'));
        	},
        	addNewProduct(){
        		$('#addNewProduct').modal('hide');
        		$(document.body).removeClass("modal-open");
				$(".modal-backdrop.show").hide();
        		axios.post('api/v2/addnewproduct',{
        			name: this.name,
        			price: this.price,
        			price_title: this.price_title,
        			classes_total: this.classes_total,
        			classes_week: this.classes_week,
        			category_time: this.category_time,
        			freezing_total: this.freezing_total,
        			active: true,
        		})
        		.then(response => this.responsesuccess = response.data)
        		.finally(() => (this.getProducts()))
        		setTimeout(() => {
                  		Vue.$toast.open({message: 'Продукт успешно добавлен',type: 'success',duration: 5000,position: 'top-right'
                	});
        		}, 500)
        	},
        },
	}
</script>

<style type="text/css">
	tr {
    cursor: pointer;
}

</style>