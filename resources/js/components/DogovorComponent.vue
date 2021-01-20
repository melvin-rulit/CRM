<template>
	<div>
        <!-- Модальное окно с оплатой -->
        <b-modal id="pay" title="Оплата" centered ok-only ok-title="Ок">
            <div class="card-body py-0">
                <div class="form-group row mt-4">
                    <label class="col-sm-3 col-form-label">Сумма</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="productVm.price">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-3 col-form-label">Сумма прописью</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="productVm.price_title">
                    </div>
                </div>
            </div>
        </b-modal>

        <!-- Модальное окно с оплатой в основном контраакте-->
        <b-modal id="pay_main" title="Оплата" centered ok-only ok-title="Ок" @ok="savePaysPays">
            <div class="card-body py-0">
                <div class="form-group row mt-4">
                    <label class="col-sm-3 col-form-label">Сумма</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="pay_main">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-3 col-form-label">Сумма прописью</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="product.price_title">
                    </div>
                </div>
            </div>
        </b-modal>

        <!-- Модальное окно с частичной оплатой в основном контраакте перед печатью-->
        <b-modal id="editPay" title="Частичная оплата" centered ok-only ok-title="Ок" @ok="savePartially">
            <div class="card-body py-0">
                <p class="text-center">Текущая оплата составляет
                    <span class="h3" v-if="pays.pays">{{ pays.pays[0].pay }}</span> , введите сумму</p><hr>
                <div class="form-group row mt-4">
                    <label class="col-sm-3 col-form-label">Сумма</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-mask="'##############'" v-model="pay_artially">
                    </div>
                </div>
            </div>
        </b-modal>

        <!-- Модальное окно с частичной оплатой в ВМ контраакте перед печатью-->
        <b-modal id="editPayVM" title="Частичная оплата" centered ok-only ok-title="Ок" @ok="savePartiallyVM">
            <div class="card-body py-0">
                <p class="text-center">Текущая оплата составляет
                    <span class="h3">{{ productVm.price }}</span> , введите сумму</p><hr>
                <div class="form-group row mt-4">
                    <label class="col-sm-3 col-form-label">Сумма</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-mask="'##############'" v-model="pay_artiallyVM">
                    </div>
                </div>
            </div>
        </b-modal>

        <!-- Модальное окно с пробным контрактом -->
        <b-modal id="dogovorVm"
                 centered
                 @ok="sendVm('vm')"
                 @hidden="closeModal"
                 ok-title="Сохранить и распечатать"
                 cancel-title="Закрыть"
                 size="lg"
                 title="Договор Виткрый можливости">
            <div class="modal-body modal-lg" id="printVM">
                <div class="Section1">
                    <img src="http://185.146.156.207/logo.png" class="logo">
                    <h1>Договір<br>про надання послуг<br>за програмою «{{ contracts_vm }}»</h1>
                    <table border="0" width="100%">
                        <td class="tdleft">{{ dataVm.branch.geolocation }}</td>
                        <!--                         <td class="tdright">{{ dataVm.date }} рік</td> -->
                        <date-picker
                            v-if="!printvm"
                            :lang="lang"
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
                        2.6. Вартість Програми складає {{ productVm.price }} ({{ productVm.price_title }}.).
                        <a v-if="productVm" href="#" @click.prevent="showEditPayModal">Изменить</a><br>
                        2.7. Два навчально-тренувальних заняття, що були оплачені Замовником за акційною вартістю250 (двісті
                        п’ятдесят), проводяться в чітко визначений Сторонами час для тренування:<br>

                        <span v-if="!print">выберите программу обучения</span>

                        <dynamic-select
                            :options="dataVm.programms_vm"
                            class="mb-2"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска программы"
                            v-model="programm"
                            @input="getHalls()" />

                        <span v-if="!print">выберите продукт</span>

                        <dynamic-select
                            :options="newProducts"
                            class="mb-2"
                            option-value="id"
                            option-text="name"
                            placeholder="Введите для поиска программы"
                            v-model="productVm"
                            />

                        <span v-if="!print">выберите зал</span>

                        <b-form-select
                            v-model="hall"
                            class="mb-2"
                            :options="halls"
                            value-field="id"
                            text-field="name"
                            :disabled="!programm"
                            @change="getGroup()"
                        ></b-form-select>

                        <span v-if="!print">выберите группу</span>

                        <select
                            class="form-control mb-2"
                            v-if="shedule_hall && !print" v-model="shedule">
                            <option :value="item" v-for="item in shedule_hall">{{ item.name }} - ({{ select_schedule(item.hall) }})</option>
                        </select>

                        <div class="p-2">
                            <span v-if="!print && shedule">выбор недели группы</span>

                            <date-picker
                                v-if="!print && shedule"
                                v-model="week"
                                value-type="YYYY-MM-DD"
                                type="week"
                                format="MM.YYYY"
                                placeholder="Выберите неделю">
                            </date-picker>
                        </div>

                        <div class="py-3">
                            <a v-if="productVm" href="#" @click.prevent="showEditPayVMModal">Внести часть оплаты</a><br>
                            <span>Внесена часть оплаты на сумму {{ pay_artiallyVM }}</span><br>
                            <span>Остаток {{ balance }}</span><br>
                        </div>




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
                                {{ dataVm.organization }}.<br>
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
        </b-modal>


        <!-- Модальное окно с основным контрактом -->
        <b-modal id="dogovorMain"
                 centered
                 @ok="sendVm('main')"
                 @hidden="closeModal"
                 ok-title="Сохранить и распечатать"
                 size="lg"
                 title="Основоной договор">

            <template #modal-footer="{ ok, cancel, hide }">
                <b-button @click="sendVm('main')">
                    Сохранить и распечатать
                </b-button>
                <b-button @click="closeModal">
                    Отменить
                </b-button>
                <b-button @click="showPayMod">
                    Изменить платеж
                </b-button>
            </template>

            <div class="modal-body modal-lg pt-0" id="printmain">
                <div class="Section1">
                    <img src="http://185.146.156.207/logo.png" class="logo">
                    <h1>ЗАЯВА № {{ user_id }} від «
                        <date-picker
                            v-if="!print"
                            :lang="lang"
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
                        </tr>
                        <tr>
                            <td>, дата народження</td>
                            <td>
                                <date-picker
                                    v-if="!print"
                                    :lang="lang"
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
                            <td width="25%">
                                <input v-model="dataVm.parent_phone" class="line" v-mask="'+## (###) ###-##-##'">
                            </td>
                            <td class="gray">Viber/Telegram Замовника</td>
                            <td>
                                <input v-model="dataVm.parent_viber" class="line" v-mask="'+## (###) ###-##-##'">
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
                    <hr>
                    Прошуприйняти вище вказану дитину на навчання за програмою навчання:<br>
                    <dynamic-select
                        v-if="!print"
                        :options="dataVm.programms"
                        option-value="id"
                        option-text="name"
                        placeholder="Введите для поиска программы"
                        v-model="programm"
                        @input="getHalls()" />
                    <span v-if="print">{{ programm.name }}</span>
                    з наступними умовами:
                    <dynamic-select
                        v-if="!print && programm"
                        :options="newProducts"
                        option-value="id"
                        option-text="name"
                        placeholder="Введите для поиска продукта"
                        v-model="product"
                        @input="stopDate(product.id)" />
                    <span v-if="print">{{ product.name }}</span>
                    <hr>
                    <span v-if="!print">выберите зал</span>
                    <b-form-select
                        v-if="!print"
                        v-model="hall"
                        :options="halls"
                        value-field="id"
                        text-field="name"
                        :disabled="!programm"
                        @change="getGroup()"
                    ></b-form-select>

                    <span v-if="!print">выберите группу</span>

                    <select class="form-control" v-if="shedule_hall && !print" v-model="shedule">
                        <option :value="item" v-for="item in shedule_hall">{{ item.name }} - ({{ select_schedule(item.hall) }})</option>
                    </select>

                    <span v-if="shedule && print">{{ shedule.name }} - {{ select_schedule(shedule.hall) }}</span>

                    <br>
                    <table class="tabs">
                        <tr>
                            <td class="gray" width="25%">Дата початку договору</td>
                            <td width="25%">
                                <date-picker v-if="!print" :lang="lang" v-model="dataVm.end_actualy" :editable="false" value-type="YYYY-MM-DD" format="DD.MM.YYYY"></date-picker>
                                <span v-if="print">{{ dataVm.end_actualy }}</span>
                            </td>
                            <td class="gray" width="25%">Дата закінчення договору</td>
                            <td v-if="days" width="25%">{{ stoped() }}</td>
                        </tr>
                        <tr>
                            <td class="gray" width="25%">Загальна кількість занять за договором</td>
                            <td width="25%"><input v-if="product" placeholder="10" v-mask="'##'" v-model="product.classes_total" class="line"></td>
                            <td class="gray" width="25%">Кількість занять на тиждень</td>
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

                    <a v-if="pays.pays" href="#" @click.prevent="showEditPayMainModal">Изменить</a><br>

                    <br>Графік оплати:<br>
                    <div class="mt-2 mb-2">
                            <span v-if="pays" v-for="(time, index) in pays.pays">
                                <strong>{{(index+1)}}.</strong>{{time.pay}} {{ dataVm.branch.currency }}. до {{ reversedMessage(time.day) }}  |                      </span>

                        <br><a href="#" v-if="!print" @click="showPayMod">Изменить платеж</a>
                    </div>

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
                            <td>«Виконавець»</td>
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
        </b-modal>

	</div>
