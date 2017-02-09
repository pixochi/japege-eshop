<?php  $this->login->is_admin_logged(); ?>
         
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

     if(preg_match("/products/",$this->uri->uri_string())){ $this->loading->acss(['products']);} 

     if(preg_match("/add_product/",$this->uri->uri_string())){ $this->loading->acss(['add_product']);} 

     if(preg_match("/product_details/",$this->uri->uri_string())){ $this->loading->acss(['product_details']);} 

     if(preg_match("/orders/",$this->uri->uri_string())){ $this->loading->acss(['orders']);} 

     if(preg_match("/customers/",$this->uri->uri_string())){ $this->loading->acss(['customers']);} 

     if(preg_match("/order_details/",$this->uri->uri_string())){ $this->loading->acss(['order_details']);} 

     if(preg_match("/customer_details/",$this->uri->uri_string())){ $this->loading->acss(['customer_details']);} 

     if(preg_match("/admins/",$this->uri->uri_string())){ $this->loading->acss(['admins']);} 

     if(preg_match("/admin_details/",$this->uri->uri_string())){ $this->loading->acss(['admin_details']);} 

     if(preg_match("/add_admin/",$this->uri->uri_string())){ $this->loading->acss(['admin_details']);} 

     ?>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Bungee+Inline|Russo+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>

<body>
    <div class="flexbox">
        <header class="main_header">
            <h1>JaPeGe</h1>
            <span class="mobile_title">J</span>
            <nav>
                <a href="<?= base_url('product_control/products'); ?>"
                   class="<?php if(preg_match("/product_control/",$this->uri->uri_string())){echo "selected_nav";} ?>">Products
                </a>
                <a href="<?= base_url('order_control/orders'); ?>"
                   class="<?php if(preg_match("/order_control/",$this->uri->uri_string())){echo "selected_nav";} ?>">
                   Orders
                </a>
                <a href="<?= base_url('customer_control/customers'); ?>" 
                   class="<?php if(preg_match("/customer_control/",$this->uri->uri_string())){echo "selected_nav";} ?>">Customers
                </a>
                <a href="<?= base_url('admin/admins'); ?>" 
                   class="<?php if(preg_match("/admin/",$this->uri->uri_string())){echo "selected_nav";} ?>">
                    Admins
                </a>
                <a href="<?= base_url('admin/logout'); ?>">Logout</a>
            </nav>
        </header>
       