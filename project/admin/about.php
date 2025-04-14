<?php 
	include'header.php';
	if ( $_SESSION["userrole"] != "superadmin")
	{
		header("Location:../index.php");
	}
	$sql = "SELECT `BusinessBackground`, `Name`, `CompanyProfile`, `Contact No`, `fb`, `linkledn`, `gplus`, `twitter`, `Email` FROM `about` WHERE id = 1";
	$result = getSingleRow($sql);
?>
<!-- banner -->
<script>
var countAppend = 0;
	$(document).ready(function(e) {

             $('#aboutli').addClass("active");

		$('#editName').click(function(e) {
			if (countAppend==0){
          	 	appendInput("Name", "");
			}
			$('button').click(function(e) {
				//alert(($('#BBSEC').text()));
				$.ajax({
					type: "POST",
					url: "update.php",
					data: { updName: 'updName', name: encodeURIComponent($('#Name1').val())},                   
					success: function (response) {
						var result = $.parseJSON(response);
					},
				});
				disappendInput("Name");
			});
        });
		
		$('#editBusinessSec').click(function(e) {
			//alert(countAppend);
			if (countAppend==0){
          	 	appendInput("BBSec", "");
			}
			$('button').click(function(e) {
				//alert(bb);
				$.ajax({
					type: "POST",
					url: "update.php",
					data: {BusinessBackground:  encodeURIComponent($('#BBSec1').val()), CompanyProfile:  encodeURIComponent($('#CPSec').text()), ContactNo:  encodeURIComponent($('#cn').text()), fb:  encodeURIComponent($('#fb').text()), linkledn:  encodeURIComponent($('#linkledn').text()), gplus:  encodeURIComponent($('#gplus').text()), twitter:  encodeURIComponent($('#twitter').text()), email: encodeURIComponent($('#email').text()), updName: ''} ,                   
					success: function (response) {
						var result = $.parseJSON(response);
					},
				});
				disappendInput("BBSec");
			});
        });
		
		$('#editCpSec').click(function(e) {
			if (countAppend==0){
				appendInput("CPSec", "");
			}
			$('button').click(function(e) {
				var bb = $('#BBSec').text();
				var cp = $('#CPSec').text();
				var cn = ''; var fblink=''; var linkledn=''; var gplus=''; var twitter='';
				//alert(bb);
				$.ajax({
					type: "POST",
					url: "update.php",
					data: { BusinessBackground:  encodeURIComponent($('#BBSec').text()), CompanyProfile:  encodeURIComponent($('#CPSec1').val()), ContactNo:  encodeURIComponent($('#cn').text()), fb:  encodeURIComponent($('#fb').text()), linkledn:  encodeURIComponent($('#linkledn').text()), gplus:  encodeURIComponent($('#gplus').text()), twitter:  encodeURIComponent($('#twitter').text()), email: encodeURIComponent($('#email').text()), updName: ''},                   
					success: function (response) {
						var result = $.parseJSON(response);
					},
				});
				
				disappendInput("CPSec");
			});
        });
		
		$('#editContact').click(function(e) {
			if (countAppend==0){
				appendInput("cn", "editcontact");
				appendInput("twitter", "editcontact");
				appendInput("fb", "editcontact");
				appendInput("gplus", "editcontact");
				appendInput("linkledn","editcontactbttn");
				appendInput("email","editcontact");
			}
			$('button').click(function(e) {
				$.ajax({
					type: "POST",
					url: "update.php",
					data: { BusinessBackground:  encodeURIComponent($('#BBSec').text()), CompanyProfile:  encodeURIComponent($('#CPSec').text()), ContactNo:  encodeURIComponent($('#cn1').val()), fb:  encodeURIComponent($('#fb1').val()), linkledn:  encodeURIComponent($('#linkledn1').val()), gplus:  encodeURIComponent($('#gplus1').val()), twitter:  encodeURIComponent($('#twitter1').val()), email: encodeURIComponent($('#email1').val()), name: encodeURIComponent($('#Name').text())},                   
					success: function (response) {
						var result = $.parseJSON(response);
					},
				});
				disappendInput("cn");
				disappendInput("fb");
				disappendInput("twitter");
				disappendInput("gplus");
				disappendInput("linkledn");
				disappendInput("email");
			});
        });
		
		function appendInput(id, editcontact){
		  	$('#'+id).css("border-width","5px");
			$('#'+id).css("background-color", "#FFF");
			$('#'+id).css("color","#000");
			$('#'+id).focus();
			if(editcontact == ""){
				$('<div style="margin-bottom:2%;"><input id="'+id+'1" type="textarea" class="form-control" style="margin-bottom:0px;"/><button>save</button></div>').insertAfter($('#'+id));
				$('input').val($('#'+id).text());
			}
			else if (editcontact == "editcontact"){
				$('<div style="margin-bottom:2%;"><input id="'+id+'1" type="textarea" class="form-control" style="margin-bottom:0px; margin-left: 2%; width:95%"/></div>').insertAfter($('#'+id));
				$('#'+id+'1').val($('#'+id).text());
			}
			else if (editcontact == "editcontactbttn"){
				$('<div style="margin-bottom:2%;"><input id="'+id+'1" type="textarea" class="form-control" style="margin-bottom:0px; margin-left: 2%; width:95%"/><button style="margin-top: 3%; margin-left: 2%;">save</button></div>').insertAfter($('#'+id));
				$('#'+id+'1').val($('#'+id).text());
			}
			$('#'+id).css("display","none");
			countAppend = countAppend + 1;
		}
		
		function disappendInput(id){
				$('#CPSec').css("border-width","0px");
				$('#'+id).css("background-color", "transparent");
				$('#'+id).css("color","#000");
				$('#'+id).css("display","block");
				$('#'+id).css("margin-bottom","30px");
				$('#'+id).text($('#'+id+'1').val());
				$('button').css("display","none");
				$('#'+id+'1').css("display", "none");
				countAppend = countAppend - 1;
		}
		
    });
