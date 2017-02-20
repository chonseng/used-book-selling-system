<div class="page-container">
	<div class="main-container">
		<div class="navbar">
			<a href="<?php echo str_replace("//","/", $this->webroot); ?>" id="search"><i class="fa fa-reply fa-lg"></i><div id="tags">返回</div></a>
		</div>

		<div class="content-header">
			<div class="row">
			<h1>
				買書指南<br><small>培正中學學生會</small>
			</h1>
			</div>
		</div>
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2>賣書位置及日期</h2>
				</div>
				<div class="block-content">
					<div class="row">
						<div class="large-6 medium-6 small-12 column">
							<div class="map">
								<img src="../img/oldbook_map.png" alt="">
							</div>
						</div>
						<div class="large-6 medium-6 small-12 column">
							<p class="collect"><i class="fa fa-square"></i>收書日子(6月30日-7月11日, 逢星期一、三、五,14:00-17:00)</p>
							<p class="buy"><i class="fa fa-square"></i>賣書日子(7月7日-7月25日, 逢星期一、三、五,14:00-17:00)</p>
							<div class="responsive-calendar" id="collect">
							    <div class="controls">
							        <a class="pull-left" data-go="prev"><div class="button">上月份</div></a>
							        <h4><span data-head-year></span> <span data-head-month></span></h4>
							        <a class="pull-right" data-go="next"><div class="button">下月份</div></a>
							    </div><hr/>
							    <div class="day-headers">
							      <div class="day header">一</div>
							      <div class="day header">二</div>
							      <div class="day header">三</div>
							      <div class="day header">四</div>
							      <div class="day header">五</div>
							      <div class="day header">六</div>
							      <div class="day header">日</div>
							    </div>
							    <div class="days" data-group="days">
							      
							    </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var d = new Date();

var month = d.getMonth()+1;
if (month<10) month = "0"+month;
console.log(month);
  $(document).ready(function () {
    $("#collect").responsiveCalendar({
      time: '2014-'+month,
      events: {
        "2014-06-30": {},
        "2014-07-02": {}, 
        "2014-07-04":{}, 
        "2014-07-07":{"class":"active together"}, 
        "2014-07-09":{"class":"active together"}, 
        "2014-07-11":{"class":"active together"}, 
        "2014-07-14":{"class":"active buy"}, 
        "2014-07-16":{"class":"active buy"}, 
        "2014-07-18":{"class":"active buy"}, 
        "2014-07-21":{"class":"active buy"}, 
        "2014-07-23":{"class":"active buy"}, 
        "2014-07-25":{"class":"active buy"}, 
      }
    });

  });
</script>