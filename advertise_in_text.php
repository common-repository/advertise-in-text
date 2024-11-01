<?php
/*
Plugin Name: Advertise in Text
Plugin URI: http://www.sponsorzahlt.de/wordpress+plugins_cat12.html
Description: Werbebanner k&ouml;nnen mit diesem Plugin automatisch mitten in den Text hinzugef&uuml;gt werden. Auch f&uuml;r Mobile / Iphone Ger&auml;te geeignet. Erfolgreich getestet mit Google Adsense, Affili, Zanox, Sponsorads usw.
Author: Iphoneler.de
Version: 1.0
Author URI: http://www.sponsorzahlt.de/


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the
Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

The GNU General Public License is also available at
http://www.gnu.org/copyleft/gpl.html
*/


$form_werbecode = get_option('ait_werbecode');
if ('insert' == $HTTP_POST_VARS['action']) {update_option("ait_werbecode",$HTTP_POST_VARS['ait_werbecode']);}
$form_werbecode = get_option('ait_werbecod_mobile');
if ('insert' == $HTTP_POST_VARS['action']) {update_option("ait_werbecode_mobile",$HTTP_POST_VARS['ait_werbecode_mobile']);}
$form_werbecode = get_option('ait_divstart');
if ('insert' == $HTTP_POST_VARS['action']) {update_option("ait_divstart",$HTTP_POST_VARS['ait_divstart']);}
$form_werbecode = get_option('ait_divende');
if ('insert' == $HTTP_POST_VARS['action']) {update_option("ait_divende",$HTTP_POST_VARS['ait_divende']);}
$form_werbecode = get_option('ait_trenner');
if ('insert' == $HTTP_POST_VARS['action']) {update_option("ait_trenner",$HTTP_POST_VARS['ait_trenner']);}
$form_werbecode = get_option('ait_user_agents');
if ('insert' == $HTTP_POST_VARS['action']) {update_option("ait_user_agents",$HTTP_POST_VARS['ait_user_agents']);}



function ait_aktivieren() {
	 		if(get_option('ait_user_agents')==false){
			add_option('ait_trenner', '</p>');
			add_option('ait_divstart', '<p>');
			add_option('ait_divende', '</p>');
			$user_agents_standart = "Android, AvantGo, Blackberry, Blazer, Cellphone, Danger, DoCoMo, EPOC, EudoraWeb, Handspring, Kyocera, LG, MMEF20, MMP, MOT-V, Mot, Motorola, NetFront, Newt, Nokia, Opera Mini, Palm, Palm, PalmOS, PlayStation Portable, ProxiNet, Proxinet, SHARP-TQ-GX10, Samsung, Small, Smartphone, SonyEricsson, SonyEricsson, Symbian, SymbianOS, TS21i-10, UP.Browser, UP.Link, WAP, Windows CE, hiptop, iPhone, iPod, portalmmm, Elaine/3.0, OPWV";
			add_option('ait_user_agents',$user_agents_standart);
			}
}
 
add_action( 'activate_'.plugin_basename(__FILE__),   'ait_aktivieren' );

 function cleanit($text) {
		$text = str_replace('\"', '"', $text); 
		$text = str_replace("\'", "'", $text); 
		return $text; }
 
	 
	 function absatz_banner($content) {
			$mobiles_geraet = 0;
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$user_agents = get_option('ait_user_agents');
			$user_agents = explode(',',$user_agents);
			
			foreach($user_agents AS $agent){
			if(eregi(trim($agent),$user_agent)){
			$mobiles_geraet = 1;
					}
				}
				
		
				
			if(is_single() ) {
			$werbecode = get_option("ait_werbecode");  $werbecode = str_replace('\"', '"', $werbecode); $werbecode = str_replace("\'", "'", $werbecode);
			$werbecode_mobile = get_option("ait_werbecode_mobile");  $werbecode_mobile = str_replace('\"', '"', $werbecode_mobile); $werbecode_mobile = str_replace("\'", "'", $werbecode_mobile);
			$divende = get_option("ait_divende");   $divende = str_replace('\"', '"', $divende); $divende = str_replace("\'", "'", $divende);
			$divstart = get_option("ait_divstart");   $divstart = str_replace('\"', '"', $divstart); $divstart = str_replace("\'", "'", $divstart);
			$trenner = get_option("ait_trenner");   $trenner = str_replace('\"', '"', $trenner); $trenner = str_replace("\'", "'", $trenner);
			
			if($mobiles_geraet ==1) { $werbecode = $werbecode_mobile; }

					$absatz = explode("".$trenner."", $content);
					$content = $absatz[0];
					$content .= "".$divstart."".$werbecode."".$divende."";
					for($i=1; $i < count($absatz); $i++) {
					$content .= $absatz[$i]; $i++; }
					return $content; 
					
					} else { return $content; }
				
			}


