<?php
$layout['pagetitle'] = trans('Product groups');

if(!isset($_GET['o']))
	$SESSION->restore('sglo', $o);
else
	$o = $_GET['o'];

$SESSION->save('sglo', $o);

$grouplist = $LMSST->GroupGetList($o);
$listdata['total'] = $grouplist['total'];
$listdata['direction'] = $grouplist['direction'];
$listdata['order'] = $grouplist['order'];
unset($grouplist['total']);
unset($grouplist['direction']);
unset($grouplist['order']);

if(!isset($_GET['page']))
        $SESSION->restore('sglp', $_GET['page']);

$page = (! $_GET['page'] ? 1 : $_GET['page']);
$pagelimit = (! $CONFIG['phpui']['grouplist_pagelimit'] ? $listdata['total'] : $CONFIG['phpui']['grouplist_pagelimit']);
$start = ($page - 1) * $pagelimit;

$SESSION->save('swlp', $page);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('page',$page);
$SMARTY->assign('pagelimit',$pagelimit);
$SMARTY->assign('start',$start);
$SMARTY->assign('grouplist', $grouplist);
$SMARTY->assign('listdata', $listdata);
$SMARTY->display('stck/stckgrouplist.html');
?>
