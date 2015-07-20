/**
 *  
 *
*/
jQuery(document).ready(function(){
	/*
	 * Show something
	 * */			
	$('.showInDialog').click(function(){			
		$.getJSON( $(this).attr('href')+'/ajax/1', function(data){
			showDialog({
				html: data.html,
				maxWidth: 600,
				minWidth: 600,
				buttons:[{
					 text: "Aceptar",
		             name: 'button_green',
		             click: function(){$(this).dialog('destroy');$(this).remove()}
				}]
			});
		});
		return false;
	});
	
	/* 
	 * Register form
	 */
	if( $('#button_register').size() ){
		$('#button_register').click(function(){		
			$("#form_register").validationEngine();		
			if( $("#form_register").validationEngine( 'validate' ) ){
				$.getJSON('/site/signinWaiting', function(data){
					showDialog({
						title: data.title,
						html: data.html,						
						buttons: null
					});
				});	
				
				
				var data_form = {
						email: $('#email').val(),
						password: $('#password').val(),
						name: $('#name').val()
				}
				
				//Request sigin
				$.post( '/site/signin', data_form, function(data){
					data = jQuery.parseJSON(data);				
					if(data.errno == 0){
						//Erase data form
						$('#email').val('');
						$('#password').val('');
						$('#password_repeat').val('');
						$('#name').val('');
						$('#accept').attr('checked', false);					
					}
					
					//Show message
					$('.ui-dialog').remove();
					showDialogResponse(data.message);
				});								
			}
			return false;
		});
	}
	/*
	 * login form 
	 */
	if( $('#header_login_form').size() ){		
		$('#header_login_button_entrar').click(function(){
			$('#header_login_form').validationEngine({promptPosition:"bottomLeft"});
			return $('#header_login_form').validationEngine('validate')
		});
	}
	
	// binds form submission and fields to the validation engine
	//Characters / 
	if( $('#knight_overview').size() ){
		//Move experience bar
		var knight_level = $('#knight_level').val();		
		var knight_experiencie_earned = $('#knight_experience_earned').val();
		var xp_current_level = app.getXPLevel( knight_level  );// attribute_cost['level_'+knight_level]*app.total_attributes + skills_cost['level_'+knight_level]*app.total_skills;		
		var xp_next_level = app.getXPLevel( parseInt(knight_level) + 1 );//attribute_cost['level_'+(parseInt(knight_level)+1)]*app.total_attributes + skills_cost['level_'+(parseInt(knight_level)+1)]*app.total_skills;		
		var percent = (knight_experiencie_earned-xp_current_level)*100/(xp_next_level-xp_current_level);	
		
		//alert( 'Percent: '+knight_experiencie_earned+'-'+xp_current_level+')*100/('+xp_next_level+'-'+xp_current_level );
		
		
		$('#experience_bar_percent').animate( {width: percent+'%'}, 5000, function(){});
		
		//click all level up enable
		$('.ui_levelup_enabled').click(function(){
			var name = $(this).attr('id');			
			var actual_value =parseInt(  $('#knight_card_'+name+'_value').html() );			
			var message = '<table><tbody>'+
						'<tr><td>PX disponibles</td><td class="textAlignRight">'+$('#knight_experience_enabled').html()+' PX</td></tr>'+						
						'<tr><td>Coste nivel '+(actual_value+1)+'</td><td class="textAlignRight">'+level_cost[name]+' PX</td></tr></tbody></table>'+
						'¿Estás seguro de subir este nivel?';						
			
			showDialogAcceptAction("Subir a nivel "+(actual_value+1), message, function(){
				  $.getJSON( '/character/upgradeCharacteristic', {name: name}, function(data){
		       		  $(this).remove();
		       		  showDialogAcceptAction("Subir a nivel "+(actual_value+1), data.message, function(){
			       		  window.location.reload();
			       	  });
				  });
       	  	});			
		});
	}
	
	//CHARTS
	if( $('#chart_knight_attributes').size() > 0 ){
		generateKnightsAttributesChart();
	}
	if( $('#chart_knight_stats').size() > 0 ){
		if( app.user.hasCombats ){
			generateKnightsStatsChart();
		}else{
			$('#chart_knight_stats').html( 'Todavía no has realizado ningún combate.' );
		}
	}
	if( $('#chart_knight_stats_vs').size() > 0 ){
		if( app.user.hasStatsVs ){
			generateKnightsVsStatsChart();
		}else{
			$('#chart_knight_stats').html( 'Todavía no has realizado ningún combate.' );
		}
	}
	
	/**
	 * Item overview -> display or hidden the div when mouse enter or leave the item element.
	 */
	if( $('.item').size() ){
		showItemInfo();
	}
	
	/**
	 * Item draggable
	 */
	if( $('.ui_inventory_position' ).size() && app.user.isMyProfile ){
		makeItemsDraggable();
		/*
		//Let the item to be draggable
		$( '.item' ).draggable({
			cursor: "move",
			revert: true,
			start: function(event, ui){
				$(this).children( '.item_info' ).css('display', 'none');
			},
			stop: function(event, ui){
				$(this).parent().css('z-index', 'auto');
			}
		});
		*/
		
		//Let the inventary position to be droppable
		makePrimaryEquipmentDroppable();
		/*EQUIOP PRIMARIO*/
		/*
		primary_equipment = {
				ui_inventory_position_1: '.item_position_hombrera_derecha',
				ui_inventory_position_2: '.item_position_casco',
				ui_inventory_position_3: '.item_position_hombrera_izquierda',
				ui_inventory_position_4: '.item_position_codera_derecha',
				ui_inventory_position_5: '.item_position_codera_izquierda',
				ui_inventory_position_6: '.item_position_guante_derecho',
				ui_inventory_position_7: '.item_position_guante_izquierdo',
				ui_inventory_position_8: '.item_position_lanza',
				ui_inventory_position_9: '.item_position_coraza',
				ui_inventory_position_10: '.item_position_escudo'				
		}
		
		for( var attr in primary_equipment ){			
			$( '#'+attr ).droppable({
				cursor: "move",
				accept: primary_equipment[attr]+'',
				activeClass: "ui_inventory_position_enable",
				drop: function( event, ui ) {	
					var initial_position = $( ui.draggable ).parent().attr('id').replace('ui_inventory_position_','');				
					var final_position = $(this).attr('id').replace('ui_inventory_position_','');
					//Creamos el div y le asignamos el draggable
					$( ui.draggable ).removeClass('ui-draggable-dragging');
					$(this).html( '<div class="'+$( ui.draggable ).attr('class')+'">'+$( ui.draggable ).html()+'</div>' );
					$( '.item' ).draggable({
						cursor: "move",
						revert: true,
						start: function(event, ui){				
							$(this).children( '.item_info' ).css('display', 'none');
						}
					});
					$( ui.draggable ).remove()				
					showItemInfo();					
					$.getJSON( '/character/moveItemPosition/sir/'+app.knight.name, 
							{							
								initial_position: initial_position,
								final_position: final_position,
							}, 
							function(data){
								if(data.errno != 0){
									//Error. Mostramos el mensaje de error
									showDialogResponse( data.message );									
								}
							}
				);
					
				}
			});			
		}		
		*/
		/*EQUIPO SECUNDARIO*/
		makeSecondaryEquipmentDroppable();
		/*
		$( '.ui_inventory_position_all' ).droppable({
			cursor: "move",			
			activeClass: "ui_inventory_position_enable",
			drop: function( event, ui ) {
				var item = '';
				var initial_position = $( ui.draggable ).parent().attr('id').replace('ui_inventory_position_','');				
				var final_position = $(this).attr('id').replace('ui_inventory_position_','');
				
				//Comprobamos si la casilla destino está ocupada 
				if( $(this).children('.item').size()  ){
					//Si la posicion inicial es de una del equipo en uso y los objetos notienen el mismo tipo, no se puede hacer el cambio.					
					if( $( ui.draggable ).parent().hasClass( 'ui_inventory_position_in_use' )  ){
						var class_list = $(this).children('.item').attr('class');					
						var type_object_in_position =  (class_list.replace( 'item', '' )).replace('ui-draggable','');
						
						//objeto arrastrado
						var type_object_dragged = $( ui.draggable ).attr( 'class' );
						type_object_dragged = (type_object_dragged.replace( 'item', '' )).replace('ui-draggable-dragging','').replace('ui-draggable','');
						//Comprobamos si son del mismo tipo
						//alert(  && type_object_in_position +'!='+ type_object_dragged );
						if( type_object_in_position != type_object_dragged ){ 
							//no son del mismo tipo así qué rechazamos que sea dropeado aquí.
							return false;
						}
					}
					//almacenamos el código del objeto que está en la posicion final.
					item = $(this).html();
					 
				}
				
				//Hacemo se lcambio en la base de datos
				//alert( $( ui.draggable ).parent().attr('id').replace('ui_inventory_position_','')+'-'+$(this).attr('id').replace('ui_inventory_position_',''));
				var dropItem = true; 
				
				
				$.getJSON( '/character/moveItemPosition/sir/'+app.knight.name, 
							{								
								initial_position: initial_position,
								final_position: final_position,
							}, 
							function(data){
								if(data.errno != 0){
									//Error. Mostramos el mensaje de error			
									showDialogResponse( data.message );
								}
							}
				);				
				
				//Creamos el div y le asignamos el draggable
				$( ui.draggable ).removeClass('ui-draggable-dragging');
				$(this).html( '<div class="'+$( ui.draggable ).attr('class')+'">'+$( ui.draggable ).html()+'</div>' );
				$( '.item' ).draggable({
					cursor: "move",
					revert: true,
					start: function(event, ui){				
						$(this).children( '.item_info' ).css('display', 'none');
					}
				});
				//Insertamos en la posicion inicial el objeto de la posicion final o vacio
				$( ui.draggable ).parent().html( item ).children('.item').draggable({
					cursor: "move",
					revert: true,
					start: function(event, ui){				
						$(this).children( '.item_info' ).css('display', 'none');
					}
				});
				showItemInfo();
				
				
				
			}
		});
		*/
	}
	/**
	 * Check if knights evolution is loaded 
	 */
	if( $('#knights_evolution').size() ){
		
		var ticks = [];
		var data = []
		for(var i = 0;i<app.knight.knights_evolution.length; i++){
			ticks.push( app.knight.knights_evolution[i][0] );
			data.push( app.knight.knights_evolution[i][1] );
		}
		
		//Make chart
		 var plot1 = jQuery.jqplot ('evolution_chart', [data],
				    {
			 			seriesDefaults: {
			 				renderer: $.jqplot.LineRenderer,
			 				markerOptions: {
			 					show: false
			 				}
			 			},
					    axes: {
					        xaxis: {
					            renderer: $.jqplot.CategoryAxisRenderer,
					            ticks: ticks,             
					            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
					            tickOptions: {
					            	angle: -60,
					            	markSize: 10,
					            	
					            	formatString:'%d.%m'						            	
					          }
					        },
					    }
				    }
		);
	}
	
	/**
	 * Request friendship
	 */	
	if( $('#friendshipRequest').size() ){
		$('#friendshipRequest').click(function(){			
			$.getJSON( '/character/sendFriendshipRequest/sir/'+app.knight.name, 
					{}, 
					function(data){						
						//Show dialog
						showDialogAcceptAction( 'Mensaje', data.message, function(){
							window.location.reload();
						});		
					}
			);
			return false;
		});		
	}
	/**
	 * Request cancel friendship
	 */
	if( $('#rejectFriendshipRequest').size() ){
		$('#rejectFriendshipRequest').click(function(){			
			$.getJSON($(this).attr('href'), function(data){
				if( data.errno == 0){
					showDialogAcceptAction( data.title, data.html, function(){
						$(this).remove();
						$.getJSON( data.urlRequest, function(data){
							showDialogAcceptAction( data.title,  data.html, function(){
								window.location.reload();
							});
						});
					});
				}else{
					showDialogResponse(data.html);
				}
			});
			return false;
		});
	}
	
	/*
	 * Show friendship flyer
	 * */
	$('#showFriendsFlyer').click(function(){
		$('#header_messages_flyer').slideUp();
		$('#header_fiends_flyer').slideToggle();		
		return false;
	});
	/*
	 * send reply to friendship
	 * */
	$('.acceptFriendship').click(function(){
		replyToFriendship( $(this).attr('name'), 'accept'  );		
		return false;
	});
	$('.rejectFriendship').click(function(){
		replyToFriendship( $(this).attr('name'), 'reject'  );		
		return false;
	});
	/*
	 * Show message flyer and delete new messages
	 * */
	$('#showMessagesFlyer').click(function(){
		$('#header_fiends_flyer').slideUp();
		$('#header_messages_flyer').slideToggle();
		//Check if user has new messages
		if( app.user.hasNewMessages > 0){
			$.getJSON( '/character/deleteNewMessages/sir/'+app.user.knights.name,{},function(data){
				if( data.errno > 0){
					showDialog( data.html );
				}
			});
			app.user.hasNewMessages = 0;
		}
		return false;
	});
	
	
	//Send message
	$('#sendMessage').click(function(){
		var form_message = '<div id="message_form"><p>Escribe un nuevo mensaje</p><textarea id="message_text"></textarea><p class="fontXSmall">Tienes un límite de 140 caracteres<span id="message_text_characters" class="right">140</span></p></div>'; 
		showDialogAcceptAction( 'Mensaje', form_message, function(){
			//Check total
      	  var total = 140 - parseInt( $('#message_text').val().length);
      	  if(total >= 0 && total < 140 ){
				//$('#message_form .fontXSmall').css('color', '#333');
				//$('#message_form .fontXSmall').css('font-size', 'x-small');
      		 //Send message
				$.post( '/character/sendMessage/sir/'+app.knight.name, {text:  $('#message_text').val()}, function(data){
					data = jQuery.parseJSON(data);
					//Destroy dialog
					$(this).remove();
					$(this).dialog('destroy');
					$('.message_dialog').remove();
					
					//Show new dialog with message      					
					if(data.errno==0){
						showDialogAcceptAction( 'Mensaje', data.message, function(){
							$(this).remove();
							//check if messagesWith screen
							if( $('#messages').size() ) window.location.reload();
						});
					}else{
						showDialogResponse( data.message );	      				      						
					}
				});
    		  }else{
    			$('#message_form .fontXSmall').css('color', 'tomato');	
    			$('#message_form .fontXSmall').css('font-size', 'small');	
    		  }
		});
		
		
		//Character count		
		$('#message_text').keyup(function(){
			//alert( 'keyup:'+($('#message_text').val()) );
			var total = 140 - parseInt( $('#message_text').val().length);
			$('#message_text_characters').html( total );
			//Show red color
			if(total >= 0){
				$('#message_text_characters').css('color', '#333');
			}else{
				$('#message_text_characters').css('color', 'tomato');	
			}
		});
		
		
		return false;
	});
	
	/**
	 * header search bar
	 */
	if( $('#search_text').size() ){
		
		$('#search_text').focus(function(){
			if( $(this).val() == 'Buscar caballero' ) $(this).val( '' );			
		});
		
		$('#search_text').focusout(function(){
			if( $(this).val() == '' ) $(this).val( 'Buscar caballero' );
			$('#header_search_flyer').slideUp();
		});
		
		//Search when key up
		$('#search_text').keyup(function(){			
			$.getJSON('/knights/headerSearch/value/'+$(this).val(), function(data){
				$('#header_fiends_flyer').slideUp();
				$('#header_messages_flyer').slideUp();
				$('#header_search_flyer').slideDown();
				$('#header_search_flyer .header_flyer_body').html(data.html);
			});
		});
	}
	
	/*
	 * Combat
	 */	
	combatManager.init();
	//confirm challenger
	/*
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
	
	
	//reject Response event combat
	if( $('.combat_status_pending .reject_button').size() ){
		$('.combat_status_pending .reject_button').click(function(){
			var challenge_id = $(this).attr('name');
			//Request for html contect
			$.getJSON( $(this).attr('href'), function(data){
				//show dialog
				showDialogAcceptAction( 'Rechazar desafio', data.html, function(){
					$(this).remove();
					$.get( '/character/responseChallenge/sir/'+app.user.knights.name+'/action/reject/id/'+challenge_id, function(data){						
						showDialogAcceptAction( 'Desafio rechazado', data, function(){
							window.location.reload();
						});						
					});	
				});
			});
			return false;
		});
	}
	
	//accept response event combat
	if( $('.combat_status_pending .accept_button').size() ){
		$('.combat_status_pending .accept_button').click(function(){
			var challenge_id = $(this).attr('name');
			
			//Request for html contect
			$.getJSON( $(this).attr('href'), function(data){				
				if( data.errno == 0){
					//show dialog
					showDialogAcceptAction( 'Aceptar desafio', data.html, function(){	
						$(this).remove();
						$.getJSON( '/character/responseChallenge/sir/'+app.user.knights.name+'/action/accept/id/'+challenge_id, function(data){
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
							            	//Show round
							            	$.getJSON( '/character/showPendingRoundDialog/sir/'+app.user.knights.name+'/id/'+challenge_id,function(data){
												if( data.errno == 0){
									          		  showDialog({
															title: 'Ronda 1',
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
														            	  $.getJSON( '/character/showRoundSelectedPointsDialog/sir/'+app.knight.name, function(data){
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
														            	  //Check valid data
														            	  if( app.combat.attack_position > 0 && app.combat.defense_position > 0 ){
														            		 //Show round dialog
														            		  $(this).remove();
														            		  $(this).dialog('destroy');
														            		  $.getJSON('/character/setCombatPoints/sir/'+app.knight.name+'/combat/'+challenge_id+'/attack_position/'+app.combat.attack_position+'/defense_position/'+app.combat.defense_position, function(data){
														            			showDialog({
														            				title: 'Resultado',
														            				html: data.html,
														            				maxWidth: 575,
														            				minWidth: 575,
														            				buttons: [{
														            					text: 'aceptar',
														            					name: 'button_green',
														            					click: function(){
														            						$(this).remove();
														            						//Reload window
														            						window.location.reload();
														            						
														            					}
														            				}]
														            			});
														            		  });						  					            		
														            	  }else{
														            		  showDialogResponse( 'Las posiciones de ataque y defensa no son válidas.' );
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
							            }
									}]
								});
							}else{
								//Error for to show
				          		 showDialogResponse( data.html );
							}
						});	
					});
				}else{
					 showDialogResponse( data.html ); 
				}
			});
			return false;
		});
	}
	*/
	//getPrecombat
	/*
	if( $('.showPrechallenge').size() ){
		$('.showPrechallenge').click(function(){			
			var attack_point = 0;
			var defense_point = 0;
			var combat_id = $(this).attr('name');
			$.getJSON( '/character/showPrechallenge/sir/'+app.knight.name+'/id/'+combat_id, function(data){
				if( data.errno == 0){
					showDialog({
						title: 'Precombate',
						html: data.html,
						maxWidth: 600, 
						minWidth: 600,
						buttons: [{
									text: "artimañas",
						            name: 'button_blue',
						            click: function(){
						            	alert('Esta bajo desarrallo.');
						            }
								},
					            {
					              text: "continuar",
					              name: 'button_green',
					              click: function(){
					            	  //Show round dialog
					            	  $(this).dialog('destroy');
					            	  $.getJSON( '/character/showPendingRoundDialog/sir/'+app.knight.name+'/id/'+combat_id, function(data){
					            		  if( data.errno == 0){
						            		  showDialog({
						  						title: 'Ronda ',
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
						  					            	  $.getJSON( '/character/showRoundSelectedPointsDialog/sir/'+app.knight.name, function(data){
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
						  					            	  //Check valid data
						  					            	  if( app.combat.attack_position > 0 && app.combat.defense_position > 0 ){
						  					            		 //Show round dialog
						  					            		$(this).remove();
						  					            		
						  					            		
						  					            		  $(this).dialog('destroy');
						  					            		  $.getJSON('/character/setCombatPoints/sir/'+app.knight.name+'/combat/'+combat_id+'/attack_position/'+app.combat.attack_position+'/defense_position/'+app.combat.defense_position, function(data){
						  					            			showDialog({
						  					            				title: 'Resultado',
						  					            				html: data.html,
						  					            				maxWidth: 575,
						  					            				minWidth: 575,
						  					            				buttons: [{
						  					            					text: 'aceptar',
						  					            					name: 'button_green',
						  					            					click: function(){
						  					            						//$(this).remove();
						  					            						window.location.reload();
						  					            					}
						  					            				}]
						  					            			});
						  					            		  });						  					            		
						  					            	  }else{
						  					            		  showDialogResponse( 'Las posiciones de ataque y defensa no son válidas.' );
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
					              }
								}							
						]
					});
				}else{
					showDialogResponse( data.html );
				}
			});
			return false;
		});
	}
	
	//Show precombat for all	
	/*
	if( $('.showPrecombat').size() > 0 ){
		$('.showPrecombat').click(function(){			
			$.getJSON( $(this).attr('href'), function(data){
				showDialog({
					title: 'Precombate',
					html: data.html,
					maxWidth: 600, 
					minWidth: 600,
					buttons: [{
								text: "artimañas",
					            name: 'button_blue',
					            click: function(){
					            	alert('Esta bajo desarrallo.');
					            }
							},
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
	*/
	/*
	//Show pending round 	
	if( $('.showPendingRound').size() > 0 ){
		$('.showPendingRound').click(function(){
			//Load identificator of combat
			var combat_id = $(this).attr('href').substring( $(this).attr('href').indexOf('id/') + 3 );
			$.getJSON( $(this).attr('href'), function(data){				
      		  if( data.errno == 0){
          		  showDialog({
						title: 'Ronda',
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
					            	  $.getJSON( '/character/showRoundSelectedPointsDialog/sir/'+app.knight.name, function(data){
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
					            	  
						            	  //Check valid data position and knight has all primary equipment 
						            	  if( 	app.combat.attack_position > 0 && 
						            			app.combat.defense_position > 0 ){
						            		 //Show round dialog
						            		  $(this).remove();
						            		  $(this).dialog('destroy');
						            		  $.getJSON('/character/setCombatPoints/sir/'+app.knight.name+'/combat/'+combat_id+'/attack_position/'+app.combat.attack_position+'/defense_position/'+app.combat.defense_position, function(data){
						            			showDialog({
						            				title: 'Resultado',
						            				html: data.html,
						            				maxWidth: 575,
						            				minWidth: 575,
						            				buttons: [{
						            					text: 'aceptar',
						            					name: 'button_green',
						            					click: function(){
						            						$(this).remove();	
						            					}
						            				}]
						            			});
						            		  });						  					            		
						            	  }else{
						            		  showDialogResponse( '<p>Las posiciones de ataque y defensa no son válidas.</p><p>Selecciona donde quieres atacar y defender en la pestaña \'ataque y defensa\'</p>' );
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
			
			return false;
		});		
	}
	*/
	
	
	//Show finished round 	
	/*
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
	*/
	
	//Show postcombat
	/*
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
	*/
	
	/*medievalmarket*/
	if($('#medievalmarket').size()){
		
		$('#inventory_type').change(function(){
			$('#filter_spears').slideUp();
			$('#filter_armours').slideUp();
			$('#filter_tricks').slideUp();			
			if( $(this).val() == 56 ){ $('#filter_armours').slideDown(); }
			if( $(this).val() == 57 ){ $('#filter_spears').slideDown(); }
			if( $(this).val() == 68 ){ $('#filter_tricks').slideDown(); }
		});
		
		$('#filter_spears form').validationEngine();		
		$('#filter_spears form').submit(function(){
			return $(this).validationEngine('validate');
		});
		$('#filter_armours form').validationEngine();		
		$('#filter_armours form').submit(function(){
			return $(this).validationEngine('validate');
		});
		$('#filter_tricks form').validationEngine();		
		$('#filter_tricks form').submit(function(){
			return $(this).validationEngine('validate');
		});
	
		$('.medievalmarket_buy').click(function(){
			$.getJSON( $(this).attr('href'), function(data){
				if( data.errno == 0){
					showDialogAcceptAction( 'Comprar', data.html, function(){
						$(this).remove();
						$.getJSON( data.url, function(data2){
							if(data2.errno==0){
								showDialogResponse(data2.html);
								$('#knight_coins').html(data2.coins);
							}else{
								//Data
								showDialogResponse( data2.html );
							}
						});
					});
				}else{
					showDialogResponse( data.html );
				}
			});			
			return false;
		});
		
		$('.medievalmarket_requirements').click(function(){		
			$.getJSON( $(this).attr('href'), function(data){
				if( data.errno == 0){
					showDialogAcceptAction( 'Requisitos', data.html, function(){
						$(this).remove();						
					});
				}else{
					showDialogResponse( data.html );
				}
			});			
			return false;
		});
		
		
	}
	/**
	 * ************************** SETTINGS
	 */
	if( $('#settings').size() ){
		
		/*
		 * Update password 
		 */
		$('#updatePassword').click(function(){
			$.post( $(this).attr('href'),{newPassword: $('#newPassword').val(), repeatPassword:$('#repeatPassword').val()  }, function(data){
				data = jQuery.parseJSON(data);
				if(data.errno){
					showDialogResponse(data.html);
				}else{
					showDialogResponse(data.html);
				}
			});
			return false;
		});
		
		$('#updateSendEmails').click(function(){
			$.post( $(this).attr('href'),{emailToSendChallenge: $('#emailToSendChallenge').is(':checked'), emailToFinishedCombat: $('#emailToFinishedCombat').is(':checked'), emailToSendMessage: $('#emailToSendMessage').is(':checked'), emailToSendFriendlyRequest: $('#emailToSendFriendlyRequest').is(':checked')  }, function(data){
				data = jQuery.parseJSON(data);
				if(data.errno){
					showDialogResponse(data.html);
				}else{
					showDialogResponse(data.html);
				}
			});
			return false;
		})
	}
	
});