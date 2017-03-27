<div id="main-content">
    <div id="top-fold">
        <div class="container">
            <div class="row">
                <div class="col-xs-8">
                    <div id="home-slider" class="carousel slide" data-ride="carousel">
                        <!--ol class="carousel-indicators">
                            <li data-target="#home-slider" data-slide-to="0" class="active"></li>
                            <li data-target="#home-slider" data-slide-to="1"></li>
                            <li data-target="#home-slider" data-slide-to="2"></li>
                        </ol-->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="<?= base_url() ?>includes/img/slide-welcome.jpg" alt="Welcome to SneakerTrade PH">
                            </div>
                            <!--div class="item">
                                <img src="<?= base_url() ?>includes/img/ad1.jpg" alt="">
                            </div>
                            <div class="item">
                                <img src="<?= base_url() ?>includes/img/ad1.jpg" alt="">
                            </div-->
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div id="small-ad">
                        <!--p class="text-center">Advertisement</p-->
						
						<a href="http://facebook.com/sneakertradeph" target="_blank"><img class="img-responsive" src="<?= base_url() ?>includes/img/fb-ad.jpg"></a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div id="quick-link">
        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <a href="products/q/?search=roshe+run">
                        <img src="<?= base_url() ?>includes/img/quick1.jpg" alt="" class="img-responsive">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="products/q/?search=air+max">
                        <img src="<?= base_url() ?>includes/img/quick2.jpg" alt="" class="img-responsive">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="products/q/?search=flyknit">
                        <img src="<?= base_url() ?>includes/img/quick4.jpg" alt="" class="img-responsive">
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!--div id="ad1" class="ad">
        <div class="container">
            <p class="text-center">Advertisement</p>
        </div>
    </div-->

    <?php $this->load->view('pages/latest_ads.php', array('ads' => $latest_ads));?>
    
    <div id="ad2" class="ad">
        <div class="container">
            <!--p class="text-center">Advertisement</p-->
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- sneakertrade1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6374175639938072"
     data-ad-slot="5546856346"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </div>
    </div>
	
	<center>
		<div class="container">
			<a class="btn btn-primary" href="<?=site_url('products')?>">View All Ads</a>
		</div>
	</center>

</div>