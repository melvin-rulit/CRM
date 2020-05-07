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
    			</div>
    			<div class="modal-body pb-0">
					<form @submit.prevent="addNewBranch">
                        <div class="col-md form-group" v-for="item in newBranchFields">
                          <label class="form-control-label required">{{ item.label }}</label>
                          <input class="form-control" v-model="addNewBranchFields[item['v-model']]" :placeholder="item.placeholder" v-mask="item.mask" required>
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

<!-- Модальное окно открытия карточки филиала -->
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
                <div class="card-body row">
                    <div class="col-md-6">
                        <h4 class="mb-3 name">{{ branch.name}}</h4>
                        <p class="mb-1 ml-3">Город: 
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form v-model="branch.geolocation" name="geolocation" :id="branch.id" @edit-field="editFieldBranch"></input-form>
                            </span>
                        </p>
                        <p class="mb-1 ml-3">Адрес: 
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form v-model="branch.adress" name="adress" :id="branch.id" @edit-field="editFieldBranch"></input-form>
                            </span>
                        </p>
                        <p class="mb-1 ml-3">Телефон: 
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form placeholder="+38 (926) 123-45-67" v-mask="'+## (###) ###-##-##'" v-model="branch.phone" name="phone" :id="branch.id" @edit-field="editFieldBranch"></input-form>
                            </span>
                        </p>
                    </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <p class="mb-1 ml-3">Реквизиты: 
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form v-model="branch.requisites" name="requisites" :id="branch.id" @edit-field="editFieldBranch"></input-form>
                            </span>
                        </p>
                        <p class="mb-1 ml-3">Организация: 
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form v-model="branch.organization" name="organization" :id="branch.id" @edit-field="editFieldBranch"></input-form>
                            </span>
                        </p>
                    </div>
              </div>
          </div>
    		<div class="table-responsive">
    			<table class=" table table-bordered table-hover datatable datatable-User">
    				<thead>
    					<tr>
    						<th>Название</th>
    						<th v-title="price" class="text-center"><span class="fe fe-dollar-sign h3 text-danger"></span></th>
    						<th v-title="classes_total" class="text-center"><span class="fe fe-users h3 text-success"></span></th>
    						<th v-title="classes_week" class="text-center"><span class="fe fe-calendar h3 text-info"></span></th>
    						<th v-title="category_time" class="text-center"><span class="fe fe-clock h3 text-primary"></span></th>
    						<th v-title="freezing_total" class="text-center"><span class="fe fe-battery-charging h3 text-danger"></span></th>
                            <th v-title="months" class="text-center"><span class="fe fe-calendar h3 text-success"></span></th>
                            <th v-title="days" class="text-center"><span class="fe fe-clock h3 text-info"></span></th>
                            <th v-title="add_product" v-show="buttonAdd" class="text-center bg-success" @click="addRow(branch.id), buttonAdd = !buttonAdd"><span class="fe fe-plus h3 text-white"></span></th>
    					</tr>
    				</thead>
    				<tbody v-for="(product, int) in branch.products">
    					<tr data-toggle="collapse" :data-target="'#' + product.id" class="accordion-toggle" >
    						<td>
                                <input-form v-model="product.name" name="name" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-model="product.price" name="price" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-mask="'###'" v-model="product.classes_total" name="classes_total" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-mask="'###'" v-model="product.classes_week" name="classes_week" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-mask="'###'" v-model="product.category_time" name="category_time" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-mask="'###'" v-model="product.freezing_total" name="freezing_total" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-mask="'###'" v-model="product.months" name="months" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td class="text-center">
                                <input-form v-mask="'###'" v-model="product.days" name="days" :id="product.id" @edit-field="editField"></input-form>
                            </td>
                            <td v-if="product.rowNew" class="text-center" v-on:click="saveProgramm(branch.id)">
                                <span class="fe fe-save h3 text-success"></span>
                            </td>
                            <td v-else="" class="text-center" v-on:click="removeRow(int, product.id, product.name)">
                                <span class="fe fe-trash-2 h3 text-danger"></span>
                            </td>
                            <tr>
                                <td colspan="12" class="hiddenRow">
                                    <div class="accordian-body collapse p-3" :id="product.id">
                                        <div class="row">
                                            <div class="card-body col-md-6 pt-1 pb-1">
                                                <button class="btn btn-sm btn-success pb-2" @click="addRowPay(int, product.id)" :disabled="busy">Добавить платеж</button>
                                                <p v-for="(pay, index) in product.pays">Платёж {{ index+1 }} : <input-form v-mask="'###'" v-model="pay.pay" name="pay" :id="pay.id" @edit-field="editFieldProductPay"></input-form> + дней <input-form v-mask="'###'" v-model="pay.day" name="day" :id="pay.id" @edit-field="editFieldProductPay"></input-form>
                    <span v-if="pay.rowNewPay" v-on:click="savePay(int, index, branch.id)" class="fe fe-save h3 text-success"></span>
                    <span v-else="" v-on:click="removePay(int, index, pay.id)" class="fe fe-trash-2 h3 text-danger pl-2"></span>
