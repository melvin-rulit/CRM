<template>
    <span>
        <span>
            <a class="text-success" href="#" v-if="value == null && !keyInputForm" @click.prevent="focus">Добавить</a>
        </span>
          <span v-if="!keyInputForm" class="card-title" @click="focus">{{ value }}</span>

          <input 
          v-else
          ref="edit"
          class="form-control" 
          size="1" 
          type="text" 
          :placeholder="placeholder" 
          :id="id" 
          :name="name" 
          v-model="value" @input="$emit('input', value)" 
          @keyup.enter="keyInputForm = false;$emit('edit-field', $event)" 
          @blur="keyInputForm = false;$emit('edit-field', $event)">
    </span>
</template>

<script>
export default {
    props: {
    value: {
      type: String,
      required: true
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
    }
  },
  data() {
    return {
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
