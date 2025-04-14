<?php 
	include'header.php';
	/*include'includes/db_connect.php';
	include'includes/functions.php';*/
	//error_reporting(0);
	
	if(isset($_SESSION['userrole'])){
		if($_SESSION['userrole'] == "user")
			{
				////var_dump("thisi s "); exit;
				header("location:index.php");
			} else if ($_SESSION['userrole'] == "superadmin") {
				header("location:admin/");
			}
	}
	
	
	$error = "";
	if (isset($_POST['Submit']) && !empty($_POST['Submit'])){
		$uname = mysql_real_escape_string($_POST['uname']);
		$pwd = mysql_real_escape_string($_POST['password']);
		
		$sql="SELECT * from userprofile where `UserName`='".$uname."' and (`Password`='".md5($pwd)."' OR `temp_password` = '".$pwd."')";
        $result = getSingleRow($sql);
      
        if($result)
        {
            $_SESSION['uname']=$uname;
			$_SESSION['userrole']=$result['User Role'];
			
			if($_SESSION['userrole'] == "user")
			{
				////var_dump("thisi s "); exit;
				header("location:index.php");
			} else if ($_SESSION['userrole'] == "superadmin") {
				header("location:admin/");
			}
        }
        else
        {
            $error="Invalid Credintial. Please Try Again.";
        }
	}
	
	/*if (isset($_POST['SubmitEmail']) && !empty($_POST['SubmitEmail'])){
		$email = mysqli_real_escape_string($_POST['SubmitEmail']);
		
		$sql="SELECT * from userprofile where `Email`='$email'";
        $result = getSingleRow($sql);
        
        if($result)
        {
				header("location:forgotpassword.php");
		
        }
        else
        {
            $error="Email address does not exist.";
        }
	}*/


?>
<script>
	/*$(document).ready(function(e) {

        $('#login').addClass("active");
        $('#forgot').click(function(e) {
            $('#login').css("display", "none");
			$('#forgotpassword').css("display", "block");
			$('#forgot').css("display", "none");
        });
		
		$('#submitemail').click(function(e) {
             if ($('#email').val() != ""){
				 $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent($("#email").val()), tablename: "`userprofile`", fieldname: "Email", function: "CheckPropAvailablity"},                   
					success: function (response) {
						var result = $.parseJSON(response);
						//alert(response.IsNameExist);
						$('#email').css('float','left');
					    if(result.IsNameExist == "0"){
							$('<label>Email does not exist.</label>').insertafter($('.col-lg-6 col-sm-6 '));
						} else {
							window.location.replace('forgotpassword.php');
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});		
			}
        });
    });*/
</script>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Login Us</span>
    <h2>Log In</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row contact">
  <div class="col-lg-6 col-sm-6 ">
  	<?php if ($error != "") echo '<label>'.$error.'</label>'; ?>
	<form action="#" method="post" id="login">
		<fieldset>
            <input type="text" name="uname" class="form-control" placeholder="User Name">
            <input type="password" name="password" class="form-control" placeholder="Password Address">
      		<button type="submit" value="Submit" class="btn btn-success" name="Submit">Log In</button>
         </fieldset>
	</form>
    <br/>
    <a href="forgotpwd.php">Forgot Password</a>
                
        </div>
 <!-- <div class="col-lg-6 col-sm-6 ">
  <div class="well"><iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Pulchowk,+Patan,+Central+Region,+Nepal&amp;aq=0&amp;oq=pulch&amp;sll=37.0625,-95.677068&amp;sspn=39.371738,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Pulchowk,+Patan+Dhoka,+Patan,+Bagmati,+Central+Region,+Nepal&amp;ll=27.678236,85.316853&amp;spn=0.001347,0.002642&amp;t=m&amp;z=14&amp;output=embed"></iframe></div>
  </div> -->
</div>
</div>
</div>

<?php include'footer.php';?>