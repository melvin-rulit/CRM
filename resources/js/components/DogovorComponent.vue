<template>
	<div>

<!-- Модальное окно с выбором контрактом -->
<div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Выберите контракт</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row modal-body">
                <div class="col-md-6"><a href="#" @click.prevent="contract('vm')">Контракт на пробное занятие</a></div>
                <div class="col-md-6"><a href="#" @click.prevent="contract('main')">Контракт основной программы</a></div>
            </div>
            <div class="modal-footer">
                <button @click="closeSelectModal" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно с пробным контрактом -->
<div class="modal fade" id="vmModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">{{ contracts_vm }}</h4>
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fe fe-x h2"></i></span>
                </button>
            </div>
            <div class="modal-body modal-lg" id="printVM">
                <div class="Section1">
                    <img src="http://185.146.156.207/logo.png" class="logo">
                    <h1>Договір<br>про надання послуг<br>за програмою «{{ contracts_vm }}»</h1>
                    <table border="0" width="100%">
                        <td class="tdleft">{{ dataVm.branch.geolocation }}</td>
<!--                         <td class="tdright">{{ dataVm.date }} рік</td> -->
                    <date-picker 
                          v-if="!printvm" 
                          v-model="dataVm.date" 
                          :editable="false" 
                          value-type="DD.MM.YYYY" 
                          format="DD.MM.YYYY">
                    </date-picker>
                        <span v-if="printvm">{{ dataVm.date }}</span>» р.<br>
                    </table> <br>
                    <p>Фізична особо-підприємець {{ dataVm.organization }}, надалі іменується «Виконавець», з одного боку, та законні представники
                        (опікуни, піклувальники)
                    </p>
                    <form>
                        <table class="tabs">
                            <tr>
                                <td><input v-model="dataVm.parent_surname" class="line" placeholder="Фамилия"></td>
                                <td><input v-model="dataVm.parent_name" class="line" placeholder="Имя"></td>
                                <td><input v-model="dataVm.parent_middle_name" class="line" placeholder="Отчество"></td>
                            </tr>
                        </table>
                        <br>ПІП, надалі - «Замовник»,<br>
                        <table class="tabs">
                            <tr>
                                <td width="25%">неповнолітньої дитини:</td>
                                <td><input v-model="dataVm.child_surname" class="line" placeholder="Фамилия"></td>
                                <td><input v-model="dataVm.child_name" class="line" placeholder="Имя"></td>
                                <td><input v-model="dataVm.child_middle_name" class="line" placeholder="Отчество"></td>
                            </tr>
                        </table>
                        ПІП дитини, що буде отримувати конкретні послуги, надалі -«Вихованець»<br>
                        а разом «Сторони», уклали цей Договір, про наступне:<br>
                        1. Предметом Договору є надання Виконавцем, Замовнику послуг з фізичної підготовкиза програмою«Відкрий
                        можливості» (надалі – «Програма») на визначених цим Договором умовах.<br>
                        2. Умови Програми:<br>
                        2.1. Програма складається з двох тренувань, тривалістю 45 хвилинкожне;<br>
                        2.2. Тренування відбуваються у спеціальному спортивному залі за адресою: {{ dataVm.branch.geolocation }}, {{ dataVm.branch.adress }};<br>
                        2.3. Заняття Програми проводять два тренери одночасно;<br>
                        2.4. Заняття проводяться без присутності батьків в спортивному залі;<br>
                        2.5. Виконавець видаєспортивну форму(футболка, шорти, гетри). На заняття Вихованець не допускається без
                        повного комплекту форми та змінного спортивного взуття.<br>
                        2.6. Вартість Програми складає {{ dataVm.price }} ({{ dataVm.price_title }}.).<br>
                        2.7. Два навчально-тренувальних заняття, що були оплачені Замовником за акційною вартістю250 (двісті
                        п’ятдесят), проводяться в чітко визначений Сторонами час для тренування:<br>
