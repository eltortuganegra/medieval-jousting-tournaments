/**
* Combat Manager 
*/
var combatManager = {
	//Attributes
	knight_name: null, 
	combat_id: null, //current combat identificator
	round_id: null, //current round
	isInCombat: false, //If user is in combat
	intervalTime: 10000, //Time in miliseconds for check if a rival accept challenge 
	setTimeoutTime: 1000, //Time in miliseconds for check is round is finished by rival
	countdownTime: 0, //TIme in seconds for countdown
	desqualification: false, //check if a knight is desqualified
	logoutTime: 1200000,//Time in miliseconds for logout. 20 minutes 
	
	//Methods
	/**
	 * Init funcionality
	 */
	init: function( knight_name ){
		this.knight_name = knight_name;		
		this.confirmChallengeButton();
		this.rejectChallengeButton();
		this.acceptChallengeButton();
		this.showPendingRoundButton();
		this.showFinishedRoundButton();
		this.precombatButton();
		this.postcombatButton();
		//Only for logged user		
		if( app.user != undefined ){
			setInterval('combatManager.checkInCombat()', this.intervalTime );
			this.isInCombat = app.user.knights.isInCombat;
			if( this.isInCombat ){
				this.combat_id = app.combat.id;
				this.checkIfKnightIsDesqualified();
				this.showPendingRound( app.user.knights.name, this.combat_id)
				
			}
			setTimeout('combatManager.logout()', this.logoutTime);
		}
		
	},
	/**
	 * Bind event 'confirm challenge' to button.
	 */	
	confirmChallengeButton: function(){
		$('#confirmChallenge').click(function(){
			$.getJSON('/character/confirmSendChallenge/sir/'+app.knight.name, function(data){
				if( data.errno == 0 ){
					showDialog({
						title: 'Reto',
						html: data.html,
						buttons:[{
								text: 'todavía no',	
								name: 'button_red',							
								click: function(){ 
									$(this).remove();							
								}
							},
							{
								text: 'abofetear',
								name: 'button_green',
								click: function(){ 
									$(this).remove();
									//Send challenge
									$.get( '/character/sendChallenge/sir/'+app.knight.name, function(data){									
										showDialogResponse( data );
									});
								}
							}
						]
					});
				}else{
					showDialogAcceptAction( 'Upsss', data.html, function(){
						window.location.reload();
					});					
				}
			});
			return false;
		});
	},
	
	
	/**
	 * Reject challenge
	 */
	rejectChallengeButton: function(){
		if( $('.combat_status_pending .reject_button').size() ){
			$('.combat_status_pending .reject_button').click(function(){
				var challenge_id = $(this).attr('name');
				//Request for html contect
				$.getJSON( $(this).attr('href'), function(data){
					//show dialog
					showDialogAcceptAction( '¡Me cago vivo!', data.html, function(){
						$(this).remove();
						$.getJSON( '/character/responseChallenge/sir/'+app.user.knights.name+'/action/reject/id/'+challenge_id, function(data){						
							showDialogAcceptAction( '¡Desafio rechazado!', data.html, function(){
								window.location.reload();
							});						
						});	
					});
				});
				return false;
			});
		}
	},
	/**
	 * accept challenge
	 */
	acceptChallengeButton: function(){
		var that = this;
		if( $('.combat_status_pending .accept_button').size() ){
			$('.combat_status_pending .accept_button').click(function(){
				that.combat_id = $(this).attr('name');
				
				//Request for html contect
				$.getJSON( $(this).attr('href'), function(data){				
					if( data.errno == 0){
						//show dialog
						showDialogAcceptAction( 'Aceptar desafio', data.html, function(){
							//Challenge accepted
							$(this).remove();
							that.isInCombat = true;
							that.checkIfKnightIsDesqualified();
							that.acceptChallenge(that.combat_id);
						});
					}else{
						 showDialogResponse( data.html ); 
					}
				});
				return false;
			});
		}		
	},
	/**
	 * add funcionality for show pending round button 
	 */
	showPendingRoundButton: function(){		
		if( $('.showPendingRound').size() > 0 ){			
			var that = this;
			$('.showPendingRound').click(function(){
				that.combat_id = $(this).attr('href').substring( $(this).attr('href').indexOf('id/') + 3 );
				that.showPendingRound( app.user.knights.name, that.combat_id );
				return false;
			});
		}
	},
	/**
	 * Accept challenge and show precombat dialog for a knight in combat
	 * @param combat_id identificator of combat
	 */
	acceptChallenge: function(combat_id){	
		var that = this;
		$.getJSON( '/character/responseChallenge/sir/'+app.user.knights.name+'/action/accept/id/'+combat_id, function(data){
			if(data.errno==0){
				showDialog({
					title: 'Precombate',
					html: data.html, 
					maxWidth: 600, 
					minWidth: 600,
					buttons: [{
						text: "continuar",
			            name: 'button_blue',
			            click: function(){
			            	$(this).remove();
			            	that.showPendingRound(app.user.knights.name, combat_id);
			            }
					}]
				});
			}else{
				//Error for to show
          		 showDialogResponse( data.html );
			}
		});	
	},
	/**
	 * Show precombat dialog of combat
	 * @param combat_id int
	 */
	showPrecombat: function(combat_id){
		var that = this;
		$.getJSON( '/character/showPrecombat/sir/'+app.user.knights.name+'/id/'+combat_id, function(data){
			if(data.errno==0){
		
				showDialog({
					title: 'Precombate',
					html: data.html,
					maxWidth: 600, 
					minWidth: 600,
					buttons: [{
							text: "continuar",
				            name: 'button_blue',
				            click: function(){
				            	$(this).remove();
				            	that.showPendingRound(app.user.knights.name, combat_id);
				            }
				            }]
				});
			}else{
				//Error for to show
         		 showDialogResponse( data.html );
			}
		});
	},
	/**
	 * Show pending round for knight in combat 
	 */
	showPendingRound: function(knight_name, combat_id){
		var that = this;
		that.checkIfKnightIsDesqualified();
		//Show round
    	$.getJSON( '/character/showPendingRoundDialog/sir/'+knight_name+'/id/'+combat_id,function(data){
			if( data.errno == 0){
          		  showDialog({
						title: 'Ronda actual',
						html: data.html,
						maxWidth: 900, 
						minWidth: 900,
						buttons: [{
									text: "equipo",
						            name: 'button_blue',
						            click: function(){
						            	$('#round_pending_round #layer1').slideUp();
						            	$('#round_pending_round #layer2').slideDown();
						            }
								},
					            {
					              text: "ataque y defensa",
					              name: 'button_blue',
					              click: function(){
					            	  //Show round dialog
					            	  $.getJSON( '/character/showRoundSelectedPointsDialog/sir/'+knight_name, function(data){
					            		  if(data.errno==0){
					            			  $('#round_pending_round #layer1').html( data.html );
					            			  $('#round_pending_round #layer2').slideUp();
					            			  $('#round_pending_round #layer1').slideDown( function(){						  					            				
					            				  makeIconAttackPointDraggable();
							            		  makeAttackPointPositionDroppable();
							            		  makeIconDefensePointDraggable();
							            		  makeDefensePointPositionDroppable(); 
					            			  });
					            		  }else{
					            			  $('#round_pending_round #layer1').html( data.html );
					            			  $('#round_pending_round #layer1').slideDown();
					            		  }
					            	  });
					            	  makeIconAttackPointDraggable();
				            		  makeAttackPointPositionDroppable();						  					            	  
					              }
								},
					            {
					              text: "comenzar",
					              name: 'button_green',
					              click: function(){
					            	//Check if all priimary equipment is filled
					            	  if( 	  $('#ui_inventory_position_1').children().size() && 
					            			  $('#ui_inventory_position_2').children().size() && 
					            			  $('#ui_inventory_position_3').children().size() &&
					            			  $('#ui_inventory_position_4').children().size() &&
					            			  $('#ui_inventory_position_5').children().size() &&
					            			  $('#ui_inventory_position_6').children().size() &&
					            			  $('#ui_inventory_position_7').children().size() &&
					            			  $('#ui_inventory_position_8').children().size() &&
					            			  $('#ui_inventory_position_9').children().size() &&
					            			  $('#ui_inventory_position_10').children().size() ){
						            	  //Check valid data
						            	  if( app.combat.attack_position > 0 && app.combat.defense_position > 0 ){
						            		 //Show round dialog
						            		  $(this).remove();
						            		  $(this).dialog('destroy');
						            		  that.roundResolve(knight_name, combat_id);					  					            		
						            	  }else{
						            		  showDialogResponse( 'Las posiciones de ataque y defensa no son válidas.' );
						            	  }
					            	  }else{
					            		  showDialogResponse( '<p>No puedes entrar al combate sin el equipo completo</p><p>Revisa tu equipo y comprueba que tienes tu armadura completamente equipada así como tu lanza y escudo puestos.</p>' );
					            	  }
					              }
								}]
						});
          		  //Fixed time of open	
      			  showItemInfo();
      			  makeItemsDraggable();
          		  makePrimaryEquipmentDroppable();
          		  makeSecondaryEquipmentDroppable();  						            		  						            		  
          	  }else{
          		  //Error for to show
          		  showDialogResponse( data.html ); 
          	  } 
		});
	},
	
	/**
	 * Resolve round. In this case knight must to wait to rival send attack and defense point or if rival has sended it then show round result.
	 */
	roundResolve: function(knight_name, combat_id){
		var that = this;
		$.getJSON('/character/setCombatPoints/sir/'+knight_name+'/combat/'+combat_id+'/attack_position/'+app.combat.attack_position+'/defense_position/'+app.combat.defense_position, function(data){
			if( data.errno ){
				//error
				showDialogResponse(data.html);
			}else{
				//Check if round is finished
				if( data.roundIsFinished ){
					that.showFinishedRound(data);
				}else{
					that.showWaitingForRival(data);					
				}
			}
		});	
	},
	/**
	 * Show dialog for waiting rival. This dialog contents a countdown for to can disqualify rival. If time expired knight can click button for win combat. 
	 * If rival send resolve round before countdown is finished then this dialog is removed and showed a new finished round dialog.  
	 *  
	 */
	showWaitingForRival: function(data){
		var that = this;
		showDialog({
			title: 'Esperando al adversario',
			html: data.html,
			maxWidth: 575,
			minWidth: 575,
			buttons: [{
				text: 'descalificar al rival',
				name: 'button_red',
				click: function(){
					that.desqualifyButton();
					
				}
			}]
		});
		//Check rival response
	  this.checkIfRoundIsResolve(this.combat_id, data.round_id);	  
	},
	/**
	 * Show a dialog with result of round. If combat is finished a button of 'postcombat' is showed else 'next round'.
	 * @param isCombatFinished boolean 
	 */
	showFinishedRound:function(data){
		var that = this;
		//Check if combat is finished
		if( data.isCombatFinished ){
			showDialog({
				title: 'Resultado de la ronda',
				html: data.html,
				maxWidth: 575, 
				minWidth: 575,
				buttons: [{
			              text: "combate terminado",
			              name: 'button_green',
			              click: function(){
			            	  //Show round dialog
			            	  $(this).remove();
			            	  that.showPostcombat(that.combat_id);
			              }
			            }]
			});
		}else{
			showDialog({
				title: 'Resultado de la ronda',
				html: data.html,
				maxWidth: 575, 
				minWidth: 575,
				buttons: [{
			              text: "siguiente ronda",
			              name: 'button_green',
			              click: function(){
			            	  //Show round dialog
			            	  $(this).remove();
			            	  that.showPendingRound(app.user.knights.name, that.combat_id );
			              }
			            }]
			});
		}
	},
	/**
	 * Show postcombat dialog
	 */
	showPostcombat: function(combat_id){
		this.isInCombat = false;
		$.getJSON( '/character/showPostcombat/sir/'+app.user.knights.name+'/id/'+combat_id, function(data){
			showDialog({
				title: 'Post combate',
				html: data.html,
				maxWidth: 575, 
				minWidth: 575,
				buttons: [{
			              text: "aceptar",
			              name: 'button_green',
			              click: function(){
			            	  //Show round dialog
			            	  $(this).remove();
			            	  window.location.reload();
			              }
			            }]
			});
		});
		
	},
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Funcionality for precombat button. Show dialog for all users, knigths in combat too.
	 */
	precombatButton: function(){
		if( $('.showPrecombat').size() > 0 ){
			$('.showPrecombat').click(function(){			
				$.getJSON( $(this).attr('href'), function(data){
					showDialog({
						title: 'Precombate',
						html: data.html,
						maxWidth: 600, 
						minWidth: 600,
						buttons: [
						          /*{
									text: "artimañas",
						            name: 'button_blue',
						            click: function(){
						            	alert('Esta bajo desarrallo.');
						            }
								},*/
					            {
					              text: "cerrar",
					              name: 'button_green',
					              click: function(){
					            	  //Show round dialog
					            	  $(this).remove();
					              }
					            }]
					});
				});
				return false;
			});		
		}		
	},
	/**
	 * Funcionality for postcombat button
	 */
	postcombatButton:function(){
		if( $('.showPostcombat').size() > 0 ){
			$('.showPostcombat').click(function(){
				$.getJSON( $(this).attr('href'), function(data){
					showDialog({
						title: 'Post combate',
						html: data.html,
						maxWidth: 575, 
						minWidth: 575,
						buttons: [{
					              text: "aceptar",
					              name: 'button_green',
					              click: function(){
					            	  //Show round dialog
					            	  $(this).remove();
					              }
					            }]
					});
				});
				return false;
			});
		}
	},
	/**
	 * show finished round 
	 */
	showFinishedRoundButton:function(){
		if( $('.showFinishedRound').size() > 0 ){
			$('.showFinishedRound').click(function(){			
				$.getJSON( $(this).attr('href'), function(data){
					showDialog({
						title: 'Ronda terminada',
						html: data.html,
						maxWidth: 575, 
						minWidth: 575,
						buttons: [{
					              text: "aceptar",
					              name: 'button_green',
					              click: function(){
					            	  //Show round dialog
					            	  $(this).remove();
					              }
					            }]
					});
				});
				return false;
			});		
		}
	},
	
	/**
	 * Check if a rival has accepted your challenge. A request every X seconds for check if 
	 */
	checkInCombat: function(){
		var that = this;
		//Check if knight is not in combat
		if( !this.isInCombat ){
			$.getJSON( '/combats/isInCombat/sir/'+app.user.knights.name,function(data){
				//Check if we get error
				if(data.errno){
					showDialogResponse( data.html );
				}else{
					//Check if knight is in combat 
					if( data.isInCombat ){
						//set is in combat
						that.isInCombat = true;						
						that.combat_id = data.combat_id;
						that.showPrecombat(data.combat_id);
						that.checkIfKnightIsDesqualified();
						document.title = "¡En combate!";	
						var url = $('#faviconShortcut').attr('href' ).substring( 0, $('#faviconShortcut').attr('href' ).indexOf("favicon.ico") )+'favicon_incombat.ico' ;
						
						$('#faviconShortcut').remove();
						$('<link id="faviconShortcut" rel="shortcut icon" href="'+url+'"/>	' ).appendTo('head');						
						url = $('#faviconIcon').attr('href' ).substring( 0, $('#faviconIcon').attr('href' ).indexOf("favicon_incombat.ico") )+'favicon_incombat.ico';
						$('#faviconIcon').remove();
						$('<link id="faviconIcon" rel="icon" href="'+url+'"/>	' ).appendTo('head');
						
						
					}
				}
			});
		}
	},
	/**
	 * While knight is waiting for rival in round we check if rival has sended his points of attack and defense
	 * @param combat_id
	 * @param round_id
	 */
	checkIfRoundIsResolve: function(combat_id, round_id){	
		var that = this;
		$.getJSON( '/character/showFinishedRound/sir/'+app.user.knights.name+'/combat/'+combat_id+'/round/'+round_id, function(data){
			if( data.errno ){
				alert(data.html);
			}else{
				//Check if knight is not desqualified
				if( that.desqualification==false){
					if(data.isFinishedRound ){
						//check if combat is finished
						$('.message_dialog').remove();
						that.showFinishedRound( data ); 						
					}else{					
						setTimeout('combatManager.checkIfRoundIsResolve('+combat_id+','+round_id+')', that.setTimeoutTime)
					}
				}
			}
		});
	},
	/*
	 * Start a countdown
	 */
	countdownRun: function(){
		if( this.countdownTime == 0 ){
			$('#countdownTime').html('¡descalifícalo!');
			$('button[name="button_red"]').removeAttr('disabled');
			$('button[name="button_red"]').removeAttr('style');
		}else if(this.countdownTime > 0){
			$('button[name="button_red"]').attr('disabled', 'disabled');
			$('button[name="button_red"]').attr('style', 'background-color: #999');			
			$('#countdownTime').html( this.countdownTime+' sg' );
			this.countdownTime--;
			setTimeout('combatManager.countdownRun()', 1000);
		}
	},
	/**
	 * desqualify button
	 */
	desqualifyButton: function(){
		var that = this;
		$('button[name="button_red"]').click( function(){
			$.getJSON('/character/desqualifyRival/sir/'+app.user.knights.name+'/combat/'+that.combat_id, function(data){
				if(data.errno){
					showDialogResponse(data.html);
				}else{
					//Check if desqualify					
					if(data.isDesqualified){
						//check if combat is finished
						
						$('.message_dialog').remove();
						showDialog({
							title: '¡Rival descalificado!',
							html: data.html,
							maxWidth: 575, 
							minWidth: 575,
							buttons: [{
						              text: "postcombate",
						              name: 'button_green',
						              click: function(){
						            	  //Show round dialog
						            	  $(this).remove();
						            	  that.showPostcombat(that.combat_id);
						              }
						            }]
						});
					}else{
						showDialogResponse(data.html);
					}
				}
			});
		});
	},
	/**
	 * check if knight is desqualified
	 */
	checkIfKnightIsDesqualified:function(){
		var that = this;
		
		if(that.isInCombat ){
			$.getJSON( '/character/isDesqualified/sir/'+app.user.knights.name+'/combat/'+that.combat_id, function(data){
				if(data.errno){
					showDialogAcceptAction(data.html);
				}else{
					if( data.isDesqualified ){
						that.isInCombat = false;
						that.showDisqualification( data.html );
					}else{
						setTimeout( 'combatManager.checkIfKnightIsDesqualified()',1000 );
					}
				}
			});
		}
	},
	/**
	 * Show dialog when a knight is desqualified by rival
	 */
	showDisqualification: function( html){
		var that = this;
		$('.message_dialog').remove();
		showDialog({
			title: '¡Descalificado!',
			html: html,
			maxWidth: 575, 
			minWidth: 575,
			buttons: [{
		              text: "postcombate",
		              name: 'button_green',
		              click: function(){
		            	  //Show round dialog
		            	  $(this).remove();
		            	  that.showPostcombat(that.combat_id);
		              }
		            }]
		});
	},
	/**
	 * Show dialog
	 */
	logout:function(){
		$.getJSON('/site/getAutomaticLogoutDialog',function(data){
			showDialog({
				title: data.title,
				html: data.html,
				maxWidth: 575, 
				minWidth: 575,
				buttons: [{
			              text: data.logoutButtonLabel,
			              name: 'button_green',
			              click: function(){
			            	  //Show round dialog
			            	  window.location.reload();
			              }
			            }]
			});
			//setTimeout
			setTimeout('window.location.href="/site/logout"',60000);//A minute			
		});			
	}
	
}