#	add_filter('the_content', 'checkcontent');
	add_filter('the_content', 'absatz_banner');
	
	
	function advertise_in_text_option_page() { 
			?>
	
	<div class="wrap">
	<h1>Advertise in Text</h1>
	<form name="form1" method="post" action="<?=$location ?>">
		<strong>Trennzeichen:</strong>(Standart ist &lt;/p&gt; um nach dem ersten Absatz den Banner einzuf&uuml;gen. M&ouml;glich auch Dinge wie <--Banner--> um es manuell im Text zu setzen)
		<p style="padding-left:20px;"><textarea name="ait_trenner" class="widefat" rows="1" cols="40" ><? echo cleanit(get_option("ait_trenner")) ?></textarea></p>
		<strong>Div vor dem Banner:</strong> (Die CSS Anweisungen die vor dem Bannercode stehen)
		<p style="padding-left:20px;"><textarea class="widefat" name="ait_divstart" rows="3" cols="40" ><? echo cleanit(get_option("ait_divstart")) ?></textarea></p>
		<strong>Werbecode:</strong> (Eine kleine Auswahl an verschiedenen Anbietern findest du unten)
		<p style="padding-left:20px;"><textarea name="ait_werbecode" class="widefat" rows="10" cols="40" ><? echo cleanit(get_option("ait_werbecode")) ?></textarea></p>
		<strong>Werbecode f&uuml;r HANDYS:</strong> (Hier kann ein gesonderter Code f&uuml;r Handynutzer gew&auml;hlt werden)
		<p style="padding-left:20px;"><textarea name="ait_werbecode_mobile" class="widefat" rows="10" cols="40" ><? echo cleanit(get_option("ait_werbecode_mobile")) ?></textarea></p>
		<strong>Div nach dem Banner</strong> (Die CSS Anweisungen die nach dem Bannercode stehen)
		<p style="padding-left:20px;"><textarea name="ait_divende" class="widefat" rows="3" cols="40" ><? echo cleanit(get_option("ait_divende")) ?></textarea></p>
		<br /><br /><strong>Erkennung mobiler Ger&auml;te:</strong> (Mit dieser Liste k&ouml;nnen die mobilen Ger&auml;te gefiltert werden)
		<p style="padding-left:20px;"><textarea name="ait_user_agents" class="widefat" rows="3" cols="40" ><? echo cleanit(get_option("ait_user_agents")) ?></textarea></p>
		<input type="submit" value="Speichern" />
		<input name="action" value="insert" type="hidden" />
</form>
<br /><br />
Wenn euch das Plugin gef&auml;llt, dann k&ouml;nnt ihr gerne einen Backlink zu Iphoneler.de setzen!
	
<br /><h1>Anbieter f&uuml;r Bannerwerbung:</h1>
<ul>
<li><a href="http://www.iphoneler.de/belboon_link" >Belboon</a> (Affiliate Marketing, nutzt FlashCookies für eine bessere und längere Registrierung der Sales)
<li><a href="http://www.iphoneler.de/bee5_link" >Bee5</a> (Riesige auswahl an Partnerprogrammen, keine Freischaltungszeit!)</li>
<li><a href="http://www.iphoneler.de/contaxe_link" >Contaxe</a> (Contentabh&auml;ngige Werbung &auml;hnlich wie bei Adsense)</li>
<li><a href="http://www.iphoneler.de/sponsorads_link" >Sponsorads</a> (bis zu 13 Cent pro Klick)</li>
<li><a href="http://www.iphoneler.de/selfcash_link" >SelfCash</a> (bis zu 10 Cent pro Klick)</li>
<li><a href="http://www.iphoneler.de/xadservice_link">X-Adservice</a> (9 Cent pro klick, auch Erotik)</li>
	
	
	</div>
	
<?php
} // Ende Funktion fb_meta_description_option_page()
 
// Adminmenu Optionen erweitern
function advertise_in_text_add_menu() {
add_options_page('Advertise in Text', 'Advertise in Text', 9, __FILE__, 'advertise_in_text_option_page'); //optionenseite hinzufügen
}
 
// Registrieren der WordPress-Hooks
add_action('admin_menu', 'advertise_in_text_add_menu');

?>