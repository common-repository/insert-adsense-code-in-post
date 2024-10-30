
<?php

require_once  dirname(__FILE__) .'/libs/delta_translator.php';
 
global $wpdb;
   $languageCode = "en_EN";
   $scriptTop = "none";
   $scriptRight = "none";
   $scriptBottom = "none";



		 
 if(isset($_POST['language'])) 
 {
 	$str_script1='none';
 	$str_script2='none';
 	$str_script3='none';
	 
	 if($_POST['script1']==='')
	{
		$str_script1 = '';
		$str_script1_placeholder = DeltaTranslator::getText('textContentScriptRightSettings');

	}
	else
		$str_script1 =  htmlentities($_POST['script1']);

	 
		 
		 $resultUpdate_script1 = $wpdb->update( 
	        $wpdb->prefix . 'delta_adsense_in_post', 
			array( 
				 
				'adsense_script' => $str_script1
			), 
			array(  'wp_position'=>'right' ), 
			array( 
					'%s' 
			),    
			array( 
                   '%s'   
				   ) 
			);
			$wpdb->flush();
	 
	if($_POST['script2']==='')
	{
		$str_script2 = '';
		$str_script2_placeholder =   DeltaTranslator::getText('textContentScriptTopSettings');   
	}
	else
		$str_script2 =   htmlentities($_POST['script2']);

	/*if(!get_magic_quotes_gpc()) {
    $str_script2 = addslashes($str_script2);
	}*/

		//$str_script2 =  str_replace('"','\"',$_POST['script2']);
		
		 $resultUpdate_script2 = $wpdb->update( 
	        $wpdb->prefix . 'delta_adsense_in_post', 
			array( 
				 
				'adsense_script' => $str_script2
			), 
			array(  'wp_position'=>'top' ), 
			array( 
					'%s' 
			), 
			array( 
                   '%s'
				   ) 
			);
			$wpdb->flush();
	 
	 if($_POST['script3']==='')
	{
		$str_script3 = '';
		$str_script3_placeholder =   DeltaTranslator::getText('textContentScriptBottomSettings');

	}
	else
		$str_script3 =   htmlentities($_POST['script3']);
	/*if(!get_magic_quotes_gpc()) {
    $str_script3 = addslashes($str_script3);
	}*/
	 
		//$str_script3 =  str_replace('"','\"',$_POST['script3']);
		 
		 $resultUpdate_script3 = $wpdb->update( 
	        $wpdb->prefix . 'delta_adsense_in_post', 
			array( 
				 
				'adsense_script' => $str_script3
			), 
			array(  'wp_position'=>'bottom' ), 
			array( 
					'%s' 
			), 
			array( 
                   '%s'
				   ) 
			);
			$wpdb->flush();
	 
	 
	if($resultUpdate_script1 !=false or $resultUpdate_script2 !=false or $resultUpdate_script3!=false)
	{
		 
		echo ' <br />
			<div id="message" class="updated notice notice-success is-dismissible below-h2">
			<p>'.DeltaTranslator::getText('successMessageUpdate').'</p>
			</div> ';
	}
	else
	{
		echo ' <br />
			<div id="message" class="updated notice notice-error is-dismissible below-h2">
			<p> Error.</p>
			</div> ';
	}
 }
 
 
 $options = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."delta_adsense_in_post ;");

			foreach($options as $option)
			{
				if($option->wp_position ==="top")
				{
					 $scriptTop = $option->adsense_script;
					 $scriptTop = html_entity_decode($scriptTop);
							 		$scriptTop =   str_replace('\"','"',$scriptTop);
					 $scriptTopShortcode = $option->shortcode;
				}
				elseif($option->wp_position ==="bottom")
				{
					$scriptBottom = $option->adsense_script; 
					 $scriptBottom = html_entity_decode($scriptBottom);
							 		$scriptBottom =   str_replace('\"','"',$scriptBottom);
					$scriptBottomShortcode = $option->shortcode;
				}
				elseif($option->wp_position ==="right")
				{
					$scriptRight = $option->adsense_script;	
					 $scriptRight = html_entity_decode($scriptRight);
							 		$scriptRight =   str_replace('\"','"',$scriptRight);
					$scriptRightShortcode = $option->shortcode;	
				}
				else
				{
                    $languageCode =  $option->adsense_script;
                    $languageName = $option->shortcode;	
				}

			}

 ?>


<div class="wrap">
<div id="post-body-content" style="position: relative;">
<?php
if(isset($_GET['message']))
{
	
		if($_GET['message']==='successUpdate')
		 echo '
		<div id="message" class="updated notice notice-success is-dismissible below-h2">
		<p>'. DeltaTranslator::getText('successMessageUpdate').' </p>
		<button type="button" class="notice-dismiss">
		<span class="screen-reader-text">Ne pas tenir compte de ce message.</span>
		</button></div> ';
		
		
}
?>
<h2> <div style="max-width:32px; "><img style="max-width:32px; " src="<?php  echo plugins_url() .'/insert-adsense-code-in-post/webroot/img/logo-mini.png'; ?>" /> </div>
 <div style="    margin-left: 40px;     margin-top: -36px;"> <?php echo DeltaTranslator::getText('pluginTitle'); ?></div></h2>

 <br />

