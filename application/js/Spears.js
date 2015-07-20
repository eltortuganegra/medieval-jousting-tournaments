/*
 * Codigo relacionado con armours
 * */
$(document).ready(function() {

	//Encontrado
	if( $('#spears-form').size() ){
		//Para el alta y actualizacion actualizamos los valores de endurance, pde y precio según se elijan opciones
		$('#Spears_spears_materials_id, #Spears_equipment_qualities_id, #Spears_equipment_size_id').change(function(){
			updateDamagePdePrize();
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
function updateDamagePdePrize(){
	var spears_materials, equipment_qualities, equipment_size_percent, equipment_qualities_percent  = null;
	//Load endurance prize
	$.getJSON(
			'/spearsMaterials/get/id/'+$('#Spears_spears_materials_id').val(),			
			function(data){								
				if(data.errno==0){	
					spears_materials = data.row;										
					//Load  
					$.getJSON(
						'/equipmentQualities/get/id/'+$('#Spears_equipment_qualities_id').val(),
						function(data){																																																
							if(data.errno==0){
								equipment_qualities = data.row;
								$.getJSON(
										'/equipmentSize/get/id/'+$('#Spears_equipment_size_id').val(),
										function(data){
											if(data.errno==0){
												equipment_size = data.row;
												
												//Set endurance
												$('#Spears_damage').val( spears_materials.maximum_damage );
												
												//Set pde. Thhis is endurance*quality percent*size
												$('#Spears_pde').val( Math.floor( (spears_materials.endurance*5)*(equipment_qualities.percent/100)*data.row.size ) );
												
												//Set prize
												//alert(spears_materials.endurance+'*'+'('+equipment_qualities.percent+'/100)*('+equipment_size.percent+'/100)*'+spears_materials.maximum_damage+'/'+spears_materials.prize    );
												$('#Spears_prize').val( Math.round( (spears_materials.endurance)*(equipment_qualities.percent/100)*(equipment_size.percent/100)*(spears_materials.maximum_damage*spears_materials.prize) )  );
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