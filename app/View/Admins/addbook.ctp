<div class="block-content">
	<div class="row">
		<form action="<?php echo str_replace("//","/", $this->webroot); ?>admins/addbook" method="post" id="bookform">

				<label>書名</label>
				<input type="text" name="Book[name]">
				<label>書單序號</label>
				<input type="number" name="Place[code]">
				<label>價錢</label>
				<input type="number" step="0.01" name="Book[price]">

				<label for="type">類別</label>
				<select name="Place[type]" id="type">
					<option value="0" selected>非國內書</option>
					<option value="1">國內書</option>
				</select>

				<label for="form">年級</label>
				<select name="Place[form]" id="form">
					<option value="7">初一</option>
					<option value="8">初二</option>
					<option value="9">初三</option>
					<option value="10">高一</option>
					<option value="11">高二</option>
					<option value="12">高三</option>
				</select>

				<label for="subject">科目</label>
				<select name="Book[subject]" id="subject">
					<option value="Bible">聖經</option>
					<option value="English">英文</option>
					<option value="Chinese">國文</option>
					<option value="Maths">數學</option>
					<option value="Physics">物理</option>
					<option value="Chemistry">化學</option>
					<option value="Science">科學</option>
					<option value="Biology">生物</option>
					<option value="History">歷史</option>
					<option value="Geography">地理</option>
					<option value="IT">資訊</option>
					<option value="Economics">經濟</option>
					<option value="Accounting">會計</option>
				</select>
				
				

			<input type="submit" class="button" value="加入">
		</form>
	</div>
</div>

<script>
	if (localStorage["add_form"] != undefined) $("#form").val(localStorage["add_form"]);
	if (localStorage["add_subject"] != undefined) $("#subject").val(localStorage["add_subject"]);

	$("#bookform").submit(function(){
		localStorage["add_form"] = $("#form").val();
		localStorage["add_subject"] = $("#subject").val();
	})
</script>