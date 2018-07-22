<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Category extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		$where = array(
			'isDeleted' => '1',
		);
		$status = $this->input->post( 'status' );
		$bar = $this->input->post( 'bar' );
		$filter = $this->input->post( 'filter' );
		if ( $status && !isset( $status[ 1 ] ) ) {
			if ( isset( $status[ 0 ] ) ) {
				$where[ 'status' ] = $status[ 0 ];
			}
		}
		if ( $bar ) {
			if ( isset( $bar[ 0 ] ) && !isset( $bar[ 1 ] ) ) {
				if ( $bar[ 0 ] == 'top' ) {
					$where[ 'isTopBar' ] = '1';
				}
				if ( $bar[ 0 ] == 'left' ) {
					$where[ 'isLeftBar' ] = '1';
				}
			}
		}
		$records = getCategoryList( $where );
		$ref = $records[ 0 ];
		$items = $records[ 1 ];

		function get_menu( $items, $class = 'dd-list' ) {
			$html = "<ol class=\"" . $class . "\" id=\"menu-id\">";
			foreach ( $items as $key => $value ) {
				$encriptedID = encode( $value[ 'category_id' ] );
				if ( $value[ 'status' ] == '1' ) {
					$ststbtn = 'Disable';
					$ststCls = 'btn-success';
				} else {
					$ststbtn = 'Enable';
					$ststCls = 'btn-default';
				}


				$fldTopBar = $value[ 'isTopBar' ] == '1' ? '<span class="btn btn-white btn-info btn-sm">Top Header</span> ' : '';
				$fldLeftBar = $value[ 'isLeftBar' ] == '1' ? '<span class="btn btn-white btn-purple btn-sm">Left Panel</span>' : '';
				$html .= '<li class="dd-item dd3-item" data-id="' . $value[ 'category_id' ] . '" >
				<div class="dd-handle dd3-handle">Drag</div>
				<div class="dd3-content">
					<div class="disIndLs">' . $value[ 'name' ] . '</div>
					<div class="actionIndLs">
						' . $fldTopBar . $fldLeftBar . '
						<a target="_blank" href="' . base_url() . 'admin/category/edit/' . $encriptedID . '" data-tooltip="tooltip" title="Edit" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
						<button type="button" data-tooltip="tooltip" data-status="' . $value[ 'status' ] . '" onclick="changeCatStatus(this, \'' . $encriptedID . '\', \'status\', \'category\')" title="Click to ' . $ststbtn . '" class="btn ' . $ststCls . ' btn-xs"><i class="fa fa-power-off"></i></button>
						<button type="button" data-tooltip="tooltip" onclick="changeCatStatus(this, \'' . $encriptedID . '\', \'delete\', \'category\')" title="Delete" class="btn btn-danger btn-xs btn-xs"><i class="fa fa-trash"></i></button>
					</div>
				</div>';
				if ( array_key_exists( 'child', $value ) ) {
					$html .= get_menu( $value[ 'child' ], 'child' );
				}
				$html .= "</li>";
			}
			$html .= "</ol>";
			return $html;
		}
		$data[ 'categoryLst' ] = get_menu( $items );

		$data[ 'activeMenu' ] = 'store';
		$data[ 'activeSubMenu' ] = 'category';
		if ( $filter ) {
			echo $data[ 'categoryLst' ];
		} else {
			$this->load->view( 'admin/category_list', $data );
		}
	}

	function add() {
		$finalOu = array();
		$catOption[] = $this->common_model->getAll( 'category_id, name, parent_id', 'category', array( 'isDeleted' => '1', 'parent_id' => '0' ), 'sort_order asc' );

		$catAray = array();
		$data[ 'catSelctIDs' ] = $finalOu;
		$data[ 'parentArayList' ] = $catOption;
		$data[ 'catAray' ] = $catAray;
		$data[ 'activeMenu' ] = 'store';
		$data[ 'activeSubMenu' ] = 'category';
		$data[ 'eCID' ] = '';
		$this->load->view( 'admin/category_data', $data );
	}

	function edit( $id = '' ) {
		$eCID = $id;
		$id = decode( $id );
		$finalOu = array();
		$catOption[] = $this->common_model->getAll( 'category_id, name, parent_id', 'category', array( 'isDeleted' => '1', 'parent_id' => '0' ), 'sort_order asc' );

		$catAray = $this->common_model->getAll( '*', 'category', array( 'isDeleted' => '1', 'category_id' => $id ) );
		if ( !$catAray ) {
			$this->load->view( 'admin/404' );
			exit;
		}

		foreach ( $catOption[ 0 ] as $key => $value ) {
			if ( $value->category_id == $catAray[ 0 ]->category_id ) {
				unset( $catOption[ 0 ][ $key ] );
			}
		}
		$pid = $catAray[ 0 ]->parent_id;
		do {
			$catListing = $this->common_model->getAll( 'category_id, name, parent_id', 'category', array( 'isDeleted' => '1', 'category_id' => $pid ), 'sort_order asc' );
			if ( $catListing ) {
				$pid = $catListing[ 0 ]->parent_id;
				$finalOu[] = json_decode( json_encode( $catListing[ 0 ] ), TRUE );
			} else {
				$pid = 0;
			}

		} while ( $pid != 0 );
		$finalOu = array_reverse( $finalOu );

		for ( $k = 0; $k < count( $finalOu ); $k++ ) {
			$catOption[] = $this->common_model->getAll( 'category_id, name, parent_id', 'category', array( 'isDeleted' => '1', 'parent_id' => $finalOu[ $k ][ 'category_id' ] ), 'sort_order asc', '', array( 'category_id' => array( $catAray[ 0 ]->category_id ) ) );
		}

		$data[ 'catSelctIDs' ] = $finalOu;
		$data[ 'parentArayList' ] = $catOption;
		$data[ 'catAray' ] = $catAray;
		$data[ 'eCID' ] = $eCID;
		$data[ 'activeMenu' ] = 'store';
		$data[ 'activeSubMenu' ] = 'category';
		$this->load->view( 'admin/category_data', $data );
	}

	function storeCatSorting() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}

		$data = json_decode( $_POST[ 'data' ] );

		function parseJsonArray( $jsonArray, $parentID = 0 ) {
			$return = array();
			foreach ( $jsonArray as $subArray ) {
				$returnSubSubArray = array();
				if ( isset( $subArray->children ) ) {
					$returnSubSubArray = parseJsonArray( $subArray->children, $subArray->id );
				}
				$return[] = array( 'category_id' => $subArray->id, 'parent_id' => $parentID );
				$return = array_merge( $return, $returnSubSubArray );
			}
			return $return;
		}
		$readbleArray = parseJsonArray( $data );

		$i = 0;
		foreach ( $readbleArray as $row ) {
			$i++;
			$data = array(
				'parent_id' => $row[ 'parent_id' ],
				'sort_order' => $i
			);
			$this->common_model->updateData( 'category', array( "category_id" => $row[ 'category_id' ] ), $data );
		}
	}

	function storeCategory() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}


		$cid = decode( $this->input->post( 'cid' ) );
		$name = $this->input->post( 'name' );
		$slug = $this->input->post( 'url_slug' );
		$metaDesc = $this->input->post( 'meta_desc' );
		$metaKey = $this->input->post( 'meta_keywords' );
		$desc = $this->input->post( 'desc' );
		$categoryID = $this->input->post( 'category' ) ? $this->input->post( 'category' ) : '0';
		$isTop = $this->input->post( 'isTop' ) ? $this->input->post( 'isTop' ) : '0';
		$isLeft = $this->input->post( 'isLeft' ) ? $this->input->post( 'isLeft' ) : '0';
		$mobileViwe = $this->input->post( 'isMobile' ) ? $this->input->post( 'isMobile' ) : '0';
		$status = $this->input->post( 'isStatus' ) ? $this->input->post( 'isStatus' ) : '0';
		$data = array(
			'parent_id' => $categoryID,
			'name' => trim($name),
			'url_slug' => trim($slug),
			'isTopBar' => trim($isTop),
			'isLeftBar' => trim($isLeft),
			'meta_description' => trim($metaDesc),
			'meta_keyword' => trim($metaKey),
			'description' => trim($desc),
			'mobile_display' => trim($mobileViwe),
			'status' => $status,
		);
		$notId = '';
		if ( $cid ) {
			$notId = array( 'category_id' => array( $cid ) );
		}

		$iCount = $this->common_model->getAll( 'count(category_id) as totl', 'category', array( 'isDeleted' => '1', 'url_slug' => $slug ), '', '', $notId );
		$iCount = $iCount[ 0 ]->totl;
		if ( $iCount > 0 ) {
			echo json_encode( array( 'status' => 'slug_error' ) );
			exit;
		}

		$avtar = $_FILES[ 'img' ][ 'name' ];
		if ( $avtar ) {
			$data[ 'image' ] = uploadFiles( 'img', $path = 'uploads/product/', 'thumb', 360, 360 );
		}
		$avtar = $_FILES[ 'icon' ][ 'name' ];
		if ( $avtar ) {
			$data[ 'icon' ] = uploadFiles( 'icon', $path = 'uploads/product/', 'thumb', 360, 360 );
		}
		if ( $cid ) {
			$this->common_model->updateData( 'category', array( 'category_id' => $cid ), $data );
			$status = 'updated';
			$id = $this->input->post( 'cid' );
		} else {
			$data[ 'created_on' ] = date( "Y-m-d H:i:s", time() );
			$id = $this->common_model->saveData( 'category', $data );
			$status = 'added';
			$id = encode( $id );
		}
		echo json_encode( array( 'status' => $status, 'id' => $id ) );
	}

	function generateURLSlug() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		$catName = $this->input->post( 'data' );
		$type = $this->input->post( 'type' );
		$notId = $this->input->post( 'notId' );
		if ( $notId ) {
			$notId = array( 'category_id' => array( decode( $notId ) ) );
		}
		$slug = slugify( $catName );


		$iCount = $this->common_model->getAll( 'count(category_id) as totl', 'category', array( 'isDeleted' => '1', 'url_slug' => $slug ), '', '', $notId );
		$iCount = $iCount[ 0 ]->totl;

		if ( $iCount > 0 && $type == 'cat' ) {
			$iTotalAry = $this->manual_model->findDubliSlug( $slug, 'category' );
			$iTotal = $iTotalAry[ 0 ]->iTotal;
			$slug = $slug . ( $iTotal );
		}
		if ( $type == 'slug' ) {
			echo json_encode( array( 'status' => $iCount > 0 ? 'error' : 'success' ) );
		} else if ( $type == 'cat' ) {
			echo json_encode( array( 'slug' => $slug ) );
		}

	}

	function getCategoryChield( $cId = '0' ) {
		if ( !AID ) {
			exit( 'Unauthorized Access' );
		}
		$catId = $this->input->post( 'id' ) ? $this->input->post( 'id' ) : $cId;
		$notId = $this->input->post( 'notId' );
		if ( $notId ) {
			$notId = array( 'category_id' => array( decode( $notId ) ) );
		}
		$result = $this->common_model->getAll( 'category_id, name, parent_id', 'category', array( 'isDeleted' => '1', 'parent_id' => $catId ), 'sort_order asc', '', $notId );
		if ( $this->input->post( 'id' ) ) {
			echo json_encode( $result );
		} else {
			return ( $result );
		}
	}
}