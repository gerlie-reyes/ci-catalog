<div id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-8">
				<div class="main-title">
					<h2 class="blue">Post an ad</h2>
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

					<!-- AJAX Response will be outputted on this DIV container -->
				    <div class="">
				        <!-- Generate the form using form helper function: form_open_multipart(); -->
				        <?php echo form_open_multipart('main/do_upload', array('class' => 'upload-image-form form-horizontal'));?>
				        <div class="form-group">
							<label for="" class="col-xs-3 control-label">Upload Photos</label>

							<div class="col-xs-8">
					            <input type="file" multiple = "multiple" accept = "image/*" class = "form-control" name="uploadfile[]" size="20" id="img-select"/><br />
					            <p class="help-block">Maximum of 5 photos per ad. Each photo should not exceed 4MB in size.</p>
					            <!-- <input type="submit" name = "submit" value="Upload" class = "btn btn-primary" /> -->
					            <div class="clearfix"></div>
					            <div class = "upload-image-messages"></div>
					         </div>
					    </div>
				        </form>
				    </div>





				  
					<form class="form-horizontal" action="<?=site_url('post-ad')?>" method="post" id="post-ad-form">
						<div class="form-group">
							<div class="col-xs-12">
								<div id="ad-upload">
									<ul>
										<?php if(isset($images) && $images): ?>
						            		<?php foreach($images as $image): ?>
						            			<li>
                                                                                        <span class="remove-photo glyphicon glyphicon-remove" aria-hidden="true"></span>
						            				<img width="91" height="70" class="img-responsive" src="<?=base_url()?>includes/uploads/<?=$image?>">
						            				<input type="hidden" value="<?=$image?>" name="images[]" />
						            				<div class="radio">
						            					<label>
						            						<input type="radio" value="<?=$image?>" name="primary_photo" <?=set_value('primary_photo') == $image ? 'checked=true' : '' ?>> Primary Photo</label>
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
								<input type="text" class="form-control" id="" placeholder="" name="title" value="<?=set_value('title')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Condition</label>
							<div class="col-xs-9">
								<?php
									$conditions = array('brand_new' => 'Brand New',
														'used' => 'Used');
									echo form_dropdown('condition', $conditions, set_value('condition'), 'class="form-control"');
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
									echo form_dropdown('size', $sizes, set_value('size'), 'class="form-control"');
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Selling Price</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" id="" placeholder="" name="price" value="<?=set_value('price')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Description</label>
							<div class="col-xs-9">
								<textarea style="resize: vertical; max-height: 500px;" class="form-control wysihtml5" rows="8" name="description" id="wysiwyg"><?=set_value('description')?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Captcha</label>
							<div class="col-xs-9">
								<div class="form-inline">
									<?=$captcha_img?>
									<input type="text" class="form-control" id="" placeholder="" name="captcha">
								</div>
							</div>
						</div>
						<div id="submit-ad">
							<div class="form-group">
								<div class="col-xs-8">
									<p style="margin-top: 10px;"><em>By posting this ad, you agree to the <a href="terms-and-conditions" target="_blank">Terms of Use</a> of Sneaker Trade PH</em></p>
								</div>
								<div class="col-xs-4">
									<button type="submit" class="btn btn-primary btn-block" id="add-form-submit">Post Ad</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				
			</div>
			<div class="col-xs-4">
				<!-- ads here -->
			</div>
			<div class="clearfix"></div>
		</div>

	</div>		
</div>
