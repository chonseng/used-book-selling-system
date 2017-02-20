<div class="page-container">
	<div class="main-container">
		<div class="navbar">
			<a href="#" id="search"><i class="fa fa-search fa-lg"></i><div id="tags"></div></a>
			<a href="#" id="refresh"><i class="fa fa-refresh fa-lg"></i></a>
		</div>
		<div class="side-container">
			<h1>搜尋</h1>


			<form action="<?php echo str_replace("//","/", $this->webroot); ?>records" method="get" id="filterForm">
				<div class="row">
					<div class="large-12 column filter form">
						<label for="form">年級 (選填)</label>
						<select name="form" id="form">
							<option value="">/</option>
							<option data-form='初一'value="7">初一</option>
							<option data-form='初二'value="8">初二</option>
							<option data-form='初三'value="9">初三</option>
							<option data-form='高一'value="10">高一</option>
							<option data-form='高二'value="11">高二</option>
							<option data-form='高三'value="12">高三</option>
						</select>
					</div>
					<div class="large-12 column filter subject">
						<label for="subject">科目 (選填)</label>
						<select name="subject" id="subject">
							<option value="">/</option>
							<option data-subject='聖經' value="Bible">聖經</option>
							<option data-subject='英文' value="English">英文</option>
							<option data-subject='國文' value="Chinese">國文</option>
							<option data-subject='數學' value="Maths">數學</option>
							<option data-subject='物理' value="Physics">物理</option>
							<option data-subject='化學' value="Chemistry">化學</option>
							<option data-subject='科學' value="Science">科學</option>
							<option data-subject='生物' value="Biology">生物</option>
							<option data-subject='歷史' value="History">歷史</option>
							<option data-subject='地理' value="Geography">地理</option>
							<option data-subject='資訊' value="IT">資訊</option>
							<option data-subject='經濟' value="Economics">經濟</option>
							<option data-subject='會計' value="Accounting">會計</option>
						</select>
					</div>
					<div class="large-12 column filter code">
						<label for="code">書單序號 (選填)</label>
						<input type="number" name="code" id="code">
					</div>
					<div class="large-12 column">
						<input type="submit" class="button button-primiary" value="搜尋" id="searchButton">
						<input type="button" class="button button-warning" value="重設" id="reset">
					</div>
				</div>
			</form>
			
		</div>
		<div class="content-header">
			<div class="row">
			<h1>
				代賣舊書<br><small>培正中學學生會</small>
			</h1>
				<a href="<?php echo str_replace("//","/", $this->webroot); ?>records/receipt" class="receipt"><i class="fa fa-file-text-o fa-3x"></i><div>查詢帳單</div></a>
				<!-- <a href="<?php echo str_replace("//","/", $this->webroot); ?>pages/instruction" class="question"><i class="fa fa-question-circle fa-3x"></i><div>買書指南</div></a> -->
			</div>
		</div>
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><strong>現售</strong>書目</h2>
					<div class="sort"><?=$this->Paginator->sort('selled_at', '按時間',array('direction' => 'asc','class'=>'sorting button'));?></div>
					<div class="sort"><?=$this->Paginator->sort('price', '售價',array('direction' => 'asc','class'=>'sorting button'));?></div>
					<div class="sort"><?=$this->Paginator->sort('diff', '差價',array('direction' => 'desc','class'=>'sorting button'));?></div>
				</div>
					<div class="block-content">
						<p>記下「舊書號」，然後親臨本會購買。
							<!-- 詳閱<a href="<?php echo str_replace("//","/", $this->webroot); ?>pages/instruction">買書指南</a> -->
						</p>	
					</div>
					<table>
						<thead>
							<tr>
								<td>舊書號</td>
								<td>書名</td>
								<td class="diff_td">差價</td>
								<td>售價</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $record) : ?>
							<tr>
								<td class="table_info">
									<?php 
										echo $record["Record"]["receipt"];
										if ($record["Record"]["receipt_num"]<10) echo "0";
										echo $record["Record"]["receipt_num"];
									?>
									<div class="table_tag">
										<a href="<?php echo str_replace("//","/", $this->webroot); ?>records/index?subject=<?=$record['Book']['subject']?>" class="tag subject">
											<?=$subject_array[$record["Book"]["subject"]]?>
										</a>
									</div>
								</td>
								<td>
									<a href="<?php echo str_replace("//","/", $this->webroot); ?>records/index?book_id=<?=$record["Book"]["id"]?>"><?=$record["Book"]["name"]?></a>
								</td>
								<td class="diff diff_td">
									[$<?= $record["Record"]["diff"] ?>]
								</td>
								<td class="price">
									<div>$<?=$record["Record"]["price"]?></div>
									<small><span>書店價：</span>$<?=$record["Book"]["price"]?></small>
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
			
		</div>
	</div>
</div>
<script>
	(function(){
		$("#code").val(<?=$code?>);
		$("#form").val(<?=$form?>);
		$("#subject").val("<?=$subject?>");
		var book_name = "<?=$book_name?>";

		function changeTag(){
			$("#tags").html("");
			if (book_name != "") {
				$("#tags").append("<div class='tag book_name'>"+book_name+"</div>");
			}

			if ($("#form").val() != "") {
				$("#tags").append("<div class='tag form'>"+$("#form option:selected").data("form")+"</div>");
			}
			
			if ($("#subject").val() != "") {
				$("#tags").append("<div class='tag subject'>"+$("#subject option:selected").data("subject")+"</div>");
			}
			
			if ($("#code").val() != "") {
				$("#tags").append("<div class='tag code'>"+$("#code").val()+"</div>");
			}

			if ($("#tags").html() == "") {
				$("#tags").html("搜尋..");
				$("#refresh").hide();
			}
			else {
				$("#refresh").show();	
			}
		}
		changeTag();

		function formChange() {
			if ($("#form").val() != "") {
				$(".filter.form").addClass("active");
			} else $(".filter.form").removeClass("active");
			
			if ($("#subject").val() != "") {
				$(".filter.subject").addClass("active");
			} else $(".filter.subject").removeClass("active");
			
			if ($("#code").val() != "") {
				$(".filter.code").addClass("active");
			} else $(".filter.code").removeClass("active");
		}
		formChange();
		$("#form").change(function(){
			formChange();
		})
		$("#subject").change(function(){
			formChange();
		})
		$("#code").keyup(function(){
			formChange();
		})

		function resetForm() {
			$("#form").val("");
			$("#subject").val("");
			$("#code").val("");
			$("#refresh").hide();
			$("#filterForm").submit();
		}

		$("#reset").click(function(){
			resetForm();
			return false;
		})
		$("#refresh").click(function(){
			resetForm();
			return false;
		})


		$("#searchButton").click(function(){
			mixpanel.track("Search Button Clicked");
		})

		$(".tag.subject").click(function(){
			mixpanel.track("Subject Tag Clicked");
		})


		// function hasSide() {
		// 	if ($("body").width() > 800) $(".page-container").addClass("open");
		// 	else $(".page-container").removeClass("open");
		// }
		// hasSide();

		$("#search").click(function(){
			mixpanel.track("Search Bar Clicked");
			if ($(".page-container").hasClass("open")) $(".page-container").removeClass("open");
			else $(".page-container").addClass("open");
			return false;
		})
	})();
</script>