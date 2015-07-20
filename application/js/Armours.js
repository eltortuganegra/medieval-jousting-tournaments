/*
 * Codigo relacionado con armours
 * */
$(document).ready(function() {

	//Encontrado
	if( $('#armours-form').size() ){
		//Para el alta y actualizacion actualizamos los valores de endurance, pde y precio según se elijan opciones
		$('#Armours_armours_materials_id, #Armours_equipment_qualities_id, #Armours_equipment_size_id').change(function(){
			updateEndurancePdePrize();
		});
		/*
		$('#Armours_equipment_qualities_id').change(function(){
			updateEndurancePdePrize();
		});
		$('#Armours_equipment_size_id').change(function(){
			updateEndurancePdePrize();
		});
		*/
		
	}
});

/*
 * Change values,  armours_materials
 */
function updateEndurancePdePrize(){
	var armours_materials_endurance, armours_materials_prize, equipment_size_percent, equipment_qualities_percent  = null;
	//Load endurance prize
	$.getJSON(
			'/armoursMaterials/get/id/'+$('#Armours_armours_materials_id').val(),			
			function(data){			
								
				if(data.errno==0){	
					armours_materials_endurance = data.row.endurance;
					armours_materials_prize = data.row.prize;					
					//Load  
					$.getJSON(
						'/equipmentQualities/get/id/'+$('#Armours_equipment_qualities_id').val(),
						function(data){																																																
							if(data.errno==0){
								equipment_qualities_percent = data.row.percent;
								$.getJSON(
										'/equipmentSize/get/id/'+$('#Armours_equipment_size_id').val(),
										function(data){
											if(data.errno==0){
												
												
												//Set endurance
												$('#Armours_endurance').val( armours_materials_endurance );
												
												//Set pde. Thhis is endurance*quality percent*size
												$('#Armours_pde').val( Math.floor( (armours_materials_endurance*5)*(equipment_qualities_percent/100)*data.row.size ) );
												
												//Set prize
												$('#Armours_prize').val( Math.round( (armours_materials_endurance)*(equipment_qualities_percent/100)*data.row.percent)  );
											}else{
												alert(data.message);
											}
										}
								);
								
								
								
								
							}else{
								alert( data.message);
							}
						}
					);
				}else{
					//Show alert
					alert(data.message);
				}
			}
	);
	
	//alert( 'armours_materials_endurance:'+armours_materials_endurance+ '|armours_materials_prize'+armours_materials_prize );
	
}
/**
 * tamaño, calidad, resistencia
 */
function updateArmoursPde(){
	$('#Armours_pde').val();
}
/**
 * tamaño, calidad, precio resistencia
 */
function updateArmoursPrize(){
	$('#Armours_prize').val();
}