<?php
//temp
$uid = @$uid;
$uri2 =$this->uri->segment(2);
?>
<ul class="nav nav-pills" id="profile-nav">
    <li role="presentation" class='<?=$uri2 == "member-ads" || $uri2 == "view" ? "active" : ""?>'>
        <a href='<?=site_url("profile/view/$uid")?>'>Member ads</a>
    </li>
    <li role="presentation" class='<?=$uri2 == "feedbacks" ? "active" : ""?>'>
        <a href='<?=site_url("profile/feedbacks/$uid")?>'>Member ratings</a>
    </li>
    <?php if($uid && $uid != @$logged_in_data->uid): ?>
        <li role="presentation" class='<?=$uri2 == "add-feedback" ? "active" : ""?>'>
            <a href='<?=site_url("profile/add-feedback/$uid")?>'>Rate this member</a>
        </li>
        <li role="presentation" class='<?=$uri2 == "report" ? "active" : ""?>'>
            <a href='<?=site_url("profile/report/$uid")?>'>Report this member</a>
        </li>
    <?php endif; ?>
</ul>