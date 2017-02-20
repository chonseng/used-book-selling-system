
<div class="row">

	<table>
		<thead>
			<tr>
				<td>賣家</td>
				<td>聯絡電話</td>
				<td>賣得金額</td>
				<td>帳單</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $seller) : ?>
			<tr>
				<td>
					<?=$seller["Seller"]["name"]?>
				</td>
				<td>
					<a href='tel:<?=$seller["Seller"]["phone"]?>'><?=$seller["Seller"]["phone"]?></a>
				</td>
				<td>
					<?= money_format('%i', $seller[0]["Total"])?>
				</td>
				<td>
					<?php foreach ($seller[0]["Receipt"] as $receipt) :?>
						<li><?=$receipt?></li>
					<?php endforeach ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<div class="paginator">
		<span>
			<?= $this->Paginator->counter('<strong>{:start}</strong>-<strong>{:end}</strong> of <strong>{:count}</strong>') ?>
		</span>
		<div class="paging">
		<?php
			echo $this->Paginator->prev('<', array('tag'=>'i','class'=>'fa fa-chevron-left page'), ' ', array('tag'=>'i','class' => 'fa fa-chevron-left page prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ' ','class'=>'page'));
			echo $this->Paginator->next('>', array('tag'=>'i','class'=>'fa fa-chevron-right page'), ' ', array('class' => 'fa fa-chevron-right page next disabled'));
		?>
		</div>
		
	</div>
</div>
<!-- 

<div class="row">
	<p>第<?=$current?>頁</p>
	<?php if (isset($pre)): ?>
	<a href="?page=<?=$pre?>">上一頁</a>
	<?php endif ?>
	<?php if (isset($next)): ?>
	<a href="?page=<?=$next?>">下一頁</a>
	<?php endif ?>
	<?php foreach ($records as $record) : ?>
	<div class="panel callout radius">
		<h3>賣家：<?=$record["name"]?></h3>
		<p>聯絡電話：<a href='tel:<?=$record["phone"]?>'><?=$record["phone"]?></a></p>
		<p>賣得金額：$<big><?=$record["total"]?></big></p>
		<p>擁有的帳單：</p>
		<ul>
		<?php foreach ($record["receipt"] as $receipt) :?>
			<li><?=$receipt?></li>
		<?php endforeach ?>
		</ul>
	</div>
	<?php endforeach; ?>
</div>
 -->
<script>
	$(".panel").click(function(){
		if($(this).hasClass("callout")) $(this).removeClass("callout");
		else $(this).addClass("callout");
	})
</script>