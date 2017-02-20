<div class="page-container">
	<div class="main-container">
		<div class="navbar">
			<a href="<?php echo str_replace("//","/", $this->webroot); ?>" id="search"><i class="fa fa-reply fa-lg"></i><div id="tags">返回</div></a>
		</div>

		<div class="content-header">
			<div class="row">
				<h1>
					查詢帳單<br><small>培正中學學生會</small>
				</h1>
			</div>

		</div>
		<div class="row">
			<?php echo $this->Session->flash("good"); ?>
    	<?php echo $this->Session->flash("bad"); ?>
			<div class="block">
				<div class="block-title">
					<h2>書本即時狀況</h2>
				</div>
				<div class="block-content">
					<form action="<?php echo str_replace("//","/", $this->webroot); ?>records/receipt" method="post">
						<label for="receipt">帳單號碼</label>
						<input type="number" name="Record[receipt]" id="receipt" placeholder="01234">
						<label for="phone">聯絡電話</label>
						<input type="number" name="Seller[phone]" id="phone" placeholder="61234567">
						<input type="submit" class="button" value="搜尋帳單">
					</form>

				</div>
				<?php if(isset($records)) : ?>
						<hr>
					<div class="block-content">
						<h4>你的帳單：</h4>
					</div>
					<table>
						<thead>
							<tr>
								<td>書號</td>
								<td>書名</td>
								<td>價錢</td>
								<td>賣家</td>
								<td>放售時間</td>
								<td>賣出時間</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($records as $record) : ?>
							<tr>
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
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<div class="block-content">
						<p>賣得：$<?=$total?></p>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>

