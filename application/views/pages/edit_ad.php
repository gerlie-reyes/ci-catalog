<div id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-8">
				<div class="main-title">
					<h2 class="blue">Edit an ad</h2>
				</div>
				<div class="main-box" id="post-product">


  					<?php if(validation_errors()): ?>
  						<div class="alert alert-danger">
  							<span class="close">x</span>
  							<?=validation_errors()?>
  						</div>
  					<?php endif; ?>

  					<?php if($this->session->flashdata('saved')): ?>
  						<div class="alert alert-success">
  							<span class="close">x</span>
  							<?=$this->session->flashdata('saved')?>
  						</div>
  					<?php endif; ?>

  					<?php if(isset($error)): ?>
						<div class="alert alert-danger">
  							<span class="close">x</span>
  							<?=$error?>
  						</div>
  					<?php  
  						else: 
							$images = json_decode($ad_info->images);
							$primary_photo = set_value('primary_photo') ? set_value('primary_photo') : $ad_info->primary_photo;
							$title = set_value('title') ? set_value('title') : $ad_info->title;
							$condition = set_value('condition') ? set_value('condition') : $ad_info->condition;
							$size = set_value('size') ? set_value('size') : $ad_info->size;
							$price = set_value('price') ? set_value('price') : $ad_info->price;
							$description = set_value('description') ? set_value('description') : $ad_info->description;
					?>

					<!-- AJAX Response will be outputted on this DIV container -->
				    <div class="">
				        <!-- Generate the form using form helper function: form_open_multipart(); -->
				        <?php echo form_open_multipart('main/do_upload', array('class' => 'upload-image-form form-horizontal'));?>
				        <div class="form-group">
							<label for="" class="col-xs-3 control-label">Upload Photos</label>

							<div class="col-xs-9">
					            <input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" id="img-select"/><br />
					            <p class="help-block">Maximum of 5 photos per ad. Each photo should not exceed 4MB in size.</p>
					            <!-- <input type="submit" name = "submit" value="Upload" class = "btn btn-primary" /> -->
					            <div class="clearfix"></div>
					            <div class = "upload-image-messages"></div>
					         </div>
					    </div>
				        </form>
				    </div>

					<form class="form-horizontal" action="<?=site_url('products/edit/'.$ad_info->unique_id)?>" method="post" id="post-ad-form">
						<div class="form-group">
							<div class="col-xs-12">
								<div id="ad-upload">
									<ul>
										<?php if(count($images)):?>
						            		<?php foreach($images as $image): ?>
						            			<li>
						            				<img width="91" height="70" class="img-responsive" src="<?=base_url()?>includes/uploads/<?=$image?>">
						            				<input type="hidden" value="<?=$image?>" name="images[]" />
						            				<div class="radio">
						            					<label>
						            						<input type="radio" value="<?=$image?>" name="primary_photo" <?=$primary_photo == $image ? 'checked=true' : '' ?>> Primary Photo</label>
						            					</label>
						            				</div>
						            			</li>
						            		<?php endforeach; ?>
						            	<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="form-group <?=form_error('title') ? 'error' : ''?>">
							<label class="col-xs-3 control-label">Title</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" id="" placeholder="" name="title" value="<?=$title?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Condition</label>
							<div class="col-xs-9">
								<?php
									$conditions = array('brand_new' => 'Brand New', 'used' => 'Used');
									echo form_dropdown('condition', $conditions, $condition, 'class="form-control"');
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Size</label>
							<div class="col-xs-9">
								<?php
									$sizes = array();
									for($i = 5; $i <= 14; $i++){
										$sizes[$i] = $i;
										$sizes[$i.".5"] = $i.".5";
									}
									echo form_dropdown('size', $sizes, $size, 'class="form-control"');
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Selling Price</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" id="" placeholder="" name="price" value="<?=$price?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Description</label>
							<div class="col-xs-9">
								<textarea style="resize: vertical; max-height: 500px;" class="form-control" rows="8" name="description"><?=$description?></textarea>
							</div>
						</div>
						<div id="submit-ad">
							<div class="form-group">
								<div class="col-xs-8">
									
								</div>
								<div class="col-xs-4">
									<button type="submit" class="btn btn-primary btn-block" id="add-form-submit">Save Changes</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php endif; ?>
			</div>
			<div class="col-xs-4">
				<!-- ads here -->
			</div>
			<div class="clearfix"></div>
		</div>

	</div>		
</div>
