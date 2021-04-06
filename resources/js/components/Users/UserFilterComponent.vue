<template>

  <b-modal id="filter" title="Фильтр по сотрудникам" @ok="getFilter" centered ok-only ok-title="Фильтровать">
    <div class="card-body py-0">
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Имя</label>
        <div class="col-sm-9">
          <input class="form-control" v-model="name">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Фамилия</label>
        <div class="col-sm-9">
          <input class="form-control" v-model="surname">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Телефон</label>
        <div class="col-sm-9">
          <input class="form-control" v-model="phone">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
          <input class="form-control" v-model="email">
        </div>
      </div>

    </div>
  </b-modal>

</template>


<script>
export default {
  data() {
    return {
      name: '',
      surname: '',
      phone: '',
      email: '',
      users: [],
    }
  },

  methods: {

    showUserFilter(){
      this.$bvModal.show('filter')
    },

    getFilter(){
      axios.post('api/v2/getFilter', {name: this.name, surname: this.surname, phone: this.phone, email: this.email})
          .then(response => this.$emit('get-method', {users: response.data}))
    },

  }
}
</script>

