<div class="block-content">
	<div class="row">
		<form action="<?php echo str_replace("//","/", $this->webroot); ?>admins/receipt" method="get">
			<label for="receipt">帳單號</label>
			<input type="text" name="receipt" id="receipt">
			<input type="submit" value="查找" class="button">
		</form>
	</div>
</div>

<?php if(isset($records)) : ?>
<div class="row">
	<h3>賣家：<?= $_GET["receipt"]?></h3>
		
	<table>
		<thead>
			<tr>
				<td>經手人</td>
				<td>書號</td>
				<td>書名</td>
				<td>價錢</td>
				<td>賣家</td>
				<td>放售時間</td>
				<td>賣出時間</td>
				<td>刪除</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($records as $record) : ?>
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
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<?php elseif (isset($_GET["receipt"])) : ?>
	<div class="row">
		<h3>沒有賣家資料</h3>
	</div>
<?php endif ?>

<script>
	if (localStorage["receipt"] != undefined) $("#receipt").val(localStorage["receipt"]);
</script>