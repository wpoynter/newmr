<?php 
$connected = new WP_Query(array(
	'connected_type' => 'presentation_to_person',
	'connected_items' => get_post(),
	'nopaging' => true,
));
$title = get_the_title();
$permalink = get_permalink();
$slides = get_post_meta(get_the_ID(), 'presentation_slides', true);
$persons = array();
while ($connected->have_posts()) {
	$connected->the_post();
	$persons[] = '<a href="' . get_permalink() . '" >' . get_the_title() . '</a>';
}
wp_reset_postdata();
$people = implode(', ', $persons);
?>
<tr class="spacer"></tr>
<tr>
	<td class="speaker-col"><?php echo $people; ?></td>
	<td class="title-col"><?php echo $title; ?></td>
	<td class="watch watch-col"><a href="<?php echo $permalink; ?>" rel="bookmark"></a></td>
	<td class="download download-col">
		<?php echo (strlen($slides) > 1 ? '<a href="' . $slides . '" onClick="ga(\'send\', \'event\', \'Booth\', \'Click\', \'' . $title . '\');" ></a>' : ''); ?>
	</td>
</tr>