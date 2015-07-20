/**
 * ************************************************************* FUNCTIONS
 * /

/**
 * funcion 
 */
function showItemInfo(){
	$('.item').hover(
			function(){
				$(this).children( '.item_info' ).css('display', 'block');
			},
			function(){
				$(this).children( '.item_info' ).css('display', 'none');
			}
	);
}
/**
 * 
 */
function generateKnightsAttributesChart(){
	$.jqplot(
			'chart_knight_attributes', 
			[
		        [[app.user.knights_card.strength,8], 
		         [app.user.knights_card.dexterity,7], 
		         [app.user.knights_card.constitution,6], 
		         [app.user.knights_card.perception,5], 
		         [app.user.knights_card.intelligence,4], 
		         [app.user.knights_card.skill,3], 
		         [app.user.knights_card.charisma,2], 
		         [app.user.knights_card.will,1]]		        
		    ],
		    {
				seriesDefaults: {
					renderer:$.jqplot.BarRenderer,
					pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
					shadowAngle: 120,
					rendererOptions: {
		                barDirection: 'horizontal'
		            },
		            color: '#4169E1',
		            lineWidth: 2.5
				},
				axes: {
					xaxis:{	
						min:0,
						pad: 2				
						
					},
		            yaxis: {		            	
		                renderer: $.jqplot.CategoryAxisRenderer,
		                ticks: ['VOLUNTAD','CARISMA','HABILIDAD','INTELIGENCIA','PERCEPCIÓN','CONSTITUCIÓN','DESTREZA','FUERZA' ],		                					
		            }
		        },
		        
			}
		);
}
function generateKnightsStatsChart(){
	 var data = [
	             ['Ganados', app.user.knights_stats.combats_wins],['Ganados con herida', app.user.knights_stats.combats_wins_injury], ['empatados', app.user.knights_stats.combats_draw],
	             ['empatados con herida', app.user.knights_stats.combats_draw_injury],['perdidos', app.user.knights_stats.combats_loose], ['perdidos con herida', app.user.knights_stats.combats_loose_injury]
	           ];
	/*
	 data = [
             ['Ganados', 10],['Ganados con herida', 9], ['empatados', 1],
             ['empatados con herida', 10],['perdidos', 0], ['perdidos con herida', 0]
           ];
        */
	 var plot1 = jQuery.jqplot ('chart_knight_stats', [data],
			    {
		 			seriesColors: [ "palegreen", "lime", "khaki", "yellow", "tomato", "red"],
		 			seriesDefaults: {
		 				// Make this a pie chart.
		 				renderer: jQuery.jqplot.PieRenderer,
		 				rendererOptions: {
			 				// Put data labels on the pie slices.
			 				//By default, labels show the percentage of the slice.
			 				showDataLabels: true,			 				 
		 				}
		 			},
		 			legend: { show:true, location: 's',yoffset: 7 }	 		
			    }
			  );	
}
/**
 * Generate Vs stats
 */
function generateKnightsVsStatsChart(){
	 var data = [
	             ['Ganados', app.user.knights_stats_vs.combats_wins],['Ganados con herida', app.user.knights_stats_vs.combats_wins_injury], ['empatados', app.user.knights_stats_vs.combats_draw],
	             ['empatados con herida', app.user.knights_stats_vs.combats_draw_injury],['perdidos', app.user.knights_stats_vs.combats_loose], ['perdidos con herida', app.user.knights_stats_vs.combats_loose_injury]
	           ];
	/*
	 data = [
            ['Ganados', 10],['Ganados con herida', 9], ['empatados', 1],
            ['empatados con herida', 10],['perdidos', 0], ['perdidos con herida', 0]
          ];
       */
	 var plot2 = jQuery.jqplot ('chart_knight_stats_vs', [data],
			    {
		 			seriesColors: [ "palegreen", "lime", "khaki", "yellow", "tomato", "red"],
		 			seriesDefaults: {
		 				// Make this a pie chart.
		 				renderer: jQuery.jqplot.PieRenderer,
		 				rendererOptions: {
			 				// Put data labels on the pie slices.
			 				//By default, labels show the percentage of the slice.
			 				showDataLabels: true,			 				 
		 				}
		 			},
		 			legend: { show:true, location: 's',yoffset: 7 }	 		
			    }
			  );	
}

