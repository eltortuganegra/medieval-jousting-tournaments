/**
 * 
 */
jQuery(document).ready(function(){
	/**
	 * ************************** SETTINGS
	 */
	if( $('#settings').size() ){
		/*
		 * Update password 
		 */
		$('#updatePassword').click(function(){
			$.post( $(this).attr('href'),{password: $('#newPassword').val()}, function(data){
				data = jQuery.parseJSON(data);
				if(data.errno){
					showDialogResponse(data.html);
				}else{
					showDialogResponse(data.html);
				}
			});
			return false;
		});
		
		$('#').click()
	}
});