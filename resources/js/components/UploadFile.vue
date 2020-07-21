<template>
    <div class="container">
        <input @change="send" type="radio" id="one" value="mother_lpr" v-model="picked">
        <label for="one">Один</label>
        <br>
        <input @change="send" type="radio" id="two" value="father_lpr" v-model="picked">
        <label for="two">Два</label>
        <br>
        <input @change="send" type="radio" id="three" value="other_relative_lpr" v-model="picked">
        <label for="two">Три</label>
        <br>
        <span>Выбрано: {{ picked }}</span>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                file: '',
                picked: ''
            }
        },

        methods: {

            send(){
                axios.post( '/api/V2/halls/', {test: this.picked})
            },

            submitFile(){
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post( '/api/V2/halls',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(){
                    console.log('SUCCESS!!');
                })
                    .catch(function(){
                        console.log('FAILURE!!');
                    });
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            }
        }
    }
</script>
