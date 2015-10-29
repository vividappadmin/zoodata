<?php
/**
 * Sushi Digital Wordpress Media helper class.
 *
 * @category 	Wordpress
 * @package 	WordPress
 * @subpackage	Sushi
 * @author		~Kai~
 * @version		Version 1.0.0
 * @copyright	Copyright (c) 2013 Sushi Digital Pty. Ltd.( http://www.sushidigital.com.au )
 * @since		Class available since Release 1.0.0
 *
 */
class Sushi_WP_Media
{	
	public $ID;
	public $author;
	public $date;
	public $dateGmt;
	public $description;
	public $title;
	public $caption;
	public $status;
	public $name;
	public $url;
	public $type = 'attachment';
	public $mimeType;
	public $alt;
	public $width;
	public $height;
	public $dimensions;	
	public $sizes;
	public $fileSize;
	public $fileExt;
	
	public function __construct()
	{		
	}	
	
	public static function getMedia( array $args = null )
	{
		global $wpdb, $sushi;
		
		// persist post type to 'attachment'
		$args['post_type'] = 'attachment';
				
		foreach ( $args as $key => $val )
		{					
			$params[] = $key . '=' . quotify( $val );
		}
					
		$results = $wpdb->get_results( sprintf( 'SELECT * FROM %1$s WHERE %2$s', "{$wpdb->posts}", implode( " AND ", $params ) ) );		
		
		$medias = array();
		foreach ( $results as $media )
		{
			$meta = $wpdb->get_row( sprintf( 
				'SELECT %1$s.%3$s AS file, %2$s.%3$s AS metadata  
				FROM %4$s AS A 
				INNER JOIN %4$s AS %1$s ON %1$s.meta_key = \'_wp_attached_file\' 
				INNER JOIN %4$s AS %2$s ON %2$s.meta_key = \'_wp_attachment_metadata\' 
				WHERE %1$s.post_id = %5$s AND %2$s.post_id = %5$s', 
				"mfile", "mdata", "meta_value", "{$wpdb->postmeta}", $media->ID ));
				
			$alt = $wpdb->get_row( sprintf( 
				'SELECT %2$s.%1$s AS alt 
				FROM %2$s
				WHERE %2$s.post_id = %3$s AND meta_key = \'_wp_attachment_image_alt\'', 
				"meta_value", "{$wpdb->postmeta}", $media->ID ));
			
			$metadata = (object)unserialize( $meta->metadata );
			$subdir = str_replace( substr( $metadata->file, strrpos( $metadata->file, "/" ) + 1 ), "", $metadata->file );
			
			$obj = new Sushi_WP_Media();
			$obj->ID = $media->ID;
			$obj->author = $media->post_author;
			$obj->date = $media->post_date;
			$obj->dateGmt = $media->post_date_gmt;
			$obj->description = $media->post_content;
			$obj->title = $media->post_title;
			$obj->caption = $media->post_excerpt;
			$obj->status = $media->post_status;
			$obj->name = $media->post_name;
			$obj->url = $sushi->uploadDir['baseurl'] . '/' . $meta->file;
			$obj->type = 'attachment';
			$obj->mimeType = $media->post_mime_type;
			$obj->alt = $alt->alt;
			$obj->width = $metadata->width;
			$obj->height = $metadata->height;
			$obj->fileSize = filesize( $sushi->uploadDir['basedir'] . '/' . $meta->file );
			$obj->fileExt = pathinfo( $sushi->uploadDir['basedir'] . '/' . $meta->file, PATHINFO_EXTENSION );
					
			$tmp = unserialize( $meta->metadata );
			if ( ! empty( $tmp ) )
			{			
				$obj->dimensions = $metadata->width . ' x ' . $metadata->height;			
				$obj->sizes = array(
					'thumbnail' => (object)array(
						"url" => $sushi->uploadDir['baseurl'] . '/' . $subdir . $metadata->sizes['thumbnail']['file'],
						"width" => $metadata->sizes['thumbnail']['width'],
						"height" => $metadata->sizes['thumbnail']['height']
					),
					'medium' => (object)array(
						"url" => $sushi->uploadDir['baseurl'] . '/' . $subdir . $metadata->sizes['medium']['file'],
						"width" => $metadata->sizes['medium']['width'],
						"height" => $metadata->sizes['medium']['height']
					),
					'index-categories' => (object)array(
						"url" => $sushi->uploadDir['baseurl'] . '/' . $subdir . $metadata->sizes['index-categories']['file'],
						"width" => $metadata->sizes['index-categories']['width'],
						"height" => $metadata->sizes['index-categories']['height']
					),
					'page-single' => (object)array(
						"url" => $sushi->uploadDir['baseurl'] . '/' . $subdir . $metadata->sizes['page-single']['file'],
						"width" => $metadata->sizes['page-single']['width'],
						"height" => $metadata->sizes['page-single']['height']
					)
				);
			}
			
			$medias[] = $obj;			
		}		
		return $medias;
	}	
	
}

/*
* END OF FILE
* sushi-media.php
*/
?>