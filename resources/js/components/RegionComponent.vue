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
                    <span aria-hidden="true"><i class="fe fe-x h2"></i></span>
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
                        <input class="form-control" v-model="addNewBranchFields[item['v-model']]" :placeholder="item.placeholder" mask="item.mask" required>
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
    <div class="modal-dialog modal-dialog-centered modal-lg modal-branch" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Карточка филиала {{ branch.name }}</h4>
                <span>Удалить филиал <a href="#" class="fe fe-trash-2 h3 text-danger ml-3 mb-0" @click.prevent="deleteBranch(branch.id)"></a></span>
                <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fe fe-x h2"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body row pt-0">
                    <div class="col-md-6">
                        <p class="mb-1 ml-3">Название:
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form
                                    v-model="branch.name"
                                    name="name"
                                    :id="branch.id"
                                    @edit-field="editFieldBranch">
                                </input-form>
                            </span>
                        </p>
                        <p class="mb-1 ml-3">Город:
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form
                                    v-model="branch.geolocation"
                                    name="geolocation"
                                    :id="branch.id"
                                    @edit-field="editFieldBranch">
                                </input-form>
                            </span>
                        </p>
                        <p class="mb-1 ml-3">Адрес:
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form
                                    v-model="branch.adress"
                                    name="adress"
                                    :id="branch.id"
                                    @edit-field="editFieldBranch">
                                </input-form>
                            </span>
                        </p>
                        <p class="mb-1 ml-3">Телефон:
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form
                                v-model="branch.phone"
                                    name="phone"
                                    placeholder="+38 (926) 123-45-67"
                                    mask="+## (###) ###-##-##"
                                    :id="branch.id"
                                    @edit-field="editFieldBranch">
                                </input-form>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Реквизиты:
                            <span class="card-text text-muted mb-1 ml-2">
                                <input-form v-model="branch.requisites" name="requisites" textarea="true" :id="branch.id" @edit-field="editFieldBranch">
                                </input-form>
                            </span>
                        </p>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Валюта филиала:</label>
                            <div class="col-sm-3">
                                <select class="form-control" v-model="branch.currency" @change="editBranchCurrency(branch.id, branch.currency)">
                                    <option>руб</option>
                                    <option>грн</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title-collapse">
                    <a data-toggle="collapse" data-target="#1_products" href="#" class="accordion-toggle">Условия программ обучения</a>
                    <i class="fe fe-chevron-down h3 text-info pl-2"></i>
                </div>
                <div class="collapse p-3" id="1_products">
                    <div class="table-responsive">
                        <div class="table-responsive tbl-content">
                        <table class="table table-bordered datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th data-toggle="tooltip" :title="price" class="text-center">
                                        <span class="fe fe-dollar-sign h3 text-danger"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="classes_total" class="text-center">
                                        <span class="fe fe-users h3 text-success"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="classes_week"  class="text-center">
                                        <span class="fe fe-calendar h3 text-info"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="category_time" class="text-center">
                                        <span class="fe fe-clock h3 text-primary"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="freezing_total" class="text-center">
                                        <span class="fe fe-battery-charging h3 text-danger"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="months" class="text-center">
                                        <span class="fe fe-calendar h3 text-success"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="days" class="text-center">
                                        <span class="fe fe-clock h3 text-info"></span>
                                    </th>
                                    <th data-toggle="tooltip" :title="add_product" v-show="buttonAdd" class="text-center bg-success bp" @click="addRow(branch.id), buttonAdd = !buttonAdd">
                                        <span class="fe fe-plus h3 text-white"></span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="(product, int) in branch.products">
                                <tr :class="{'bg-light text-muted' : product.product_active}">
                                    <td>
                                        <input-form
                                            v-model="product.name"
                                            name="name"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.price"
                                            name="price"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.classes_total"
                                            name="classes_total"
                                            mask="###"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.classes_week"
                                            name="classes_week"
                                            mask="###"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.category_time"
                                            name="category_time"
                                            mask="###"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.freezing_total"
                                            name="freezing_total"
                                            mask="###"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.months"
                                            name="months"
                                            mask="###"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td class="text-center">
                                        <input-form
                                            v-model="product.days"
                                            name="days"
                                            mask="###"
                                            :id="product.id"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    <td v-if="product.rowNew" class="text-center" v-on:click="saveProduct(branch.id)">
                                        <span class="fe fe-save h3 text-success"></span>
                                    </td>
                                    <td v-else="">
                                        <span class="fe fe-trash-2 h3 text-danger mr-3" @click="removeRow(int, product.id, product.name)"></span>
                                        <span data-toggle="collapse" :data-target="'#' + product.id + 'collap'" class="accordion-toggle fe fe-chevron-down h3 text-info"></span>
                                    </td>
                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="collapse p-3" :id="product.id + 'collap'">
                                            <div class="row">
                                                <div class="card-body col-md-6 pt-1 pb-1">
                                                    <table>
                                                        <tbody>
                                                            <tr class="w-100">
                                                                <td class="w-25">Платеж</td>
                                                                <td class="w-25">Сумма</td>
                                                                <td class="w-25">Дней</td>
                                                                <td class="text-center bg-success">
                                                                    <span class="fe fe-plus h3 text-white" @click="addRowPay(int, product.id)" v-show="!busy"></span>
                                                                </td>
                                                            </tr>
                                                            <tr v-for="(pay, index) in product.pays">
                                                                <td class="text-center">{{ index+1 }}</td>
                                                                <td class="text-center">
                                                                    <input-form
                                                                        v-model="pay.pay"
                                                                        name="pay"
                                                                        mask="######"
                                                                        :id="pay.id"
                                                                        @edit-field="editFieldProductPay">
                                                                    </input-form>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input-form
                                                                        v-model="pay.day"
                                                                        name="day"
                                                                        mask="####"
                                                                        :id="pay.id"
                                                                        @edit-field="editFieldProductPay">
                                                                    </input-form>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span v-if="pay.rowNewPay" v-on:click="savePay(int, index, branch.id)" class="fe fe-save h3 text-success"></span>
                                                                    <span v-else="" v-on:click="removePay(int, index, pay.id)" class="fe fe-trash-2 h3 text-danger"></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-body col-md-6 pt-1 pb-1 border-left">
                                                    <p>Сумма прописью : <input-form v-model="product.price_title" name="price_title" :id="product.id" @edit-field="editField"></input-form>
                                                    </p>
                                                    <p>Заморозки по :
                                                        <select v-model="product.freezing_kolvo" @change="editProduct(product.id, product.freezing_kolvo)">
                                                            <option>0</option>
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                        </select>
                                                    </p>
                                                    <p>Дата окончания продукта:
                                                        <input-form
                                                            v-model="product.date_end"
                                                            name="date_end"
                                                            :id="product.id"
                                                            mask="##.##.####"
                                                            datePicker="true"
                                                            @edit-field="editField">
                                                        </input-form>
                                                    </p>
                                                    <p>Описание:
                                                        <input-form
                                                            v-model="product.description"
                                                            name="description"
                                                            textarea="true"
                                                            :id="product.id"
                                                            @edit-field="editField">
                                                        </input-form>
                                                    </p>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Программа:</label>
                                                        <div class="col-sm-9">
                                                            <dynamic-select
                                                                :options="branch.programms"
                                                                option-value="id"
                                                                option-text="name"
                                                                placeholder="Поиск программы"
                                                                v-model="product.programm"
                                                                @input="saveProductProgramm(product.id, product.programm.id)"
                                                            />
                                                        </div>
                                                    </div>
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
                </div>
                <div class="title-collapse mt-2">
                    <a data-toggle="collapse" data-target="#2_programms" href="#" class="accordion-toggle">Основные программы обучения</a>
                    <i class="fe fe-chevron-down h3 text-info pl-2"></i>
                </div>
                <div class="collapse p-3" id="2_programms">
                    <div class="table-responsive">
                        <table class=" table table-bordered datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Основная</th>
                                    <th>ПК</th>
                                    <th>ВМ</th>
                                    <th v-show="buttonAddProgramm" class="text-center bg-success bp" @click="addRowProgramm(branch.id), buttonAddProgramm = !buttonAddProgramm"><span class="fe fe-plus h3 text-white"></span></th>
                                </tr>
                            </thead>
                            <tbody v-for="(programm, int) in branch.programms">
                                <tr>
                                    <td>
                                        <input-form
                                            v-model="programm.name"
                                            name="name"
                                            :id="programm.id"
                                            @edit-field="editFieldProgramm">
                                        </input-form>
                                    </td>
                                    <td><input @change="sendTypeProgramm(programm.id, 1)" type="radio" id="main" value="1" v-model="programm.type"></td>
                                    <td><input @change="sendTypeProgramm(programm.id, 2)" type="radio" id="pk" value="2" v-model="programm.type"></td>
                                    <td><input @change="sendTypeProgramm(programm.id, 3)" type="radio" id="vm" value="3" v-model="programm.type"></td>
                                    <td v-if="programm.rowNew" class="text-center" @click="saveProgramm(branch.id)">
                                        <span class="fe fe-save h3 text-success"></span>
                                    </td>
                                    <td class="text-center" v-else="">
                                        <span class="fe fe-trash-2 h3 text-danger" @click="removeRowProgramm(int, programm.id, programm.name)"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="title-collapse mt-2">
                    <a data-toggle="collapse" data-target="#3_dopproducts" href="#" class="accordion-toggle">Дополнительные программы</a>
                    <i class="fe fe-chevron-down h3 text-info pl-2"></i>
                </div>
                <div class="collapse p-3" id="3_dopproducts">
                    <div class="table-responsive">
                        <table class=" table table-bordered datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Цена</th>
                                    <th v-show="buttonAddDopProduct" class="text-center bg-success bp" @click="addRowDopProduct(branch.id), buttonAddDopProduct = !buttonAddDopProduct"><span class="fe fe-plus h3 text-white"></span></th>
                                </tr>
                            </thead>
                            <tbody v-for="(dopproduct, int) in branch.dopproducts">
                                <tr>
                                    <td>
                                        <input-form
                                            v-model="dopproduct.name"
                                            name="name"
                                            :id="dopproduct.id"
                                            @edit-field="editFieldDopProduct">
                                        </input-form>
                                    </td>
                                    <td>
                                        <input-form
                                            v-model="dopproduct.price"
                                            name="price"
                                            :id="dopproduct.id"
                                            @edit-field="editFieldDopProduct">
                                        </input-form>
                                    </td>
                                    <td v-if="dopproduct.rowNew" class="text-center" v-on:click="saveDopProduct(branch.id)">
                                        <span class="fe fe-save h3 text-success"></span>
                                    </td>
                                    <td class="text-center" v-else="">
                                        <span class="fe fe-trash-2 h3 text-danger" @click="removeRowDopProduct(int, dopproduct.id, dopproduct.name)"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="title-collapse mt-2">
                    <a data-toggle="collapse" data-target="#4_hall" href="#" class="accordion-toggle">Зал/Поле</a>
                    <i class="fe fe-chevron-down h3 text-info pl-2"></i>
                </div>
                <div class="collapse p-3" id="4_hall">
                    <div class="table-responsive">
                        <table class=" table table-bordered datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th v-show="buttonAddHall" class="text-center bg-success bp" @click="addRowHall(branch.id), buttonAddHall = !buttonAddHall"><span class="fe fe-plus h3 text-white"></span></th>
                                </tr>
                            </thead>
                            <tbody v-for="(hall, int) in branch.halls">
                                <tr>
                                    <td>
                                        <input-form
                                            v-model="hall.name"
                                            name="name"
                                            :id="hall.id"
                                            @edit-field="editFieldHall">
                                        </input-form>
                                    </td>
                                    <td v-if="hall.rowNew" class="text-center" v-on:click="saveHall(branch.id)">
                                        <span class="fe fe-save h3 text-success"></span>
                                    </td>
                                    <td class="text-center" v-else="">
                                        <span class="fe fe-trash-2 h3 text-danger" @click="removeRowHall(int, hall.id, hall.name)"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <div class="card card-sm mb-2 pointer" v-for="branch in region.branches" data-toggle="modal" data-target="#getbranch" @click="getBranch(branch.id)">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12 col-md">
                                <a href="javascript:void(0)" class="mb-md-0">{{ branch.name }}</a>
                            </div>
                        </div>
                    </div>
                </div>
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