</script>
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / About Us</span>
    <h2>About Us</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row">
  <div class="col-lg-8  col-lg-offset-2">
  		<img src="../images/Pencil-icon.png" id="editName" style="width:20px; float:left; margin-bottom:5px; margin-right:5px;">
      <h3>Name of Company</h3>
      <p id="Name"><?php echo $result["Name"]; ?></p>
      <img src="images/about.jpg" class="img-responsive thumbnail"  alt="realestate">
      <img src="../images/Pencil-icon.png" id="editBusinessSec"style="width:20px; float:left; margin-bottom:5px; margin-right:5px;">
      <h3>Business Background</h3>
      <p id="BBSec" ><?php echo $result["BusinessBackground"]; ?></p>
      
      <img src="../images/Pencil-icon.png" id="editCpSec"style="width:20px; float:left; margin-bottom:5px; margin-right:5px;">
      <h3>Company Profile</h3>
      <p id="CPSec"><?php echo $result["CompanyProfile"]; ?></p>
  </div>
  
  <div class="col-lg-8  col-lg-offset-2">
  	  <img src="../images/Pencil-icon.png" id="editContact"style="width:20px; float:left; margin-bottom:5px; margin-right:5px;">
      <h3>Edit Contact Detail from here</h3>
      <table style="width: 55%;">
          <tr>
          	<td><h5>Contact Number</h5></td>
            <td colspan="3"><p class="contact" id="cn"><?php if ($result["Contact No"] != 0)echo $result["Contact No"]; ?></p></td>			
          </tr>
           <tr>
          	<td><h5>Email</h5></td>
            <td colspan="3"><p class="contact" id="email"><?php echo $result["Email"]; ?></p></td>			
          </tr>
          <tr>
             <td><h5>Twitter</h5></td>
              <td colspan="3"><p class="contact" id="twitter"><?php echo $result["twitter"]; ?></p></td>
          </tr>
          <tr>
              <td><h5>Facebook</h5></td>
              <td colspan="3"><p class="contact" id="fb"><?php echo $result["fb"]; ?></p></td>
          </tr>
          <tr>
              <td><h5>GooglePlus</h5></td>
              <td colspan="3"><p class="contact"id="gplus"><?php echo $result["gplus"]; ?></p></td>
          </tr>
          <tr>
              <td><h5>Linkledn</h5></td>
              <td colspan="3"><p class="contact" id="linkledn"><?php echo $result["linkledn"]; ?></p></td>
          </tr>
      </table>
  </div>
 
</div>
</div>
</div>

<?php include'footer.php';?>