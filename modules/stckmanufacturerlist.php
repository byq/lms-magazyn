<?php
$layout['pagetitle'] = trans('Manufacturers');

if(!isset($_GET['o']))
	$SESSION->restore('smlo', $o);
else
	$o = $_GET['o'];

$SESSION->save('smlo', $o);

$manufacturerlist = $LMSST->ManufacturerGetList($o);
$listdata['total'] = $manufacturerlist['total'];
$listdata['direction'] = $manufacturerlist['direction'];
$listdata['order'] = $manufacturerlist['order'];
unset($manufacturerlist['total']);
unset($manufacturerlist['direction']);
unset($manufacturerlist['order']);

if(!isset($_GET['page']))
        $SESSION->restore('smlp', $_GET['page']);

$page = (! $_GET['page'] ? 1 : $_GET['page']);
$pagelimit = (! $CONFIG['phpui']['manufacturerlist_pagelimit'] ? $listdata['total'] : $CONFIG['phpui']['manufacturerlist_pagelimit']);
$start = ($page - 1) * $pagelimit;

$SESSION->save('swlp', $page);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('page',$page);
$SMARTY->assign('pagelimit',$pagelimit);
$SMARTY->assign('start',$start);
$SMARTY->assign('manufacturerlist', $manufacturerlist);
$SMARTY->assign('listdata', $listdata);
$SMARTY->display('stck/stckmanufacturerlist.html');
?>
