<template>
    <div>
      <button class="btn btn-success" @click="redirect">REDIRECT</button>
    </div>
</template>

<script>
export default {
  data() {
    return {

    }
  },
      methods: {
        redirect(){
          axios.post('api/v2/getinfo/', {id: 14})
            },
      }
};
</script>
