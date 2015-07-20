<div id="settings">
	<h1>Configuración de la cuenta</h1>
	
	<h2>Correo electrónico</h2>
	<p>Correo electrónico <span class="right"><?php echo $this->user_data['user']->email?></span></p>
	<p>Actualizar contraseña <span class="right"><input type="password" id="newPassword" /> </p>
	<p>Repetir contraseña <span class="right"><input type="password" id="repeatPassword" /> </p>
	<p><span class="right"><a href="/settings/updatePassword" id="updatePassword">actualizar contraseña</a></span></p>
	<h2>Notificaciones al correo electronico.</h2>
	<form>
		<p><input type="checkbox" name="emailToSendChallenge" id="emailToSendChallenge" <?php echo ($this->user_data['knight_settings']->emailToSendChallenge)?'checked="checked"':'';?>>Enviarme un correo cada vez que alguien me rete.</p>
		<p><input type="checkbox" name="emailToFinishedCombat" id="emailToFinishedCombat" <?php echo ($this->user_data['knight_settings']->emailToFinishedCombat)?'checked="checked"':'';?>>Enviarme un correo cada vez que termine un combate.</p>
		<p><input type="checkbox" name="emailToSendMessage" id="emailToSendMessage" <?php echo ($this->user_data['knight_settings']->emailToSendMessage)?'checked="checked"':'';?>>Enviarme un correo cada vez que alguien me mande un mensaje.</p>
		<p><input type="checkbox" name="emailToSendFriendlyRequest" id="emailToSendFriendlyRequest" <?php echo ($this->user_data['knight_settings']->emailToSendFriendlyRequest)?'checked="checked"':'';?>>Enviarme un correo cada vez que alguien me mande una solicitud de amistad.</p>
		<p><a href="/settings/updateSendEmails" class="right" id="updateSendEmails">actualizar notificaciones</a></p>
	</form>
</div>