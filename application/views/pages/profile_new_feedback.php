<div id="main-content">
    <div class="container">
        <?php $this->load->view('templates/profile_info', array('userdata' => @$userdata)); ?>

        <div id="profile-box">
            <?php $this->load->view('templates/profile_nav', array('userdata' => @$userdata)); ?>

            <div id="profile-content">
                <div id="new-feedback">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger"><?=validation_errors()?></div>
                    <?php endif; ?>

                    <?php if(isset($err)): ?>
                        <div class="alert alert-danger"><?=$err?></div>
                    <?php else: ?>
                        <?php if($existing): ?>
                            <div class="alert alert-danger">You can only rate a member once. <a href="#edit-feedback" id="edit-feedback">Click here</a> to edit your rating for this member.</div>
                        <?php endif; ?>
                        <form class="form-horizontal <?=$existing ? 'hide' : '' ?>" method="post" action="<?=site_url('profile/add-feedback/'.$uid)?>" id="form-feedback">
                            <div class="form-group">
                                <label class="col-xs-2 control-label">Your Rating</label>
                                <div class="col-xs-4">
                                    <?php
                                        $type = set_value('feedback_type') != '' ? set_value('feedback_type') : @$existing[0]['feedback_type'];
                                        $fbtypes = array(
                                                        '1' => 'Positive',
                                                        '0' => 'Negative'
                                                        );
                                        echo form_dropdown('feedback_type', $fbtypes, $type, 'class="form-control"');
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 control-label">Message</label>
                                <div class="col-xs-10">
                                    <?php $comment = set_value('comment') != '' ? set_value('comment') : @$existing[0]['comment']; ?>
                                    <textarea class="form-control" rows="10" name="comment"><?=$comment?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-offset-2 col-xs-10">
                                    <button type="submit" class="btn btn-primary pull-right">Rate Member</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>		
</div>