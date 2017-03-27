<div id="main-content">
    <div class="container">

        <?php if($this->session->flashdata('feedback_saved')): ?>
            <div class="alert alert-success">
                Your feedback has been saved.
                <span class="close">x</span>
            </div>
        <?php endif; ?>
        
        <?php $this->load->view('templates/profile_info', array('userdata' => @$userdata)); ?>

        <div id="profile-box">
            <?php $this->load->view('templates/profile_nav', array('userdata' => @$userdata)); ?>
            <div id="profile-content">
                <div id="item-sort">
                    <form class="form-inline" id="form-sorting" action="<?=base_url()?>profile/view/<?=$uid?>">
                        <label for="">Sort by</label>
                        <?php
                            $filters = array(
                                            'price' => 'Price',
                                            'title' => 'Name',
                                            'condition' => 'Condition'
                                            );
                            echo form_dropdown('sort_by', $filters, $this->input->get('sort_by'), 'class="form-control" id="member-sorting"');
                        ?> 
                    </form> 
                </div>
                <div id="items">
                    <div class="item-box">
                        <?php if($products): ?>
                        <ul>
                            <?php foreach ($products as $product): 
                                $url = base_url(). 'products/view/' . $product['unique_id'] . '/' . title_url($product['title']);
                            ?>
                                <li>
                                    <a href="<?=$url?>">
										<div class="table-display">
											<div class="cell-display">
												<img src="<?=base_url()?>includes/uploads/<?=$product['primary_photo']?>" alt="" class="img-responsive product-img">
											</div>
										</div>
									</a>
                                    <h3><a href="<?=$url?>"><?=$product['title']?></a></h3>
                                    <span class="item-price red">P <?=number_format($product['price'], 2)?></span>
                                    <span class="item-info"><?=ucwords(str_replace("_", " ", $product['condition']))?> | Size <?=$product['size']?></span>
                                    <span class="item-address"><?=$product['location']?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                            <div style="padding: 30px;">This user doesn't have any ads yet.</div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($pagination)): ?>
        <nav>
            <?=$pagination?>
            <div class="clearfix"></div>
        </nav>
        <?php endif; ?>
    </div>		
</div>