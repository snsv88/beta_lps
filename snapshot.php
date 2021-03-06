<?php
namespace Lapsic;
/**
 * Pagina di Front-end del progetto Lapsic
 *
 *
 * @version   1.00
 * @since     2015-05-17
 * @company   http://addictify.it/
 */
include_once(dirname(__FILE__).'/config/config.php');

include_once('super.php');  

        ini_set('display_startup_errors',1);
        ini_set('display_errors',1);
        error_reporting(-1);
        
$element = new LapsicPhoto($db);

$erro = 'false';   
$my_profile = false;

if(isset($id)) {
	
	if(!$element->GetElement($id)){
		//header('Location: index.php?resp_code=615');
		exit ();
	}
}
else
{
	//header('Location: index.php?resp_code=615');
	exit ();   
}
 
    //echo 'TIMER <br>';
    $ParametersList['types_timer']         = 'image';
    $ParametersList['type']               = 'image';
    $ParametersList['elements_in_page']    = 5;
    $ParametersList['id_element']         = $element->id;
    $elements 			= LapsicNotification::GetElementsListRelation($ParametersList);
    //echo $element->id_owner.' === '.$lapsic_user->id;
    if($element->id_owner == $lapsic_user->id)
    {       
        //echo 'sono nel mio profilo';
        //echo '<br>';
        $my_profile = true;
        //var_dump($my_profile);
    }
    
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Photo - <?php echo ($element->name); ?></title>
<meta name="description" content="hype sensitive photography � which pics will stand the test of time?">
<meta property="og:url" content="<?php echo('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>"/>
<meta property="og:title" content="<?php echo($element->description); ?>" />
<?php $fb_photo = ElabImg('media/image/big/',$element->source_path); ?>
<meta property="og:image" content="<?php echo(' http://www.lapsic.it/'.$fb_photo['name']); ?>"/>
<meta property="og:image:width" content="<?php echo($fb_photo['width']); ?>"/>
<meta property="og:image:height" content="<?php echo($fb_photo['height']); ?>"/><meta property="og:site_name" content="Lapsic"/>
<meta property="og:description" content="<?php echo($element->name.' by '.$element->user); ?>"/>
<?php 
/*
Per quanto riguarda il funzionamento, nella classe social c'� la funzione shareFB(ref), passagli l'url della pagina snapshot con url_encode(url) dal bottone che vuoi usare per fare il condividi e sei a posto

*/


?>
<?php include_once('include/resources.php'); ?>
<script type="text/javascript" src="js/home.js" defer></script>
<style type="text/css">
.header-int{ max-width:1394px;}
.name-profile-zoom{ background: rgba(255,255,255, 0.6);}
.name-profile-zoom, .piu-ore, .descr-profile-zoom{ color:#3a3a3a;}
</style>
</head>

<body>
    <?php include('include/googanal.php'); ?>
        
    <div class="second-container">    
        
        <?php include ("include/header.php");?>
        
        <div class="content-dett-img">
    <div class="contenitore-dett-img">
        <div class="descr-dett-img">
            <p class="name-profile-zoom"><a class="nounderline" target="_top" href="profile.php?id=<?php echo ($element->id_owner); ?>"><?php echo ((strlen($element->user)>9)?substr($element->user,0,9).'...':$element->user); ?></a></p>
            <div class="spacer-name-zoom-img"></div>
            <a class="href_nn" style="color: white;" href="index.php?mode=rankuser">
                <p class="posizione-profile-zoom black">#<?php echo ($lapsic_user->rank); ?></p>
            </a>
            <p class="descr-profile-zoom black">
               <?php echo ($element->ElabHashtag($element->description, true)); ?>

            </p>
            <div class="spacer-name-zoom-img"></div>
            <p class="descr-profile-zoom pdBt12">
                TIMED BY<br />
                <?php if(sizeof($elements) > 0) { $count = 0; ?>
                    <?php foreach ($elements as $el) {
                        if($count<5)
                        {
                            echo('<a class="nounderline" target="_top" href="profile.php?id='.$el['id'].'">'.((strlen($el['user'])>15)?substr($el['user'],0,15).'...':$el['user']).','.'</a><br>');  
                            if($count==9) echo ('<a id="more_follow">more..</a><div id="hide_follow" style="display:none">');                      
                        }
                        else
                        {
                            
                            echo('<a class="nounderline" target="_top" href="profile.php?id='.$el['id'].'">'.((strlen($el['user'])>15)?substr($el['user'],0,15).'...':$el['user']).','.'</a><br>');
                        }
                        
                        $count++;
                    } 
                    if($count>10) {echo ('</div>'); }
                    echo(' >>'); ?>        
                <?php } else { ?> nope <?php } ?>  
       
                  
            </p> 
            
            
            <img src="images/orologio.png" width="16" height="16" alt=""/>
            <div class="tempo-profilo" id="counter_<?php echo ($element->id); ?>" title="<?php echo (strtotime($element->time_left)); ?>"  now="<?php echo (time()); ?>" data-countdown="<?php echo ($element->time_left); ?>">
                
                112d:04h
            </div>
            <?php if($my_profile) { ?>  
            <div class="spacer-name-zoom-img"></div>
            <p class="descr-profile-zoom">
                <a target="_parent" class="nounderline" href="edit_photo.php?id=<?php echo($element->id); ?>">edit > </a>
            </p>
            <?php } ?>
            
            <img src="/images/share.png" onclick="shareFB('http://lapsic.it/snapshot.php?id=<?php echo($element->id); ?>')" style="padding-top: 5px;width: 65px;"/> 
        </div>
        <div class="img-dett-zoom">
            <?php $dimensions = ElabImg('media/image/big/',$element->source_path); ?>
            <img src="<?php echo ( $dimensions['name'] ); ?>" width="100%" alt="" style="background-color: #<?php echo ($element->average_colour); ?>; min-height: 200px;"/>
            
			<div class="container-esagoni-piu-ore">
				
				<div class="esagono-abs" style="background: url(../images/esagono-trasp_dark.png) no-repeat;" id="3_<?php echo ($element->id); ?>">
					<p class="piu-ore">+3h</p>
				</div>
				<div class="esagono-abs" style="background: url(../images/esagono-trasp_dark.png) no-repeat;" id="6_<?php echo ($element->id); ?>">
					<p class="piu-ore">+6h</p>
				</div>
				<div class="esagono-abs" style="background: url(../images/esagono-trasp_dark.png) no-repeat;" id="12_<?php echo ($element->id); ?>">
					<p class="piu-ore">+12h</p>
				</div>
				<div class="esagono-abs" style="background: url(../images/esagono-trasp_dark.png) no-repeat;" id="24_<?php echo ($element->id); ?>">
					<p class="piu-ore">+24h</p>
				</div>
			</div>
        </div>
    </div>
</div>

    </div>
    
    <?php include ("include/footer.php");?>
    <?php $teeee = Social::getInstance(); $teeee->generaJs('FB', (isset($_SESSION['state'])? $_SESSION['state'] :'')); ?>
</body>
</html>