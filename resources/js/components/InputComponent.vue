<template>
    <span>
        <span>
            <a class="text-success" href="#" v-if="thisValue == '' || thisValue == null && !keyInputForm" @click.prevent="focus">Добавить</a>
        </span>
          <span v-if="!keyInputForm" class="card-title" @click="focus">{{ thisValue }}</span>

        <textarea
            v-if="textarea && keyInputForm"
            ref="edit"
            class="form-control"
            :id="id"
            :name="name"
            v-model="thisValue"
            @input="$emit('input', value)"
            @blur="keyInputForm = false; $emit('edit-field', $event)">
        </textarea>

        <input
            v-if="keyInputForm && !textarea && !datePicker"
            ref="edit"
            class="form-control"
            size="1"
            type="text"
            :placeholder="placeholder"
            :id="id"
            :name="name"
            v-model="thisValue"
            @input="$emit('input', value)"
            @keyup.enter="keyInputForm = false;$emit('edit-field', $event)"
            @blur="keyInputForm = false; $emit('edit-field', $event)">

        <date-picker
            v-if="keyInputForm && datePicker"
            :lang="lang"
            ref="edit"
            v-model="thisValue"
            :editable="false"
            value-type="DD.MM.YYYY"
            format="DD.MM.YYYY"
            @close="keyInputForm = false; $emit('edit-field', value, name ,datePicker)">
        </date-picker>
    </span>
</template>

<script>
    import {TheMask} from 'vue-the-mask'
    export default {
        components: {TheMask},
        props: {
            value: {
                type: String,
            },
            name: {
                type: String,
                required: true
            },
            id: {
                type: String,
            },
            placeholder: {
                type: String,
            },
            mask: {
                type: String,
            },
            // Свойство вывод textarea
            textarea: {
                type: String,
            },
            // Свойство выводы даты
            datePicker: {
                type: String,
            }
        },
        data() {
            return {
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                        weekdaysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                        monthsShort: ['Янв', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    },
                },
                keyInputForm: null,
                thisValue: this.value,
            }
        },
        methods: {
            focus(){
                this.keyInputForm = true
                setTimeout(() => {
                    this.$refs.edit.focus();
                }, 100);
            },
        }
    };
</script>
