<template>

<div>

<form @submit.prevent="submit">
  <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
    <label class="form__label">Name</label>
    <input class="form-control form__input" v-model.trim="$v.name.$model"/>
  </div>
  <div class="error" v-if="!$v.name.required">Поле не может быть пустым</div>
  <!-- <div class="error" v-if="!$v.name.minLength">Имя должно содержать хотя бы {{$v.name.$params.minLength.min}} буквы.</div> -->
  <button class="button" type="submit" :disabled="submitStatus === 'PENDING'">Submit!</button>
</form>

</div>

</template>



<script>

import Vue from 'vue'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import { required, minLength } from 'vuelidate/lib/validators'

export default {
  data() {
    return {
      name: '',
      age: 0,
      submitStatus: null
    }
  },
  validations: {
    name: {
      required,
      minLength: minLength(4)
    }
  },
  methods: {
    submit() {
      console.log('submit!')
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR'
        alert("BED");
      } else {
        alert("OK");
        // do your submit logic here
        this.submitStatus = 'PENDING'
        setTimeout(() => {
          this.submitStatus = 'OK'
          this.name = null
          this.$v.name.$reset()
        }, 500)
      }
    }
  }
}


</script>

<style type="text/css">

.form-group--error {
    animation-name: shakeError;
    animation-fill-mode: forwards;
    animation-duration: .6s;
    animation-timing-function: ease-in-out;
}

.form-group--error input, .form-group--error textarea, .form-group--error input:focus, .form-group--error input:hover {
    border-color: #f79483;
}

.form-group--error + .form-group__message, .form-group--error + .error {
    display: block;
    color: #f57f6c;
}
.form-group__message, .error {
    font-size: 0.75rem;
    line-height: 1;
    display: none;
    margin-left: 14px;
    margin-top: -0.687rem;
    margin-bottom: 0.9375rem;
}

.form__input:hover, .form__textarea:hover {
    border-color: #cfcfcf;
}
</style>


