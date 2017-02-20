<div class="block-content">
	<div class="row">
		<form action="<?php echo str_replace("//","/", $this->webroot); ?>admins/oldbook" method="post" id="addform">
			<label>上年年級</label>
			<select name="Prev[form]" id="form">
				<option value="">/</option>
				<option value="7">初一</option>
				<option value="8">初二</option>
				<option value="9">初三</option>
				<option value="10">高一</option>
				<option value="11">高二</option>
				<option value="12">高三</option>
			</select>

			<label>上年序號</label>
			<input type="text" name="Prev[code]" id="receipt">
			
			<label>今年年級</label>
			<select name="Place[form]" id="form">
				<option value="">/</option>
				<option value="7">初一</option>
				<option value="8">初二</option>
				<option value="9">初三</option>
				<option value="10">高一</option>
				<option value="11">高二</option>
				<option value="12">高三</option>
			</select>

			<label>今年序號</label>
			<input type="text" name="Place[code]" id="receipt">


			<input type="submit" value="加入" class="button">
		</form>

	</div>
</div>
