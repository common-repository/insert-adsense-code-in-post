<?php
class DeltaTranslator { 

 
		static function getText($textKey)
		{
			 $langCode = "en_EN";
			 if(get_locale()==="fr_FR" or get_locale()==="es_ES")
				  $langCode = get_locale();
			$contentsOfFile = file_get_contents(plugin_dir_path(__DIR__).'lang/'.$langCode.'/default.json');
			 $contentsOfFile =  utf8_encode($contentsOfFile );
			$languageTexts = json_decode(utf8_decode($contentsOfFile));
			 

			
			if(!empty($languageTexts->$textKey))
			{
				return $languageTexts->$textKey;
			}
			
			else
			{
				$contentsOfFile = file_get_contents(plugin_dir_path(__DIR__).'lang/en_EN/default.json');
				$languageTexts = json_decode(utf8_decode($contentsOfFile)); 
				return $languageTexts->$textKey;
			}
				
		}
		
}
?>