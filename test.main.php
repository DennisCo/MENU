<?php

defined('COT_CODE') or die('Wrong URL.');

if(!$db_list_menu){
    include_once cot_incfile("menu", "plug");
}

$t = new XTemplate(cot_tplfile("test", "module"));

$t->assign("TEST_TITLE", "Тестовый модуль!");


$a = $db->query("SELECT * FROM `{$db_list_menu}` WHERE menu_id=18")->fetchAll();

function mapTree($data) {
 
 $tree = array();
 
 foreach ($dataset as $id=>&$node) {
 
 if (!$node['id_parent']) {
 $tree[$id] = &$node;
 }
 else {
 $dataset[$node['id_parent']]['childs'][$id] = &$node;
 }
 
 }
 return $tree;
 
}
// вызываем функцию и передаем ей наш массив
$data = mapTree($a);

function view_cat ($data) {
 
 foreach ($data as $a) {
 
 echo '<li><a href="?id='.$a["id"].'">'.$a["name"].'</a>';
 
 if($a['childs']) {
 echo '<ul class="submenu">';
 view_cat($a['childs']);
 echo '</ul>';
 }
 echo '</li>';
 
 }

}
view_cat($data);

/*foreach($a as $k=>$v){
    list($la, $lb) = explode(",", $v["link"]);
    $t->assign(array(
         "TEST_ROW_TITLE" => $v["name"]
        ,"TEST_ROW_LINK" => cot_url($la, $lb)
    ));
    $t->parse("MAIN.ROW");
}*/
