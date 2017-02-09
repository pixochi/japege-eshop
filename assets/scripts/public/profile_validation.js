$(function(){
	var password_err;
	var zip_err;
function check_password(){
	 password_err = false;
	password = $.trim($('#password').val());

	password_match();
	if(password.length < 8){
		$('#password_err').text("Password should be at least 8 characters").show();
		password_err = true;
	} 

	if(!password_err){
		$('#password_err').hide();
	}
}

function password_match(){
	
	password = $.trim($('#password').val());
	confirm_password = $.trim($('#confirm_password').val());
	if(password != confirm_password){
		$('#password_err').text('Passwords do not match.').show();
		password_err = true;
	} else password_err = false;
}

function check_zip(){
	zip_err = false;
	zip_code = $.trim($('#zip').val());

	if(isNaN(zip_code) || Math.floor(zip_code) != zip_code){
		$('#zip_err').text("ZIP code is not valid.").show();
		zip_err = true;
	} 

	if(!zip_err){
		$('#zip_err').hide();
	}
}

$('#profile_form').submit(function(){
	check_zip();
	if($("#password").val().length > 0){
			check_password();
	}
	if(zip_err || password_err){
		return false;
	}
	return true;

});
});
