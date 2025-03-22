<?php
session_start();
include('includes/dbconnection.php'); // Your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($message)) {
        header("Location: contact.php?error=All fields are required.");
        exit();
    } else {
        $sql = "INSERT INTO contact_form (first_name, last_name, email, phone, message) 
                VALUES (:first_name, :last_name, :email, :phone, :message)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':first_name', $first_name);
        $query->bindParam(':last_name', $last_name);
        $query->bindParam(':email', $email);
        $query->bindParam(':phone', $phone);
        $query->bindParam(':message', $message);

        if ($query->execute()) {
            header("Location: contact.php?success=Your message has been sent successfully!");
            exit();
        } else {
            header("Location: contact.php?error=Something went wrong. Please try again.");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Employee Task Management System||Contact Page</title>
	
	

	<!--//tags -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

	<link href="css/font-awesome.css" rel="stylesheet" >
	<!-- //for bootstrap working -->
	<link href="//fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,900,900italic,700italic'
	    rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="css/style1.css">
    <!-- Fontawesome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
	

<style>
  .contact-form1 {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 40px;
  margin-top: 50px;
  flex-wrap: wrap;
}

.contact-form1 form {
  flex: 1;
  min-width: 300px;
  margin-top: 100px;
}

.contact-form1 .form-row {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
}

.contact-form1 .form-row input {
  flex: 1;
}

.contact-form1 input[type="text"],
.contact-form1 input[type="email"],
.contact-form1 textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
  box-sizing: border-box;
}

.contact-form1 .send-btn {
  padding: 10px 20px;
  background-color: #3085d6;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.contact-form1 > div:last-child {
  flex: 1;
  min-width: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.contact-form1 img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

@media (max-width: 768px) {
  .contact-form1 {
    flex-direction: column;
  }
  .contact-form1 .form-row {
    flex-direction: column;
  }
}

</style>
<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- SweetAlert2 CSS & JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const successMsg = urlParams.get('success');
        const errorMsg = urlParams.get('error');

        if (successMsg) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMsg,
                confirmButtonColor: '#3085d6'
            });
        } else if (errorMsg) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMsg,
                confirmButtonColor: '#d33'
            });
        }
    });
</script>


</head>

<body>
	<!-- header -->

			<?php include_once('includes/header.php');?>
			<div class="inner_page_agile">
		<h3>Contact</h3>
		<p>Add Some Short Description</p>

	</div>
	<div class="services-breadcrumb_w3layouts">
		<div class="inner_breadcrumb">

			<ul class="short_w3ls"_w3ls>
				<li><a href="index.php">Home</a><span>|</span></li>
				<li>Contact</li>
			</ul>
		</div>
	</div>
    <section class = "contact-section">
     

     <div class = "contact-body">
       <div class = "contact-info">
         <div>
           <span><i class = "fas fa-mobile-alt"></i></span>
           <span>Phone No.</span>
           <span class = "text">1-2392-23928-2</span>
         </div>
         <div>
           <span><i class = "fas fa-envelope-open"></i></span>
           <span>E-mail</span>
           <span class = "text">mail@company.com</span>
         </div>
         <div>
           <span><i class = "fas fa-map-marker-alt"></i></span>
           <span>Address</span>
           <span class = "text">423 silver business hub trede motavaracha utran  surat gujrat </span>
         </div>
         <div>
           <span><i class = "fas fa-clock"></i></span>
           <span>Opening Hours</span>
           <span class = "text">Monday - Friday (9:00 AM to 5:00 PM)</span>
         </div>
       </div>

       <div class = "contact-form1" >
       
       <form method="POST">
    <div class="form-row">
        <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
    </div>
    <div class="form-row">
        <input type="email" class="form-control" name="email" placeholder="E-mail" required>
        <input type="text" class="form-control" name="phone" placeholder="Phone" required>
    </div>
    <textarea rows="5" name="message" placeholder="Message" class="form-control" required></textarea>
    <input type="submit" class="send-btn" value="Send Message">
</form>

         <div>
           <img src = "images/contact-png.png" alt = "">
         </div>
       </div>
     </div>

     <div class = "map">
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3718.9706478514654!2d72.8698906!3d21.233012500000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f7adffdd9f9%3A0x8e5947b84d098fd9!2sSilver%20Trade%20Center!5e0!3m2!1sen!2sin!4v1734356364957!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
     </div>


   
   </section>

   
	
	<!-- banner -->

	<!--//banner -->
	
	<!-- /inner_content -->
	<div class="inner_content_info_agileits">
		<div class="container">
			<div class="tittle_head_w3ls">
			</div>
			<div class="inner_sec_grids_info_w3ls">
				<div class="col-md-4 agile_info_mail_img_info">
					<div class="address-grid">
						<h4>Contact <span>Info</span></h4>
						<?php
$sql="SELECT * from tblpage where PageType='contactus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
						<div class="mail-agileits-w3layouts">
							<i class="fa fa-volume-control-phone" aria-hidden="true"></i>
							<div class="contact-right">
								<p>Telephone </p><span>+<?php  echo htmlentities($row->MobileNumber);?></span>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="mail-agileits-w3layouts">
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
							<div class="contact-right">
								<p>Mail </p><a href="mailto:info@example.com"><?php  echo htmlentities($row->Email);?></a>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="mail-agileits-w3layouts">
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<div class="contact-right">
								<p>Location</p><span><?php  echo htmlentities($row->PageDescription);?>.</span>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="agileits_w3layouts_nav_right contact">
							<div class="social two">
								<ul>
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-rss"></i></a></li>
								</ul>
							</div>
						</div><?php $cnt=$cnt+1;}} ?>
					</div>
				</div>
				<div class="col-md-8 agile_info_mail_img">

				</div>
				<div class="clearfix"> </div>
				


			</div>

		</div>
	</div>
	<!-- //mid-services -->
	

	<!-- //inner_content -->
	<?php include_once('includes/footer.php');?>

	<a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>