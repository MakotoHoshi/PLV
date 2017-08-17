<?php
/*
Plugin Name: Pegion Log Viewer
Plugin URI: https://github.com/MakotoHoshi/
Description: Pegionメールライブラリに搭載されたDBモードに対応するログビューワです。
Version: 1.0.0
Author: MakotoHoshi
Author URI: https://github.com/MakotoHoshi/
License: GPL2
*/

add_action("admin_menu", "PLV_menu_output");
function PLV_input(){

}
function PLV_console(){
	/*テーブル名を設定*/
	$tb_name = "log";

	global $wpdb;
	$sql = "";
	$sql .= "SELECT * FROM `".$tb_name."`";
	$result = $wpdb->get_results($sql);
	$string = "";
	$string .= "<h1>Pegion Log Viewer</h1>";
	$string .= '<table class="wp-list-table widefat fixed striped posts">';
	$string .= '<tbody>';
	foreach($result as $key=>$value){
		$string .= '<tr class="mail_ov">';
		$string .= '<th>'.$value->_id.'</th>';
		$string .= '<td>'.$value->time.'</td>';
		foreach($value as $k=>$v){
			if($k == "email" || $k == "user"){
				$string .= '<td>'.$v.'</td>';
			}
		}
		$string .= '</tr>';
		$string .= '<tr class="mail_txt" style="display:none;">
		<th colspan="4">
		<div>';
		foreach($value as $k=>$v){
			if($k == "_id" || $k == "time"){
				continue;
			}
			if(strpos($v, "&lt;br&gt;") !== false){
				$v = str_replace("&lt;br&gt;", "／", $v);
				$string .= $v."<br>";
			}else{
				$string .= $v."<br>";
			}
		}
		$string .= '</div>
		</th>
		</tr>';
	}
	$string .= '</tbody>';
	$string .= '</table>';

	echo $string;
}
function PLV_menu_output(){
	add_menu_page("PLV", "PLV", "manage_options", "plv", "PLV_console", content_url()."/plugins/PLV/img/icon.png");
}
?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
	$(function(){
		$('.mail_ov').on('click', function(){
			$(this).next('.mail_txt').slideToggle();
		});
	});
</script>