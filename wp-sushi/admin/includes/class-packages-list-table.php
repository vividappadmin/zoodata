<?php
/**
 * Sushi WordPress Starter System
 * Copyright (C) 2013-2014, Sushi Digital Pty. Ltd. - http://sushidigital.com.au
 * 
 * This program is not a free software; this program is an intellectual
 * property of Sushi Digital Pty. Ltd. and CANNOT be REDISTRIBUTED, COPIED, 
 * MODIFIED or USED by ANY MEANS outside and/or unrelated to the company.
 * Disregarding this copyright notice is an act of copyright infringement, 
 * and is subject to civil and criminal penalties.
 */

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Sushi_Packages_List_Table extends WP_List_Table
{
	function __contruct()
	{
		global $status, $page;
		
		parent::__construct( array(	
			'singular'	=> 'swp_package',
			'plural'	=> 'swp_packages',
			'ajax'		=> false
		) );
	}
	
	public function prepare_items()
	{
		$columns	= $this->get_columns();
		$hidden		= $this->get_hidden_columns();
		$sortable	= $this->get_sortable_columns();
		
		$data		= $this->get_packages();		
		
		$perpage	= 10;
		$current	= $this->get_pagenum();
		$totalItems = count( $data );
		
		$this->set_pagination_args( array(
			'total_items'	=> $totalItems,
			'per_page'		=> $perpage,
			'total_pages'	=> ceil( $totalItems / $perpage )
		) );
		
		$data		= array_slice( $data, ( ( $current-1 ) * $perpage ), $perpage );
		
		$this->_column_headers	= array( $columns, $hidden, $sortable );
		$this->items			= $data;
	}
	
	function column_title( $item )
	{
        $actions = array(
            'activate'      => sprintf( '<a href="?page=%s&action=%s&package=%s">Activate</a>', $_REQUEST['page'], 'activate', $item['UniqueID'] ),
            'deactivate'    => sprintf( '<a href="?page=%s&action=%s&package=%s">Deactivate</a>', $_REQUEST['page'], 'deactivate', $item['UniqueID'] ),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['Name'],
            /*$2%s*/ $item['UniqueID'],
            /*$3%s*/ $this->row_actions( $actions )
        );
    }
	
	public function column_default( $item, $column_name )
    {		
        switch( $column_name ) {		
            case 'name':
            case 'description':
			case 'action':
                return $item[ $column_name ];
 
            default:
                return print_r( $item, true ) ;
        }
    }
	
	public function get_columns()
	{
		$columns	= array(			
			'name'			=> 'Package',
			'description'	=> 'Description',
			'action'		=> 'Action'
		);
		return $columns;
	}
	
	public function get_hidden_columns()
	{
		return array(
			
		);
	}
	
	public function get_sortable_columns()
	{
		return array();
	}
	
	public function get_packages()
	{
		$packages	= SushiWP()->get_packages();
		$data		= array();
		
		$active		= SushiWP()->swp_get_option( 'active_package' );
		
		foreach ( $packages as $index => $package ) {		
			$data[$index]['id'] 			= $package['UniqueID'];
			$data[$index]['name'] 			= $package['Name'];
			$data[$index]['description'] 	= $package['Description'];
			$data[$index]['version'] 		= $package['Version'];
			$data[$index]['author'] 		= $package['Authors'];
			$data[$index]['path'] 			= $package['dir'];
			$data[$index]['preview'] 		= $package['preview'];
			$data[$index]['action'] 		= ' ';
			$data[$index]['active']			= ( $package['UniqueID'] === $active ) ? true : false;
			$data[$index]['default'] 		= ( $package['UniqueID'] === SWP_DEFAULT_PACKAGE ) ? true : false;
		}
		
		return $data;
	}
	
	public function single_row( $item )
	{
		static $row_class = '', $row_id = '';
		$row_id		= ( $row_id == '' ? sprintf( ' id="%s"', $item['id'] ) : '' );
		$row_class  = ( $row_class == '' ? sprintf( ' class="package-item package-%s"', $item['id'] ) : '' );

		echo '<tr' . $row_id . $row_class . '>';
		$this->single_row_columns( $item );
		echo '</tr>';
	}
	
	function column_name( $item )
	{
		$obj 	= (object)$item;
		$html	= sprintf( '<strong %s>%s</strong><br /><span class="ver">Version: %s</span>', ( $obj->active ) ? ' class="active"' : '', $obj->name, $obj->version );
		
		return $html;
	}
	
	function column_action( $item )
	{		
		$obj 		= (object)$item;
		$action 	= 'activate';		
		$button 	= 'Activate';
		$class		= 'button button-secondary';
		$disabled 	= false;
		$onclick	= '';
		
		if ( $obj->active ) {
			$action = 'deactivate';
			$button = 'Deactivate';
			$class .= ' deactivate-package';
			
			if ( $obj->default ) {
				$button 	= 'Default';
				$class 		.= ' default-package';
				$disabled 	= true;
				$onclick	= ' onclick="return false;"';
			}
		} else {
			$class .= ' activate-package';
		}
		
		$html	= sprintf( '<a href="?page=%s&action=%s&package=%s" class="%s" %s %s>%s</a>', $_REQUEST['page'], $action, $obj->id, $class, ( $disabled ) ? ' disabled="disabled"' : '', $onclick, $button );
		
		return $html;
	}
}

/**
 * END OF FILE
 * admin/includes/class-packages-list-table.php
 */
?>