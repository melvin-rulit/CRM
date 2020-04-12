<template>
	<div>
		<!-- Modal -->
<div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Выберите контракт</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="row modal-body">

            <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="vmModal()">Контракт на пробное занятие</a></div>

            <div v-show="vmContract" class="col-md-6"><a href="javascript:void(0)" @click="vmContract = !vmContract, contractSelected = !contractSelected">Контракт основной программы</a></div>




            <form v-show="contractSelected" class="form-inline">
              <div class="form-group mb-2">
                <label>Выберите программу</label>
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <select v-model="selected">
                    <option v-for="option in options" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>
              </div>
              <button type="submit" class="btn btn-sm btn-primary mb-2">Выбрать</button>
            </form>



      </div>
      <div class="modal-footer">
        <button @click="vmContract = !vmContract, contractSelected = !contractSelected" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
	</div>
</template>

<script>

    export default {
        data() {
            return{
            	options: [
                  { text: 'Зирка лева', value: 'А' },
                  { text: 'Народження зирки', value: 'Б' },
                ],   
                vmContract: true,
                contractSelected: false,
            }
        },

        methods: {
        	vmModal(){
                $('#vmModal').modal('show');
                $('#selectModal').modal('hide');
            },
        }
}

</script>


<style type="text/css">
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}
</style>