<!--                         <table class="tabs">
                            <tr>
                                <td>дні занять</td>
                                <td>
                                    <select v-model="days">
                                        <option v-for="day in dayselect">{{ day.day }}</option>
                                    </select>
                                </td>
                                <td>, час занять</td>
                                <td>
                                    <select v-model="time">
                                        <option v-for="time in timeselect">{{ time.time }}</option>
                                    </select>
                                </td>
                                <td>, а Вихованець закріплюється за конкретною групою.</td>
                            </tr>
                        </table> -->
                        3. Права та обов’язки Замовника<br>
                        3.1. Замовник має право сплатити послуги за акційною ціною {{ dataVm.price_stock }} ({{ dataVm.price_stock_title }}) грн. у випадку оплати
                        Програми в день першого безкоштовного (презентаційного) тренування «Перший Крок» та проходженні
                        занять Програми протягом наступних, семи днів після оплати;<br>
                        3.2. Замовник має право з поважних причин змінити час та групу для тренування лише в період дії акційної ціни
                        та наявності вільних місць в групах в перші 7 днів після оплати. Переважне право прийняття остаточного
                        рішення належить Виконавцю.<br>
                        3.3. У випадку переносу занять на більш пізній термін без поважної причини, Замовник зобов’язується оплатити
                        повну вартість Програми;<br>
                        3.4. Замовник має право спостерігати за заняттями на екрані телевізора в кімнаті батьків;<br>
                        4. Якщо Вихованцем було пропущено одне з двох навчально-тренувальних занять, Програма вважається
                        завершеною. Вартість пропущеного заняття Виконавцем не повертається.<br>
                        5.Замовник вносить заставу за форму в розмірі {{ dataVm.price_pledge }} ({{ dataVm.price_pledge_title }}) грн. до початку першого тренування. Форма повинна
                        бути повернена Виконавцю після другого заняття. Якщо Замовником не повертається форма в день закінчення
                        Програми, застава за форму вважається її оплатою. У випадку продовження тренувань Вихованця забазовими
                        програмами «Відкрий можливості» чи «Народження Зірки», застава в розмірі 400 (чотириста) грн. зараховується в
                        оплату вартості подальшогонавчання.<br>
                        6. Підписуючи даний Договір, Замовник дає згоду на проведення Виконавцем фото та відео зйомки тренувань з
                        подальшим використанням цих матеріалів в рекламних і маркетингових цілях.<br>
                        7. Підписуючи Договір, Замовник підтверджує факт відсутності обмежень, чи будь-яких протипоказань до занять
                        спортом у Вихованця.<br>
                        8. Договір підписується у 2-х примірниках, маючих однакову юридичну силу.
                    </form>
                    <table class="tabs">
                        <tr>
                            <td width="50%">
                                <b>Виконавець</b><br>
                                ФОП {{ dataVm.organization }}.<br>
                                Реквізити для оплати:<br>
                                {{ dataVm.requisites }}<br>
                                Адреса надання послуг:<br>
                                {{ dataVm.branch.geolocation }}, {{ dataVm.branch.adress }}<br>
                                Тел. {{ dataVm.branch.phone }}<br><br>
                                __________________________(підпис)
                            </td>
                            <td>
                                <b>Замовник</b><br>
                                ПІП ________________________________________<br>
                                ____________________________________________<br>
                                Адреса:_____________________________________<br>
                                ____________________________________________<br>
                                Тел._________________________________________<br>
                                E-mail_______________________________________<br>
                                ______________________________ (підпис)
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button @click="sendVm('vm')" type="button" class="btn btn-success">Сохранить и распечатать</button>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно с основным контрактом -->
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"></h4>
                <button @click="closeModal" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true"><i class="fe fe-x h2"></i></span>
                </button>
            </div>
            <div class="modal-body modal-lg" id="printmain">
                <div class="Section1">
                    <img src="http://185.146.156.207/logo.png" class="logo">
                    <h1>ЗАЯВА № {{ user_id }} від «
                        <date-picker 
                          v-if="!print" 
                          v-model="dataVm.date" 
                          :editable="false" 
                          value-type="DD.MM.YYYY" 
                          format="DD.MM.YYYY">
                        </date-picker>
                        <span v-if="print">{{ dataVm.date }}</span>» р.<br>
                        до Публічної пропозиції Договору надання послуг фізичного виховання дітей<br>
                        <span class="hide">(публічний договір розташований на офіційномусайті clubleva.ua)</span>
                    </h1>
                    <table class="tabs">
                        <tr>
                            <td width="25%">Я, законний представник</td>
                            <td v-if="!print"><input v-model="dataVm.parent_surname" class="line" placeholder="Фамилия"></td>
                            <td v-if="print"><span>{{dataVm.parent_surname}}</span></td>
                            <td v-if="!print"><input v-model="dataVm.parent_name" class="line" placeholder="Имя"></td>
                            <td v-if="print"><span>{{dataVm.parent_name}}</span></td>
                            <td v-if="!print"><input v-model="dataVm.parent_middle_name" class="line" placeholder="Отчество"></td>
                            <td v-if="print"><span>{{dataVm.parent_middle_name}}</span></td>
                        </tr>
                    </table>
                    <table class="tabs">
                        <tr>
                            <td width="25%">неповнолітньої дитини</td>
                            <td><input v-model="dataVm.child_name" class="line" placeholder="Имя"></td>
                            <td><input v-model="dataVm.child_surname" class="line" placeholder="Фамилия"></td>
                            <td>, дата народження</td>
                            <td>
                                <date-picker 
                                  v-if="!print" 
                                  v-model="dataVm.child_birthday" 
                                  :editable="false" 
                                  value-type="DD.MM.YYYY" 
                                  format="DD.MM.YYYY">
                                </date-picker>
                                <span v-if="print">{{ dataVm.child_birthday }}</span>
                            </td>
                            <td>надалі «Замовник»</td>
                        </tr>
                    </table>
                    <table class="tabs">
                        <tr>
                            <td class="gray">Телефон Замовника</td>
                            <td>
                              <input v-model="dataVm.parent_phone" class="line" placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'">
                            </td>
                            <td class="gray">Viber/Telegram Замовника</td>
                            <td>
                              <input v-model="dataVm.parent_viber" class="line" placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'">
                            </td>
                        </tr>
                        <tr>
                            <td class="gray">Email Замовника</td>
                            <td><input v-model="dataVm.parent_email" class="line"></td>
                            <td class="gray">Facebook/Instagram Замовника</td>
                            <td><input v-model="dataVm.parent_facebook" class="line"></td>
                            <td><input v-model="dataVm.parent_instagram" class="line"></td>
                        </tr>
                    </table>
                    Прошуприйняти вище вказану дитину на навчання за програмою навчання:<br>
                    <dynamic-select 
                      v-if="!print" 
                      :options="dataVm.programms" 
                      option-value="id" 
                      option-text="name" 
                      placeholder="Введите для поиска программы" 
                      v-model="programm" />
                    <span v-if="print">{{ programm.name }}</span>
                    з наступними умовами:
                    <dynamic-select 
                      v-if="!print" 
                      :options="dataVm.products" 
                      option-value="id" 
                      option-text="name" 
                      placeholder="Введите для поиска продукта" 
                      v-model="product" 
                      @input="stopDate(product.id)" />
                    <span v-if="print">{{ product.name }}</span>
                    <br>
                    <table class="tabs">
                        <tr>
                            <td class="gray" width="25%">Дата початку договору</td>
                            <td width="25%">
                                <date-picker v-if="!print" v-model="dataVm.end_actualy" :editable="false" value-type="YYYY-MM-DD" format="DD.MM.YYYY"></date-picker>
                                <span v-if="print">{{ dataVm.end_actualy }}</span>
                            </td>
                            <td class="gray" width="25%">Дата закінчення договору</td>
                            <td v-if="days" width="25%">{{ stoped() }}</td>
                        </tr>
                        <tr>
                            <td class="gray" width="25%">Загальна кількість занять за договором</td>
                            <td width="25%"><input v-if="product" placeholder="10" v-mask="'##'" v-model="product.classes_total" class="line"></td>
                            <td class="gray" width="25%">Кількість занятьна тиждень</td>
                            <td width="25%"><input v-if="product" placeholder="10" v-mask="'##'" v-model="product.classes_week" class="line"></td>
                        </tr>
                    </table>
                    Адреса надання послуг: {{ dataVm.branch.geolocation }}, {{ dataVm.branch.adress }}
                    Вартість занять за договором з урахування раніше пройдених програм та акційних пропозицій складає
                    <table class="tabs">
                        <td width="15%"><span v-if="product">{{product.price}}</span></td>
                        <td>(<span v-if="product">{{ product.price_title }}</span>) {{ dataVm.branch.currency }}.</td>
                    </table>
                    Вказана ціна діє для категорії часу занять « <span v-if="product">{{product.category_time}}</span> » (вказується категорія від 1 до 4)<br>
                    <br>Графік оплати:<br>
                    <table width="100%">
                        <tr v-if="pays" v-for="(time, index) in pays.pays">
                            <td>{{time.pay}} {{ dataVm.branch.currency }}. до {{ reversedMessage(time.day) }}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>Кількість акційних заморозок (<span v-if="product">{{product.freezing_total}}</span>)</td>
                            <td>Включаються заморозки по: (<span v-if="product">{{product.freezing_kolvo}}</span>) тренування</td>
                            <td>Форма включена увартість занять.</td>
                            <td>Розмiр</td>
                            <td>
                                <select v-model="form_size">
                                    <option>31</option>
                                    <option>32</option>
                                    <option>33</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    Підписанням цієї Заяви я підтверджую, що:<br>
                    1. приймаю в повному обсязі умови Публічної пропозиції Академії футболу для дошкільнят «Клуб Лева»<br>
                    на укладення Договору надання послуг фізичного виховання дітей, яка розміщена на офіційному сайті:
                    clubleva.ua;<br>
                    2. надаю право на обробку персональних даних, склад та зміст зібраних персональних даних, права
                    суб’єкта персональних даних та іншу інформацію згідно Закону України «Про захист персональних
                    даних»;<br>
                    3. вчасно та в повному обсязі сплачувати послуги за цим договором;<br>
                    4. ознайомлений з зобов’язанням повернення коштів у разі дострокового припинення Договору надання
                    послуг фізичного виховання дітей.<br>
                    <b>Замовник отримує одну копію даної Заяви. Оригінал заяви зберігає Виконавець до дати закінчення
                        договору.</b><br>
                    <table style="margin-top: 0.5in; border-spacing: 0.2in;" class="tabs">
                        <tr>
                            <td>«Виконавець» ФОП</td>
                            <td>_______________________</td>
                            <td>«Замовник»</td>
                            <td>_______________________</td>
                        </tr>
                        <tr>
                            <td>Підпис:</td>
                            <td>_______________________</td>
                            <td>Підпис:</td>
                            <td>_______________________</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="closeModal" type="button" class="btn btn-secondary">Закрыть</button>
                <button @click="sendVm('main')" class="btn btn-success">Сохранить и распечатать</button>
            </div>
        </div>
    </div>
