<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

	$aColumns= array( "id_komunitas", "nama", "alamat", "email", "facebook", "twitter", "skill", "lat", "lng", "status", );

    $sIndexColumn = "id_komunitas";

    $sTable = "komunitas";

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
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }

    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
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

    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
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
        for ( $i=1 ; $i<count($aColumns) ; $i++ )
        {
			$str = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$strlink = preg_replace("/\/po-adminboard\/po-component\/po-komunitas\/(datatable\.php$)/","",$str);
			$tbldelete = "<a class='btn btn-xs btn-danger alertdel' id='$aRow[id_komunitas]'><i class='fa fa-times'></i></a>";
            $tbl_setuju = "<a class='btn btn-xs btn-default setuju' id='$aRow[id_komunitas]'><i class='fa fa-check'></i></a>";
			$checkdata = "<div class='text-center'><input type='checkbox' id='titleCheckdel' /><input type='hidden' class='deldata' name='item[$no][deldata]' value='$aRow[id_komunitas]' disabled></div>";
			$row[] = $checkdata;
			$row[] = $aRow['nama'];
			$row[] = "Alamat : ".$aRow['alamat']."<br> Email : ".$aRow['email']."<br> Facebook : ".$aRow['facebook']."<br> Twitter : ".$aRow['twitter'];
			$row[] = $aRow['skill'];
			$row[] = $aRow['status'];
			$row[] = "<div class='text-center'><div class='btn-group btn-group-xs'>
				<a href='admin.php?mod=komunitas&act=edit&id=$aRow[id_komunitas]' class='btn btn-xs btn-default' id='$aRow[id_komunitas]'><i class='fa fa-pencil'></i></a>
				$tbl_setuju
                $tbldelete
			</div></div>";
        }
        $output['aaData'][] = $row;
	$no++;
    }

    echo json_encode( $output );
}
?>