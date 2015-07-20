<div id="yellow_pages">
	<h1>PÁGINAS AMARILLAS MEDIEVALES</h1>
	<ul class="yellow_pages_menu">
	<?php //Make ul   
	foreach( $yellow_pages_total as $letter_total){		
		if( $letter_total->total ){
			echo '<li /><a href="/yellowPages/show/letter/'.$letter_total->letter0->name.'">'.$letter_total->letter0->name.'</a>';
		}else{
			echo '<li />'.$letter_total->letter0->name.'';
		}		
	}?>
	</ul>
	<div id="description">
		<h4>Bienvenido a las páginas amarillas medievales</h4>		
		<p>Aquí podras encontrar una lista con todos los caballeros del reino.</p>
		<p>Puedes buscar caballeros por su nombre pinchando en el menú superior. Las letras de color azul indica que hay uno o más caballeros mientras que las grises indica que la categoría está vacía.</p>		
	</div>
	<div id="last_suscribe">
		<h4>Últimos caballeros suscritos</h4>
		<?php 
		if( count( $last_knights_suscribe ) ){
			foreach( $last_knights_suscribe as $knight){
				$this->renderPartial( '/knights/_miniview', array('model'=>$knight));
			}
		}else{
			echo '<p>Actualmente no hay ningún caballero suscrito.<p>';
		}?>		
	</div>
</div>