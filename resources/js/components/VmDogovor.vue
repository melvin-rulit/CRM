<template>

<div>    <div class="modal fade" id="vmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">{{ dataVm.contract_name }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-lg" id="printVM">

                    <vmdogovor-component></vmdogovor-component>



                </div>

            </div>
        </div>
    </div></div>

</template>










<style type="text/css">
	Size : 8.27in and 11.69 inches

@page Section1 {
size:8.27in 11.69in; 
margin:.5in .5in .5in .5in; 
mso-header-margin:.5in; 
mso-footer-margin:.5in; 
mso-paper-source:0;
}



/*body, .tdleft, .tdright, .line, .tabs{
	font-size: 0.138in;
}*/


div.Section1 {
page:Section1;
border: solid 0px;
} 
.logo{
	display: block;
	width: 1.917in;
	height: 0.590in;
}

h1{
	text-align: center;
	font-size: 0.166in;
}

.tabs{
	width: 100%;
}

.tdleft{
	text-align: left;
}

.tdright{
	text-align: right;
}

.line{
	border: solid;
	border-width: 0px 0px 1px 0px;
	width: 100%;
	font-weight: bold;
}

.hide{
	font-weight: normal;
}

.gray{background:#cbc1c1;}
</style>