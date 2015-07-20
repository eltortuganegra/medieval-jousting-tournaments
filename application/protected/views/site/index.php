<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div id=principal>
	<div>
		<div class="boxLarge">
			<h2 class="title_blueCenter">¡HUMILLA A TUS AMIGOS!</h2>
			<p>Las estadísticas se imponen. Combates ganados, heridas producidas, daño máximo...te los pules en todo. Si quieres que sigan siendo tus amigos ¡vas a tener que dejarles ganar algún combate!</p>
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index1.png" alt="Humilla a tu rival" title="¡Humillado!"/>
		</div>		
		<div class="boxSmall box_register">
			<h2 class="title_orangeCenter">¡REGÍSTRATE GRATIS!</h2>
			<form id="form_register" name="form_register" method="post" action="#">
				<p>Correo electrónico</p>
				<p><input type="text" id="email" name="email" class="validate[required,custom[email]]"/></p>
				<p>Contraseña</p>
				<p><input type="password" id="password" class="validate[required,minSize[6]]"/></p>
				<p>Repite la contraseña</p>
				<p><input type="password" id="password_repeat" class="validate[required,equals[password]]"/></p>
				<p>Nombre caballero</p>				
				<p><input type="text" class="validate[required,maxSize[10],minSize[3],custom[knightName]]" id="name"></p>
				<p class="fontSmall"><input type="checkbox" id="accept" name="accept" class="validate[required]" /> He leido y acepto las <a href="/site/conditionsofuse" title="Condiciones de uso" class="showInDialog">condiciones de uso</a> y la <a href="/site/privacyPolicy" title="política de privacidad" class="showInDialog">política de privacidad</a>.</p>		
				<p class="registerButton"><a id="button_register" href="#" class="button_yellow">¡REGISTRARME!</a></p>
			</form>	
		</div>
	</div>
	<div>
		<div class="boxSmall">
			<h2 class="title_blueCenter">RÁPIDO Y LETAL</h2>
			<p>1.- Reta a tu víctima.</p>
			<p>2.- Elige ataque y defensa.</p>
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index2.png" alt="" title="Elije ataque y defensa"/>
			<p>3.- ¡REVIÉNTALO!</p>
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index3.png" alt="¡reviéntalo!" title="¡Reventado!">
		</div>
		
		<div class="boxSmall">
			<h2 class="title_blueCenter">¡HAZ TRAMPAS!</h2>
			<p>Esto no es un camino de rosas. ¡Aquí la gente PALMA!.</p>
			<p>Envenenamientos, dopajes, patas de conejo, ...</p>
			<p>¡Todo vale para ganar!</p>
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index4.png" alt="Imagen envenenamiento" title="Envenena a tu adversario y que combata con menos vida."/>	
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index5.png" alt="Imagen distracción" title="Distrae a tu adversario mediante una buena doncella.">
		</div>
		
		<div class="boxSmall">
			<h2 class="title_blueCenter">LEYENDAS</h2>
			<p>Sólo los caballeros más audaces llegan a convertirse en leyendas.</p>
			<p>Elige cuidadosamente tus atributos y habilidades de manera que los juglares y trovadores cuenten historias de tus hazañas.</p>	
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index6.png" alt="Imagen evolución" title="Evolución del personaje."/>
		</div>
		
		<div class="boxSmall">
			<h2 class="title_blueCenter">EQUIPO DELUXE</h2>
			<p>Lanzas, escudos, armaduras, ... Deshazte de todo ese equipo mundano hasta conseguir las armas únicas que te convertirán en leyenda.</p>	
			<img src="<?php echo Yii::app()->params['cdn_statics'].Yii::app()->params['paths']['general']?>index7.png" alt="Imagen de equipo único" title="Objetos únicos."/>	
			<p>¡Hazte con ellas antes de tener que enfrentarte a ellas!</p>
		</div>
	</div>
</div>