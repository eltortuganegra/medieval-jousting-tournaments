<div id="messages">
	<h1>Mensajes</h1>
	<?php if( count( $messages) >0 ):?>
		<?php foreach( $messages as $message ):?>
		<a href="/character/messagesWith/sir/<?php echo $message['name'];?>">
			<div class="message">
				<p class="message_date right"><?php echo $message['date'];?></p>			
				<h2><strong>Sir <?php echo $message['name'];?></strong></h2>
				<div class="ui_icon left">
					<img id="avatar" alt="Avatar" src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$message['avatars_id'];?>.png">
				</div>				
				<p class="message_content">Último mensaje: <span class="indent">-"<?php echo $message['text'];?>"</span></p>
				<p class="message_link">ver conversación</p>				
			</div>
		</a>
		<?php endforeach;?>
	<?php else:?>
	<div class="messages">
		<p>Actualmente no hay ningún mensaje.</p>
	</div>
	<?php endif;?>
</div>