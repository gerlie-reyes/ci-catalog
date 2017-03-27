<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="modal-close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Account Login</h4>
      </div>
      <div class="modal-body">
        <div id="login-form">
                <?php if(!$this->session->userdata('is_logged_in') && !$this->session->userdata('is_logged_infb')): ?>
                    <?php echo form_open('main/dologin', 'class="form-inline login-form"');?>
                <div>
                        <a href="<?php echo site_url('fblogin/do_login'); ?>" class="btn btn-fb">
                        Login with Facebook</a>
                </div>
                    <center><p>or</p></center>
                        <?php if($this->session->flashdata('login_error')): ?>
                            <div class="alert alert-danger"><?=$this->session->flashdata('login_error')?></div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                                <label class="sr-only">Username</label>
                                <input type="text" class="form-control" placeholder="Username" name="username">
                        </div>				
                        <div class="form-group">
                            <label class="sr-only">Password</label>
                            <input type="password" class="form-control"  placeholder="Password" name="password">
                        </div>
                        
                        <p class="pull-left" id="forgot">Forgot password?<a href="<?=site_url('forgot-password')?>"> Click here</a></p>
                        <input type="submit" class="pull-right btn btn-primary" value="Log In">
                        <div class="clearfix"></div>
                    </form>
                    	
                <?php else: ?>
                    <div>
                        <img src="http://graph.facebook.com/<?=$this->session->userdata('uid')?>/picture?type=square" alt="">
                        <span><?=$userdata->first_name . " " . $userdata->last_name?></span>
                        <span><a href="<?=site_url('main/logout')?>" class="btn btn-primary">Logout</a></span>
                    </div>
                <?php endif; ?>
            </div>
      </div>
    </div>
  </div>
</div>

<footer id="main-footer">
        <div class="container">
                <div class="row">
                        <div class="col-sm-4">
                                <img src="<?=base_url()?>includes/img/sneakertrade-logo-footer.png" alt="">&nbsp;&nbsp;&nbsp;
								<div style="top: 6px; left: 10px;" class="fb-like" data-href="https://www.facebook.com/sneakertradeph" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                        </div>
                        <div class="col-sm-8">
                                <ul class="pull-right" id="footer-nav">
                                        <li><a href="<?=site_url('about')?>">About Sneakertrade.ph</a></li>
                                        <li><a href="<?=site_url('disclaimers')?>">Disclaimers & Privacy</a></li>
                                        <li><a href="<?=site_url('terms-and-conditions')?>">Terms Of Use</a></li>
                                        <!--li><a href="#">Contact Us</a></li-->
										 <li><a href="#"><a href="http://facebook.com/sneakertradeph" target="_blank"><img src="<?=base_url()?>includes/img/icon-fb-2.png" style="margin-right: 3px;">
                        Follow us on Facebook</a></a></li>
                                </ul>
                                <div class="clearfix"></div>
                                <p class="text-right">Copyright 2014 All Rights Reserved</p>
                        </div>
                        <div class="clearfix"></div>
                </div>
        </div>
    </footer>


    <script src="<?=base_url()?>includes/js/vendor/jquery-1.11.1.min.js"></script>
    <script src="<?=base_url()?>includes/assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>includes/js/vendor/bootstrap.min.js"></script>
    <script src="<?=base_url()?>includes/js/vendor/jquery.bxslider.min.js"></script>
    <script src="<?=base_url()?>includes/js/library.js"></script>
    <script src="<?=base_url()?>includes/js/main.js"></script>
    <script type="text/javascript">
        <?php if($this->session->flashdata('login_error')): ?>
            $('#loginModal').modal('show');
        <?php endif; ?>
    </script>

    <script type = "text/javascript" src = "//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
    <script src="<?=base_url()?>includes/js/upload.js"></script>
</body>
</html>