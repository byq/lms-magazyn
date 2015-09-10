<?php

if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
	$SESSION->redirect('?m=stckproductlist');
elseif (! $LMSST->ProductExists($_GET['id']))
	$SESSION->redirect('?m=stckproductlist');

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$layout['pagetitle'] = trans('Edit product');
$error = NULL;

if (isset($_POST['productedit'])) {
	$productedit = $_POST['productedit'];
	$productedit['id'] = $_GET['id'];
	
	if ($productedit['name'] == '')
		$error['name'] = trans('Product must have a name!');
	
	if ($productedit['quantity'] < 1 || !ctype_digit($productedit['quantity']))
		$error['quantity'] = trans('Incorrect product quantity!');
	
	if (!$productedit['quantitycheck'])
		$productedit['quantitycheck'] = 0;
	
	if (!$error) {
		$id = $LMSST->ProductEdit($productedit);
		$SESSION->redirect('?m=stckproductinfo&id='.$id);
	}
} else {
	$productedit = $LMSST->ProductGetInfoById($_GET['id']);
}
$mlist = $LMSST->ManufacturerGetList();
$glist = $LMSST->GroupGetList();
$tlist = $LMSST->TypeGetList();
$qlist = $LMSST->QuantityGetList();

unset($mlist['total']);
unset($mlist['order']);
unset($mlist['direction']);
unset($glist['total']);
unset($glist['order']);
unset($glist['direction']);
unset($tlist['total']);
unset($tlist['order']);
unset($tlist['direction']);
unset($qlist['total']);
unset($qlist['order']);
unset($qlist['direction']);

$SMARTY->assign('error', $error);
$SMARTY->assign('productedit', $productedit);
$SMARTY->assign('mlist', $mlist);
$SMARTY->assign('glist', $glist);
$SMARTY->assign('tlist', $tlist);
$SMARTY->assign('qlist', $qlist);
$SMARTY->assign('txlist', $LMS->GetTaxes());
$SMARTY->display('stck/stckproductedit.html');

?>
