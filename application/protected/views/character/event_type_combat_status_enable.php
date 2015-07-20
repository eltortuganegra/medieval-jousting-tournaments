<div class="combat_status_enable">
	<div class="combat_status_enable_pre_pro">
		<a href="/character/showPrecombat/sir/<?php echo $this->knight->name?>/id/<?echo $combat->id?>" class="showPrecombat"><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>precombat.png" /></a>
		<?php if($combat->status == Combats::STATUS_FINISHED):?>
			<a href="/character/showPostcombat/sir/<?php echo $this->knight->name?>/id/<?echo $combat->id?>" class="showPostcombat"><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>postcombat_enable.png" /></a>
		<?php else:?>
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>postcombat_disable.png" />		
		<?php endif;?>
	</div>
	<div class="rounds">
		<?php 
		/*
		 * Rounds is sort by date desc. Last rounds are first. Show last 12rounds. 
		 */	
		$maxRound = 12;	
		foreach( array_reverse($combat->rounds) as $round ){
			if( $maxRound == 0) break;
			//Check if user is login
			if( !Yii::app()->user->isGuest && Yii::app()->user->knights_id == $this->knight->id && $round->status == Rounds::STATUS_PENDING){
				//This round is pending for this user and user is in combat.
				$urlAction = '/character/showPendingRoundDialog/sir/'.$this->knight->name.'/id/'.$round->combats_id;
				$classAction = 'showPendingRound';
			}else{
				//User is not in combat
				if( $round->status == Rounds::STATUS_PENDING ){
					$urlAction = '/character/showPendingRoundDialog/sir/'.$this->knight->name.'/combat/'.$round->combats_id.'/round/'.$round->number;
					$classAction = 'showFinishedRound';
				}else{
					$urlAction = '/character/showFinishedRound/sir/'.$this->knight->name.'/combat/'.$round->combats_id.'/round/'.$round->number;
					$classAction = 'showFinishedRound';
				}				
			}
			echo '<a href="'.$urlAction.'" class="'.$classAction.'" title="'.$round->number.'">
					<div class="round round_size">						
						<img src="'.Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'rounds_status_'.$round->status.'.png"/>
						<p class="round_number">'.$round->number.'</p>
					</div>					
				</a>';
			$maxRound--;
		}
		?>	
	</div>
</div>