<?php
$layout['pagetitle'] = trans('Receive notes list');

if(!isset($_GET['o']))
	$SESSION->restore('srnlo', $o);
else
	$o = $_GET['o'];

$SESSION->save('srnlo', $o);

if(!isset($_GET['sprn']))
	$SESSION->restore('srnlsp', $sprn);
else
	$sprn = $_GET['sprn'];

$SESSION->save('srnlsp', $sprn);

switch ($_GET['action']) {
	case 'srna':
		foreach ($_POST['marks'] as $k => $v) {
			$LMSST->ReceiveNoteAccount($k);
			//print_r($rn);
		}
		break;
	default:
		break;
}

$receivenotelist = $LMSST->ReceiveNoteList($o, $sprn);
$listdata['total'] = $receivenotelist['total'];
$listdata['direction'] = $receivenotelist['direction'];
$listdata['order'] = $receivenotelist['order'];
$listdata['totalvu'] = $receivenotelist['totalvu'];
unset($receivenotelist['totalvu']);
unset($receivenotelist['total']);
unset($receivenotelist['direction']);
unset($receivenotelist['order']);

foreach ($receivenotelist as $k => $v)
	$receivenotelist[$k]['sbalance'] = $LMS->GetCustomerBalance($v['sid']);

if(!isset($_GET['page']))
        $SESSION->restore('srnlp', $_GET['page']);

$page = (! $_GET['page'] ? 1 : $_GET['page']);
$pagelimit = (! $CONFIG['phpui']['receivenotelist_pagelimit'] ? $listdata['total'] : $CONFIG['phpui']['receivenotelist_pagelimit']);
$start = ($page - 1) * $pagelimit;

$SESSION->save('srnlp', $page);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('page',$page);
$SMARTY->assign('pagelimit',$pagelimit);
$SMARTY->assign('start',$start);
$SMARTY->assign('listdata', $listdata);
$SMARTY->assign('sprn', $sprn);
$SMARTY->assign('receivenotelist', $receivenotelist);
$SMARTY->display('stck/stckreceivenotelist.html');
?>
