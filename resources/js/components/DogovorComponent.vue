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
        <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="contract('vm')">Контракт на пробное занятие</a></div>
        <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="contract('osn')">Контракт основной программы</a></div>
      </div>
      <div class="modal-footer">
        <button @click="vmContract = !vmContract" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>



<!-- Модальное окно с пробным контрактом -->
<div class="modal fade" id="vmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">{{ contracts_vm }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" id="printVM">
        <div class="Section1"> 
          <!-- <img src="Logo.png" class="logo"> -->
          <h1>Договір<br>про надання послуг<br>за програмою «{{ contracts_vm }}»</h1>
          <table border="0" width="100%">
            <td class="tdleft">{{ dataVm.branch.geolocation }}</td> <!-- Переменная города филиала с настройки филиала -->
            <td class="tdright">{{ dataVm.date }} рік</td> <!-- Вставляем переменные с текущей датой -->
          </table> <br>
          <p>Фізична особо-підприємець {{ dataVm.organization }}.<!-- переменная с настройки филиала. Юр. лицо -->, надалі іменується «Виконавець», з одного боку, та законні представники
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
                    <td><input v-model="dataVm.child_surname" type="" name="" class="line" placeholder="Фамилия"></td>
                    <td><input v-model="dataVm.child_name" type="" name="" class="line" placeholder="Имя"></td>
                    <td><input v-model="dataVm.child_middle_name" type="" name="" class="line" placeholder="Отчество"></td>
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
              <table class="tabs">
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
              </table>
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
        <button  type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
        <button @click="sendVm('vm')" type="button" class="btn btn-success" data-dismiss="modal">Сохранить и распечатать</button>
      </div>
    </div>
  </div>
</div>


<!-- Модальное окно с основным контрактом -->
<div class="modal fade" id="osnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" id="printOSN">
        <div class="Section1"> 
          <h1>ЗАЯВА № {{ user_id }} від  «{{ dataVm.date }}»  р.<br>
            до Публічної пропозиції Договору надання послуг фізичного виховання дітей<br>
            <span class="hide">(публічний договір розташований на офіційномусайті clubleva.ua)</span>
          </h1>
          <table class="tabs">
            <tr>
              <td width="25%">Я, законний представник</td>
              <td><input v-model="dataVm.parent_surname" class="line" placeholder="Фамилия"></td>
              <td><input v-model="dataVm.parent_name" class="line" placeholder="Имя"></td>
              <td><input v-model="dataVm.parent_middle_name" class="line" placeholder="Отчество"></td>
            </tr>
          </table>
          <table class="tabs">
            <tr>
              <td width="25%">неповнолітньої дитини</td>
              <td><input v-model="dataVm.child_name" class="line" placeholder="Имя"></td>
              <td><input v-model="dataVm.child_surname" class="line" placeholder="Фамилия"></td>
              <td>, дата народження</td>
              <td><input placeholder="12.05.1988" v-mask="'##.##.####'" v-model="dataVm.child_birthday" class="line"></td>
              <td>надалі «Замовник»</td>
            </tr> 
          </table>
          <table class="tabs">
            <tr>
              <td class="gray">Телефон Замовника</td>
              <td><input v-model="dataVm.parent_phone" class="line" placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'"></td>
              <td class="gray">Viber/Telegram Замовника</td>
              <td><input v-model="dataVm.parent_viber" class="line" placeholder="+3 (926) 123-45-67" v-mask="'+# (###) ###-##-##'"></td>
            </tr>
            <tr>
              <td class="gray">Email Замовника</td>
              <td><input v-model="dataVm.parent_email" class="line"></td>
              <td class="gray">Facebook/Instagram Замовника</td>
              <td><input v-model="dataVm.parent_facebook" class="line"></td>
              <td><input v-model="dataVm.parent_instagram" class="line"></td>
            </tr>
          </table>


    <select v-model="product">
        <option v-for="user in dataVm.products" v-bind:value="user">{{user.name}}</option>
    </select>



          Прошуприйняти вище вказану дитину на навчання за програмою навчання
<!--           <select style="font-weight: bold; border: 0;" v-model="contracts_name">
            <option v-for="product in dataVm.products">{{ product.name }}</option>
             <span v-if="selectedUser!==null">Выбрано: {{contracts_name.price}}</span> -->
          </select> з наступними умовами:<br>
          <table class="tabs">
            <tr>
              <td class="gray" width="25%">Дата початку договору</td>
              <td width="25%"><input placeholder="12.05.2020" v-mask="'##.##.####'" v-model="dataVm.date" class="line"></td>
              <td class="gray" width="25%">Дата закінчення договору</td>
              <td width="25%"><input placeholder="12.05.2020" v-mask="'##.##.####'" v-model="end" class="line"></td>
            </tr>
            <tr>
              <td class="gray" width="25%">Загальна кількість занять за договором</td>
              <td width="25%"><input placeholder="10" v-mask="'##'" v-model="dataVm.classes_total" class="line"></td>
              <td class="gray" width="25%">Кількість занятьна тиждень</td>
              <td width="25%">
                  <table>
                    <input type="radio" id="one" value="1" v-model="classes_week">
                    <label for="one">Один</label>
                    <input type="radio" id="two" value="2" v-model="classes_week">
                    <label for="two">Два</label>
                    <input type="radio" id="two" value="3" v-model="classes_week">
                    <label for="two">Три</label>
                  </table>
              </td>
            </tr>
          </table>
          Адреса надання послуг: {{ dataVm.branch.geolocation }}, {{ dataVm.branch.adress }}
          Вартість занять за договором з урахування раніше пройдених програм та акційних пропозицій складає
          <table class="tabs">   
            <td width="15%"><span v-if="product">{{product.price}}</span></td>
            <td> грн.</td>
            <td>({{ dataVm.price_title }}) грн.</td>
          </table>
            Вказана ціна діє для категорії часу занять « » (вказується категорія від 1 до 4)<br>
            Графік оплати:<br>
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
            договору.</b>
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
          <button @click="vmContract = !vmContract" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          <button @click="sendVm('osn')" type="button" class="btn btn-success" data-dismiss="modal">Сохранить и распечатать</button>
        </div>
      </div>
    </div>
  </div>

	</div>
</template>

<script>

    export default {
        props: {
          user_id: {},
        },
        data() {
            return{
            users:[
                {name:'Tom', age:22},
                {name:'Bob', age:25},
                {name:'Sam', age:28},
                {name:'Alice', age:26}
            ],
            product:null,
              dataVm: {branch:[],products: [],},
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
            	options: [
                  { text: 'Зирка лева', value: 'А' },
                  { text: 'Народження зирки', value: 'Б' },
                ],
                contracts_vm: 'Відкрий можливості',
                vmContract: true,
                form_size: '',
                classes_week: '',
                days: '',
                time: '',
                start: '',
                contract_name: '',
                user:''
            }
        },

        methods: {
        	contract(contract_type){
                axios.post('api/v2/getvmcontract', {id : this.user_id, contract_type: contract_type}).then(response => {
                    this.dataVm = response.data.data
                });
                if (contract_type == 'vm') {
                    $('#vmModal').modal('show');
                    $('#selectModal').modal('hide');
                }else{
                    $('#osnModal').modal('show');
                    $('#selectModal').modal('hide');
                }
            },
          sendVm(contract_type) {
                axios.post('api/v2/savecontract', {
                  contract_type: contract_type, 
                  base_id: this.user_id , 
                  name: this.product.name, 
                  name_vm: this.contracts_vm, 
                  start: this.dataVm.date,
                  end: this.dataVm.date, 
                  end_actually: this.dataVm.date, 
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
                  classes_week: this.dataVm.classes_week,
                  classes_total: this.dataVm.classes_total,          
                  freezing_total: this.product.freezing_total,  
                  freezing_kolvo: this.product.freezing_kolvo,
                  days: this.days,
                  time: this.time,
                })
                contract_type == 'vm' ? this.$htmlToPaper('printVM'): this.$htmlToPaper('printOSN');
             },
        }
}
</script>


<style type="text/css">

#vmModal, #osnModal{
    overflow-x: hidden;
    overflow-y: auto;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}
</style>