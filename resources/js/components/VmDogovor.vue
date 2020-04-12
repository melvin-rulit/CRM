<template>
	<div class="modal fade" id="dogovorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLongTitle">Выберите контракт</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="ststic_page">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="text-center">Договор на оказания услуг программы "Зирка Лева"</h3>
								<p>ФИО: {{ dataObject.attributes['child_surname'] }} {{ dataObject.attributes['child_name'] }} {{ dataObject.attributes['child_middle_name'] }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button @click="vmContract = !vmContract, contractSelected = !contractSelected" type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
				</div>
			</div>
		</div>
	</div>
</template>