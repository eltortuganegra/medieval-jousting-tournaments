<div id="buy_item">	
	<p class="leyend">-"Los objetos con una rareza 'muy frecuente' son fáciles de encontrar y no hace falta de ninguna habilidad especial para conseguirlos."</p>
	<div class="ui_icon">
		<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$equipments_type.'_'.$identificator;?>.png">
	</div>
	<p><?php echo $item->name;?></p>
	<p>Precio <span class="right"><?php echo $item->prize;?> M.O.</span></p>
	<p>¿Comprar el objeto?</p>
</div>