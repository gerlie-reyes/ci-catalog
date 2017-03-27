<div id="main-content">
    <div class="container">
        <div class="main-title">
            <h2 class="blue"><?=$title?></h2>
        </div>
        <div class="main-box">
            <div class="col-xs-10 col-xs-push-1">
                    <center>
                        <?php if(@$changed): ?>
                            <div class="alert alert-success"><p><?=$changed?></p></div>
                        <?php endif; ?>
                        <?php if(validation_errors()): ?>
                            <div class="alert alert-danger"><p><?=validation_errors()?></p></div>
                        <?php endif; ?>

                        <?php if(!isset($error)): ?>
                            <p>Please enter your new password.</p>
                            <br>
                            <?php //echo "<pre>".print_r($fb_data, 1)."</pre>"; ?>
                            <form class="form-horizontal" action="<?=site_url('change-password/'.$request_input)?>" method="post">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Password</label>
                                        <div class="col-xs-9">
                                            <input type="password" class="form-control" style="width:350px;" name="password" placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Confirm Password</label>
                                        <div class="col-xs-9">
                                            <input type="password" class="form-control" style="width:350px;" name="passconf" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-primary" value="Reset Password">Save Password</button>
                                        </div>
                                    </div>
                                    
                            </form>
                        <?php else: ?>
                            <div class="alert alert-danger"><p><?=$error?></p></div>
                        <?php endif; ?>
                    </center>
            </div>
        </div>
    </div> 
</div>