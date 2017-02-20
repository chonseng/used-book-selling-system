<div class="row">
	<?php echo $this->Session->flash("good"); ?>
    	<?php echo $this->Session->flash("bad"); ?>
	<div class="large-4 large-offset-4 medium-8 medium-offset-2 column">
		<div class="block">
			<div class="block-title">
				<h2>登入管理系統</h2>
			</div>
			<div class="block-content">
				<?= $this->Form->create("Admin") ?>


				<?= $this->Form->input("login", array("label"=>"用戶名")) ?>
				<?= $this->Form->input("password", array("label"=>"密碼")) ?>



				<?= $this->Form->end(array('label'=>'登入',"class"=>"button")) ?>
			</div>
		</div>
	</div>

</div>