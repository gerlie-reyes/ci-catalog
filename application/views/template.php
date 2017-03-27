<?php $this->load->view('templates/header'); ?>
	<div id="content" class="container">
		<div class="row">
			<?php $this->load->view('pages/'.$page); ?>
			<div class="clearfix"></div>
		</div>
	</div>
<?php $this->load->view('templates/footer'); ?>