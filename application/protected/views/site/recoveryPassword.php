<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Recuperar contraseña';
$this->breadcrumbs=array(
	'Recuperar contraseña',
);
?>

<h1>Recuperación de contraseña</h1>
<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>¿No te acuerdas del password? </p>
<p>¡No hay problema! te mandamos un correo con un nuevo password. Una vez dentro de tu cuenta podrás actualizarlo sin problemas.</p>
<p>Gracias.</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'RecoveryPasswordForm',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Correo electrónico'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'Código de verificación'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Necesitamos saber si eres humano.
		<br/>Introduce los caracteres de la imagen.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Enviar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>