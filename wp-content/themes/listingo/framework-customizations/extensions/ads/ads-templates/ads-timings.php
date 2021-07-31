<?php 
/*
* @Template file to show timing details
*/
global $post;
$time_details 	= get_post_meta( $post->ID, '_time_details', true );
$time_zone 		= get_post_meta( $post->ID, '_timezone', true );				

if( !empty( $time_details ) ) {
	$dateFormat = "Y:m:d H:i:s";	
	$current_time_date = date($dateFormat, time());	
	$today_day = date('l', strtotime($current_time_date));

	$week_key	= listingo_get_week_array_key();
?>
<div class="tg-sectionpaddingvtwo tg-businesshours tg-businesshoursvtwo">
	<div class="tg-sectiontitlevthree text-left">
		<h2><?php esc_html_e('Business Hours', 'listingo'); ?></h2>
		<?php if( !empty( $time_zone  ) ){?>
			<span><strong><?php esc_html_e('Listing Timezone','listingo');?></strong>:&nbsp;<?php echo esc_attr( $time_zone );?></span>
		<?php }?>
	</div>
	<?php 		
	foreach ( $time_details as $key => $time ) {  
		if ( strpos($today_day, ucfirst(substr($key, 0, 3))) !== false ) {						
			$time_class = 'tg-timeactive';
		} else {						
			$time_class = '';
		}
		?>
		<ul class="tg-businesshoursholder tg-shiftsdays">
			<li><span><?php echo esc_attr($week_key[$key]); ?></span></li>
			<?php 		
				$starttime 	= !empty( $time['starttime'] ) ?  $time['starttime'] : '';
				$endtime 	= !empty( $time['endtime'] ) ? $time['endtime'] : '';	
				$off_day 	= !empty( $time['off_day'] ) ? $time['off_day'] : 'false';			
				$starttime 	= !empty( $starttime ) ? date("g:i a", strtotime($starttime) ) : '';
				$endtime 	= !empty( $endtime ) ? date("g:i a", strtotime($endtime) ) : '';	
				if( $off_day == 'true' || empty( $starttime ) || empty( $endtime ) ) {?>
					<li class="<?php echo esc_attr( $time_class ); ?>"><span><?php esc_html_e('Closed', 'listingo'); ?></span></li>
				<?php } else { ?>			
					<li class="<?php echo esc_attr( $time_class ); ?>">
						<span><?php echo esc_attr( $starttime ); ?></span><span><?php echo esc_attr( $endtime ); ?>
						</span>
					</li> 
			<?php } ?>				
		</ul>
	<?php } ?>	
</div>
<?php } 