<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$tableroleaccess = new PoTable('user_role');
$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, post);
$currentRoleAccess = $currentRoleAccess->current();

if($currentRoleAccess->read_access == "Y"){

    $aColumns = array( 'id_post', 'id_category', 'title', 'seotitle', 'active', 'headline', 'editor' );

    $sIndexColumn = "id_post";

    $sTable = "post";

    $gaSql['user']       = DATABASE_USER;
    $gaSql['password']   = DATABASE_PASS;
    $gaSql['db']         = DATABASE_NAME;
    $gaSql['server']     = DATABASE_HOST;

    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );

    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or
        die( 'Could not select database '. $gaSql['db'] );

    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
    }

    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
                    ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
            }
        }

        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }

    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }

    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }

	if ($_SESSION['leveluser'] != "1"){
		if ($sWhere == ""){
			$sWhereUser = "WHERE editor='".$_SESSION['iduser']."' ";
		}else{
			$sWhereUser = " AND editor='".$_SESSION['iduser']."' ";
		}
	}else{
		$sWhereUser = "";
	}

    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
		$sWhereUser
        $sOrder
        $sLimit
    ";
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());

    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];

    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable
    ";
    $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultTotal = mysql_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];

    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );

	$no = 1;
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
		$tableroleaccess = new PoTable('user_role');
		$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, 'post');
		$currentRoleAccess = $currentRoleAccess->current();
        for ( $i=1 ; $i<count($aColumns) ; $i++ )
        {
			$str = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$strlink = preg_replace("/\/po-adminboard\/po-component\/po-post\/(datatable\.php$)/","",$str);
			$valid = $aRow['id_category'];
			$tablecat = new PoTable('category');
			$currentCat = $tablecat->findBy(id_category, $valid);
			$currentCat = $currentCat->current();
            $tableuser = new PoTable('users');
			$currentUser = $tableuser->findBy(id_user, $aRow['editor']);
			$currentUser = $currentUser->current();
			if($aRow['active'] == 'Y'){
				$sactive = "<i class='fa fa-eye'></i> Active";
			}else{
				$sactive = "<i class='fa fa-eye-slash'></i> Not Active";
			}
			if($_SESSION['leveluser'] == '1' OR $_SESSION['leveluser'] == '2'){
                if($currentRoleAccess->modify_access == "Y"){
                    $tblheadline = "<a class='btn btn-xs btn-warning setheadline' id='$aRow[id_post]'><i class='fa fa-star'></i></a>";
                }
            }
			if($aRow['headline'] == 'Y'){
				$headline = "<i class='fa fa-star text-warning'></i> Set Headline";
			}else{
				$headline = "<i class='fa fa-star'></i> Not Set Headline";
			}
			if($currentRoleAccess->delete_access == "Y"){
				$tbldelete = "<a class='btn btn-xs btn-danger alertdel' id='$aRow[id_post]'><i class='fa fa-times'></i></a>";
			}
			$checkdata = "<div class='text-center'><input type='checkbox' id='titleCheckdel' /><input type='hidden' class='deldata' name='item[$no][deldata]' value='$aRow[id_post]' disabled></div>";
			$row[] = $checkdata;
			$row[] = $aRow['id_post'];
			$row[] = $currentCat->title;
			$row[] = "$aRow[title]<br />
					<i><a href='$strlink/detailpost/$aRow[seotitle]' target='_blank'>$strlink/detailpost/$aRow[seotitle]</a></i><br /><br />
					<div class='btn-group btn-group-xs pull-right'>
                        <a class='btn btn-xs btn-default'><i class='fa fa-user'></i> By $currentUser->username</a>
						<a class='btn btn-xs btn-default tbl-subscribe' id='$aRow[id_post]'><i class='fa fa-rss text-danger'></i> Subscribe</a>
						<a href='po-component/po-post/facebook.php?id=$aRow[id_post]' class='btn btn-xs btn-default'><i class='fa fa-facebook text-info'></i> Share</a>
						<a href='po-component/po-post/twitter.php?id=$aRow[id_post]' class='btn btn-xs btn-default'><i class='fa fa-twitter text-primary'></i> Share</a>
                        <a class='btn btn-xs btn-default'>$sactive</a>
						<a class='btn btn-xs btn-default' id='seth$aRow[id_post]' data-headline='$aRow[headline]'>$headline</a>
			</div>";
			$row[] = "<div class='text-center'><div class='btn-group btn-group-xs'>
                    $tblheadline
					<a href='admin.php?mod=post&act=edit&id=$aRow[id_post]' class='btn btn-xs btn-default' id='$aRow[id_post]'><i class='fa fa-pencil'></i></a>
					$tbldelete
			</div></div>";
        }
        $output['aaData'][] = $row;
	$no++;
    }

    echo json_encode( $output );
}
}
?>