<?php 
//list($feedbacks, $positive) = explode(',', $ufeedbacks);
//echo "<pre>" . print_r($feedbacks, 1) . "</pre>"; exit;
$rating = $ufeedbacks;

if($rating < 0){
    $rating_style = "color:#b10000;";
} else {
    $rating_style = "color:#45c108;";
}
$contact = $this->session->userdata('is_logged_in') || $this->session->userdata('is_logged_infb') ? $userdata->mobile : "Login to view";
?>
<div id="profile-info">
    <div class="row">
        <div class="col-sm-2">
            <img src="<?=get_fbpic(@$userdata->fbid, 'large')?>" alt="" class="img-responsive">
        </div>
        <div class="col-sm-10">
            <h2 class="blue"><?=@$userdata->username?></h2>
            <p><?=@$userdata->first_name . ' ' . @$userdata->last_name?></p>
            <div class="" id="info-group">
                <p class="pull-left">Contact No. <span><?=@$contact?></span></p>
                <p class="pull-left">Location <span><?=@$userdata->location?></span></p>
                <p class="pull-left">Registered <span><?=date("F d, Y", strtotime(@$userdata->date_reg))?></span></p>
                <p class="pull-left" id="feedback-info">Rating <span id="feedback-percentage" style="<?=$rating_style?>"><?=$rating?></span></p>
                <!-- <p class="pull-left" id="feedback-info" >Feedback <span id="feedback-percentage"><?=$positive?>% Positive<br><small><?=$feedbacks?> Feedbacks</small></span></p> -->
            </div>
            <div class="clearfix"></div>
            <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-success"><?=$this->session->flashdata('message')?></div>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
        <?php if(($this->session->userdata('is_logged_in') || $this->session->userdata('is_logged_infb'))
                    && $logged_in_data->uid == $uid): ?>
            <a href="<?=site_url('profile/edit')?>" id="profile-btn">Update Profile</a>
        <?php endif; ?>
    </div>
</div>