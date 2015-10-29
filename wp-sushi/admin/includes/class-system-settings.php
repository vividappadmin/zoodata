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
 
class Sushi_SystemSettings
{
	var $id;

	var $page;

	var $active_tab;
		
	var $tabs = array();
	
	function __construct( $page, $group )
	{
		if ( gettype( $page  ) !== 'string' && ! empty( $page ) ) {
			throw new Exception( 'Please specify the page. Must be string without space.' );
		}

		if ( gettype( $group  ) !== 'string' && ! empty( $group ) ) {
			throw new Exception( 'Please specify a group name. Must be string without space.' );
		}
		
		$this->page = sanitize_title( $page );
		$this->id 	= sanitize_title( $group );
	}

	function authenticate( $tab )
	{
		if ( ! current_user_can( $this->tabs[$tab]['cap'] ) ) {
			wp_die( '<p>&ldquo;A very unpleasant time to be lost my friend; the night is dark and full of terrors.&rdquo;</p>' );
		}

		$this->active_tab = $tab;
	}
	
	function add_setting_tab( $slug, $title, $callback, $cap = 'activate_plugins' )
	{
		$slug = sanitize_title( $slug );
		
		foreach ( $this->tabs as $t ) {
			if ( $slug == $t['id'] ) {
				throw new Exception( 'The slug already exists, it must be unique.' );
				return false;
			}
		}
	
		$tab = array(
			'id'		=> $slug,
			'title'		=> $title,
			'callback'	=> $callback,
			'cap'		=> $cap
		);
		
		if ( current_user_can( $cap ) ) {
			$this->tabs[$slug] = $tab; 
		}
	}
	
	function do_settings()
	{
		settings_fields( $this->id . '-' . $this->active_tab );
		do_settings_sections( $this->id . '-' . $this->active_tab );
	}
	
	function render_tabs()
	{?>
			<div id="settings-tabs" class="tab-control-tabs">
				<ul>
				<?php foreach ( $this->tabs as $t ) : ?>				
					<li data="#<?php echo $t['id']; ?>" class="<?php echo ( $this->active_tab === $t['id'] ) ? ' active' : ''; ?>"><h3><a href="?page=<?php echo $this->page; ?>&tab=<?php echo $t['id']; ?>"><?php echo $t['title']; ?></a></h3></li>
				<?php endforeach; ?>
				</ul>
			</div>
	<?php		
	}
	
	function render_panels()
	{?>
			<div id="settings-panels" class="tab-control-panels">
			<?php			
				echo sprintf( '<div id="%1$s" class="settings-panel tab-control-panel%2$s">%3$s', $this->active_tab, ' active', PHP_EOL );
				call_user_func( $this->tabs[$this->active_tab]['callback'] );
				echo PHP_EOL . '</div>';		
			?>
			</div>
	<?php		
	}
	
	function render_settings()
	{
		if ( ! empty( $this->tabs ) ) :			
			$this->do_settings(); ?>
		<div id="settings-tab-control" class="tab-control">
		<?php
			$this->render_tabs();
			$this->render_panels();
			submit_button();
		?>
		</div>
		<?php else : ?>
		<div id="message" class="error"><p>There is currently no available settings for this configuration, or your access level is just not high enough. Oh, well.</p></div>
		<?php endif;
	}
}
?>