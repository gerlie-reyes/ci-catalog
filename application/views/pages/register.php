<div id="main-content">
    <div class="container">
        <div class="main-title">
            <h2 class="blue">Sign Up</h2>
            <span>Step 2 of 2</span>
        </div>
        <div class="main-box" id="step2">
            <p>Almost there! Complete your information below to complete your registration.</p>
            <div id="sign-form">
                <?php echo form_open_multipart('main/register', 'class="reg-form"');?>
                <?php 
                    $fname = set_value('first_name') ? set_value('first_name') : @$fb_data['first_name'];
                    $lname = set_value('last_name') ? set_value('last_name') : @$fb_data['last_name'];
                    $mobile = set_value('mobile') ? set_value('mobile') : @$fb_data['mobile'];
                    $email = set_value('email') ? set_value('email') : @$fb_data['email'];
                    $location = set_value('location') ? set_value('location') : @$fb_data['location']['name'];
                    $username = set_value('username') ? set_value('username') : ''; ?> 

                    <input type="hidden" value="<?=$fb_data['id']?>" name="fbid" />
                    <div class="row">
                        <div class="col-xs-7">
                            <?php if(validation_errors()): ?>
                                <div class="alert alert-danger">
                                  <button class="close" data-dismiss="alert"></button>
                                  <span><?php echo validation_errors(); ?></span>
                                </div>
                            <?php endif; ?> 
                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p class="blue">Login Credentials</p>
                                    <div class="form-group <?=form_error('username') ? 'alert alert-danger' : '' ?>">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" value="<?=$username?>" >
                                    </div>
                                    <div class="form-group <?=form_error('password') ? 'alert alert-danger' : '' ?>">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" min="8">
                                    </div>
                                    <div class="form-group">
                                        <label>Re-type Password</label>
                                        <input type="password" class="form-control" name="passconf" min="8">
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p class="blue">Personal Information</p>
                                    <div class="form-group <?=form_error('first_name') ? 'alert alert-danger' : '' ?>">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" value="<?=@$fname?>" name="first_name">
                                    </div>
                                    <div class="form-group <?=form_error('last_name') ? 'alert alert-danger' : '' ?>">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" value="<?=@$lname?>" name="last_name">
                                    </div>
                                    <div class="form-group <?=form_error('mobile') ? 'alert alert-danger' : '' ?>">
                                        <label>Mobile No.</label>
                                        <input type="text" class="form-control number-only" maxlength="11" value="<?=@$mobile?>" name="mobile">
                                    </div>
                                    <div class="form-group <?=form_error('email') ? 'alert alert-danger' : '' ?>">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" value="<?=@$email?>" name="email" >
                                    </div>
                                    <div class="form-group <?=form_error('location') ? 'alert alert-danger' : '' ?>">
                                        <!-- <label>Province</label>
                                        <?php //echo form_dropdown('province', $provinces, set_value('provice'), 'id="province-select"'); ?> -->
                                        <label>City</label>
                                        <!-- <select name="city_location" id="city-select">
                                            <option value="0">Select City</option>
                                        </select> -->
                                        <input id="city-select" class="form-control" type="text" name="location" />
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="agreed"> I agree to the <a href="terms-and-conditions" target="_blank">Terms of Use</a> of Sneaker Trade PH
                                </label>
                            </div>
                            <input type="submit" class="btn btn-alt btn-lg" value="Register" name="submit_reg">
                        </div>
                        <div class="col-xs-4 col-xs-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <p class="blue">Profile Photo</p>
                                    <div id="profile-photo">
                                        <img src="http://graph.facebook.com/<?=$fb_data['id']?>/picture?width=160&height=160" alt="">
                                    </div>
                                    <!-- <a href="#">Change Photo</a> -->
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>

        </div>

    </div>		
</div>