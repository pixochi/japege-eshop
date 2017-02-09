<?php if($this->login->admin_logged) redirect(base_url('product_control/products'));?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Japege Admin</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Table css -->
    <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <!-- Page css -->
     <?php 
     if(preg_match("/admin/",$this->uri->uri_string())){ $this->loading->acss(['admin_details','adnanstyle']);}  
     ?>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Bungee+Inline|Russo+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<div id="login_content">
	<div class="login_form col-sm-4 col-sm-offset-4">
		<h1>Admin Login</h1>
		<form action="/admin/login" method="post">
			<input class="col-xs-12" type="text" name="name" placeholder="Username" />
			<input class="col-xs-12" type="password" name="password" placeholder="Password" />
			<input class="col-xs-12 login_btn" type="submit" name="submit" value="LOGIN" />
		</form>
		<?php echo "<p id = 'login_message'>".$this->session->login_message."</p>";?>
	</div>
</div>





   
