

<div class="header" id="home">
      <div class="content white agile-info">
         <nav class="navbar navbar-default" role="navigation">
            <div class="container">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
                  <a class="navbar-brand" href="index.php">
                     <h1><span class="fa fa-signal" aria-hidden="true"></span> Employee HUB  <label>Management System</label></h1>
                  </a>
               </div>
               <!--/.navbar-header-->
               <?php $uri = $_SERVER['REQUEST_URI'];?>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <nav class="link-effect-2" id="link-effect-2">
                     <ul class="nav navbar-nav">
                        <li class=" <?php if($uri == '/etms/index.php'){ echo "active"; } ?>"><a href="index.php" class="effect-3">Home</a></li>
                        <li class=" <?php if($uri == '/etms/about.php'){ echo "active"; } ?>"><a href="about.php" class="effect-3">About</a></li>
                        <li class=" <?php if($uri == 'contact.php'){ echo "active"; } ?>"><a href="contact.php" class="effect-3">Contact</a></li>
                        <li class=" <?php if($uri == '../faq-management-system/'){ echo "active"; } ?>"><a href="faq-management-system/" class="effect-3">FAQ</a></li>

                        <li ><a href="admin/login.php" class="effect-3">Admin</a></li>
                        <li><a href="employee/login.php" class="effect-3">Employee</a></li>
                     </ul>
                  </nav>
               </div>
               <!--/.navbar-collapse-->
               <!--/.navbar-->
            </div>
         </nav>
      </div>
   </div>

   <!-- header section ends -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
