<template>
	<div>

<!-- Модальное окно с основным контрактом -->
<div class="modal fade" id="ShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span @click="closeModal" aria-hidden="true"><i class="fe fe-x h2"></i></span>
                </button>
            </div>
            <div class="modal-body modal-lg">
                <div class="Section1" id="print">
                    <img src="http://185.146.156.207/logo.png" class="logo">
                    <h1>ЗАЯВА № {{contract.id}} від «{{contract.date}}» р.<br>
                        до Публічної пропозиції Договору надання послуг фізичного виховання дітей<br>
                        <span class="hide">(публічний договір розташований на офіційномусайті clubleva.ua)</span>
                    </h1>
                    <table class="tabs">
                        <tr>
                            <td width="25%">Я, законний представник</td>
                            <td>{{contract.parent_surname}}</td>
                            <td>{{contract.parent_name}}</td>
                            <td>{{contract.parent_middle_name}}</td>
                        </tr>
                    </table>
                    <table class="tabs">
                        <tr>
                            <td width="25%">неповнолітньої дитини</td>
                            <td>{{contract.child_surname}}</td>
                            <td>{{contract.child_name}}</td>
                            <td>, дата народження</td>
                            <td>{{contract.child_birthday}}</td>
                            <td>надалі «Замовник»</td>
                        </tr>
                    </table>
                    <table class="tabs">
                        <tr>
                            <td class="gray">Телефон Замовника</td>
                            <td>{{contract.parent_phone}}</td>
                            <td class="gray">Viber/Telegram Замовника</td>
                            <td>{{contract.parent_viber}}</td>
                        </tr>
                        <tr>
                            <td class="gray">Email Замовника</td>
                            <td>{{contract.parent_email}}</td>
                            <td class="gray">Facebok/Instagram Замовника</td>
                            <td>{{contract.parent_facebook}} / {{contract.parent_instagram}}</td>
                        </tr>
                    </table>
                    Прошуприйняти вище вказану дитину на навчання за програмою навчання
                    <span>{{contract.programm}}</span>
                    з наступними умовами:
                    <span>{{contract.name}}</span>
                    <table class="tabs">
                        <tr>
                            <td class="gray" width="25%">Дата початку
                                договору</td>
                            <td width="25%"><span>{{contract.start}}</span></td>
                            <td class="gray" width="25%">Дата закінчення
                                договору</td>
                            <td width="25%"><b>{{contract.end}}</b></td>
                        </tr>
                        <tr>
                            <td class="gray" width="25%">Загальна кількість
                                занять за договором</td>
                            <td width="25%">{{contract.classes_total}}</td>
                            <td class="gray" width="25%">Кількість занять
                                на тиждень</td>
                            <td width="25%">
                                {{contract.classes_kolvo}}
                            </td>
                        </tr>
                    </table>
                    Адреса надання послуг: {{contract.adress}}.
                    Вартість занять за договором з урахування раніше пройдених програм та акційних пропозицій складає
                    <table class="tabs">
                        <tr>
                            <td width="15%">{{contract.price}}</td>
                            <td>( {{contract.price_title}} ) {{contract.currency}}.</td>
                        </tr>
                    </table>
                    Вказана
                    ціна діє для категорії часу занять « {{contract.category_time}} »(вказується категорія від 1 до 4), за розкладом занятть:
                    <br>Графік оплати:<br>
                    <table width="100%">
                        <tr v-if="contract.contract_pays" v-for="item in contract.contract_pays">
                            <td>{{item.pay}} {{contract.currency}}. до {{item.date}}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>Кількість акційних заморозок ({{contract.freezing_total}})</td>
                            <td>Включаються заморозки по: ({{contract.freezing_kolvo}}) тренування
                            </td>
                            <td>Форма включена у
                                вартість занять.</td>
                            <td>Розмiр</td>
                            <td>{{contract.form_size}}</td>
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
                <button @click="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button @click="printContract" class="btn btn-success">Распечатать</button>
            </div>
        </div>
    </div>
</div>

	</div>
</template>

<script>


    $('#ShowModal').modal({
      backdrop: 'static',
      keyboard: false
    })


import Vue from 'vue';
import VueHtmlToPaper from 'vue-html-to-paper';

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
        data() {
            return{
                contract: []
            }
        },
        methods: {
            showModal(id){
                $('#ShowModal').modal('show');
                    axios.post('api/v2/showcontract' ,{id: id}).then(response => {
                    this.contract = response.data.data
                    })
            },
            printContract(){
                this.$htmlToPaper('print')
                $('#ShowModal').modal('hide')
            },
            closeModal(){
                $('#info li:first-child a').tab('show')
            }
        }
}
</script>

<style>
    #ShowModal{
        overflow-x: hidden;
        overflow-y: auto;
    }
</style>