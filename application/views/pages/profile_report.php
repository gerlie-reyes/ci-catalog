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

                    <?php if($this->session->flashdata('report_saved')): ?>
                        <div class="alert alert-success">Your message is sent. We will review your message and will take an action on this. Thank you.</div>
                    <?php endif; ?>
                    
                    <?php if(isset($err)): ?>
                        <div class="alert alert-danger"><?=$err?></div>
                    <?php else: ?>
                        <form class="form-horizontal" action="<?=site_url('profile/report/'.$uid)?>" method="post">
                            <div class="form-group">
                                <label class="col-xs-2 control-label">Reason</label>
                                <div class="col-xs-4">
                                    <?php 
                                        $options = array(
                                                'Scam' => 'Scam',
                                                'Fake Items' => 'Fake Items',
    											'Fake Account' => 'Fake Account',
    											'Misleading Ads' => 'Misleading Ads',
    											'No Show' => 'No Show',
    											'Others' => 'Others'
                                                );
                                        echo form_dropdown('reason', $options, $this->input->post('reason'), 'class="form-control"');
                                    ?>
                                </div>
                                <!--div class="col-xs-6">
                                    <p class="help-block">Scam, Fake items, Fake account, Misleading ads, No show, others</p>
                                </div-->
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 control-label">Message</label>
                                <div class="col-xs-10">
                                    <textarea class="form-control" rows="10" name="message"><?=set_value('message')?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-offset-2 col-xs-10">
                                    <button type="submit" class="btn btn-primary pull-right">Report this user</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>		
</div>