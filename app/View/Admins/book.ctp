
<div class="row">
	<table>
		<thead>
			<tr>
				<td><?=$this->Paginator->sort('form', '年級',array('direction' => 'desc','class'=>'sorting'));?></td></td>
				<td><?=$this->Paginator->sort('code', '書單序號',array('direction' => 'desc','class'=>'sorting'));?></td>
				<td><?=$this->Paginator->sort('name', '書名',array('direction' => 'desc','class'=>'sorting'));?></td></td>
				<td><?=$this->Paginator->sort('subject', '科目',array('direction' => 'desc','class'=>'sorting'));?></td></td>
				<td><?=$this->Paginator->sort('price', '價錢',array('direction' => 'desc','class'=>'sorting'));?></td></td>
				<td><?=$this->Paginator->sort('type', '備注',array('direction' => 'desc','class'=>'sorting'));?></td></td>
				<td>刪除</td></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $record) : ?>
			<tr>
			
				<td>
					<?php foreach ($record["Place"] as $key => $place) : ?>
					<li><?=$form_array[$place["form"]]?></li>
					<?php endforeach;?>
					
				</td>
				<td>
					<?php foreach ($record["Place"] as $key => $place) : ?>
					<li><?=$place["code"]?></li>
					<?php endforeach;?>
				</td>
				<td>
					<?=$record["Book"]["name"]?>
				</td>
				<td>
					<?=$record["Book"]["subject"]?>
				</td>
				<td>
					<?=$record["Book"]["price"]?>
				</td>
				<td>
					<?php foreach ($record["Place"] as $key => $place) : ?>
					<li><?=$book_type[$place["type"]]?></li>
					<?php endforeach;?>
				</td>
				<td>
					<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/deletebook/<?=$record['Book']['id']?>" class="alert button label">刪除</a>
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

