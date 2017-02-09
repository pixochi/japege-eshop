    <!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>JAPEGE</title>
     <?=link_tag('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css','stylesheet'); ?>
    <?php $this->loading->pcss(['header','footer','typography']); ?>
     <?php if( base_url() == base_url(uri_string()) ) $this->loading->pcss(['mainpage_content','carousel','mainpage_query']); ?>
    
     <?php if(preg_match("/search/",$this->uri->uri_string())){ 
        $this->loading->pcss(['search_content','search_query']);
echo link_tag('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.5.1/css/bootstrap-slider.min.css','stylesheet');
        } ?>

        <?php if(preg_match("/cart/",$this->uri->uri_string())){ 
        $this->loading->pcss(['cart_content','cart_query']);
        } ?>

         <?php if(preg_match("/checkout/",$this->uri->uri_string())){ 
        $this->loading->pcss(['checkout']);
        } ?>

         <?php if(preg_match("/product/",$this->uri->uri_string())){ 
        $this->loading->pcss(['product_content','product_query']);
        } ?>

        <?php if(preg_match("/my_profile/",$this->uri->uri_string())){
        $this->loading->pcss(['my_profile']);
        } ?>

        <?php if(preg_match("/edit_profile/",$this->uri->uri_string())){ 
        $this->loading->pcss(['edit_profile']);
        } ?>

        <?php if(preg_match("/user/",$this->uri->uri_string())){
        $this->loading->pcss(['my_profile']);
        } ?>

         <?php if(preg_match("/messages/",$this->uri->uri_string())){
        $this->loading->pcss(['messages']);
        } ?>


        <?php if(preg_match("/login/",$this->uri->uri_string())){ 
        $this->loading->pcss(['login_content','login_query']);
        } ?>

        <?php if(preg_match("/register/",$this->uri->uri_string())){ 
        $this->loading->pcss(['register_content','register_query']);
        } ?>

         <?php if(preg_match("/faq/",$this->uri->uri_string())){ 
        $this->loading->pcss(['faq']);
        } ?>

        <?php if(preg_match("/about/",$this->uri->uri_string())){ 
        $this->loading->pcss(['about']);
        } ?>

         <?php if(preg_match("/contact/",$this->uri->uri_string())){ 
        $this->loading->pcss(['contact']);
        } ?>

        <?php $this->loading->pcss(['error_404']);?>

         <?= link_tag('https://fonts.googleapis.com/css?family=Bungee+Inline|Fira+Sans|Russo+One','stylesheet'); ?>
    <?= link_tag('https://fonts.googleapis.com/css?family=Montserrat','stylesheet'); ?>
<?= link_tag('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css','stylesheet'); ?>

 <?php $this->loading->pjs(['../jquery-1.7.min']); ?>


</head>

<body data-spy="scroll" data-target=".nav" data-offset="60">
    <header>
        <nav id="header_navigation">
            <section class="main_navigation">
                <a id="logo_heading" href="<?= base_url(); ?>"><h1 id="japege">JaPeGe</h1><h2 id="j">J</h2></a>
                <form>
                    <input type="text" id="search_nav" list="search_results" class="form-control search_bar" placeholder="Search by a category, activity or hobby" aria-label="...">

                    <select class="form-control category_select" id="category_nav">
                        <option value="all">All Categories</option>
                    <?php foreach ($this->product->categories as $category) { ?>
                        <option value="<?= $category; ?>"><?= ucfirst($category); ?></option>
                        <?php } ?>
                    </select>
                </form>
                <?php if($this->session->customer_id){
                    $this->load->view('public/partials/logged_in_header');
                    } else {
                        $this->load->view('public/partials/logged_out_header');
                        } ?>
                
                <a href="<?= base_url('cart'); ?>" class="cart_button"> <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"><span class="badge" id="cart_badge"><?php echo get_cookie('quantity_cart') == null ? 0 : get_cookie('quantity_cart'); ?></span>
                    </span>
                </a>
            </section>
                 <div id="search_results">
</div>
        </nav>
    </header>