/**
 * Send a requesto for reply to frienship
 * @param id, identificator of frienship
 * @param action, accept/reject
 */
function replyToFriendship( id, action){
	
	$.getJSON( '/character/replyToFriendship', 
			{
				id: id,
				action: action
			}, 
			function(data){						
				//Error. Mostramos el mensaje de error									
				$('<div class="message"></div>')
				.html( data.message )
				.dialog({
					title: "Mensaje",
					autoOpen: false,
					modal:true,
					closeOnEscape: true,
					resizable: false,
					maxWidth: 200,
					minWidth: 200,
					buttons: [{
					              text: "Aceptar",
					              click: function() {
					            	  window.location.reload();
					            	  $(this).dialog("close");
					            	  $(this).remove();
					            	  dropItem =  false;
					              }
					}]
					
				})
				.dialog('open');						
			}
	);
}

/**
 * Show a standar dialog for information 
 * @param html
 */
function showDialogResponse( html ){
	$('<div class="message_dialog"></div>')
	.html( html )
	.dialog({
		title: "Mensaje",
		autoOpen: false,
		modal:true,
		closeOnEscape: true,
		resizable: false,
		maxWidth: 200,
		minWidth: 200,
		buttons: [{
		              text: "Aceptar",
		              name: 'button_green',
		              click: function(){$(this).dialog('destroy');$(this).remove()}
		}]
		
	})
	.dialog('open');
}


function showDialogAcceptAction( title, html, acceptClickFunction ){
	//Show 							
	$('<div class="message_dialog"></div>')
	.html( html )
	.dialog({
		title: title,
		autoOpen: false,
		modal:true,
		closeOnEscape: true,
		resizable: false,
		maxWidth: 200,
		minWidth: 200,
		buttons: [{
		              text: "Aceptar",
		              name: 'button_green',
		              click:acceptClickFunction
		}]
		
	})
	.dialog('open');						

}

/**
 * Show jquery ui dialog for with options 
 */
function showDialog( options ){
	$('<div class="message_dialog"></div>')
	.html( options.html )
	.dialog({
		title: (options.title == undefined)?'Mensaje':options.title,
		autoOpen: false,
		modal:true,
		closeOnEscape: true,
		resizable: false,
		maxWidth: (options.maxWidth == undefined)? 200 : options.maxWidth,
		minWidth: (options.minWidth == undefined)? 200 : options.minWidth,
		buttons: options.buttons
		
	})
	.dialog('open');
}

function makeItemsDraggable(){
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
}

function makePrimaryEquipmentDroppable(){

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
					var finalPositionItem = '';//If item in 
					//Comprobamos si la casilla destino está ocupada 
					if( $(this).children('.item').size()  ){
						//Almacenamos el item.
						finalPositionItem = $(this).html();
					}
					//Comprobamos la posicion inicial y final
					var initial_position = $( ui.draggable ).parent().attr('id').replace('ui_inventory_position_','');					
					var final_position = $(this).attr('id').replace('ui_inventory_position_','');
					
					//Insertamos el item en la posicion destino. Creamos el div y le asignamos el draggable
					$( ui.draggable ).removeClass('ui-draggable-dragging');
					$(this).html( '<div class="'+$( ui.draggable ).attr('class')+'">'+$( ui.draggable ).html()+'</div>' );
					$( '.item' ).draggable({
						cursor: "move",
						revert: true,
						start: function(event, ui){				
							$(this).children( '.item_info' ).css('display', 'none');
						}
					});
					//Actualizamos la posicion inicial
					if( finalPositionItem == '' ){
						$( ui.draggable ).remove();
					}else{
						$( ui.draggable ).html( finalPositionItem );	
					}
					

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
								}else{
									//Change status of knight
									$('#user_knights_status').html( data.knight_status_label );
								}
							}
				);
					
				}
			});			
		}	


}

