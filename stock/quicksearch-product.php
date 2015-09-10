<?php		
		if(isset($_GET['ajax'])) {
			$candidates = $DB->GetAll("SELECT ".$DB->Concat('m.name', '" "', 'p.name')." AS name, p.id, p.ean, p.quantity
			FROM stck_products p
			LEFT JOIN stck_manufacturers m ON p.manufacturerid =  m.id
			WHERE ".(preg_match('/^[0-9]+$/', $search) ? 'p.id = '.intval($search).' OR ' : '')."
				LOWER(".$DB->Concat('m.name',"' '",'p.name').") ?LIKE? LOWER($sql_search)
				OR LOWER(p.ean) ?LIKE? LOWER($sql_search)
				ORDER by name, id
				LIMIT 15");
			
			$eglible=array(); $actions=array(); $descriptions=array();
			if ($candidates)
				 foreach($candidates as $idx => $row) {
					$actions[$row['id']] = 'javascript:pad(\''.$row['id'].'\')';
					$eglible[$row['id']] = escape_js(($row['deleted'] ? '<font class="blend">' : '')
					.truncate_str($row['name'], 150).($row['deleted'] ? '</font>' : ''));

					if (preg_match("~^$search\$~i",$row['id'])) {
						$descriptions[$row['id']] = escape_js(trans('Id:').' '.$row['id']);
						continue;
					}
					if (preg_match("~$search~i",$row['name'])) {
						$descriptions[$row['id']] = '';
						continue;
					}
					if (preg_match("~$search~i",$row['ean'])) {
						$descriptions[$row['id']] = escape_js(trans('EAN:').' '.$row['ean']);
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
			
			if(is_numeric($search)) { // maybe it's product ID
				if($customerid = $DB->GetOne('SELECT id FROM stck_products WHERE id = '.$search)) {
					$target = '?m=customerinfo&id='.$customerid;
					break;
				}
			}
		break;
?>
