<div id="main-content">
    <div class="container">
        <div class="main-title">
            <h2 class="blue"><?=$title?></h2>
        </div>
        <div class="main-box">
            <div class="col-xs-10 col-xs-push-1">
                    <center>
                        <?php if(@$sent): ?>
                            <div class="alert alert-success"><p><?=$sent?></p></div>
                        <?php endif; ?>
                        <?php if(@$error): ?>
                            <div class="alert alert-danger"><p><?=@$error?></p></div>
                        <?php endif; ?>
                        <p>Forgot your password? Please enter you email address below to reset your password.</p>
                        <br>
                       <?php //echo "<pre>".print_r($fb_data, 1)."</pre>"; ?>
                        <form class="form-inline" action="<?=site_url('forgot-password')?>" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" style="width:350px;" name="email" placeholder="Enter email address">
                                    <input type="hidden" name="fbid" value="<?=@$fb_data['id']?>">
                                    <button type="submit" class="btn btn-primary" value="Reset Password">Reset Password</button>
                                </div>
                        </form>
                    </center>
            </div>
        </div>
    </div> 
</div>