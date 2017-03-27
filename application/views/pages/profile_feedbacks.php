<div id="main-content">
    <div class="container">
        <?php $this->load->view('templates/profile_info', array('userdata' => @$userdata)); ?>

        <div id="profile-box">
            <?php $this->load->view('templates/profile_nav', array('userdata' => @$userdata)); ?>
            <div id="profile-content">
                <div id="item-sort">
                    <form class="form-inline" id="feedback-filter-form" action="<?=base_url()?>profile/feedbacks/<?=$uid?>">
                        <label for="">View</label>
                        <?php
                            $filters = array(
                                            '' => 'All',
                                            '1' => 'Positive',
                                            '0' => 'Negative'
                                            );
                            $default = $this->input->get('feedback_type') ? $this->input->get('feedback_type') : '';
                            echo form_dropdown('feedback_type', $filters, $default, 'class="form-control" id="feedback-type"');
                        ?> 
                        
                    </form>
                </div>
                <div id="profile-feedbacks">
                   
                        <?php if(count($feedbacks) > 0): ?>
							<ul>
                            <?php foreach ($feedbacks as $feedback) : ?>
							
                                <li>
                                    <div class="row">
                                        <div class="col-xs-2 user-feedback">
                                            <img src="http://graph.facebook.com/<?=$feedback['fbid_from']?>/picture?type=square" alt=""><br>
                                            <span><?=$feedback['username']?></span><br>
                                            <small><?=$feedback['first_name'] . ' ' . $feedback['last_name']?></small>
                                        </div>
                                        <div class="col-xs-10">
                                           
                                                <?php if($feedback['feedback_type'] == 1) {?>
													<p class="feedback-pos pull-left">
														<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Positive
													</p>
                                                <?php } else { ?>
                                                   <p class="feedback-neg pull-left">
														<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Negative
													</p>
                                                <?php } ?>
                                            
                                            <small class="pull-left">Posted: <?=date("M d, Y", strtotime($feedback['date_posted']))?></small>
                                            <div class="clearfix"></div>
                                            <p><?=$feedback['comment']?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </li>

                        <?php endforeach;?>
							</ul>
						<?php  else: ?>
                            <div style="border-top: 1px solid #eee; padding: 30px;">This user doesn't have any ratings yet.</div>
                        <?php endif; ?>
                        
                    

                </div>
            </div>
        </div>
        <nav>
            <!-- <ul class="pagination pull-right">
                <li class="prev"><a href="#">Prev</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li class="next"><a href="#">Next</a></li>
            </ul> -->
            <?=@$pagination?>
            <div class="clearfix"></div>
        </nav>

    </div>		
</div>