</p>                                    
                                            </div>
                                            <div class="card-body col-md-6 pt-1 pb-1 border-left">
                                                <p>Сумма прописью : <input-form v-model="product.price_title" name="price_title" :id="product.id" @edit-field="editField"></input-form></p>
                                                <p>Заморозки по : 
                                                    <select v-model="product.freezing_kolvo" @change="editProduct(product.id, product.freezing_kolvo)">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </p>
                                                <p>Старый ID : <input-form v-model="product.old_id" name="old_id" :id="product.id" @edit-field="editField"></input-form></p>
                                            </div>
                                        </div>
                                    </div>
                                </td> 
                            </tr>
    					</tr>
    				</tbody>
    			</table>
    		</div>
			</div>
			<div class="modal-footer">
				<button type="button" @click="buttonAdd = true, busy = false" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>



<div class="row flex-nowrap test">
	<div class="col-4 col-lg-4" v-for="region in regions">
		<div class="card">
			<div class="card-header">
				<div class="row align-items-center">
					<div class="col">{{ region.name }}</div>
				</div>
			</div>
			<div class="card-body">
				<div class="card card-sm mb-2 pointer" @click="getBranch(branch.id)" v-for="branch in region.branches">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-12 col-md">
								<a href="#" class="mb-md-0">{{ branch.name }}</a>
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


    $('.accordion-toggle').click(function(){
    $(this).next('tr').find('.hiddenRow').show();
});

Vue.component('inputForm', {
  props: {
    value: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    id: {
    },
    placeholder: {
    }
  },
  data() {
    return {
      keyInputForm: null,
      thisValue: this.value,
    }
  },
  template: `
    <span>
        <a href="#" v-if="!value && !keyInputForm" @click.prevent="keyInputForm=true;thisValue=''" style="color: green;">Добавить</a>
    <span>
      <span v-if="!keyInputForm" class="card-title" @click="keyInputForm = true">{{ value }}</span>
      <input class="form-control" size="1" v-else type="text" :value="value" :placeholder="placeholder" :id="id" :name="name" v-model="value" @input="$emit('input', value)" @blur="keyInputForm = false;$emit('edit-field', $event)">
      </div>
    </div>

  `
})


