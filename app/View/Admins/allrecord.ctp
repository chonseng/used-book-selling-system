
<div class="row">
	<div class="sort"><?=$this->Paginator->sort('brought_at', '按賣出',array('direction' => 'desc','class'=>'sorting button'));?></div>
	<div class="sort"><?=$this->Paginator->sort('selled_at', '按放售',array('direction' => 'desc','class'=>'sorting button'));?></div>
	
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
				<td>復原賣出</td>
				<td>刪除</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $record) : ?>
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
					<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/notbuy/<?=$record['Record']['id']?>" class="alert button">復原</a>
				</td>
				<td>
					<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/delete/<?=$record['Record']['id']?>" class="alert button">刪除</a>
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

