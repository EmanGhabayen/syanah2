<?php defined( 'FW' ) or die();

//Register Articles extension
$extension = new FW_Available_Extension();
$extension->set_title( esc_html__( 'Articles', 'listingo' ) );
$extension->set_name( 'articles' );
$extension->set_description( esc_html__( "This extension will enable providers to create articles from their dashboard.", 'listingo' ) );
$extension->set_thumbnail( get_template_directory_uri().'/images/articles.png' );
$extension->set_download_source( 'github', array( 'user_repo' => 'etwordpress01/articles' ) );
$register->register( $extension );

//Register questions and answers extension
$extension = new FW_Available_Extension();
$extension->set_title( esc_html__( 'Questions and Answers', 'listingo' ) );
$extension->set_name( 'questionsanswers' );
$extension->set_description( esc_html__( "This extension will enable users to post question and answers at provider detail page.", 'listingo' ) );
$extension->set_thumbnail( get_template_directory_uri().'/images/questions.jpg' );
$extension->set_download_source( 'github', array( 'user_repo' => 'etwordpress01/questionsanswers' ) );
$register->register( $extension );

//Register questions and answers extension
$extension = new FW_Available_Extension();
$extension->set_title( esc_html__( 'Ads/Listings', 'listingo' ) );
$extension->set_name( 'ads' );
$extension->set_description( esc_html__( "This extension will enable the users to create ads/listing from front-end.", 'listingo' ) );
$extension->set_thumbnail( get_template_directory_uri().'/images/questions.jpg' );
$extension->set_download_source( 'github', array( 'user_repo' => 'etwordpress01/ads' ) );
$register->register( $extension );

