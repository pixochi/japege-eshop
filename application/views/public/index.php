<section class="sidebar_navigation">
	<nav class="sidebar_categories nav">
		<a href="#carousel_special_offers" class="active"><?php $this->loading->pimg('mainpage/sale.svg'); ?></a>
		<?php foreach ($popular_products as $category => $products) { ?>
		<a href="#<?php echo $category; ?>" />
			<?php $this->loading->pimg('mainpage/'.$category.'.svg',["title" => ucfirst($category)]); ?>
		</a>
		<?php } ?>
	</nav>
</section>
<main class="content">
	<div id="carousel_special_offers">
		<div class="my_carousel">
			<!-- Carousel Containter -->
			<div class="carousel_container">
				<div id="carousel"></div>
				<?php $this->loading->pimg('mainpage/carousel/arrow_left.png',['class'=>'nextItem']); ?>
				<?php $this->loading->pimg('mainpage/carousel/arrow_right.png',['class'=>'prevItem']); ?>
			</div>
			<!-- Caption Container -->
			<div class="caption_container">
				<div id="captions"></div>
			</div>
			<!-- Carousel Data -->
			<div class="carousel_data">
				<!-- begin items -->
				<!-- Item -->
				<?php foreach ($discount_products as $product) {?>
				<div class="carousel_item">
					<div class="image">
						  <?php $this->loading->pimg('../uploads/products/'.$product->id."/".$product->image); ?>
					</div>
					<div class="caption">
					<a href="<?= base_url('product/'.$product->id); ?>">
						<h2><?= $product->name; ?> 
						<?php echo " <span class='high_discount'>-".$product->discount_percentage."%</span>"; ?>
						</h2>
						<p class="high_discount_description"><?=  $product->description;  ?></p>
					</a>
					</div>
				</div>
				<?php } ?>
				</div>
				<!-- end items -->
			</div>
		</div>
	</div>
<?php foreach($popular_products as $category => $products){ ?>
        <section id="<?= $category; ?>" class="category_title">
            <h2><?php echo ucfirst($category); ?></h2>
            <div class="category_row">
            <?php foreach($products as $product){ ?>
                <a href="<?= base_url('product/'.$product->id); ?>">
                    <article>
                        <figure>
                             <?php $this->loading->pimg('../uploads/products/'.$product->id."/".$product->image); ?>
                            <figcaption><?= $product->name; ?></figcaption>
                            <?php if($this->product->with_discount($product)){echo " <span id='discount'>-".$product->discount_percentage."%</span>";} ?>
                        </figure>
                        <button class="to_cart">Buy now
                        	<input type="hidden" name="id" value="<?php echo $product->id; ?>">
                        </button>
                    </article>
                </a>
              <?php } ?>
            </div>
        </section>
         <?php } ?>
		</main>