import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);

	export default{
	  props: {
	    canupdate: {
	    },
	  },
		data() {
            return{
                addNewBranchFields: {},
                newBranchFields: [
                    {label: 'Название филиала', 'v-model': 'name'}, 
                    {label: 'Город', 'v-model': 'town'}, 
                    {label: 'Адресс', 'v-model': 'adress'}, 
                    {label: 'Телефон', 'v-model': 'phone', 'placeholder': '+38 (926) 123-45-67', 'mask': '+## (###) ###-##-##'}, 
                 ],
                price: 'Базовая цена продукта',
                classes_total: 'Общее количество тренировок в контракте',
                classes_week: 'Количество тренировок в неделю',
                category_time: 'Категория времени',
                freezing_total: 'Количество заморозок',
                months: 'Количество месяцев',
                days: 'Количество дней',
                add_product: 'Добавить продукт',
                busy: false,
                rowNew: '',
                rowNewPay: '',
                freezing_kolvo: '',
                buttonAdd: true,
            	regions: {
                     branches: [],
                },
                branch: {
                    products: {
                        pays: [],
                    }, 
                },
                region_id: '',
            }
        },
        created(){
            this.getRegion();
        },
        methods: {
            saveProgramm(id){
                this.branch.products[this.branch.products.length - 1].rowNew = '';
                this.buttonAdd = true
                axios.post('api/v2/products',this.branch.products[this.branch.products.length - 1])
                  .catch(function (error) {
                    if (error.response) {
                      alert("Ошибка, не заполнено название программы");
                    }
                  });
                this.$alert("Программа добавлена");
                this.getBranch(id);
            },
            addRow(branch){
               this.branch.products.push({
                    rowNew: true, 
                    name: 'Название продукта', 
                    price: 0, 
                    classes_total: 0, 
                    classes_week: 0, 
                    category_time: 0, 
                    freezing_total: 0, 
                    months: 0, 
                    days: 0, 
                    active: true ,
                    price_title: 'Цена прописью' ,
                    branch_id: branch
                });
            },
            addRowPay(int, product_id){
               this.busy = true
               this.branch.products[int].pays.push({
                    rowNewPay: true, 
                    pay: 0, 
                    day: 0, 
                    product_id: product_id
                });
            },
            savePay(int, index, id){
                this.busy = false
                this.branch.products[int].pays[index].rowNewPay = '';
                axios.post('api/v2/product_pay',this.branch.products[int].pays[index])
                this.$alert("Платёж добавлен");
                this.getBranch(id);
            },
            removeRow(index, id, name){
                this.$confirm("Удалить программу " + name + " ?").then(() => {
                    this.branch.products.splice(index,1);
                    axios.delete('api/v2/products/'+ id);
                    this.$alert("Программа удалена");
                });
            },
            removePay(int, index, id){
                this.$confirm("Удалить платеж ?").then(() => {
                    axios.delete('api/v2/product_pay/'+ id);
                    this.branch.products[int].pays.splice(index,1);
                    this.$alert("Платёж удален");
                });
            },
            editField(e, name) {
                const id = e.target.id;
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/products/'+ id, {field_name: key, field_value: value })
            },
            editFieldBranch(e, name) {
                const id = e.target.id;
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/branches/'+ id, {field_name: key, field_value: value })
            },
            editFieldProductPay(e, name) {
                const id = e.target.id;
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/product_pay/'+ id, {field_name: key, field_value: value })
            },
            editProduct(id, freezing) {
                axios.put('api/v2/products/'+ id, {field_name: 'freezing_kolvo', field_value: freezing })
            },
        	getModalBranch(region_id){
        		$('#addNewBranch').modal('show');
        		this.region_id = region_id;
        	},
        	getBranch(id){
        		$('#getbranch').modal('show');
        		axios.get('api/v2/branches/' + id)
                .then(response => this.branch = response.data.data)
        	},
        	getRegion(){
        		axios.get('api/v2/regions')
                .then(response => this.regions = response.data.data)
        	},
        	addNewRegion(){
        		$('#addNewRegion').modal('hide');
        		$(document.body).removeClass("modal-open");
				$(".modal-backdrop.show").hide();
        		axios.post('api/v2/regions',{name: this.name,})
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
        			name: this.addNewBranchFields.name,
        			geolocation: this.addNewBranchFields.town,
        			adress: this.addNewBranchFields.adress,
        			phone: this.addNewBranchFields.phone,
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

.main-section{
    margin-top: 120px;
}
.hiddenRow {
    cursor: default;
    padding: 0 4px !important;
    /*background-color: #eeeeee;*/
    font-size: 13px;
}
.accordian-body span{
    color:#a2a2a2 !important;
}

</style>
