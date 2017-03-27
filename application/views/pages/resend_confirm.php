<div id="main-content">
    <div class="container">
        <div class="main-title">
            <h2 class="blue"><?=$title?></h2>
        </div>
        <div class="main-box">
            <div class="col-xs-10 col-xs-push-1">
                    <center>
                        <?php if(@$resent_msg): ?>
                            <div class="alert alert-success"><p><?=$resent_msg?></p></div>
                        <?php endif; ?>
                        <?php if(@$resent_error): ?>
                            <div class="alert alert-danger"><p><?=@$resent_error?></p></div>
                        <?php endif; ?>
                        <p>We have sent you an email to confirm your registration. If you did not receive the email in your inbox, please check your spam folder.</p>
                        <p>Not receiving the confirmation email? You can request another one below.</p>
                        <br>
                       <?php //echo "<pre>".print_r($fb_data, 1)."</pre>"; ?>
                        <form class="form-inline" action="<?=site_url('main/resend_confirmation')?>" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" style="width:350px;" name="email" placeholder="Enter email address">
                                    <input type="hidden" name="fbid" value="<?=@$fb_data['id']?>">
                                    <button type="submit" class="btn btn-primary" name="resend" value="Resend">Resend confirmation email</button>
                                </div>
                        </form>
                    </center>
            </div>
        </div>
    </div> 
</div>