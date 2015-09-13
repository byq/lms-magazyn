<?php
$layout['pagetitle'] = trans('Product list');

if(!isset($_GET['o']))
	$SESSION->restore('sglo', $o);
else
	$o = $_GET['o'];

$SESSION->save('sglo', $o);

//$productlist = $LMSST->ProductGetList($o);

// dodac wyciaganie il. szt. danego produktu oraz ich wartosc
$productlist = $DB->GetAll('SELECT id AS gid, name AS gname, comment AS gcomment
        FROM stck_products
        WHERE deleted = 0');

$productlist['total'] = sizeof($productlist);
$productlist['order'] = $order;
$productlist['direction'] = $direction;

$listdata['total'] = $productlist['total'];
$listdata['direction'] = $productlist['direction'];
$listdata['order'] = $productlist['order'];
unset($productlist['total']);
unset($productlist['direction']);
unset($productlist['order']);

if(!isset($_GET['page']))
        $SESSION->restore('sglp', $_GET['page']);

$page = (! $_GET['page'] ? 1 : $_GET['page']);
$pagelimit = (! $CONFIG['phpui']['productlist_pagelimit'] ? $listdata['total'] : $CONFIG['phpui']['productlist_pagelimit']);
$start = ($page - 1) * $pagelimit;

$SESSION->save('swlp', $page);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('page',$page);
$SMARTY->assign('pagelimit',$pagelimit);
$SMARTY->assign('start',$start);
$SMARTY->assign('productlist', $productlist);
$SMARTY->assign('listdata', $listdata);
$SMARTY->display('stck/stckproductlist.html');
?>
