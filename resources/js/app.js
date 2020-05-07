/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VTitle from 'v-title';
Vue.use(VTitle);

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)


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
      <input v-else type="text" :value="value" :placeholder="placeholder" :name="name" v-model="value" @input="$emit('input', value)" @blur="keyInputForm = false;$emit('edit-field', $event)">
      </div>
    </div>

  `
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('dogovor-component', require('./components/DogovorComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);
Vue.component('region-component', require('./components/RegionComponent.vue').default);
Vue.component('users2-component', require('./components/UsersComponent.vue').default);
Vue.component('addnewuser-component', require('./components/AddNewUserComponent.vue').default);
Vue.component('filter-component', require('./components/Filter/FilterComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