</div>


	</div>
</template>

<script>


import DatePick from 'vue-date-pick';
Vue.use(DatePick);
import 'vue-date-pick/dist/vueDatePick.css';

import DatePicker from 'vue2-datepicker';
Vue.use(DatePicker);
import 'vue2-datepicker/index.css';


import Calendar from './Calendar.vue';

import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';

import DynamicSelect from 'vue-dynamic-select'
Vue.use(DynamicSelect)

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'http://185.146.156.207/test.css',
  ]
}

Vue.use(VueHtmlToPaper, options);

    export default {
      components: {Calendar},
      components: {DatePick},
      components: { DatePicker },
        props: {
          user_id: {},
          date: {},
        },
        data() {
            return{
              te: '',
              print: false,
              printvm: false,
              stopContract: '00.00.0000',
              pays: [],
              product: null,
              programm: null,
              dataVm: {
                branch:[],
                products: [],
              },
              dayselect: [
                  {day: 'Пн:Ср'},
                  {day: 'Вт:Чт'},
                  {day: 'Сб:Вс'},
              ],
              timeselect: [
                  {time: '08:00'},
                  {time: '09:00'},
                  {time: '10:00'},
                  {time: '11:00'},
                  {time: '12:00'},
                  {time: '13:00'},
                  {time: '14:00'},
                  {time: '15:00'},
                  {time: '16:00'},
                  {time: '17:00'},
                  {time: '18:00'},
                  {time: '19:00'},
                  {time: '20:00'},
                  {time: '21:00'},
              ],
                contracts_vm: 'Відкрий можливості',
                form_size: '',
                classes_week: '',
                days: '',
                time: '',
                start: '',
                contract_name: '',
                user:'',
                time: 1,
                resultMessage: '',
                days: null,
                startA: null,
            }
        },
        methods: {
            reversedMessage(days) {
              var D = new Date(this.dataVm.end_actualy);
              D.setDate(D.getDate() + days);
              return this.resultMessage = ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear();
              this.stoped();
            },

            stoped() {
              var D = new Date(this.dataVm.end_actualy);
              D.setDate(D.getDate() + this.product.days);
              return this.stopContract = ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear();
            },

            stopDate(id) {
            axios.get('api/v2/products/' + id)
            .then(response => {
                    this.pays = response.data.data
                })
            var D = new Date(this.dataVm.end_actualy);
            D.setDate(D.getDate() + this.product.days);
            this.stopContract = ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear();
            this.days = true
            },

            contract(contract_type){
                axios.post('api/v2/getvmcontract', {id : this.user_id, contract_type: contract_type}).then(response => {
                    this.dataVm = response.data.data
                });
                if (contract_type == 'vm') {
                    $('#vmModal').modal('show');
                    $('#selectModal').modal('hide');
                }else{
                    $('#mainModal').modal('show');
                    $('#selectModal').modal('hide');
                }
            },

            sendVm(contract_type) {



                if (contract_type == 'vm') {
                    if (
                    !this.dataVm.parent_surname || 
                    !this.dataVm.parent_name || 
                    !this.dataVm.parent_middle_name || 
                    !this.dataVm.child_surname || 
                    !this.dataVm.child_name) {
                        this.$alert("Не все поля заполнены");
                        return false
                }


                axios.post('api/v2/savecontract', {
                  contract_type: contract_type, 
                  base_id: this.user_id , 
                  name_vm: this.contracts_vm, 
                  date: this.dataVm.date, 
                  child_surname: this.dataVm.child_surname, 
                  child_name: this.dataVm.child_name, 
                  child_middle_name: this.dataVm.child_middle_name, 
                  parent_surname: this.dataVm.parent_surname, 
                  parent_name: this.dataVm.parent_name,
                  parent_middle_name: this.dataVm.parent_middle_name, 
                  currency: this.dataVm.branch.currency,
                  adress: this.dataVm.branch.geolocation + ', ' + this.dataVm.branch.adress,
                })
                this.printvm = true
                contract_type == 'vm' ? this.$htmlToPaper('printVM'): this.$htmlToPaper('printmain');
                contract_type == 'vm' ? $('#vmModal').modal('hide') : $('#mainModal').modal('hide');
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop.show").hide();
                this.printvm = false

                }else{


                if (!this.dataVm.parent_surname || 
                    !this.dataVm.parent_name || 
                    !this.dataVm.parent_middle_name || 
                    !this.dataVm.child_surname || 
                    !this.dataVm.child_name || 
                    !this.programm || 
                    !this.product
                    ) {
                        this.$alert("Не все поля заполнены");
                        return false
                }

            // Переведем дату обратно в человеческий формат для записи в базу
            var D = new Date(this.dataVm.end_actualy);
            this.startA = ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear();
                axios.post('api/v2/savecontract', {
                  contract_type: contract_type, 
                  base_id: this.user_id , 
                  name: this.product.name, 
                  name_vm: this.contracts_vm, 
                  date: this.dataVm.date,
                  start: this.startA,
                  end: this.stopContract, 
                  end_actually: this.stopContract, 
                  price: this.product.price, 
                  child_surname: this.dataVm.child_surname, 
                  child_name: this.dataVm.child_name, 
                  child_middle_name: this.dataVm.child_middle_name, 
                  child_birthday: this.dataVm.child_birthday, 
                  parent_surname: this.dataVm.parent_surname, 
                  parent_name: this.dataVm.parent_name,
                  parent_middle_name: this.dataVm.parent_middle_name, 
                  parent_phone: this.dataVm.parent_phone, 
                  parent_viber: this.dataVm.parent_viber, 
                  parent_email: this.dataVm.parent_email, 
                  parent_facebook: this.dataVm.parent_facebook, 
                  parent_instagram: this.dataVm.parent_instagram, 
                  form_size: this.form_size, 
                  classes_week: this.product.classes_week,
                  classes_total: this.product.classes_total,          
                  freezing_total: this.product.freezing_total,  
                  freezing_kolvo: this.product.freezing_kolvo,
                  pays: this.pays.pays,
                  programm: this.programm.name,
                  currency: this.dataVm.branch.currency,
                  adress: this.dataVm.branch.geolocation + ', ' + this.dataVm.branch.adress,
                  price_title: this.product.price_title,
                  category_time: this.product.category_time,

                })
                this.print = true
                contract_type == 'vm' ? this.$htmlToPaper('printVM'): this.$htmlToPaper('printmain');
                contract_type == 'vm' ? $('#vmModal').modal('hide') : $('#mainModal').modal('hide');
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop.show").hide();
                this.print = false
                this.programm = ''
                this.product = ''
                                }
             },

             closeModal(){
                this.programm = ''
                this.product = ''
                $('#mainModal').modal('hide');
                $('#info li:first-child a').tab('show')
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop.show").hide();
             },
             closeSelectModal(){
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop.show").hide();
             }
        }
}
</script>


<style type="text/css">

#vmModal, #mainModal{
    overflow-x: hidden;
    overflow-y: auto;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}




Size : 8.27in and 11.69 inches

@page Section1 {
size:8.27in 11.69in; 
margin:.5in .5in .5in .5in; 
mso-header-margin:.5in; 
mso-footer-margin:.5in; 
mso-paper-source:0;
}



.tdleft, .tdright, .line, .tabs{
  font-size: 0.138in;
}


div.Section1 {
page:Section1;
border: solid 0px;
} 
.logo{
  display: block;
  width: 1.917in;
  height: 0.590in;
}

.Section1 h1{
  text-align: center;
  font-size: 0.166in;
}

.tabs{
  width: 100%;
}

.tdleft{
  text-align: left;
}

.tdright{
  text-align: right;
}

.line{
  border: solid;
  border-width: 0px 0px 1px 0px;
  width: 100%;
  font-weight: bold;
}

.hide{
  font-weight: normal;
}

.gray{background:#cbc1c1;}

</style>