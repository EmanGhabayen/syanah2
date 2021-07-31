<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of class-out-authors-widget
 *
 * @author ab
 */
if ( !class_exists( 'Listingo_Tweets' ) ) {

	class Listingo_Tweets extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'listingo_tweets', // Base ID
				esc_html__( 'Tweets | Listingo', 'listingo_core' ), // Name
				array( 'classname' => 'tg-widgettwitter',
					'description' => esc_html__( 'Show latest tweets.', 'listingo_core' ), ) // Args
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public
		function widget( $args, $instance ) {
			// outputs the content of the widget
			$counter = rand( 10, 99999 );
			extract( $instance );
			$username = isset( $username ) && !empty( $username ) ? $username : 'envato';
			$no_of_tweets = isset( $no_of_tweets ) && !empty( $no_of_tweets ) ? $no_of_tweets : 3;
			$title = isset( $instance[ 'title' ] ) && !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';

			$tweets = $this->prepare_tweets( $username, $no_of_tweets );

			echo( $args[ 'before_widget' ] );
			?>
			<?php
			if ( !empty( $title ) ) {
				echo( $args[ 'before_title' ] . apply_filters( 'widget_title', esc_attr( $title ) ) . $args[ 'after_title' ] );
			}

			if ( isset( $tweets[ 'data' ] ) && !empty( $tweets[ 'data' ] ) ) {
				?>
				<div class="tg-widgetcontent">
					<ul>
						<?php echo force_balance_tags($tweets['data']); ?>
					</ul>
				</div>
				<?php } else {?>
				<div class="txt-box">
					<p>
						<?php esc_html_e('Sorry! No tweets found','listingo_core');?>
					</p>
				</div>
				<?php } ?>
				<?php
				echo( $args[ 'after_widget' ] );
			}

			/**
			 * @get Tweets
			 *
			 */
			public
			function prepare_tweets( $username, $numoftweets ) {
				try {

					$username = html_entity_decode( $username );
					$json = array();

					if ( empty( $numoftweets ) ) {
						$numoftweets = 2;
					}

					if ( strlen( $username ) > 1 ) {

						$text = '';
						$return = '';

						$json[ 'data' ] = '';
						$json[ 'followers' ] = '';
						$cacheTime = 10000;
						$transName = 'latest-tweets';
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'libraries/twitter/twitteroauth.php';
						
						if( function_exists('fw_get_db_settings_option') ){
							$get_consumerkey = fw_get_db_settings_option( 'consumer_key', $default_value = null );
							$get_consumersecret = fw_get_db_settings_option( 'consumer_secret', $default_value = null );
							$get_accesstoken = fw_get_db_settings_option( 'access_token', $default_value = null );
							$get_accesstokensecret = fw_get_db_settings_option( 'access_token_secret', $default_value = null );
						}

						$consumerkey = isset( $get_consumerkey ) ? $get_consumerkey : '';
						$consumersecret = isset( $get_consumersecret ) ? $get_consumersecret : '';
						$accesstoken = isset( $get_accesstoken ) ? $get_accesstoken : '';
						$accesstokensecret = isset( $get_accesstokensecret ) ? $get_accesstokensecret : '';
						$connection = new TwitterOAuth( $consumerkey, $consumersecret, $accesstoken, $accesstokensecret );
						if ( empty( $consumerkey ) || empty( $consumersecret ) ) {
							return '';
						}
						$tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $numoftweets );

						if ( !empty( $tweets ) ) {
							if ( !is_wp_error( $tweets )and is_array( $tweets ) ) {
								set_transient( $transName, $tweets, 60 * $cacheTime );
							} else {
								$tweets = get_transient( 'latest-tweets' );
							}
							delete_transient( 'latest-tweets' );
							if ( !is_wp_error( $tweets )and is_array( $tweets ) ) {

								$rand_id = rand( 5, 300 );
								$exclude = 0;
								foreach ( $tweets as $tweet ) {
									$exclude++;
									//if($exclude > 1 ){                                
									$text = $tweet->{'text'};
									$text = substr( $text, 0, 100 );
									foreach ( $tweet->{'user'} as $type => $userentity ) {
										if ( $type == 'profile_image_url' ) {
											$profile_image_url = $userentity;
										} else if ( $type == 'screen_name' ) {
											$screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="colrhover" title="' . $userentity . '">@' . $userentity . '</a>';
										}
									}

									foreach ( $tweet->{'entities'} as $type => $entity ) {
										if ( $type == 'hashtags' ) {
											foreach ( $entity as $j => $hashtag ) {
												$update_with_link = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&amp;src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
												$update_with = $hashtag->{'text'};
												$text = str_replace( '#' . $hashtag->{'text'}, $update_with, $text );
											}

										}
									}

									$large_ts = time();
									$n = $large_ts - strtotime( $tweet->{'created_at'} );
									if ( $n < ( 60 ) ) {
										$posted = sprintf( esc_html__( '%d seconds ago', 'listingo_core' ), $n );
									} elseif ( $n < ( 60 * 60 ) ) {
										$minutes = round( $n / 60 );
										$posted = sprintf( _n( 'About a Minute Ago', '%d Minutes Ago', $minutes, 'listingo_core' ), $minutes );
									} elseif ( $n < ( 60 * 60 * 16 ) ) {
										$hours = round( $n / ( 60 * 60 ) );
										$posted = sprintf( _n( 'About an Hour Ago', '%d Hours Ago', $hours, 'listingo_core' ), $hours );
									} elseif ( $n < ( 60 * 60 * 24 ) ) {
										$hours = round( $n / ( 60 * 60 ) );
										$posted = sprintf( _n( 'About an Hour Ago', '%d Hours Ago', $hours, 'listingo_core' ), $hours );
									} elseif ( $n < ( 60 * 60 * 24 * 6.5 ) ) {
										$days = round( $n / ( 60 * 60 * 24 ) );
										$posted = sprintf( _n( 'About a Day Ago', '%d Days Ago', $days, 'listingo_core' ), $days );
									} elseif ( $n < ( 60 * 60 * 24 * 7 * 3.5 ) ) {
										$weeks = round( $n / ( 60 * 60 * 24 * 7 ) );
										$posted = sprintf( _n( 'About a Week Ago', '%d Weeks Ago', $weeks, 'listingo_core' ), $weeks );
									} elseif ( $n < ( 60 * 60 * 24 * 7 * 4 * 11.5 ) ) {
										$months = round( $n / ( 60 * 60 * 24 * 7 * 4 ) );
										$posted = sprintf( _n( 'About a Month Ago', '%d Months Ago', $months, 'listingo_core' ), $months );
									} elseif ( $n >= ( 60 * 60 * 24 * 7 * 4 * 12 ) ) {
										$years = round( $n / ( 60 * 60 * 24 * 7 * 52 ) );
										$posted = sprintf( _n( 'About a year Ago', '%d years Ago', $years, 'listingo_core' ), $years );
									}


									$json[ 'data' ] .= '<li><div class="tg-description">';
									$json[ 'data' ] .= '<p>' . $text . '</p>';
									$json[ 'data' ] .= '</div>';
									$json[ 'data' ] .= '<time datetime="' . date( 'Y-m-d', strtotime( $posted ) ) . '">' . $posted . '</time>' . '</li>';
								}
							}
							return $json;
						} else {
							if ( isset( $tweets->errors[ 0 ] ) && $tweets->errors[ 0 ] <> "" ) {
								return $json[ 'data' ] = '<li>' . $tweets->errors[ 0 ]->message . "</li>";
							} else {
								return $json[ 'data' ] = '<li>' . esc_html__( 'No Tweets Found', 'listingo_core' ) . '</li>';
							}
						}
					} else {
						return $json[ 'data' ] = '<li>' . esc_html__( 'No Tweets Found', 'listingo_core' ) . '</li>';
					}
				} catch ( Exception $ex ) {
					return $json[ 'data' ] = '<li>' . esc_html__( 'An error occurred, please try again later.', 'listingo_core' ) . '</li>';
				}
			}

			/**
			 * Outputs the options form on admin
			 *
			 * @param array $instance The widget options
			 */
			public
			function form( $instance ) {
				// outputs the options form on admin
				$title = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html__( 'Tweets', 'listingo_core' );
				$username = !empty( $instance[ 'username' ] ) ? $instance[ 'username' ] : '';
				$no_of_tweets = !empty( $instance[ 'no_of_tweets' ] ) ? $instance[ 'no_of_tweets' ] : '';
				?>
				<p>
					<label for="<?php echo ( $this->get_field_id('title') ); ?>">
						<?php esc_html_e('Title:','listingo_core'); ?>
					</label>
					<input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo(  $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
				</p>
				<p>
					<label for="<?php echo ( $this->get_field_id('username') ); ?>">
						<?php esc_html_e('Username:','listingo_core'); ?>
					</label>
					<input class="widefat" id="<?php echo(  $this->get_field_id('username') ); ?>" name="<?php echo ( $this->get_field_name('username') ); ?>" type="text" value="<?php echo esc_attr($username); ?>">
				</p>
				<p>
					<label for="<?php echo ( $this->get_field_id('no_of_tweets') ); ?>">
						<?php esc_html_e('Number of Tweets:','listingo_core'); ?>
					</label>
					<input class="widefat" id="<?php echo ( $this->get_field_id('no_of_tweets') ); ?>" name="<?php echo( $this->get_field_name('no_of_tweets') ); ?>" type="number" min="0" value="<?php echo esc_attr($no_of_tweets); ?>"/>
				</p>
				<?php
			}

			/**
			 * Processing widget options on save
			 *
			 * @param array $new_instance The new options
			 * @param array $old_instance The previous options
			 */
			public
			function update( $new_instance, $old_instance ) {
				// processes widget options to be saved
				$instance = $old_instance;
				$instance[ 'title' ] = ( !empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
				$instance[ 'username' ] = ( !empty( $new_instance[ 'username' ] ) ) ? strip_tags( $new_instance[ 'username' ] ) : '';
				$instance[ 'no_of_tweets' ] = ( !empty( $new_instance[ 'no_of_tweets' ] ) ) ? strip_tags( $new_instance[ 'no_of_tweets' ] ) : '6';
				return $instance;
			}

		}

}
//register widget
function listingo_register_listingo_tweets_widgets() {
	register_widget( 'Listingo_Tweets' );
}
add_action( 'widgets_init', 'listingo_register_listingo_tweets_widgets' );