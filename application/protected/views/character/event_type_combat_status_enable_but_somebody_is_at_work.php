<div class="combat_status_enable">
	<p class="title">Estado</p>
	<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>waiting.png" class="ui_icon"/>
	<?php if( $combat->fromKnight->status == Knights::STATUS_AT_WORK && $combat->toKnight->status == Knights::STATUS_AT_WORK):?>
		<p class="fontXSmall">No se puede empezar el combate porque <span class="colorBlue">Sir <?php echo $combat->fromKnight->name?></span> y <span class="colorRed">Sir <?php echo $combat->toKnight->name?></span> están trabajando ahora mismo.</p>
	<?php elseif ($combat->fromKnight->status == Knights::STATUS_AT_WORK):?>
		<p class="fontXSmall">No se puede empezar el combate porque <span class="colorBlue">Sir <?php echo $combat->fromKnight->name?></span> está trabajando ahora mismo.</p>		
	<?php else :?>
		<p class="fontXSmall">No se puede empezar el combate porque <span class="colorRed">Sir <?php echo $combat->toKnight->name?></span> está trabajando ahora mismo.</p>
	<?php endif;?>
</div>