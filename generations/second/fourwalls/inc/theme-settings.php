<?php

function setup_fourwalls_admin_menus() {  
	add_theme_page(
        'Four Walls Settings', 'Theme Settings', 'edit_theme_options',   
        'fourwalls-settings', 'fourwalls_settings');  
}  
add_action("admin_menu", "setup_fourwalls_admin_menus");

function fourwalls_settings() {
	if (!current_user_can('manage_options')) {  
		wp_die('You do not have sufficient permissions to access this page.');  
	} 
	if (isset($_POST["update_settings"])) {  
		$front_middle_left = $_POST["front_middle_left"];
		$front_bottom_right = $_POST["front_bottom_right"];
		$ga_tracking_code = $_POST["ga_tracking_code"];
		$left_footer_link = $_POST["left_footer_link"];
		$right_footer_link = $_POST["right_footer_link"];
		$featured_video = $_POST["featured_video"];
		update_option("fourwalls_front_middle_left", $front_middle_left);
		update_option("fourwalls_front_bottom_right", $front_bottom_right);
		update_option("fourwalls_ga_tracking_code", $ga_tracking_code);
		update_option("fourwalls_left_footer_link", $left_footer_link);
		update_option("fourwalls_right_footer_link", $right_footer_link);
		update_option("fourwalls_featured_video", $featured_video);
		?>
		<div id="message" class="updated">Settings saved</div>  
		<?php
	}  else {
		$front_middle_left = get_option("fourwalls_front_middle_left"); 
		$front_bottom_right = get_option("fourwalls_front_bottom_right"); 
		$ga_tracking_code = get_option("fourwalls_ga_tracking_code"); 
		$left_footer_link = get_option("fourwalls_left_footer_link"); 
		$right_footer_link = get_option("fourwalls_right_footer_link");
		$featured_video = get_option("fourwalls_featured_video");
	}
	?>
	
	<div class="wrap">  
        <?php screen_icon('themes'); ?> <h2>Fourwalls Settings</h2>  
  
        <form method="POST" action="">  
			<label for="front_middle_left">  
				Front Middle Left (Donate Box): 
			</label>
			<textarea name="front_middle_left" style="width:90%;height:100px;" /><?php echo stripslashes(esc_textarea($front_middle_left)); ?></textarea> 
			<label for="front_bottom_right" style="display: block;">  
				Front Bottom Right (About NewMR Box): 
			</label>
			<textarea name="front_bottom_right" style="width:90%;height:200px;" /><?php echo stripslashes(esc_textarea($front_bottom_right)); ?></textarea> 
			<p><label for="ga_tracking_code">
				Google Analytics Tracking:
			</label>
			<input name="ga_tracking_code" style="width: 200px" value="<?php echo esc_attr($ga_tracking_code); ?>" /></p>
			<p><label for="left_footer_link">
				Left Footer Link:
			</label>
			<select name="left_footer_link">
				<option value="">--Select a Page--</option>
				<?php
				$query = new WP_Query(array(
					'post_type'	=> 'page',
					'nopaging' => true
				));
				while ($query->have_posts()): 
					$query->the_post();
					$pagename = get_post()->post_name;
				?>
				<option value="<?php echo $pagename; ?>" <?php selected( $pagename, $left_footer_link ); ?>><?php the_title(); ?></option>
				<?php endwhile; ?>
			</select></p>
			<p><label for="right_footer_link">
				Right Footer Link:
			</label>
			<select name="right_footer_link">
				<option value="">--Select a Page--</option>
				<?php
				$query = new WP_Query(array(
					'post_type'	=> 'page',
					'nopaging' => true
				));
				while ($query->have_posts()): 
					$query->the_post();
					$pagename = get_post()->post_name;
				?>
				<option value="<?php echo $pagename; ?>" <?php selected( $pagename, $right_footer_link ); ?>><?php the_title(); ?></option>
				<?php endwhile; ?>
			</select></p>
			<p><label for="featured_video">
				Featured Video:
			</label>
			<select name="featured_video" style="width: 83%;">
				<option value="">--Select a Presentation--</option>
				<?php
				$query = new WP_Query(array(
					'post_type'	=> 'presentation',
					'nopaging' => true,
					'orderby' => 'date',
					'order' => 'DESC'
				));
				while ($query->have_posts()): 
					$query->the_post();
					$name = get_post()->post_name;
				?>
				<option value="<?php echo $name; ?>" <?php selected( $name, $featured_video ); ?>><?php the_title(); ?></option>
				<?php endwhile; ?>
			</select></p>
			<input type="hidden" name="update_settings" value="Y" /> 
			<p>  
				<input type="submit" value="Save settings" class="button-primary"/>  
			</p>  
        </form>  
    </div> 
	
	<?php
}

?>