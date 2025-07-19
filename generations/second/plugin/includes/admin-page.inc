<div class="wrap">
	<h2>Video Importer</h2> 
	
	<p>Presentations to be imported<span id="num-found"></span>:
	<textarea id="presentations" readonly="readonly" style="width: 100%; height: 200px;">

	</textarea></p>
	<p>
		<?php submit_button('Update', 'secondary', 'update', false); ?>
		<?php submit_button('Load', 'secondary', 'load-list', false); ?>
		<?php submit_button('Run', 'primary', 'run', false, array('disabled' => 'disabled')); ?>
		<span id='status' style='margin-left: 20px;'></span>
	</p>
	<p>Presentations processed<span id="num-done"></span>:
	<textarea id="done" readonly="readonly" style="width: 100%; height: 200px;">

	</textarea></p>
	
</div>