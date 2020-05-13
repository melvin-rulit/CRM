<template>
    <date-pick v-model="date" @blur="onChangeDate"></date-pick>
</template>

<script>
import DatePick from 'vue-date-pick';
import 'vue-date-pick/dist/vueDatePick.css';

export default {
    components: {DatePick},
    data: () => ({
        date: '2019-01-01'
    })
    ,
       methods: {
        onChangeDate: function(){
            this.$emit('onChangeDate', this.date)
	        }
        }
};
</script>
