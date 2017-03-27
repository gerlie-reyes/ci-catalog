<div id="main-content">
	<div class="container">
		<?php if($this->session->flashdata('saved')): ?>
			<div class="alert alert-success"><?=$this->session->flashdata('saved')?></div>
		<?php endif; ?>
		<?php if(!isset($error)): ?>
		<h2 class="blue"><?=$ad->title?> <!--span class="post-date">Date posted:  <?=date("F d, Y", strtotime($ad->date_posted))?></span--></h2>
			
		<div class="row">
			<div class="col-xs-8">
				<div class="main-box" id="ad-single">

					<div id="ad-info">
						<div class="col-xs-4">
							<p><span>Condition</span> <?=ucwords(str_replace("_", " ", $ad->condition))?></p>
							<p><span>Posted</span> <?=date("F d, Y", strtotime($ad->date_posted))?></p>
						</div>
						<div class="col-xs-4">
							<p><span>Size</span> <?=$ad->size?></p>
							<p><span>Location</span> <?=$ad->location?></p>
						</div>
						<div class="col-xs-4 text-right">
							<h3 class="ad-price">P<?=number_format($ad->price, 2)?></h3><br>
							<small>Selling Price</small>
						</div>
						<div class="clearfix"></div>
					</div>
					
					<div style="margin-right:10px" class="fb-like" data-href="<?=current_url()?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
					<div class="fb-share-button" data-layout="button_count" style="margin-bottom: 15px;"></div>
					
					<?php if($ad->images): ?>
						<div id="carousel-custom" class="carousel slide" data-ride="carousel">

							<!-- Wrapper for slides -->
							<div class='carousel-outer'>
								<div class="carousel-inner" role="listbox">
									<?php 
										$images = json_decode($ad->images);
										$i =0;

										foreach($images as $image): ?>
										<div class="item <?=$ad->primary_photo == $image ? 'active' : ''?>">
											<div class="table-display">
												<div class="cell-display">
													<img src="<?=base_url()?>includes/uploads/<?=$image?>" alt="..." class="img-responsive center-block">
											
											<!-- <div class="carousel-caption">
												...
											</div> -->
												</div>
											</div>
										</div>
									<?php $i++; endforeach; ?>
								</div>

								<!-- Controls -->
								<a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php 
									$images = json_decode($ad->images);
									$i =0;

									foreach($images as $image): ?>
										<li data-target="#carousel-custom" data-slide-to="<?=$i?>" class="<?=$ad->primary_photo == $image ? 'active' : ''?>">
											<div class="table-display">
												<div class="table-cell-display">
													<img src="<?=base_url()?>includes/uploads/<?=$image?>" alt="...">
												</div>
											</div>
										</li>
									<?php $i++; endforeach; ?>
							</ol>
						</div>
					<?php endif; ?>
					<div id="ad-desc">
						<h3 class="blue">Description</h3>
						<p><?=nl2br($ad->description)?></p>
					</div>
					
					<div style="margin-right:10px" class="fb-like" data-href="<?=current_url()?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
					<div class="fb-share-button" data-href="<?=current_url()?>" data-layout="button_count" style="margin: 15px 0px;"></div>
					
					<!-- <div id="ad-images">

						<?php if($ad->images): ?>
							<ul class="bxslider" id="ad-slider">
								<?php  
									$images = json_decode($ad->images);
									$i =0;
									
									foreach($images as $image):
								?>
									<li><img src="<?=base_url()?>includes/uploads/<?=$image?>" alt="<?=$image?>" title="<?=$ad->title?>" class="img-responsive center-block"></li>
								<?php $i++; endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if($ad->images): ?>
							<div id="ad-thumb">
								<?php  
									$images = json_decode($ad->images);
									$i =0;
									foreach($images as $image):
								?>
									<a data-slide-index="<?=$i?>" href="#"><img src="<?=base_url()?>includes/uploads/<?=$image?>" alt="<?=$image?>" title="<?=$ad->title?>"></a>
								<?php $i++; endforeach; ?>
							</div>
						<?php endif; ?>

						<div id="ad-desc">
							<h3 class="blue">Description</h3>
							<p><?=$ad->description?></p>
						</div>
					</div> -->
				</div>
				
			</div>
			<div class="col-xs-4">
				<div class="side-box" id="seller-info">
					<h3>Seller Information</h3>
					<ul>
						<li>
							<div class="media">
								<div class="media-left">
									<a href="#">
										<img class="media-object" src="<?=get_fbpic($ad->fbid, $type = 'square')?>" alt="">
									</a>
								</div>
								<div class="media-body">
								<h4 class="media-heading blue"><a href="<?=site_url('profile/view/'.$ad->uid)?>"><?=$ad->username?></a></h4>
								<p><?=$ad->first_name . ' ' . $ad->last_name?></p>
								</div>
							</div>
						</li>
						<li>
							<?php 
								$contact = $this->session->userdata('is_logged_in') || $this->session->userdata('is_logged_infb') ? $ad->mobile : "Login to view";
							?>
							<p><span>Contact No</span> <?=$contact?></p>
						</li>
						<li>
							<p><span>Location</span> <?=$ad->location?></p>
						</li>
						<li>
							<p><span>Rating</span> <strong>
							<?php 
								$rating = compute_feedbacks($ad->uid);

								if($rating < 0){
								    $rating_style = "color:#b10000;";
								} else {
								    $rating_style = "color:#45c108;";
								}
							?>
							<span style="<?=$rating_style?>; font-family: 'titilliumbold';"><?=$rating?></span>
							</strong></p>
						</li>
						<li>
							<a href="<?=site_url('profile/view/'.$ad->uid)?>" class="btn btn-primary btn-block">View Member Profile</a>
							<?php if($ad->author == @$userdata->uid): ?>
								<a href="<?=site_url('products/edit/'.$ad->unique_id)?>" class="btn btn-primary btn-block">Edit Ad</a>
								<a href="#!" class="btn btn-primary btn-block" id="mark-sold" data-id="<?=$ad->unique_id?>">Mark as Sold</a>
							<?php endif; ?>
							
						</li>
					</ul>
					<br>
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- sneakertrade2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6374175639938072"
     data-ad-slot="7023589547"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- sneakertrade1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6374175639938072"
     data-ad-slot="5546856346"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div class="comment-box">
					<div class="fb-comments" width="710px" data-href="<?=current_url()?>" data-numposts="5" data-colorscheme="light"></div>
				</div>
			</div>
		</div>
		
	<?php else: ?>
		<div class="alert alert-danger"><?=$error?></div>
	<?php endif; ?>
	</div>		
</div>