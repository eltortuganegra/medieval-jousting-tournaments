<?php if( Yii::app()->user->isGuest):?>
	<div id="header_guest">
		<div id="header_login">
			<form id="header_login_form" class="login-form" action="/site/login" method="post">					
				<table cellspading="0">
					<tr>
						<td>correo electrónico</td>
						<td>contraseña</td>
						<td></td>
					</tr>
					<tr>
						<td><input name="LoginForm[username]" id="LoginForm_username" type="text" class="validate[required,custom[email]]"/></td>
						<td><input name="LoginForm[password]" id="LoginForm_password" type="password" class="validate[required,minSize[6]]"/></td>
						<td><input type="submit" id="header_login_button_entrar" name="header_login_button_entrar" value="entrar" class="button_yellow" /></td>
					</tr>
					<tr>
						<td><input name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox" /><label for="LoginForm_rememberMe" class="fontSmall">no cerrar sesión</label></td>
						
						<td><a href="/site/recoveryPassword" class="fontSmall">¿Has olvidado tu contraseña?</a></td>
						<td></td>							
					</tr>							
				</table>
			</form>
		</div>
		<div id="logo">
			<a href="<?php echo Yii::app()->params['url_domain']?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
		</div>
	</div>						
<?php else:?>
	<div id="header">
		<div id="header_options">
			<p class="right">
				<!-- 
				<a href="/rankings">
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>rankings.png" alt="rankings" title="ir a los rankings"/>
				</a>
				 -->
				<a href="/yellowPages">
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>yellow_pages.png" alt="paginas amarillas medievales" title="ir a las páginas amarillas medievales"/>
				</a>
				<a href="/settings" title="Ir a opciones">						
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_softwareD.png" class="" alt="opciones" title="opciones">
				</a>
				<a href="/site/logout" title="Salir">
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_action_exit.png" class="" alt="logout" title="cerrar sesión">
				</a>
			</p>				
		</div>
		<div id="logo_mini"><p><a href="<?php echo Yii::app()->params['url_domain']?>"><?php echo CHtml::encode(Yii::app()->name); ?></a><p></div>		
		<div id="header_messages" class="flyer">
			<a href="#" id="showMessagesFlyer">						
				<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_aim.png" class="ui_clickable" alt="mensajes" title="mensajes"/>
				<?php if( count($this->_newMessages )>0):?>
					<p class="etiqueta"><?php echo count($this->_newMessages);?></p>
				<?php endif;?>
			</a>					
			<div id="header_messages_flyer" class="header_flyer">
				<div class="header_flyer_header">
					<p><strong>Mensajes</strong> <span class="right"><a href="#">Enviar un mensaje nuevo</a></span></p>							
				</div>
				<div class="header_flyer_body">
				<?php if( count($this->_newMessages )>0):?>						
					<?php foreach( $this->_newMessages as $message):?>
						<a href="/character/messagesWith/sir/<?php echo $message['name'];?>">
							<div class="message">
								<p class="message_date right"><?php echo $message['date'];?></p>			
								<h2><strong>Sir <?php echo $message['name'];?></strong></h2>
								<div class="ui_icon left">
									<img class="avatar" alt="Avatar" src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$message['avatars_id'];?>.png">
								</div>				
								<p class="message_content"><span class="indent">-"<?php echo $message['text'];?>"</span></p>								
							</div>
						</a>
					<?php endforeach;?>						
				<?php else:?>
					<div class="header_messages_last">
						<p>No hay mensajes</p>
					</div>							
				<?php endif;?>
				</div>
				<div class="header_flyer_footer">
					<p><a href="/character/messages/sir/<?php echo Yii::app()->user->knights_name;?>">Ver todos</a></p>
				</div>
			</div>
		</div>
		<div id="header_friends"  class="flyer">
			<a href="#" id="showFriendsFlyer">
				<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_kdmconfig.png" class="ui_clickable" alt="solicitud de amistad" title="solicitudes de amista"/>
				<?php if( count($this->_newFriends )>0):?>
					<p class="etiqueta"><?php echo count($this->_newFriends);?></p>
				<?php endif;?>
			</a>
			<div id="header_fiends_flyer" class="header_flyer">
				<div class="header_flyer_header">
					<p><strong>Solicitud de amistad</strong> <span class="right"><a href="#">buscar amigos</a></span></p>							
				</div>
				<div class="header_flyer_body">
				<?php if( count($this->_newFriends )>0):?>						
					<?php foreach( $this->_newFriends as $newFriend):?>
						<div class="header_flyer_friendship">								
							<div class="ui_icon">
								<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$newFriend['avatars_id'].'.png'?>" alt="Avatar" class="avatar"/>
							</div>									
							<p><a href="/character/events/sir/<?php echo $newFriend['name']?>">Sir <?php echo $newFriend['name']?></a> quiere ser tu amigo.</p>
							<p class="ui_rightAlign">
								<a href="#" name="<?php echo $newFriend['id']?>" class="button_red rejectFriendship">rechazar</a>
								<a href="#" name="<?php echo $newFriend['id']?>" class="button_green acceptFriendship">aceptar</a>
							</p>								
						</div>						
					<?php endforeach;?>													
				<?php else:?>
					<div class="header_flyer_friendship">
						<p>No hay solicitudes de amistad pendientes</p>
					</div>
				<?php endif;?>
				</div>
				<div class="header_flyer_footer">
					<p><a href="/character/friends/sir/<?php echo Yii::app()->user->knights_name;?>">Ver tus amigos</a></p>
				</div>
			</div>										
		</div>	
		<div class="flyer">
			<a href="/jobs"><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>jobs.png" alt="trabajos" title="trabajos"/></a>
		</div>
		<div class="flyer">
			<a href="/medievalmarket"><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>medievalmarket.png" alt="mercado medieval" title="mercado mevieval"/></a>
		</div>		
		<div id="header_search" class="flyer">
			<form id="header_search_form">
				<input type="text" id="search_text" name="search_text" value="Buscar caballero" />						
			</form>	
			<div id="header_search_flyer" class="header_flyer">
				<div class="header_flyer_header">
					<p><strong>Búsqueda</strong></p>							
				</div>
				<div class="header_flyer_body">
				</div>				
			</div>		
		</div>	
		
	</div>
<?php endif;?>