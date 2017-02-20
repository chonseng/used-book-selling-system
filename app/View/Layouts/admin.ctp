<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>培正中學學生會代賣舊書</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text<?php echo str_replace("//","/", $this->webroot); ?>css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo str_replace("//","/", $this->webroot); ?>css/foundation.css" />
    <link rel="stylesheet" href="<?php echo str_replace("//","/", $this->webroot); ?>css/style.css" />
    <script src="<?php echo str_replace("//","/", $this->webroot); ?>js/vendor/modernizr.js"></script>
  </head>
  <body>
  	<div class="page-container">
  		<div class="main-container">
  			<div class="navbar">
  				<a href="#" id="search"><i class="fa fa-bars fa-lg"></i><div id="tags"></div></a>
          <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/logout" id="refresh"><i class="fa fa-sign-out fa-lg"></i></a>
  			</div>
  			<div class="side-container">
  				<h1><a href="<?php echo str_replace("//","/", $this->webroot); ?>admins" class="home"><i class="fa fa-home fa-lg"></i></a></h1>


  				
  					<div class="row">
  						<div class="menu">
  								<h2><i class="fa fa-book fa-fw"></i>賣書<i class="fa fa-angle-down angle-down"></i></h2>
  								<div>
  									<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/add">輸入紀錄</a>
  									<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/receipt">賣家帳單</a>
  								</div>
  								<h2><i class="fa fa-check fa-fw"></i>買書<i class="fa fa-angle-down angle-down"></i></h2>
  								<div>
  									<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/buy">購買書本</a>
  								</div>
  								<h2><i class="fa fa-edit fa-fw"></i>紀錄<i class="fa fa-angle-down angle-down"></i></h2>
  								<div>
  									<a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/allrecord">所有紀錄</a>
                    <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/allseller">賣家資料</a>
  								</div>
                  <?php if ($this->Session->read("authority") == 0) : ?>
                  <h2><i class="fa fa-list fa-fw"></i>書單<i class="fa fa-angle-down angle-down"></i></h2>
                  <div>
                    <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/book">所有書目</a>
                    <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/addbook">新增書目</a>
                    <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/addmanybooks">新增書目 Excel</a>
                    <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/oldbook">舊書重用</a>
                    <a href="<?php echo str_replace("//","/", $this->webroot); ?>admins/addmanyoldbooks">舊書重用 Excel</a>
                  </div>
                  <?php endif ?>
  						</div>
  					</div>
  				
  			</div>
  			<div class="content-header">
  				<div class="row">
  				<h1>
  					代賣舊書CMS<br><small>培正中學學生會</small>
  				</h1>
  				</div>
  			</div>
  			<div>


              <?php echo $this->Session->flash('good'); ?>
              <?php echo $this->Session->flash('bad'); ?>

          </div>
  				<div class="block">
  					<div class="block-title">
  						<h2><?php echo $this->fetch('title'); ?></h2>
  					</div>
  					
		  			<script src="<?php echo str_replace("//","/", $this->webroot); ?>js/vendor/jquery.js"></script>

		  			  <?php echo $this->fetch('content'); ?>
  				</div>
  			</div>
  			
  		</div>
  	</div>
    <script>
      (function(){

        if (localStorage["admin_nav"] != undefined && localStorage["admin_nav"] == "open")
          $(".page-container").addClass("open");
        $("#search").click(function(){
          if ($(".page-container").hasClass("open")) {
            $(".page-container").removeClass("open");
            localStorage["admin_nav"] = "close";
          }
          else {
            $(".page-container").addClass("open");
            localStorage["admin_nav"] = "open";
          }
          return false;
        })

        $(".alert").click(function(){
          var result = confirm("Are you sure?");
          if (result == false) {
            return false;
          }
        })
      })();
    </script>
    
    <script src="<?php echo str_replace("//","/", $this->webroot); ?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>

