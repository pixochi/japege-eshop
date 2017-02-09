$(function(){
	$('.errors ul li').hide();

	var first_name_err = false;
	var last_name_err = false;
	var email_err = false;
	var password_err = false;

$('#first_name').on('focusout',function(){
	check_first_name()
});

$('#last_name').on('focusout',function(){
	check_last_name();
});

$('#email').on('focusout',function(){
	check_email();
});

$('#password').on('focusout',function(){
	check_password();
});

$('#confirm_password').on('focusout',function(){
	check_password();
});

function check_first_name(){
first_name_err = false;
	first_name = $.trim($('#first_name').val());

	if(is_blank(first_name)){
		$('#first_name_err').text("First Name cannot be blank.").show();
		first_name_err = true;
	} else {
		$('#first_name_err').hide();
	}
	invalid_input($('#first_name_err'),first_name_err);
}

function check_last_name(){
	last_name_err = false;
	last_name = $.trim($('#last_name').val());

	if(is_blank(last_name)){
		$('#last_name_err').text("Last Name cannot be blank.").show();
		last_name_err = true;
	} else{
		$('#last_name_err').hide();
	}

	invalid_input($('#last_name'),last_name_err);
}

function check_email(){

email_err = false;
	email = $.trim($('#email').val());
	if(!isValidEmailAddress(email)){
		$('#email_err').text("Email address is not valid.").show();
		email_err = true;

	}

	if(is_blank(email)){
		$('#email_err').text("Email cannot be blank.").show();
		email_err = true;
	}
	if(!email_err){
		$('#email_err').hide();
	}
	invalid_input($('#email_err'),email_err);
}

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
	invalid_input($('#password_err'),password_err);
	invalid_input($('#confirm_err'),password_err);
}

function is_blank(input){

return (input.length == 0) ? true : false;
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};

function password_match(){
	
	password = $.trim($('#password').val());
	confirm_password = $.trim($('#confirm_password').val());
	if(password != confirm_password){
		$('#password_err').text('Passwords do not match.').show();
		password_err = true;
	} else password_err = false;
}

function invalid_input(error_element, has_error){

	if(has_error){
		$(error_element).parent().removeClass('has-success');
		$(error_element).parent().addClass('has-error');
		$(error_element).siblings('.glyphicon').removeClass('glyphicon-ok');
		$(error_element).siblings('.glyphicon').addClass('glyphicon-remove');
	} else {
		$(error_element).parent().removeClass('has-error');
		$(error_element).parent().addClass('has-success');
		$(error_element).siblings('.glyphicon').removeClass('glyphicon-remove');
		$(error_element).siblings('.glyphicon').addClass('glyphicon-ok');
	}

}

$('#registration').submit(function(){

	check_first_name();
	check_last_name();
	check_email();
	check_password();

	if(first_name_err ||  last_name_err || email_err || password_err){
		return false;
	}
	return true;
});

});