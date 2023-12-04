<?php
session_start();

require "includes/db_connect.inc.php";

//FIRST TIME OPENING ADMIN CREATION
$sql = "Select * from admin";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)<1)
{
	date_default_timezone_set('Asia/Dhaka');
	$pass = password_hash("admin", PASSWORD_DEFAULT);
	$today = date('Y-m-d');

	$insert_Query = "INSERT INTO `admin`(`id`, `username`, `name`, `password`, `phone`, `email`, `hiredate`, `address`) VALUES ( NULL , 'admin', 'admin','".$pass."','00000000000','admin@admin.com','".$today."','admin' )";
	mysqli_query($conn,$insert_Query);
}

//------------------


/*if(isset($_SESSION['doneQuery']))
{

	$currTime = time();

	if($currTime > $_SESSION['startTime']+300)
	{
		unset($_SESSION['startTime']);
		unset($_SESSION['doneQuery']);

	}

}
*/
$fullName="";
$email="";
$query="";

$iptNameErr="";
$iptEmailErr="";
$iptQueryErr="";



if($_SERVER["REQUEST_METHOD"]=="POST")
{

	$flag =0 ;
	$fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$query = mysqli_real_escape_string($conn, $_POST['query']);



	if(!preg_match('/^[a-z , " ",".",","]*$/i', $fullName) || $fullName=="")
	{
		$iptNameErr = "Enter a Valid Name";
		$flag =1;
	}
	else
	{
		$iptNameErr="";
	}

	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$iptEmailErr="Enter A Valid Email Address";
		$flag = 1;
	}
	else
	{
		$iptEmailErr="";
	}

	if(strlen($query)<20)
	{

		$iptQueryErr = "Your Query Seems To Be Invalid (Minimum Character Length is 20)";
		$flag = 1;
	}
	else
	{
		$iptQueryErr ="";
	}

	if($flag==0)
	{

		date_default_timezone_set('Asia/Dhaka');
		$dateTime = date('Y-m-d h:i:s');

		$sql = "INSERT INTO `query` (`id`, `Name`, `Query`, `Email`, `dateTime`,`status`) VALUES (NULL, '".$fullName."','".$query."', '".$email."', '".$dateTime."', '0' );";

		
		mysqli_query($conn, $sql);


		setcookie('doneQuery','Yes',time()+300);

		$fullName="";
		$email="";
		$query="";

		$iptNameErr="";
		$iptEmailErr="";
		$iptQueryErr="";

		header("Refresh:0");

		
	}

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="shortcut icon" href="" type=""> 
	<title>CMS</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- ---fonts S--- -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
<!-- ---fonts E--- -->

<link rel="stylesheet" type="text/css" href="StyleSheet/topNav.css">
<link rel="stylesheet" type="text/css" href="StyleSheet/footer.css">
<link rel="stylesheet" type="text/css" href="StyleSheet/home.css">
</head>


<body>

	<?php 


		if(isset($_SESSION["userid"]) && isset($_SESSION["username"]))
		{
			include 'includes/homeTopNavIfLoggedIn.php'; 
		}
		else
		{
			include 'includes/homeTopNav.php';
		}

	?>

	<section id="lander">
		<div class="cont_quote">
			<p class="main_quote">Let's Make Health Care <br> Better Together</p>

			<p class="sub_info"> <br><br>
			Hospital management system: A unique cloud based hospital management system for both patients and hospital stuffs (Doctors, Management). The primary target of this design is to make hospital experience better than we currently have. Hospital is a place where no one willingly wants to visit but there are times when we need to. The old system of hospitals are not very user friendly. The first big stem is waiting in the queue for long hours. There are lots of other problems that makes your hospital experience bad. Our main focus is to make peoples life easier in the hour of need. We are working to design such a system that will reduce a lot of paperwork and save peoples time. 

To overcome those limitation we are trying to build a social networking like site for hospitals that will help everyone working in the hospital and their patients.  </p>
		</div>
	</section>


	<section id="about">
        <div class="cont_about">
            <h1 class="about_head">About Us</h1>
            <p class="para"> <br><br>

           Various management program for management are present out there but there any not too many which provides the patients any functionality. The hospital system has been automated but the benefit is not for all. In such a situation I have figured out that there should be something for the patients. Some simple features for checking appointment, asking for appointment, prescription and test reports can reduce the hassle up to 70-80%. Because those are the sector where we face a lot of trouble and can find a way out. So this will allow us something that we were waiting for so long. The world is moving to internet so this is the right time to think about this. I have checked some hospital management system on internet and some local programs that the hospital stuffs are using near me. They are also very well designed and have rich features too but nothing for the patients to be happy about is there. If we compare the benefits and the satisfaction form every point of view then we cannot conclude things beneficial for all. If a system does not provide help for every user group then it cannot be perfect system. We came out a long way with maximizing benefit for all. Still there are a lot of things that can be added but at this point this is the most we can expect. </p>
        </div>
        <img class="about_pic" src="skins/us.png">
    </section>

	<section id="query">
		
		<?php 

			if(isset($_SESSION['utype']))
			{
				echo "<h1 class="."\"query_head\"".">Thank You For Being With Us!";
			}
			else if(isset($_COOKIE['doneQuery']))
			{

				echo "<h1 class="."\"query_head\"".">Query Submitted Sucessfully</h1>";
				echo "<p align ="."\"center\"".">You Can Post Another One after 5 minutes <br> You Will Get Your Answer Via Email </p>";

			}
			else
			{
				include 'query.php';
			}


		?>



	</section>


	<div id="footer">

		
	</div>
	


</body>
</html>