<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content" style="position: relative;">

<form method="post" action="<?php echo  admin_url('admin.php?page=delta-adsense-in-post') ; ?>" name="updateSettings" id="post">

<table class="form-table">
<tbody>

<tr>
<th scope="row"><label for="blogname"><?php echo DeltaTranslator::getText('GoogleAdsenseLabelBloc2'); ?></label></th>
<td>

	<?php

$content = $scriptRight;
$editor_id = 'script1';
$settings = array( 'media_buttons' => false ,'editor_class'=>'regular-text' , 'teeny'=>true , 'textarea_rows'=>5 , 'quicktags' => false , 'tinymce'=>false);
wp_editor( $content, $editor_id ,$settings);

?>

	 

<p class="description" id="tagline-description" style="margin-top: 10px;"><?php echo DeltaTranslator::getText('GoogleAdsenseDescriptionBloc2') 
.' : <span style="background-color:white; padding: 5px 8px; border: 2px solid #ccc;">'.
$scriptRightShortcode .'</span>'; ?></p>
</td>
</tr>

<tr>
<th scope="row"><label for="blogname"><?php echo DeltaTranslator::getText('GoogleAdsenseLabelBloc1'); ?></label></th>
<td>
	<?php

$content = $scriptTop;
$editor_id = 'script2';
$settings =   array( 'media_buttons' => false ,'editor_class'=>'regular-text' , 'teeny'=>true , 'textarea_rows'=>5 , 'quicktags' => false , 'tinymce'=>false);
wp_editor( $content, $editor_id ,$settings);

?>

<p class="description" id="tagline-description" style="margin-top: 10px;"><?php echo DeltaTranslator::getText('GoogleAdsenseDescriptionBloc1') 
.' : <span style="background-color:white; padding: 5px 8px; border: 2px solid #ccc;">'.
  str_replace('\"','"',$scriptTopShortcode) .'</span>'; ?></p>
</td>
</tr>

<tr>
<th scope="row"><label for="blogname"><?php echo DeltaTranslator::getText('GoogleAdsenseLabelBloc3'); ?></label></th>
<td>
<?php

$content = $scriptBottom;
$editor_id = 'script3';
$settings =   array( 'media_buttons' => false ,'editor_class'=>'regular-text' , 'teeny'=>true , 'textarea_rows'=>5 , 'quicktags' => false , 'tinymce'=>false);
wp_editor( $content, $editor_id ,$settings);

?>  
<p class="description" id="tagline-description" style="margin-top: 10px;"><?php echo DeltaTranslator::getText('GoogleAdsenseDescriptionBloc3') 
.' : <span style="background-color:white; padding: 5px 8px; border: 2px solid #ccc;">'.
 str_replace('\"','"',$scriptBottomShortcode) .'</span>'; ?></p>
</td>
</tr>
<tr>
<th scope="row"><label for="blogname"><?php echo DeltaTranslator::getText('languagesLabel'); ?><span style="color:red;"> *</span></label></th>
<td>
<select name="language" id="language" disabled> 
	<option value="<?php echo $languageCode; ?>" selected=""><?php echo DeltaTranslator::getText('languagesOptionDefaultLabel'); ?></option>
	<option value="en_EN">English</option>
	<option value="fr_FR">Français</option>
	<option value="es_ES">Español</option>
	<option value="other" disabled><?php echo DeltaTranslator::getText('languagesOptionOtherLanguagesLabel'); ?></option>
</select>
<input type="hidden" name="language" value="<?php echo $languageCode; ?>" />
<p class="description" id="tagline-description"><?php echo DeltaTranslator::getText('languagesDescription'); ?></p>
</td>
</tr>

<tr>
<th scope="row"> </th>
<td>
 <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value=" <?php echo DeltaTranslator::getText('textButtonUpdateSettings'); ?> "></p>
</td>
</tr>
 
	</tbody></table>

</form>
 



</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
 
 

<div id="postimagediv" class="postbox ">

<div class="handlediv" title="Cliquer pour inverser."><br></div><h3 class="hndle ui-sortable-handle"><span><?php   echo DeltaTranslator::getText('helpAndSupportsLabel');  ?></span></h3>
<div class="inside">
 
<?php
 require_once dirname(__FILE__) .'/supports.php';
?>
	
 </div>
</div>
</div>

</div>
<!-- 
<div id="postbox-container-2" class="postbox-container">

3 a l ja w 22
 </div>
</div><!-- /post-body -->
<br class="clear">
</div><!-- /poststuff -->

</div>

	

<div id="ajax-response"></div>
<br class="clear">

</div>
 
</div>