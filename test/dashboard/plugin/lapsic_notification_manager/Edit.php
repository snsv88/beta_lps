			
                <?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
                	
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li onclick="ChangeTabs('tab_1');" class="active"><a href="#tab_1" data-toggle="tab">Tag Data</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- general form elements disabled -->

									<div class="box-body">
										<form role="form" method="post">
										
											<input type="hidden" name="act" value="tab_1" />
                                            
                                            <div class="col-sm-12">
                                                                                                			
    											<div class="form-group">
    												<label for="notify">Notifica diretta a tutti gli utenti</label>
                                                        
                                                    <div class="input-group">
        												
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" placeholder="" id="notify" name="notify" value="<?php echo(isset($element->text)?$element->text:''); ?>" onchange="ChangeForm();">
                                                    </div>
                                                    
                                                </div>	
											</div>
                                            
											<div class="box-footer">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>			
										</form>
									</div><!-- /.box-body -->
								
							</div><!-- /.tab-pane -->
                            
						</div><!-- /.tab-content -->
					</div><!-- nav-tabs-custom -->
