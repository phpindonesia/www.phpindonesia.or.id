<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$tableroleaccess = new PoTable('user_role');
$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, comment);
$currentRoleAccess = $currentRoleAccess->current();

if($currentRoleAccess->read_access == "Y"){

    $aColumns = array( 'id_comment', 'id_post', 'name', 'email', 'url', 'date', 'time', 'active', 'status' );

    $sIndexColumn = "id_comment";

    $sTable = "comment";

    $gaSql['user']       = DATABASE_USER;
    $gaSql['password']   = DATABASE_PASS;
    $gaSql['db']         = DATABASE_NAME;
    $gaSql['server']     = DATABASE_HOST;
	$gaSql['port']     	 = DATABASE_PORT;

    $gaSql['link'] = pg_connect(
        " host=".$gaSql['server'].
		" port=".$gaSql['port'].
        " dbname=".$gaSql['db'].
        " user=".$gaSql['user'].
        " password=".$gaSql['password']
    ) or die('Could not connect: ' . pg_last_error());

    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['iDisplayLength'] )." OFFSET ".
            intval( $_GET['iDisplayStart'] );
    }

    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc').", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }

    $sWhere = "";
    if ( $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $_GET['bSearchable_'.$i] == "true" )
            {
                if ($aColumns[$i] == 'id_comment' OR $aColumns[$i] == 'id_post' OR $aColumns[$i] == 'date') {
					$wcol = "cast({$aColumns[$i]} as text)";
				} else {
					$wcol = $aColumns[$i];
				}
                $sWhere .= $wcol." ILIKE '%".pg_escape_string( $_GET['sSearch'] )."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ")";
    }

    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            if ($aColumns[$i] == 'id_comment' OR $aColumns[$i] == 'id_post' OR $aColumns[$i] == 'date') {
				$wcol = "cast({$aColumns[$i]} as text)";
			} else {
				$wcol = $aColumns[$i];
			}
            $sWhere .= $wcol." ILIKE '%".pg_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }

    $sQuery = "
        SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";
	$rResult = pg_query( $gaSql['link'], $sQuery ) or die(pg_last_error());

    $sQuery = "
        SELECT $sIndexColumn
        FROM   $sTable
    ";
    $rResultTotal = pg_query( $gaSql['link'], $sQuery ) or die(pg_last_error());
    $iTotal = pg_num_rows($rResultTotal);
    pg_free_result( $rResultTotal );
     
    if ( $sWhere != "" )
    {
        $sQuery = "
            SELECT $sIndexColumn
            FROM   $sTable
            $sWhere
        ";
        $rResultFilterTotal = pg_query( $gaSql['link'], $sQuery ) or die(pg_last_error());
        $iFilteredTotal = pg_num_rows($rResultFilterTotal);
        pg_free_result( $rResultFilterTotal );
    }
    else
    {
        $iFilteredTotal = $iTotal;
    }

    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );

	$no = 1;
    while ( $aRow = pg_fetch_array($rResult, null, PGSQL_ASSOC) )
    {
        $row = array();
		$tableroleaccess = new PoTable('user_role');
		$currentRoleAccess = $tableroleaccess->findByAnd(id_level, $_SESSION['leveluser'], module, 'comment');
		$currentRoleAccess = $currentRoleAccess->current();
        for ( $i=1 ; $i<count($aColumns) ; $i++ )
        {
			$valid = $aRow['id_post'];
			$tablepost = new PoTable('post');
			$currentPost = $tablepost->findBy(id_post, $valid);
			$currentPost = $currentPost->current();
			$urlcar = addhttp($aRow['url']);
			if ($aRow['status'] == "Y"){
				$readdata = "<a class='btn btn-xs btn-success'><i class='fa fa-circle-o'></i></a>";
			}else{
				$readdata = "<a class='btn btn-xs btn-success readdata' id='$aRow[id_comment]'><i class='fa fa-circle' id='read$aRow[id_comment]'></i></a>";
			}
			if($currentRoleAccess->delete_access == "Y"){
				$tbldelete = "<a class='btn btn-xs btn-danger alertdel' id='$aRow[id_comment]'><i class='fa fa-times'></i></a>";
			}
			$checkdata = "<div class='text-center'><input type='checkbox' id='titleCheckdel' /><input type='hidden' class='deldata' name='item[$no][deldata]' value='$aRow[id_comment]' disabled></div>";
			$row[] = $checkdata;
			$row[] = $aRow['id_comment'];
			$row[] = "<a href='../detailpost/$currentPost->seotitle' target='_blank'>$currentPost->title</a>";
			$row[] = $aRow['name'];
			$row[] = $aRow['email'];
			$row[] = "<a href='$urlcar' target='_blank'>Website</a>";
			$row[] = "<div class='text-center'>
					$aRow[date], $aRow[time]
			</div>";
			$row[] = "<div class='text-center'>
					<span id='activespan$aRow[id_comment]'>$aRow[active]</span>
			</div>";
			$row[] = "<div class='text-center' style='width:100px;'><div class='btn-group btn-group-xs'>
					<a class='btn btn-xs btn-primary tblapprove' id='$aRow[id_comment]'><i class='fa fa-star'></i></a>
					$readdata
					<a class='btn btn-xs btn-default viewdata' id='$aRow[id_comment]'><i class='fa fa-eye'></i></a>
					$tbldelete
			</div></div>";
        }
        $output['aaData'][] = $row;
	$no++;
    }

    echo json_encode( $output );

	pg_free_result( $rResult );

    pg_close( $gaSql['link'] );
}
}
?>