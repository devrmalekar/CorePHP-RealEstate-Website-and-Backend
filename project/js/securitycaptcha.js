function checkCaptcha(value){
				//alert($('#security_code').val());
				 $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent(value), function: "CheckSecurityCode"},
					success: function (response) {
						var result = $.parseJSON(response);
						//alert(response.IsNameExist);
						$('#username').css('float','left');
					    if(result.IsNameExist == "0"){
							$('#captchaErrImg').css('display','block');
							$('#captchaErrImg').attr('src','images/right.png');
							$('#captchaErrMsg').css('display','block');
							$('#captchaErrMsg').attr('value', 'OK You are not Robot');
							$('#captchaErrMsg').css('width', '35%');
						} else {
							$('#captchaErrImg').css('display','block');
							$('#captchaErrImg').css('float','left');
							$('#captchaErrImg').attr('src','images/wrong.png');
							$('#captchaErrMsg').css('display','block');
							$('#captchaErrMsg').attr('value', 'Hey you if you are robot?.');
							$('#captchaErrMsg').css('width', '40%');
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});	
}
			