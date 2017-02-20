<?php if(isset($record)) : ?>
	<table>
		<thead>
			<tr>
				<td>經手人</td>
				<td>代賣書號</td>
				<td>書名</td>
				<td>原價</td>
				<td>價錢</td>
				<td>賣家</td>
				<td>放售時間</td>
				<td>賣出時間</td>
				<td>刪除</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?=$record["Record"]["handler"]?>
				</td>
				<td>
					<?php 
						echo $record["Record"]["receipt"];
						if ($record["Record"]["receipt_num"]<10) echo "0";
						echo $record["Record"]["receipt_num"];
					?>
				</td>
				<td>
					<?=$record["Book"]["name"]?>
				</td>
				<td>
					<?=$record["Book"]["price"]?>
				</td>
				<td>
					<?=$record["Record"]["price"]?>
				</td>
				<td>
					<?=$record["Seller"]["name"]?>
				</td>
				<td>
					<?=$record["Record"]["selled_at"]?>
				</td>
				<td>
					<?=$record["Record"]["brought_at"]?>
				</td>
				<td>
					<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/delete/<?=$record['Record']['id']?>" class="alert button label">刪除</a>
				</td>
			</tr>
		</tbody>
	</table>
<?php endif ?>
<div class="block-content">
	<div class="row">
		<form action="<?php echo str_replace("//","/", $this->webroot); ?>admins/add" method="post" id="addform">
			<label>經手人</label>
			<input type="text" name="Record[handler]" id="handler" required>
			<fieldset>
				<legend>賣家資料</legend>
				<label>名稱</label>
				<input type="text" name="Record[seller]" id="seller" required>
				<label>聯絡電話</label>
				<input type="number" name="Record[phone]" id="phone" required>
			</fieldset>
			<fieldset>
				<legend>帳單</legend>
				<label>帳單編號</label>
				<input type="number" name="Record[receipt]" id="receipt" required>
				<label>序號</label>
				<input type="number" name="Record[receipt_num]" id="receipt_num" required>
			</fieldset>
			<fieldset>
				<legend>書目資料</legend>
				<label for="type">類別</label>
				<select id="type">
					<option value="0" selected>非國內書</option>
					<option value="1">國內書</option>
				</select>

				<label for="form">年級</label>
				<select id="form">
					<option value="7">初一</option>
					<option value="8">初二</option>
					<option value="9">初三</option>
					<option value="10">高一</option>
					<option value="11">高二</option>
					<option value="12">高三</option>
				</select>

				<label for="subject">科目</label>
				<select id="subject">
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
				
				<label for="subject">書本</label>
				<select name="Book[id]" id="book"></select>
			</fieldset>

			<label>定價</label>
			<input type="number" name="Record[price]" placeholder="$" required>


			<input type="submit" value="加入" class="button">
		</form>

	</div>
</div>

<script>
	if (localStorage["handler"] != undefined) $("#handler").val(localStorage["handler"]);
	if (localStorage["seller"] != undefined) $("#seller").val(localStorage["seller"]);
	if (localStorage["phone"] != undefined) $("#phone").val(localStorage["phone"]);
	if (localStorage["receipt"] != undefined) $("#receipt").val(localStorage["receipt"]);
	// if (localStorage["receipt_num"] != undefined) $("#receipt_num").val(localStorage["receipt_num"]);
	if (localStorage["form"] != undefined) $("#form").val(localStorage["form"]);
	if (localStorage["type"] != undefined) $("#type").val(localStorage["type"]);
	if (localStorage["subject"] != undefined) $("#subject").val(localStorage["subject"]);
	$("#addform").submit(function(){

		localStorage["handler"] = $("#handler").val();
		localStorage["seller"] = $("#seller").val();
		localStorage["receipt"] = $("#receipt").val();
		// localStorage["receipt_num"] = parseInt($("#receipt_num").val(),10)+1;
		localStorage["phone"] = $("#phone").val();
		localStorage["form"] = $("#form").val();
		localStorage["type"] = $("#type").val();
		localStorage["subject"] = $("#subject").val();
	})

	function bookChange() {
		var form = $("#form").val();
		var subject = $("#subject").val();
		var type = $("#type").val();
		$.getJSON( "<?php echo str_replace("//","/", $this->webroot); ?>admins/books.json?form="+form+"&subject="+subject+"&type="+type, function( data ) {
		 	var myhtml = "";
		 	$.each( data, function( key, val ) {
		 		myhtml += "<option value='" + key + "'>" + val["name"] + " - $"+ val["price"]+ "</option>";
		 	});
		 	if (myhtml == "") myhtml = "<option value='0'>-</option>";
			console.log(myhtml);
			$("#book").html(myhtml);


		});
	}
	bookChange();

	$("#form").change(bookChange);
	$("#subject").change(bookChange);
	$("#type").change(bookChange);
</script>