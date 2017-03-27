<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>SneakerTrade PH - The Premiere Online Sneaker Trading Community</title>
        <meta name="description" content="pinoy,sneaker,trade,shoes,nike,jordan,air,max,community,roshe,run,buy,sell,sneakers">
        <meta name="viewport" content="width=device-width, initial-scale=0.3">
		<link rel="icon" type="image/png" href="<?= base_url() ?>includes/img/favicon.ico">
        <link rel="stylesheet" href="<?= base_url() ?>includes/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>includes/fonts/titillium/titillium.css">
        <link rel="stylesheet" href="<?= base_url() ?>includes/css/main.css">
        <link rel="stylesheet" href="<?= base_url() ?>includes/assets/jquery-ui/jquery-ui.min.css">
        <script src="<?= base_url() ?>includes/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <?php if($page == 'single_ad'): //echo "<pre>".print_r($ad, 1)."</pre>"; exit; ?>
            <meta property="og:title" content="<?=$ad->title?> | SneakerTrade PH" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="<?=base_url()?>products/view/<?=$ad->unique_id?>/<?=title_url($ad->title)?>" />
            <meta property="og:image" content="<?=base_url()?>includes/uploads/<?=$ad->primary_photo?>" />
            <meta property="og:description" content="<?=$ad->description?>" /> 
            <meta property="og:site_name" content="<?=base_url()?>" />
        <?php else: ?>
            <meta property="og:title" content="SneakerTrade PH" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="<?=base_url()?>" />
            <meta property="og:image" content="<?=base_url()?>includes/img/fb-share-img.jpg" />
            <meta property="og:description" content="SneakerTrade PH is the premiere online selling platform for sneakerheads in the Philippines. We are all about giving the best and the most convenient and secure way of buying, selling and trading shoes with the local community. Driven by the enthusiasm of online sneaker groups, SneakerTrade PH aims to be the leading sneaker community where everyone and anyone can buy, sell, trade and talk about shoes." /> 
            <meta property="og:site_name" content="<?=base_url()?>" />
        <?php endif; ?>
        <meta property="fb:admins" content="1491587378" />
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b, o, i, l, e, r) {
                b.GoogleAnalyticsObject = l;
                b[l] || (b[l] =
                        function() {
                            (b[l].q = b[l].q || []).push(arguments)
                        });
                b[l].l = +new Date;
                e = o.createElement(i);
                r = o.getElementsByTagName(i)[0];
                e.src = '//www.google-analytics.com/analytics.js';
                r.parentNode.insertBefore(e, r)
            }(window, document, 'script', 'ga'));
            ga('create', 'UA-63129277-1');
            //UA-63129277-1
            ga('send', 'pageview');
        </script>

        <script type="text/javascript">function get_base_url(){return '<?=base_url()?>';}</script>
        
    </head>
    <body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=603862849741207";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

        <header id="main-header">
            <div id="header-login">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-4">
                            <h1 id="logo"><a href="<?=site_url()?>">Sneaker Trade PH</a></h1>
                        </div>
                        <div class="col-xs-8">
                            <div class="pull-right">
                            <?php if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')): ?>
                                    <?php echo form_open('main/dologin', 'class="form-inline login-form"');?>
                                    <!-- If NOT logged in, do this -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                        Log in to your account
                                      </button>
                                        <a href="<?=site_url('main/signup')?>" class="btn btn-alt">Sign Up now</a>
                                        </div>
                                    </form>
                            <?php else: ?>
                                    <!-- If logged in -->
                                        <div id="profile">
                                            <a class="profile-options" href="<?=site_url('profile')?>"><img class="profile-img" src="http://graph.facebook.com/<?=$this->session->userdata('uid')?>/picture?type=square" alt="">
                                            <span><?=@$logged_in_data->first_name . " " . @$logged_in_data->last_name?></span></a>
                                            <span><a href="<?=site_url('main/logout')?>" class="btn btn-primary">Logout</a></span>
                                        </div>
                            <?php endif; ?>
                        </div>
                        </div>
                        <!--div class="col-sm-9 col-md-8">
                            <div class="pull-right" id="login-form">
                                <?php if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')): ?>
                                    <?php echo form_open('main/dologin', 'class="form-inline login-form"');?>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label class="sr-only">Username</label>
                                                <div class="input-group-addon "><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                                <input type="text" class="form-control" placeholder="Username" name="username">
                                            </div>
                                        </div>				
                                        <div class="form-group">
                                            <label class="sr-only">Password</label>
                                            <input type="password" class="form-control"  placeholder="Password" name="password">
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Log In">
                                        
                                        
                                        
                                        <?php if($this->session->flashdata('login_error')): ?>
                                            <div class="alert alert-danger"><?=$this->session->flashdata('login_error')?></div>
                                        <?php endif; ?>
                                            
                                        <div><a href="<?php echo site_url('fblogin/do_login'); ?>" class="btn btn-fb">
                                                Login with Facebook</a>&nbsp;
                                            <a href="<?=site_url('main/signup')?>" class="btn btn-alt">Sign Up</a>
                                        </div>
                                    </form>
                                    <p class="text-right" id="forgot">Forgot password?<a href="#"> Click here</a></p>	
                                <?php else: ?>
                                    <div>
                                        <img src="http://graph.facebook.com/<?=$this->session->userdata('uid')?>/picture?type=square" alt="">
                                        <span><?=$userdata->first_name . " " . $userdata->last_name?></span>
                                        <span><a href="<?=site_url('main/logout')?>" class="btn btn-primary">Logout</a></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="clearfix"></div>
                        </div-->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            
            <div id="search-box">
	            <div id="search-bar">
	                <div class="container">
	                    <div class="row">
	                        <div class="col-xs-8">
	                            <form action="" id="product-search">
	                                <div class="input-group">
	                                    <input type="text" class="form-control" placeholder="Search sneakers" id="search-text" value="<?=$this->input->get('search')?>">
	                                    <span class="input-group-btn">
	                                        <button class="btn btn-primary" type="button" id="search-product"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	                                    </span>
	                                </div>
	                            </form>
	                        </div>
							<div class="col-xs-2">
								<a class="btn btn-alt btn-block" href="http://sneakertrade.ph/products">View All Ads</a>
							</div>
	                        <div class="col-xs-2">
	                            <a type="button" class="btn btn-alt2 btn-block" href="<?=site_url('post-ad')?>">Post an Ad</a>
	                        </div>
	                        <div class="clearfix"></div>
	                    </div>

	                </div>			
	            </div>
            </div>
        </header>