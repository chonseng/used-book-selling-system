<div class="row">
	<div class="block-content">
		<form action="<?php echo str_replace("//","/", $this->webroot); ?>admins/buy" method="post">
			<label for="id">書本編號</label>
			<input type="text" id="id" name="booknum">
			<input type="submit" class="button" value="購買">
		</form>
	</div>

	<?php if(isset($selled)) : ?>
		<table>
			<thead>
				<tr>
					<td>代賣書號</td>
					<td>書名</td>
					<td>價錢</td>
					<td>賣家</td>
					<td>放售時間</td>
					<td>賣出時間</td>
					<td>復原</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<?php 
							echo $selled["Record"]["receipt"];
							if ($selled["Record"]["receipt_num"]<10) echo "0";
							echo $selled["Record"]["receipt_num"];
						?>
					</td>
					<td>
						<?=$selled["Book"]["name"]?>
					</td>
					<td>
						<?=$selled["Record"]["price"]?>
					</td>
					<td>
						<?=$selled["Seller"]["name"]?>
					</td>
					<td>
						<?=$selled["Record"]["selled_at"]?>
					</td>
					<td>
						<?=$selled["Record"]["brought_at"]?>
					</td>
					<td>
						<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/notbuy/<?=$selled['Record']['id']?>" class="button alert">復原</a>
					</td>
				</tr>
			</tbody>
		</table>
	<?php endif ?>
</div>