</template>

<script>

    import 'vue-select/dist/vue-select.css';


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
                newProducts: [],
              print: false,
              printvm: false,
              stopContract: '00.00.0000',
              pays: [],
              product: '',
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
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                        weekdaysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                        monthsShort: ['Янв', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    },
                },
                halls: [],
                shedule_hall: [],
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
                hall: '',
                shedule: '',
                productVm: '',
                pay_main: '',
                pay_artially: '',
                pay_artiallyVM: '',
                week: '',
                balance: '',
            }
        },


        methods: {

            getWeek(){


            },

            showEditPayModal(){
                this.$bvModal.show('pay')
            },

            showEditPayVMModal(){
                this.$bvModal.show('editPayVM')
            },

            showEditPayMainModal(){
                this.$bvModal.show('pay_main')
                this.pay_main = this.pays.pays[0].pay
            },

            showPayMod(){
                this.$bvModal.show('editPay')
            },

            savePaysPays(){
                this.pays.pays[0].pay = this.pay_main
            },

            savePartially(){
                if(this.pay_artially !== ''){
                    if (this.pay_artially < this.pays.pays[0].pay){
                        this.balance = this.product.price - this.pay_artially
                        this.pays.pays[0].pay = this.pays.pays[0].pay - this.pay_artially
                        this.pay_artially = ''
                    }else{
                        this.$alert("Сумма не может быть больше суммы оплаты");
                    }
                }else{
                    this.$alert("Введите сумму частичной оплаты");
                }

            },

            savePartiallyVM(){
                this.balance = this.productVm.price - this.pay_artiallyVM
            },

            // Получаем сокращеное название дня по дате и формируем селект
            select_schedule(items) {
                var days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
                return items.map(x => ` ${days[x.day - 1]} - ${x.time}:00 `).join(', ' )
            },

            getGroup(){
                axios.post('api/v2/getgroup', {hall_id : this.hall, programm_id: this.programm.id})
                    .then(response => {
                        this.shedule_hall = response.data.data
                    })
            },

            getHalls(){
                this.hall = ''
                this.product = ''
                axios.post('api/v2/gethalls', {branch_id : this.dataVm.branch.id})
                    .then(response => {
                        this.halls = response.data.data
                    })

                axios.post('api/v2/getProducts', {branch_id : this.dataVm.branch.id, programm_id: this.programm.id})
                    .then(response => {this.newProducts = response.data.data})
            },

            reversedMessage(days) {
                var D = new Date(this.dataVm.end_actualy);
                D.setDate(D.getDate() + days);
                return this.resultMessage = ('0' + D.getDate()).slice(-2) + '.' + ('0' + (D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear();
                this.stoped();
            },

            stoped() {
                var D = new Date(this.dataVm.end_actualy)
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

            getInfoFromContract(){
                axios.post('api/v2/getvmcontract', {id : this.user_id})
                    .then(response => {this.dataVm = response.data.data});
            },

            getContractVm(){
                this.$bvModal.show('dogovorVm')
                this.getInfoFromContract()
            },

            getContractMain(){
                this.$bvModal.show('dogovorMain')
                this.getInfoFromContract()
            },


            sendVm(contract_type) {

                if (contract_type == 'vm') {
                    if (
                    !this.dataVm.parent_surname ||
                    !this.dataVm.parent_name ||
                    !this.dataVm.child_surname ||
                    !this.productVm ||
                    !this.dataVm.child_name) {
                        this.$alert("Не все поля заполнены");
                        return false
                }


                axios.post('api/v2/savecontract', {
                  week: this.week,
                  contract_type: contract_type,
                  base_id: this.user_id ,
                  name_vm: this.productVm.name,
                  date: this.dataVm.date,
                  price: this.productVm.price,
                  child_surname: this.dataVm.child_surname,
                  child_name: this.dataVm.child_name,
                  child_middle_name: this.dataVm.child_middle_name,
                  parent_surname: this.dataVm.parent_surname,
                  parent_name: this.dataVm.parent_name,
                  parent_middle_name: this.dataVm.parent_middle_name,
                  currency: this.dataVm.branch.currency,
                  adress: this.dataVm.branch.geolocation + ', ' + this.dataVm.branch.adress,
                    group_id: this.shedule.id,
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
                  balance: this.balance,
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
                  programm_id: this.programm.id,
                  currency: this.dataVm.branch.currency,
                  adress: this.dataVm.branch.geolocation + ', ' + this.dataVm.branch.adress,
                  price_title: this.product.price_title,
                  category_time: this.product.category_time,
                  group_id: this.shedule.id,

                })
                this.print = true
                contract_type == 'vm' ? this.$htmlToPaper('printVM'): this.$htmlToPaper('printmain');
                contract_type == 'vm' ? $('#vmModal').modal('hide') : $('#mainModal').modal('hide');
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop.show").hide();
                this.print = false
                this.programm = ''
                this.product = ''
                this.hall = ''
                this.shedule = ''
                                }
             },

             closeModal(){
                this.programm = ''
                this.product = ''
                 this.hall = ''
                 this.shedule = ''
                 this.productVm = ''
                $('#mainModal').modal('hide');
                $('#info li:first-child a').tab('show')
                $(document.body).removeClass("modal-open");
                $(".modal-backdrop.show").hide();
                 this.pay_main = ''
                     this.pay_artially = ''
                     this.balance = ''
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
    margin: 10px 0 10px 0;
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
