<div id="main-content" class="products">
		<div class="container">
			<div class="row">
				<div class="col-xs-3">
					<div id="filter">
						<form action="" role="form">
							<div class="form-group">
							    <label>Condition</label>
								<?php
									$conditions = array('' => 'Select Condition', 'brand_new' => 'Brand new', 'used' => 'Used');
									
									echo form_dropdown('condition', $conditions, $this->input->get('condition'), 'class="form-control" id="condition"');
								?>
							</div>
							<div class="form-inline">
							    <label>Size</label><br>
								<?php
									$sizes = array('' => 'Select');
									for($i = 5; $i <= 14; $i++){
										$sizes[$i] = $i;
										$sizes[$i.".5"] = $i.".5";
									}
									echo form_dropdown('size_from', $sizes, $this->input->get('size_from'), 'class="form-control" id="size_from"');
								?>	
								<span>to</span>
								<?php
									$sizes = array('' => 'Select');
									for($i = 5; $i <= 14; $i++){
										$sizes[$i] = $i;
										$sizes[$i.".5"] = $i.".5";
									}
									echo form_dropdown('size_to', $sizes, $this->input->get('size_to'), 'class="form-control" id="size_to"');
								?>						
							</div>							
							<!-- <div class="form-group">
							    <label>Location</label>
								<select name="" class="form-control">
									<option value="">Select</option>
								</select>
							</div>	 -->	
							<div class="form-inline">				
								<div class="form-group">
								    <label>Price</label><br>
								    <span>From</span>
									<?php
										$prices = array('' => 'Select Price', 
														'1000' => 'P1,000',
														'2000' => 'P2,000',
														'4000' => 'P4,000',
														'6000' => 'P6,000',
														'8000' => 'P8,000',
														'10000' => 'P10,000',
														'15000' => 'P15,000',
														'20000' => 'P20,000'
													);
										
										echo form_dropdown('price_from', $prices, $this->input->get('price_from'), 'class="form-control" id="price_from"');
									?>
									<br>
								    <span>To</span>
									<?php
										$prices = array('' => 'Select Price', 
														'1000' => 'P1,000',
														'2000' => 'P2,000',
														'4000' => 'P4,000',
														'6000' => 'P6,000',
														'8000' => 'P8,000',
														'10000' => 'P10,000',
														'15000' => 'P15,000',
														'20000' => 'P20,000'
													);
										
										echo form_dropdown('price_to', $prices, $this->input->get('price_to'), 'class="form-control" id="price_to"');
									?>
								</div>
							</div>
						</form>
					</div>
					
				</div>
				<div class="col-xs-9">
					<div id="items">
						<div id="item-box" class="">
						<div class="item-box" id="ad-page">
							<ul><?php //echo "<pre>".print_r($products, 1)."</pre>"; ?>
								<?php if($products): 
										foreach ($products as $product): 
										$url = site_url('products/view/'.$product['unique_id'].'/'.title_url($product['title']));
										//$url = site_url('products/view/'.$product['unique_id']);
								?>
											<li>
												<a href="<?=$url?>">
													<div class="table-display">
														<div class="cell-display">
															<img src="<?=base_url()?>includes/uploads/thumbnails/<?=$product['primary_photo']?>" alt="" class="img-responsive product-img">
														</div>
													</div>
												</a>
												<h3><a href="<?=$url?>"><?=$product['title']?></a></h3>
												<p class="item-desc"><?=character_limiter($product['description'], 270)?></p>
												<span class="item-price red">P <?=number_format($product['price'], 2)?></span>
												<span class="item-info"><?=ucwords($product['condition'])?> | Size <?=$product['size']?></span>
												<span class="item-address"><?=$product['location']?></span>
											</li>
										<?php endforeach; ?>
									<?php else: ?>
										<p style="padding:30px;">No results found. Please try other keywords for your search.</p>
									<?php endif; ?>
							</ul>
							<div class="clearfix"></div>
						</div>
					</div>					
				</div>
				<div class="clearfix"></div>
				<nav>
					<?=@$pagination?>
				  <div class="clearfix"></div>
				</nav>
			</div>
		</div>
		
	</div>

</div>