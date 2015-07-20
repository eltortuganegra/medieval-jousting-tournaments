<div id="messages">
	<h1>Mensajes con <?php echo $this->knight->name;?></h1>
	<!-- 	
	<div id="message_send_new">
		<h2>Enviar un nuevo mensaje</h2>
		<textarea id="messageWith_text"></textarea>
		<p><span class="righ"><a href="#" class="button_yellow">enviar</a></span></p>
	</div>
	 -->
	<?php if( count( $messages) > 0 ):?>
		<?php foreach( $messages as $message ):?>		
			<div class="message">
				<p class="message_date right"><?php echo $message['date'];?></p>			
				<h2><strong>Sir <?php echo $message['name'];?></strong></h2>
				<div class="ui_icon left">
					<img id="avatar" alt="Avatar" src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$message['avatars_id'];?>.png">
				</div>				
				<p class="message_content"><span class="indent">-"<?php echo $message['text'];?>"</span></p>								
			</div>		
		<?php endforeach;?>
	<?php else:?>
	<div class="messages">
		<p>Actualmente no hay ningún mensaje.</p>
	</div>
	<?php endif;?>
	<div class="messages_paginator">
		<p>
		<?php for( $i=1;$i<=$totalPages;$i++){
			if( $i == $page ){
				echo '<a href="/character/messagesWith/sir/'.$this->knight->name.'/page/'.$i.'"><strong>'.$i.'</strong></a> ';
			}else{
				echo '<a href="/character/messagesWith/sir/'.$this->knight->name.'/page/'.$i.'">'.$i.'</a> ';
			}
		}?>
		</p>		
	</div>	
</div>