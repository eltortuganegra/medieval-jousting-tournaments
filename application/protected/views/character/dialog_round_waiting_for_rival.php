<h1>A la espera de tu adversario</h1>
<p>Tu adversario está sopesando sus posibilidades la cuales sabes que son escasas. Aún qué tu paciencia tiene un límite.</p>
<p>Si el muy cobardica no ha respondido antes de que termine la cuenta atrás puedes descalificarlo y ganar el combate.</p>
<div id="desqualify">	
	<p>DESCALIFICAR EN:<span id="countdownTime"></span></p>
	<script language="javascript">combatManager.countdownTime = <?php echo $desqualifyTime;?>;combatManager.countdownRun();combatManager.desqualifyButton();</script>
</div>