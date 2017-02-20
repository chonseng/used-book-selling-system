<table>
	<th>
		<td>年級(7-12)</td>
		<td>序號</td>
		<td>書名</td>
		<td>科目</td>
		<td>折後價</td>
		<td>類別</td>
	</th>
</table>
<div class="block-content">
	<div class="row">
		<form action="<?php echo str_replace("//","/", $this->webroot); ?>admins/addmanybooks" method="post" id="bookform">
				<textarea name="allbooks" id="allbooks" cols="30" rows="10" placeholder="複製Excel然後貼上"></textarea>
				
				

			<input type="submit" class="button" value="加入">
		</form>
	</div>
</div>

