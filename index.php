<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html>

<head>
	<title>Employee  Management System||Home Page</title>
	<!--/tags -->
	
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--//tags -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- //for bootstrap working -->
	<link href="//fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,900,900italic,700italic'
	    rel='stylesheet' type='text/css'>
</head>

<body>
	<!-- header -->
	<?php include_once('includes/header.php');?>
	<!-- banner -->
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1" class=""></li>
			<li data-target="#myCarousel" data-slide-to="2" class=""></li>
			<li data-target="#myCarousel" data-slide-to="3" class=""></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<div class="container">
					<div class="carousel-caption">
						<h3>Improving workplace <span>Productivity.</span></h3>
						<p>Hire. Train. Retain.</p>
					
					</div>
				</div>
			</div>
			<div class="item item2">
				<div class="container">
					<div class="carousel-caption">
						<h3>Inspiring leadership <span>innovation.</span></h3>
						<p>Hire. Train. Retain.</p>
						<div class="agileits-button top_ban_agile">
							<a class="btn btn-primary btn-lg" href="single.html">Read More »</a>
						</div>
					</div>
				</div>
			</div>
			<div class="item item3">
				<div class="container">
					<div class="carousel-caption">
						<h3>Improving workplace <span>Productivity.</span></h3>
						<p>Hire. Train. Retain.</p>
				
					</div>
				</div>
			</div>
			<div class="item item4">
				<div class="container">
					<div class="carousel-caption">

						<h3>Inspiring leadership <span>innovation.</span></h3>
						<p>Hire. Train. Retain.</p>
				
					</div>
				</div>
			</div>
		</div>
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="fa fa-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="fa fa-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		<!-- The Modal -->
	</div>
	<!--//banner -->

	<!--/search_form -->
	
	<!--//search_form -->
	<div class="banner-bottom">
		<div class="container">
			<div class="tittle_head_w3ls">
				<h3 class="tittle">About Us</h3>
			</div>
			<div class="inner_sec_grids_info_w3ls">
				<?php
$sql="SELECT * from tblpage where PageType='aboutus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
				<div class="col-md-6 banner_bottom_left">
					<h4>Employment opportunities for <span>Professionals</span></h4>
					<p><?php  echo htmlentities($row->PageDescription);?></p><?php $cnt=$cnt+1;}} ?>
			
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-6 banner_bottom_right">
					<div class="agileits_w3layouts_banner_bottom_grid">
						<img src="images/ab.png" alt=" " class="img-responsive" />
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>

		</div>
	</div>
	<!-- //banner-bottom -->
	<div class="team_work_agile">
		<h4>Whether we play a large or small role, by working together we achieve our objectives.</h4>
	</div>

	<?php include_once('includes/footer.php');?>

	<a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>