<?php
$layout['pagetitle'] = trans('Add product to invoice');

$productlist = $LMSST->ProductGetList($o);

if(!isset($_GET['page']))
        $SESSION->restore('splp', $_GET['page']);

$page = (! $_GET['page'] ? 1 : $_GET['page']);
$pagelimit = (! $CONFIG['phpui']['productlist_pagelimit'] ? $listdata['total'] : $CONFIG['phpui']['productlist_pagelimit']);
$start = ($page - 1) * $pagelimit;

$SESSION->save('splp', $page);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('error', $error);
$SMARTY->assign('page',$page);
$SMARTY->assign('pagelimit',$pagelimit);
$SMARTY->assign('start',$start);
$SMARTY->assign('productlist', $productlist);
$SMARTY->assign('listdata', $listdata);
$SMARTY->display('stck/stckproductaddinvoice.html');
?>
