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
        <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="vmModal()">Контракт на пробное занятие</a></div>
        <!-- <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="vmContract = !vmContract, contractSelected = !contractSelected">Контракт основной программы</a></div> -->

        <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="osnModal()">Контракт основной программы</a></div>
        <form v-show="contractSelected" class="form-inline" style="margin: 0 auto;">
          <div class="form-group mb-2">
            <label>Выберите программу</label>
          </div>
          <div class="form-group mx-sm-3 mb-2">
            <select v-model="selected">
              <option v-for="option in options" v-bind:value="option.value">
                {{ option.text }}
              </option>
            </select>
          </div>
          <button type="submit" class="btn btn-sm btn-primary mb-2">Выбрать</button>
        </form>
      </div>
      <div class="modal-footer">
        <button @click="vmContract = !vmContract, contractSelected = !contractSelected" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>



<!-- Модальное окно с пробным контрактом -->
<div class="modal fade" id="vmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">{{ dataVm.contract_name }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" id="printVM">
        <div class="Section1"> 
          <!-- <img src="Logo.png" class="logo"> -->
          <h1>Договір<br>
            про надання послуг<br>
            за програмою «{{ dataVm.contract_name }}»
          </h1>
          <table border="0" width="100%">
            <tr></tr>
            <td class="tdleft">{{ dataVm.town }}<!-- Переменная города филиала с настройки филиала --></td>
            <td class="tdright">{{ dataVm.date }} рік</td>
            <!-- Вставляем переменные с текущей датой -->
          </table>  
          <p></p>  
          <p>
            Фізична особо-підприємець {{ dataVm.ip }}.<!-- переменная с настройки филиала. Юр. лицо -->, надалі іменується «Виконавець», з одного боку, та законні представники
            (опікуни, піклувальники)
          </p>
          <form>
              <table class="tabs">
              <tr>
              <td><input v-model="dataVm.parent_surname" class="line" placeholder="Фамилия">
              </td>
              <td>
              <input v-model="dataVm.parent_name" class="line" placeholder="Имя">
              </td>
              <td>
              <input v-model="dataVm.parent_middle_name" class="line" placeholder="Отчество">
              </td>
              <!-- ФИО родителя -->
              </tr>
              </table>
            <br>
            ПІП, надалі - «Замовник»,<br>
<!--             <table class="tabs">
              <tr>
                <td width="25%">неповнолітньої дитини:</td><td>
                  <input v-model="dataVm.child_fio" class="line">
                </td>
              </tr>
            </table> -->

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
            2.2. Тренування відбуваються у спеціальному спортивному залі за адресою: {{ dataVm.branch_adress }};<!-- Здесь переменная с настройки филиала (адрес) --><br>
            2.3. Заняття Програми проводять два тренери одночасно;<br>
            2.4. Заняття проводяться без присутності батьків в спортивному залі;<br>
            2.5. Виконавець видаєспортивну форму(футболка, шорти, гетри). На заняття Вихованець не допускається без
            повного комплекту форми та змінного спортивного взуття.<br>
            2.6. Вартість Програми складає {{ dataVm.programm_price }} ({{ dataVm.programm_price_title }}.).<!-- Здесь переменная из настройки продукта ВМ там его цена --><br>
            2.7. Два навчально-тренувальних заняття, що були оплачені Замовником за акційною вартістю250 (двісті
            п’ятдесят), проводяться в чітко визначений Сторонами час для тренування:<br>
            <table class="tabs">
              <tr>
                <td>дні занять</td>
                <td>
                  <select name="" class="line">
                    <option>Пн:Ср</option>
                    <option>Вт:Чт</option>
                    <option>Сб:Вс</option>
                  </select>
                </td><!-- Время тренировки. Улетает в график -->
                <td>, час занять</td><td>
                  <select type="" name="" class="line">
                    <option>08:00</option>
                    <option>09:00</option>
                    <option>10:00</option>
                    <option>11:00</option>
                    <option>12:00</option>
                    <option>13:00</option>
                    <option>14:00</option>
                    <option>15:00</option>
                    <option>16:00</option>
                    <option>17:00</option>
                    <option>18:00</option>
                    <option>19:00</option>
                    <option>20:00</option>
                    <option>21:00</option>
                  </select>
                </td>
                <td>, а Вихованець закріплюється за конкретною групою.</td>
              </tr>
            </table>
            3. Права та обов’язки Замовника<br>
            3.1. Замовник має право сплатити послуги за акційною ціною {{ dataVm.programm_price_stock }} ({{ dataVm.programm_price_stock_title }}) грн. у випадку оплати<!-- Цена подтягивается с настройки филиала (акционная цена) -->
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
            5.Замовник вносить заставу за форму в розмірі {{ dataVm.programm_price_pledge }} ({{ dataVm.programm_price_pledge_title }}) грн.<!-- Подтягиваем из настройки филиала (Стоимость залога) --> до початку першого тренування. Форма повинна
            бути повернена Виконавцю після другого заняття. Якщо Замовником не повертається форма в день закінчення
            Програми, застава за форму вважається її оплатою. У випадку продовження тренувань Вихованця забазовими
            програмами «Відкрий можливості» чи «Народження Зірки», застава в розмірі 400 (чотириста) грн. зараховується в
            оплату вартості подальшогонавчання.
            <br>
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
                ФОП {{ dataVm.ip }}.<br><!-- Переменная из настроек филиала  -->
                Реквізити для оплати:<br>
                {{ dataVm.requisites }}<!-- тоже из настроек филиала --><br>
                Адреса надання послуг:<br>
                {{ dataVm.branch_adress }}<br>
                Тел. {{ dataVm.phone }}<br><br><!-- Тоже из настроек филиала -->
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
        <button @click="sendVm" type="button" class="btn btn-success" data-dismiss="modal">Сохранить и распечатать</button>
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
      <div class="modal-body modal-lg" id="printVM">
        <div class="Section1"> 
          <h1>ЗАЯВА № _________ від «___» ____________ ____ р.<br>
            до Публічної пропозиції Договору надання послуг фізичного виховання дітей<br>
            <span class="hide">(публічний договір розташований на офіційномусайті clubleva.ua)</span>
          </h1>
          <table class="tabs">
            <tr>
              <td width="25%">Я, законний представник</td><td><input type="" name="" class="line"></td>
            </tr>
          </table>
          <table class="tabs">
            <tr>
              <td width="25%">неповнолітньої дитини</td>
              <td><input type="" name="" class="line"></td>
              <td>, дата народження</td><td><input type="date" name="" class="line"></td><td>надалі «Замовник»</td>
            </tr> 
          </table>
          <table class="tabs">
            <tr>
              <td class="gray">Телефон Замовника</td>
              <td><input type="" name="" class="line" required data-mask="+0 (000) 000-00-00" placeholder="+_ (___) ___ __ __"></td>
              <!-- Не забудь маску номера ;) -->
              <td class="gray">Viber/Telegram Замовника</td>
              <td><input type="" name="" class="line" required data-mask="+0 (000) 000-00-00" placeholder="+_ (___) ___ __ __"></td>
            </tr>
            <tr>
              <td class="gray">Email Замовника</td>
              <td><input type="" name="" class="line"></td>

              <td class="gray">Facebok/Instagram Замовника</td>
              <td><input type="" name="" class="line"></td>
            </tr>
          </table>
          Прошуприйняти вище вказану дитину на навчання за програмою навчання 
          <select style="font-weight: bold; border: 0;">
            <option>«Вперед до зiрок»</option>
            <option>«Народження Зiрки»</option>
            <option>«Зiрка Лева»</option>
            <option>«Лiдер Прайду»</option>
            <option>«Супер Зiрка»</option>
            <option>«Школа футболу»</option>
          </select> з наступними умовами:<br>
          <!-- В селект загоняем продукты из настройки  -->
          <table class="tabs">
            <tr>
              <td class="gray" width="25%">Дата початку
              договору</td><td width="25%"><input v-model="dataVm.data" type="date" name="" class="line"></td>
              <td class="gray" width="25%">Дата закінчення
              договору</td><td width="25%"><b>___________<!-- Сюда вставляем дату окнчания по формуле --></b></td>
            </tr>

            <tr>
              <td class="gray" width="25%">Загальна кількість
              занять за договором</td><td width="25%"><input type="" name="" class="line"></td>
              <td class="gray" width="25%">Кількість занять
              на тиждень</td>
              <td width="25%">
                <table>
                  <tr>
                    <td>Одне:<input type="checkbox" name="" class="line"></td>
                    <td>Два:<input type="checkbox" name="" class="line"></td>
                    <td>Три:<input type="checkbox" name="" class="line"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          Адреса надання послуг: Добровольського 122/2.<!-- Адрес из настроек филиала -->
          Вартість занять за договором з урахування раніше пройдених програм та акційних пропозицій складає
          <table class="tabs">
            <tr></tr>    
            <td width="15%">
              <input type="" name="" class="line"></td><td> грн.</td><td>(____________________________<!-- Здесь цена буквами тоже из настроек -->) грн.</td><!-- Категория времени тоже в настройке программы -->
            </table>
            Вказана
            ціна діє для категорії часу занять « » (вказується категорія від 1 до 4)<br>
            Графік оплати:<br>
            <!-- Здесь перечисляем даты и суммы оплат, опять же из продукта  -->
            <table>
              <tr>
                <td>Кількість акційних заморозок (____<!-- Тоже из настройки продукта -->)</td>
                <td>Включаються заморозки по: (____) тренування<!-- Так же из настройки продукта --></td><td>Форма включена у
                вартість занять.</td><td>Розмiр</td>
                <td>
                  <select>
                    <option>31</option>
                    <option>31</option>
                    <option>31</option>
                    <option>31</option>
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
          <button @click="vmContract = !vmContract, contractSelected = !contractSelected" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
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
              dataVm: {},
            	options: [
                  { text: 'Зирка лева', value: 'А' },
                  { text: 'Народження зирки', value: 'Б' },
                ],   
                vmContract: true,
                contractSelected: false,
            }
        },

        methods: {
        	vmModal(){
                axios.post('api/v2/getvmcontract', {id : this.user_id}).then(response => {
                    this.dataVm = response.data.data
                });
                $('#vmModal').modal('show');
                $('#selectModal').modal('hide');
            },
          osnModal(){
                $('#osnModal').modal('show');
                $('#selectModal').modal('hide');
            },
          sendVm() {
                axios.post('get', {
                  base_id: this.user_id , 
                  name: this.dataVm.contract_name, 
                  start: this.dataVm.date, 
                  end: this.dataVm.date, 
                  child_surname: this.dataVm.child_surname, 
                  child_name: this.dataVm.child_name, 
                  child_middle_name: this.dataVm.child_middle_name, 
                  parent_surname: this.dataVm.parent_surname, 
                  parent_name: this.dataVm.parent_name,
                  parent_middle_name: this.dataVm.parent_middle_name, 
                  active: true
                })
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