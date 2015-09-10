<?php
$layout['pagetitle'] = trans('Add stock from receive note');
$error = NULL;
$taxeslist = $LMS->GetTaxes();
$quantities = $LMSST->QuantityGetList();
unset($quantities['order']);
unset($quantities['direction']);
unset($quantities['total']);

$receivenote = array();

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SESSION->restore('receivenote', $receivenote);

if (!$receivenote)
	$SESSION->redirect('?m=stckreceiveadd');

if (isset($_POST['receivenote']['product']) && !isset($_GET['action'])) {

	$itemdata = $_POST['receivenote']['product'];

	if (!ctype_digit($itemdata['warehouse']))
		$error['warehouse'] = 'Incorrect warehouse!';

	$itemdata['warehousename'] = $LMSST->WarehouseGetNameById($itemdata['warehouse']);

	if (!ctype_digit($itemdata['pid']))
		$error['product'] = 'Product not in databse';

	if (!ctype_digit($itemdata['count']) || $itemdata['count'] < 1)
		$error['count'] = 'Incorrect ammount!';

	$itemdata['unitname'] = $LMSST->QuantityGetNameById($itemdata['unit']);

	if (!preg_match('/^\d+[,.]{0,1}\d{0,2}$/i', $itemdata['price']['net']) && !preg_match('/^\d+[,.]{0,1}\d{0,2}$/i', $itemdata['price']['gross']))
		$error['price'] = 'Wrong or missing price!';
	
	$itemdata['price']['tax'] = isset($itemdata['price']['taxid']) ? $taxeslist[$itemdata['price']['taxid']]['label'] : '';

	if (!$error) {
		$taxvalue = isset($itemdata['price']['taxid']) ? $taxeslist[$itemdata['price']['taxid']]['value'] : 0;
		if ($itemdata['price']['net'] != 0) {
			$itemdata['price']['net'] = f_round($itemdata['price']['net']);
			$itemdata['price']['gross'] = f_round($itemdata['price']['net'] * ($taxvalue / 100 + 1),2);
			$itemdata['price']['net'] = f_round($itemdata['price']['gross'] / ($taxvalue / 100 + 1),2);
		} elseif ($itemdata['price']['gross'] != 0) {
			$itemdata['price']['gross'] = f_round($itemdata['price']['gross'], 2);
			$itemdata['price']['net'] = f_round($itemdata['price']['gross'] / ($taxvalue / 100 + 1),2);
		}
		 
		 if ($itemdata['count'] > 1) {
		 	$serials = array();
			$receivenote['doc']['net'] += $itemdata['count']*$itemdata['price']['net'];
			$receivenote['doc']['gross'] +=  $itemdata['count']*$itemdata['price']['gross'];
			for ($i = 1; $i < $itemdata['count']; ++ $i) {
				$serials[] = strtoupper($itemdata['serial'][$i]);
				unset($itemdata['serial'][$i]);
			}
			$itemdata['count'] = 1;
			$itemdata['serial'] = strtoupper($itemdata['serial'][0]);
			$receivenote['product'][] = $itemdata;
			foreach($serials as $serial) {
				$itemdata['serial'] = $serial;
				$receivenote['product'][] = $itemdata;
			}
		} else {
			$itemdata['serial'] = strtoupper($itemdata['serial'][0]);
			$receivenote['product'][] = $itemdata;
			$receivenote['doc']['net'] += $itemdata['price']['net'];
			$receivenote['doc']['gross'] += $itemdata['price']['gross'];
		}

		unset($itemdata);
		
		$SESSION->remove('receivenote');
		$SESSION->save('receivenote', $receivenote);
	} else {
		$SMARTY->assign('item', $itemdata);
	}
} elseif (isset($_GET['action']) && ctype_digit($_GET['id'])) {
	switch($_GET['action']) {
		case 'del':
			$receivenote['doc']['net'] -= $receivenote['product'][$_GET['id']]['price']['net'];
			$receivenote['doc']['gross'] -= $receivenote['product'][$_GET['id']]['price']['gross'];
			unset($receivenote['product'][$_GET['id']]);
			$SESSION->remove('receivenote');
			$SESSION->save('receivenote', $receivenote);
			break;
		case 'edit':
			$itemdata = $receivenote['product'][$_GET['id']];
			$receivenote['doc']['net'] -= $receivenote['product'][$_GET['id']]['price']['net'];
			$receivenote['doc']['gross'] -= $receivenote['product'][$_GET['id']]['price']['gross'];
			unset($receivenote['product'][$_GET['id']]);
			$SESSION->remove('receivenote');
			$SESSION->save('receivenote', $receivenote);
			break;
		default:
			break;
	}
} elseif (isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'cancel':
			$SESSION->remove('receivenote');
			$SESSION->redirect('?m=stckstock');
			break;
		case 'save':
			//print_r($receivenote);
			$LMSST->ReceiveNoteAdd($receivenote);
			$SESSION->remove('receivenote');
			$SESSION->redirect('?m=stckstock');
			break;
	}
}
$warehouses = $LMSST->WarehouseGetList('name');
unset($warehouses['total']);
unset($warehouses['order']);
unset($warehouses['direction']);

$SMARTY->assign('error', $error);
$SMARTY->assign('receivenote', $receivenote);
$SMARTY->assign('warehouses', $warehouses);
$SMARTY->assign('taxeslist', $taxeslist);
$SMARTY->assign('quantities', $quantities);
$SMARTY->assign('itemdata', $itemdata);
$SMARTY->display('stck/stckreceiveproductlist.html');
?>