function makeSecondaryEquipmentDroppable(){
	$( '.ui_inventory_position_all' ).droppable({
		cursor: "move",			
		activeClass: "ui_inventory_position_enable",
		drop: function( event, ui ) {
			var item = '';
			var initial_position = $( ui.draggable ).parent().attr('id').replace('ui_inventory_position_','');				
			var final_position = $(this).attr('id').replace('ui_inventory_position_','');
			
			//Comprobamos si la casilla destino está ocupada 
			if( $(this).children('.item').size()  ){
				//Si la posicion inicial es de una del equipo en uso y los objetos no tienen el mismo tipo, no se puede hacer el cambio.					
				if( $( ui.draggable ).parent().hasClass( 'ui_inventory_position_in_use' )  ){
					var class_list = $(this).children('.item').attr('class');					
					var type_object_in_position =  (class_list.replace( 'item', '' )).replace('ui-draggable','').replace(/\s+/g, '');
					
					//objeto arrastrado
					var type_object_dragged = $( ui.draggable ).attr( 'class' );
					type_object_dragged = (type_object_dragged.replace( 'item', '' )).replace('ui-draggable-dragging','').replace('ui-draggable','').replace(/\s+/g, '');
					//Comprobamos si son del mismo tipo					
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
							}else{
								//Change status of knight
								$('#user_knights_status').html( data.knight_status_label );
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
}
/**
 * Make attack point draggable
 */
function makeIconAttackPointDraggable(){
	
	//Let the item to be draggable
	$( '#ui_icon_attack_point' ).draggable({
		cursor: "move",
		revert: true,
		start: function(event, ui){
			//$(this).children( '.item_info' ).css('display', 'none');
		},
		stop: function(event, ui){
			//$(this).parent().css('z-index', 'auto');
		}
	});
}

/**
 * Make position enable for drop attack
 */
function makeAttackPointPositionDroppable(){
	var attack_position = 0;
	$('.ui_attack_point_position').droppable({
		cursor: "move",			
		activeClass: "ui_attack_point_position_enable",
		accept: '#ui_icon_attack_point',
		drop: function( event, ui ) {
			$(this).html( '<div id="ui_icon_attack_point">'+$(ui.draggable).html()+'</div>' );
			$( ui.draggable ).remove();
			makeIconAttackPointDraggable();
			//Load position
			app.combat.attack_position = parseInt( $(this).attr('id').replace('ui_attack_point_',''));
		}	
	});
	return attack_position;
}
/**
 * Make defense icon draggable
 */
function makeIconDefensePointDraggable(){
	//Let the item to be draggable
	$( '#ui_icon_defense_point' ).draggable({
		cursor: "move",
		revert: true,
		start: function(event, ui){
			//$(this).children( '.item_info' ).css('display', 'none');
		},
		stop: function(event, ui){
			//$(this).parent().css('z-index', 'auto');
		}
	});
	
}
/**
 * Make position enable for drop 
 */
function makeDefensePointPositionDroppable(){	
	$('.ui_defense_point_position_inner_wrapper').droppable({
		cursor: "move",			
		activeClass: "ui_defense_point_position_inner_wrapper_enable",
		accept: '#ui_icon_defense_point',
		drop: function( event, ui ) {
			var classElement = $(ui.draggable).attr('class').replace('ui-draggable-dragging','');
			var newItem = '<div id="ui_icon_defense_point" class="'+classElement+'">'+$(ui.draggable).html()+'</div>';			
			$(this).html( newItem );
			$( ui.draggable ).remove();			
			makeIconDefensePointDraggable();
			//Load position
			app.combat.defense_position = parseInt( $(this).attr('id').replace('ui_defense_point_','') );
		}	
	});
	
	
}
