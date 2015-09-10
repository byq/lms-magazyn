<?php
		if(isset($_GET['ajax'])) // support for AutoSuggest
		{
			$candidates = $DB->GetAll("SELECT id, email, address, post_name, post_address, deleted,
			    ".$DB->Concat('UPPER(lastname)',"' '",'name')." AS username
				FROM customersview
				WHERE ".(preg_match('/^[0-9]+$/', $search) ? 'id = '.intval($search).' OR ' : '')."
					LOWER(".$DB->Concat('lastname',"' '",'name').") ?LIKE? LOWER($sql_search)
					OR LOWER(address) ?LIKE? LOWER($sql_search)
					OR LOWER(post_name) ?LIKE? LOWER($sql_search)
					OR LOWER(post_address) ?LIKE? LOWER($sql_search)
					OR LOWER(email) ?LIKE? LOWER($sql_search)
				ORDER by deleted, username, email, address
				LIMIT 15");

			$eglible=array(); $actions=array(); $descriptions=array();
			if ($candidates)
			foreach($candidates as $idx => $row) {
				switch ($_GET['source']) {
					case 'rne':
						$actions[$row['id']] = '?m=stckreceivenoteedit&id='.$_GET['sid'].'&sid='.$row['id'];
						break;
					default:
						$actions[$row['id']] = '?m=stckreceiveadd&sid='.$row['id'];
						break;
				}
				$eglible[$row['id']] = escape_js(($row['deleted'] ? '<font class="blend">' : '')
				    .truncate_str($row['username'], 50).($row['deleted'] ? '</font>' : ''));

				if (preg_match("~^$search\$~i",$row['id'])) {
				    $descriptions[$row['id']] = escape_js(trans('Id:').' '.$row['id']);
				    continue;
				}
				if (preg_match("~$search~i",$row['username'])) {
				    $descriptions[$row['id']] = '';
				    continue;
				}
				if (preg_match("~$search~i",$row['address'])) {
				    $descriptions[$row['id']] = escape_js(trans('Address:').' '.$row['address']);
				    continue;
				}
				else if (preg_match("~$search~i",$row['post_name'])) {
				    $descriptions[$row['id']] = escape_js(trans('Name:').' '.$row['post_name']);
				    continue;
				}
				else if (preg_match("~$search~i",$row['post_address'])) {
				    $descriptions[$row['id']] = escape_js(trans('Address:').' '.$row['post_address']);
				    continue;
				}
				if (preg_match("~$search~i",$row['email'])) {
				    $descriptions[$row['id']] = escape_js(trans('E-mail:').' '.$row['email']);
				    continue;
				}
				$descriptions[$row['id']] = '';
			}
			header('Content-type: text/plain');
			if ($eglible) {
				print "this.eligible = [\"".implode('","',$eglible)."\"];\n";
				print "this.descriptions = [\"".implode('","',$descriptions)."\"];\n";
				print "this.actions = [\"".implode('","',$actions)."\"];\n";
			} else {
				print "false;\n";
			}
			exit;
		}

		if(is_numeric($search)) // maybe it's customer ID
		{
			if($customerid = $DB->GetOne('SELECT id FROM customersview WHERE id = '.$search))
			{
				$target = '?m=customerinfo&id='.$customerid;
				break;
			}
	    }
?>
