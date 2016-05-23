<?php 

include_once(dirname(__FILE__).'/config/include.php');
include_once('operation_foo.php');

$ParametersList['pagination'] = true;
$element 			= $Dashboard_user::GetElementsList($ParametersList); //$db, 20, $_pag, $_st, $_text, $idproprio, NULL);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo (NOME_PRJ); ?> | <?php echo($area[PAGE_NAME]['title']); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		    
        <?php include_once('resource.php'); ?>
        <?php include_once('operation_js.php'); ?>
		
	</head>

    <body class="sidebar-mini skin-<?php echo ( $Dashboard_user->GetSkin() ); ?>-light ">
        
        <div class="wrapper">
        
		<?php include_once('header.php'); ?>
		        
		<?php include_once('menu_left.php'); ?>
            
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                
				<?php include_once('page_bar.php'); ?>
				
				<?php if(sizeof($errors) > 0 || $respok !== false || sizeof($element) == 0) include_once('alerts_callouts.php'); ?>
				
				<?php include_once('search_element.php'); ?>
				
				<?php if($element->count() > 0) { ?>
				
					<div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Data Panel</h3>
                                    <!--<div class="box-tools">
                                        <div class="input-group">
                                            <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>E-mail</th>
											<th><?php echo ( (($WRITE) ? 'Edit' : '') ); ?></th>
											<th><?php echo ( (($DELETE) ? 'Delete' : '') ); ?></th>
											<th><?php echo ( (($PUBLISH) ? 'Status' : '') ); ?></th>
                                        </tr>
										<?php foreach ($element as $el) {?>
                                        <tr>
                                            <td><img src="<?php echo (MEDIA_PATH.'avatar/'.$el['img']); ?>"class="img-circle" alt="User Image" width="45" height="45" /></td>
                                            <td style="line-height: 45px;"><?php echo ($el['nickname']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['username']); ?></td>
                                            <td style="line-height: 45px;"><?php echo ($el['email']); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($WRITE) ? '<a href="'.str_replace('_list','_edit',$sub_area['page']).'.php?id='.$el['id'].'" ><span class=" iconia glyphicon glyphicon-pencil"></span></a>' : '') ); ?></td>
											<td style="line-height: 45px;"><?php echo ( ( ($DELETE && $element->count() > 1) ? '<a href="#" onclick="deleteP('.$el['id'].');" ><span class=" iconia glyphicon glyphicon-trash"></span></a>' : '') ); ?></td>
                                            <td style="line-height: 45px;"><?php echo ( ( ($PUBLISH) ? '<a href="#" onclick="'.( ($el['status'] == 0 ) ? 'approva' : 'disapprova').'P('.$el['id'].');" ><span class="label label-'.( ($el['status'] == 0 ) ? 'warning' : 'success'). '">'.( ($el['status'] == 0 ) ? 'Approve' : 'Disapproved').'</span></a>' : '' ) ); ?></td>
                                        </tr>
										<?php } ?>                                        
                                    </table>
                                </div><!-- /.box-body -->
								<?php if($element->count() > 1) { ?>
									
									<div class="box-footer clearfix">
										<ul class="pagination pagination-sm no-margin pull-right">
											<li><?php if($_pag > 1) echo '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag-1).'&'.$querystring.'">&lsaquo;</a>'; ?></li>											
											<li><a href="#">Page <?php echo $_pag;?> of <?php echo $element->getTotalItemCount();?></a></li>
											<li><?php if($_pag < $element->getTotalItemCount()) echo '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag+1).'&'.$querystring.'">&raquo;</a>'; ?></li>
										</ul>
									</div>
									
								<?php }  ?>
                            </div><!-- /.box -->
							
							
                        </div>
                    </div>
				<?php }	?>	
                
<!-- END PAGE -->
<?php include_once('footer.php')?>