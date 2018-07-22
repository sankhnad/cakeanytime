<?php
if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
class DataTblModel extends CI_Model {
	function __construct() {

	}
	function get_cd_list($tbl, $sIndexColumn, $aColumns=array(), $cWHERE='1 = 1',$orderColm, $inData='') {
		/* Total data set length */
		$sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $tbl WHERE" . $cWHERE.' '.$inData;
		$rResultTotal = $this->db->query( $sQuery );
		$aResultTotal = $rResultTotal->row();
		$iTotal = $aResultTotal->row_count;

		/*
		 * Paging
		 */
		$sLimit = "";
		$iDisplayStart = $this->input->get_post( 'start', true );
		$iDisplayLength = $this->input->get_post( 'length', true );
		if ( isset( $iDisplayStart ) && $iDisplayLength != '-1' ) {
			$sLimit = "LIMIT " . intval( $iDisplayStart ) . ", " .
			intval( $iDisplayLength );
		}
		$uri_string = http_build_query($this->input->post());
		//$uri_string = http_build_query($this->input->get());
		$uri_string = preg_replace( "/%5B/", '[', $uri_string );
		$uri_string = preg_replace( "/%5D/", ']', $uri_string );

		$get_param_array = explode( "&", $uri_string );
		$arr = array();
		foreach ( $get_param_array as $value ) {
			$v = $value;
			$explode = explode( "=", $v );
			$arr[ $explode[ 0 ] ] = $explode[ 1 ];
		}

		$index_of_columns = strpos( $uri_string, "columns", 1 );
		$index_of_start = strpos( $uri_string, "start" );
		$uri_columns = substr( $uri_string, 7, ( $index_of_start - $index_of_columns - 1 ) );
		$columns_array = explode( "&", $uri_columns );
		$arr_columns = array();
		foreach ( $columns_array as $value ) {
			$v = $value;
			$explode = explode( "=", $v );
			if ( count( $explode ) == 2 ) {
				$arr_columns[ $explode[ 0 ] ] = $explode[ 1 ];
			} else {
				$arr_columns[ $explode[ 0 ] ] = '';
			}
		}

		/*
		 * Ordering
		 */
		$sOrder = '';
		$sOrderIndex = isset( $arr[ 'order[0][column]' ] ) ? $arr[ 'order[0][column]' ] : $orderColm;
		$sOrderDir = isset( $arr[ 'order[0][dir]' ] ) ? $arr[ 'order[0][dir]' ] : 'desc';
		$bSortable_ = $arr_columns[ 'columns[' . $sOrderIndex . '][orderable]' ];
		if ( $bSortable_ == "true" ) {
			$sOrder = "ORDER BY ";
			$sOrder .= $aColumns[ $sOrderIndex ] . ( $sOrderDir === 'asc' ? ' asc' : ' desc' );
		}

		/*
		 * Filtering
		 */
		$sWhere = "";
		$sSearchVal = urldecode($arr[ 'search[value]' ]);
		if ( isset( $sSearchVal ) && $sSearchVal != '' ) {
			$sWhere = "WHERE (";
			for ( $i = 0; $i < count( $aColumns ); $i++ ) {
				$sWhere .= $aColumns[ $i ] . " LIKE '%" . $this->db->escape_like_str( $sSearchVal ) . "%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		/* Individual column filtering */
		//$sSearchReg = $arr[ 'search[regex]' ];
//		
//		for ( $i = 0; $i < count( $aColumns ); $i++ ) {
//			$bSearchable_ = $arr[ 'columns[' . $i . '][searchable]' ];
//			if ( isset( $bSearchable_ ) && $bSearchable_ == "true" && $sSearchReg != 'false' ) {
//				$search_val = $arr[ 'columns[' . $i . '][search][value]' ];
//				if ( $sWhere == "" ) {
//					$sWhere = "WHERE ";
//				} else {
//					$sWhere .= " AND ";
//				}
//				$sWhere .= $aColumns[ $i ] . " LIKE '%" . $this->db->escape_like_str( $search_val ) . "%' ";
//			}
//		}
		
		if($sWhere == ""){
			$fWHERE = 'WHERE '.$cWHERE;
		}else{
			$fWHERE = 'AND '.$cWHERE;
		}

		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . "
        FROM $tbl
        $sWhere
		$fWHERE
		$inData
        $sOrder
        $sLimit
        ";
		//echo $sQuery;
		$rResult = $this->db->query( $sQuery );
		
		/* Data set length after filtering */
		$sQuery = "SELECT FOUND_ROWS() AS length_count";
		$rResultFilterTotal = $this->db->query( $sQuery );
		$aResultFilterTotal = $rResultFilterTotal->row();
		$iFilteredTotal = $aResultFilterTotal->length_count;

		/*
		 * Output
		 */
		$sEcho = $this->input->get_post( 'draw', true );
		$output = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $iTotal,
			"recordsFiltered" => $iFilteredTotal,
			"data" => array()
		);
		
		$output['tempData'] = $rResult->result_array();
		return $output;
	}
	
	
	function multi_tbl_list($aColumns=array(), $orderColm='0', $sOrderDir='desc') {
		/*
		 * Paging
		 */
		$sLimit = "";
		$iDisplayStart = $this->input->get_post( 'start', true );
		$iDisplayLength = $this->input->get_post( 'length', true );
		if ( isset( $iDisplayStart ) && $iDisplayLength != '-1' ) {
			$sLimit = "LIMIT " . intval( $iDisplayStart ) . ", " .
			intval( $iDisplayLength );
		}
		$uri_string = http_build_query($this->input->post());
		$uri_string = preg_replace( "/%5B/", '[', $uri_string );
		$uri_string = preg_replace( "/%5D/", ']', $uri_string );

		$get_param_array = explode( "&", $uri_string );
		$arr = array();
		foreach ( $get_param_array as $value ) {
			$v = $value;
			$explode = explode( "=", $v );
			$arr[ $explode[ 0 ] ] = $explode[ 1 ];
		}

		$index_of_columns = strpos( $uri_string, "columns", 1 );
		$index_of_start = strpos( $uri_string, "start" );
		$uri_columns = substr( $uri_string, 7, ( $index_of_start - $index_of_columns - 1 ) );
		$columns_array = explode( "&", $uri_columns );
		$arr_columns = array();
		foreach ( $columns_array as $value ) {
			$v = $value;
			$explode = explode( "=", $v );
			if ( count( $explode ) == 2 ) {
				$arr_columns[ $explode[ 0 ] ] = $explode[ 1 ];
			} else {
				$arr_columns[ $explode[ 0 ] ] = '';
			}
		}

		/*
		 * Ordering
		 */
		$sOrder = '';
		$sOrderIndex = isset( $arr[ 'order[0][column]' ] ) ? $arr[ 'order[0][column]' ] : $orderColm;
		$sOrderDir = isset( $arr[ 'order[0][dir]' ] ) ? $arr[ 'order[0][dir]' ] : $sOrderDir;
		$bSortable_ = $arr_columns[ 'columns[' . $sOrderIndex . '][orderable]' ];
		if ( $bSortable_ == "true" ) {
			$sOrder = "ORDER BY ";
			$string=trim($aColumns[$sOrderIndex]);
			$expStr=explode(" ",$string);
			$sOrder .= end($expStr) . ( $sOrderDir === 'asc' ? ' asc' : ' desc' );
		}

		/*
		 * Filtering
		 */
		$sWhere = "";
		$sSearchVal = urldecode($arr[ 'search[value]' ]);
		if ( isset( $sSearchVal ) && $sSearchVal != '' ) {
			$sWhere = "WHERE (";
			for ( $i = 0; $i < count( $aColumns ); $i++ ) {
				//$sWhere .= $aColumns[ $i ] . " LIKE '%" . $this->db->escape_like_str( $sSearchVal ) . "%' OR ";
				
				$string=trim($aColumns[$i]);
				if(strpos($string, ' ')){
					continue;
				}
				$sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($sSearchVal) . "%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		$output = array(
			'where' => $sWhere,
			'order' => $sOrder,
			'limit' => $sLimit,
		);
		return $output;
	}

}