$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});

import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);

	export default{
    	   props: {
    	       canupdate: {
    	    },
    	  },
		data() {
            return{
                name: '',
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
                buttonAddProgramm: true,
                buttonAddDopProduct: true,
                buttonAddHall: true,
            	regions: {
                     branches: [],
                },
                branch: {
                    products: {
                        pays: [],
                    },
                    programm: [{
                        pk: '',
                        vm: ''
                    }],
                    dopproducts: [],
                    halls: [],
                },
                region_id: '',
            }
        },
        created(){
            this.getRegions();
        },
        mounted(){
            $('#getbranch').on('hidden.bs.modal', () => this.closeModal())
        },
        methods: {

            saveProductProgramm(id, programm){
                // Почему то при открытии карточки срабатывает этот метод
                axios.put('api/v2/products/'+ id, {field_name: 'programm_id', field_value: programm })
            },

            sendTypeProgramm(id, type){
                    axios.post( 'api/v2/updateTypeProgramm', {id: id, type: type})
            },

            saveProduct(id){
                this.branch.products[0].rowNew = '';
                this.buttonAdd = true
                axios.post('api/v2/products',this.branch.products[0])
                  .catch(function (error) {
                    if (error.response) {
                      alert("Ошибка, не заполнено название программы");
                    }
                  });
                this.$alert("Программа добавлена");
                    setTimeout(() => {
                        this.getBranch(id)
                        },500)
            },
            saveProgramm(id){
                this.branch.programms[this.branch.programms.length - 1].rowNew = '';
                this.buttonAddProgramm = true
                axios.post('api/v2/programms',this.branch.programms[this.branch.programms.length - 1])
                        setTimeout(() => {
                        this.getBranch(id)
                        },500)
            },
            saveDopProduct(id){
                this.branch.dopproducts[this.branch.dopproducts.length - 1].rowNew = '';
                this.buttonAddDopProduct = true
                axios.post('api/v2/dopproducts',this.branch.dopproducts[this.branch.dopproducts.length - 1])
                        setTimeout(() => {
                        this.getBranch(id)
                        },500)
            },
            saveHall(id){
                this.branch.halls[this.branch.halls.length - 1].rowNew = '';
                this.buttonAddHall = true
                axios.post('api/v2/halls',this.branch.halls[this.branch.halls.length - 1])
                        setTimeout(() => {
                        this.getBranch(id)
                        },500)
            },
            addRow(branch){
               this.branch.products.unshift({
                    rowNew: true,
                    name: null,
                    price: null,
                    classes_total: null,
                    classes_week: null,
                    category_time: null,
                    freezing_total: null,
                    months: null,
                    days: null,
                    active: true ,
                    price_title: null ,
                    branch_id: branch
                });
            },
            addRowPay(int, product_id){
               this.busy = true
               this.branch.products[int].pays.push({
                    rowNewPay: true,
                    pay: null,
                    day: null,
                    product_id: product_id
                });
            },
            addRowProgramm(branch){
               this.branch.programms.push({
                    rowNew: true,
                    name: null,
                    branch_id: branch,
                    type: 1,
                });
            },
            addRowDopProduct(branch){
               this.branch.dopproducts.push({
                    rowNew: true,
                    name: null,
                    branch_id: branch,
                });
            },
            addRowHall(branch){
               this.branch.halls.push({
                    rowNew: true,
                    name: null,
                    branch_id: branch
                });
            },
            savePay(int, index, id){
                this.busy = false
                this.branch.products[int].pays[index].rowNewPay = '';
                axios.post('api/v2/product_pay',this.branch.products[int].pays[index])
                this.$alert("Платёж добавлен");
                        setTimeout(() => {
                        this.getBranch(id)
                        },500)
            },
            removeRow(index, id, name){
                this.$confirm("Удалить программу " + name + " ?").then(() => {
                    this.branch.products.splice(index,1);
                    axios.delete('api/v2/products/'+ id);
                    this.$alert("Продукт удален");
                });
            },
            removePay(int, index, id){
                this.$confirm("Удалить платеж ?").then(() => {
                    axios.delete('api/v2/product_pay/'+ id);
                    this.branch.products[int].pays.splice(index,1);
                    this.$alert("Платёж удален");
                });
            },
            removeRowProgramm(index, id, name){
                this.$confirm("Удалить программу " + name + " ?").then(() => {
                    this.branch.programms.splice(index,1);
                    axios.delete('api/v2/programms/'+ id);
                    this.$alert("Программа удалена");
                });
            },
            removeRowDopProduct(index, id, name){
                this.$confirm("Удалить продукт " + name + " ?").then(() => {
                    this.branch.dopproducts.splice(index,1);
                    axios.delete('api/v2/dopproducts/'+ id);
                    this.$alert("Продукт удален");
                });
            },
            removeRowHall(index, id, name){
                this.$confirm("Удалить зал " + name + " ?").then(() => {
                    this.branch.halls.splice(index,1);
                    axios.delete('api/v2/halls/'+ id);
                    this.$alert("Зал удален");
                });
            },

            editField(e, name, type, id) {
                if (type){
                    axios.put('api/v2/products/'+ id, {field_name: name, field_value: e })

                }else{
                    const id = e.target.id;
                    const value = e.target.value;
                    const key = e.currentTarget.getAttribute('name');
                    axios.put('api/v2/products/'+ id, {field_name: key, field_value: value })
                }
            },

            // editField(e, name) {
            //     const id = e.target.id;
            //     const value = e.target.value;
            //     const key = e.currentTarget.getAttribute('name');
            //     axios.put('api/v2/products/'+ id, {field_name: key, field_value: value })
            // },
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
                axios.put('api/v2/product_pay/' + id, {field_name: key, field_value: value })
            },
            editFieldProgramm(e, name) {
                const id = e.target.id;
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/programms/' + id, {field_name: key, field_value: value })
            },
            editFieldDopProduct(e, name) {
                const id = e.target.id;
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/dopproducts/' + id, {field_name: key, field_value: value })
            },
            editFieldHall(e, name) {
                const id = e.target.id;
                const value = e.target.value;
                const key = e.currentTarget.getAttribute('name');
                axios.put('api/v2/halls/' + id, {field_name: key, field_value: value })
            },
            editProduct(id, freezing) {
                axios.put('api/v2/products/'+ id, {field_name: 'freezing_kolvo', field_value: freezing })
            },
            editBranchCurrency(id, currency) {
                axios.put('api/v2/branches/'+ id, {field_name: 'currency', field_value: currency })
            },
        	getModalBranch(region_id){
        		$('#addNewBranch').modal('show');
        		this.region_id = region_id;
        	},
        	getBranch(id){
        		// $('#getbranch').modal('show');
        		axios.get('api/v2/branches/' + id)
                .then(response => this.branch = response.data.data)
        	},
        	getRegions(){
        		axios.get('api/v2/regions')
                .then(response => this.regions = response.data.data)
        	},
        	addNewRegion(){
        		$('#addNewRegion').modal('hide');
        		$(document.body).removeClass("modal-open");
				$(".modal-backdrop.show").hide();
        		axios.post('api/v2/regions',{name: this.name,})
        		.then(response => this.responsesuccess = response.data)
        		.finally(() => (this.getRegions()))
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
        		.finally(() => (this.getRegions()))
        		setTimeout(() => {
                  		Vue.$toast.open({message: 'Филиал успешно добавлен',type: 'success',duration: 5000,position: 'top-right'
                	});
        		}, 500)
        	},
            deleteBranch(id){
                this.$confirm("Удалить филиал с продуктами и оплатами ? ").then(() => {
                    axios.delete('api/v2/branches/'+ id);
                $('#getbranch').modal('hide');
                setTimeout(() => {
                        Vue.$toast.open({message: 'Филиал успешно удален',type: 'success',duration: 5000,position: 'top-right'
                    });
                }, 500)
                this.getRegions();
                });
            },
            closeModal(){
                $('#1_products').collapse('hide')
                $('#2_programms').collapse('hide')
                $('#3_dopproducts').collapse('hide')
                $('#4_hall').collapse('hide')
                this.buttonAdd = true
                this.buttonAddProgramm = true
                this.busy = false
                this.getRegions();
            },
        },
	}
</script>

<style scoped>

    .table td, .table th {
        padding: 10px;
        font-size: 14px;
    }

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

.bp{
    width: 70px;
}
.title-collapse {
    text-align: center !important;
    text-shadow: 1px 1px 0 #fff !important;
    border: 1px solid #e6e6e6;
    padding: 8px;
}

.modal-branch {
  /* ширина модального окна */
  max-width: 1000px;
}

    .table_fixed {
        width:100%;
        table-layout: fixed;
    }

    .tbl-content {
        height: 800px;
        overflow-x: auto;
        margin-top: 0px;
    }
</style>
