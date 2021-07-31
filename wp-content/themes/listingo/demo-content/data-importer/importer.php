<?php
/**
 * @Booking Dummy data
 * All the functions will be in this file
 */



/**
 * @Data Importer
 * @return 
 */
if (!function_exists('listingo_update_users')) {

    function listingo_update_users() {
        $query_args = array(
			'role__in' => array('professional', 'business'),
		);

        
		$user_query = new WP_User_Query($query_args);
        
		//Default template for booking confirmation				
		$booking_confirmed_default = 'Hi, %customer_name%!
		This is confirmation that you have booked a "%service%" with %provider%.
		%signature%';

		//Default template for booking cancellation
		$booking_cancelled_default = 'Hi %customer_name%!<br/>
		This is confirmation that your booking regarding "%service%" with %provider% has cancelled.<br/>
		We are very sorry to process your booking right now.<br/><br/>
		%reason_title%<br/>
		%reason_description%<br/><br/>
		%signature%<br/>';

		//Default template for booking Approved
		$booking_approved_default = 'Hi, %customer_name%!<br/>
		This is confirmation that your booking regarding "%service%" with %provider% has approved.<br/>
		We are waiting on %appointment_date% at %appointment_time%.<br/>
		<br/><br/>
		%signature%<br/>
		';
		
		$profile_services	= 'a:3:{s:16:"evaluationlevel1";a:6:{s:5:"title";s:22:"Evaluation – Level 1";s:5:"price";s:3:"250";s:4:"type";s:4:"hour";s:11:"description";s:335:"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";s:11:"appointment";s:2:"on";s:11:"freeservice";s:0:"";}s:23:"cesareansectiondelivery";a:6:{s:5:"title";s:25:"Cesarean Section Delivery";s:5:"price";s:3:"300";s:4:"type";s:4:"hour";s:11:"description";s:335:"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";s:11:"appointment";s:2:"on";s:11:"freeservice";s:0:"";}s:23:"inpatientrehabilitation";a:6:{s:5:"title";s:24:"Inpatient Rehabilitation";s:5:"price";s:3:"150";s:4:"type";s:4:"hour";s:11:"description";s:335:"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";s:11:"appointment";s:2:"on";s:11:"freeservice";s:0:"";}}';
		
		$appt_cancelled_title	= 'Your Appointment Cancelled';
		$appt_approved_title	= 'Your Appointment Approved';
		$appt_confirmation_title	= 'Your Appointment Confirmation';
		$appointment_currency	= 'USD';
		$appointment_inst_desc	= 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboraum laudantium totam aperiam ab illo inventore veritatis quasi architecto beatae vitae dicta sunt explicabo enim ipsam voluptatem quia voluptas sit aspernatur aut fugit sed equi nesciunt.

Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque';
		
		$appointment_inst_title	= 'You Should Know Before You Start';
		$appointment_reasons = 'a:5:{s:10:"urgenttask";s:11:"Urgent Task";s:12:"generalvisit";s:13:"General Visit";s:9:"quotation";s:9:"Quotation";s:12:"consultation";s:12:"Consultation";s:6:"others";s:6:"Others";}';
		$appointment_types	 = 'a:3:{s:14:"newappointment";s:15:"New Appointment";s:8:"followup";s:9:"Follow Up";s:6:"others";s:6:"Others";}';
		
		$teams	= array(333,334,335,336,337,340);
       
		$privacy_settings	= 'a:20:{s:13:"profile_photo";s:2:"on";s:14:"profile_banner";s:2:"on";s:19:"profile_appointment";s:2:"on";s:15:"profile_contact";s:2:"on";s:13:"profile_hours";s:2:"on";s:15:"profile_service";s:2:"on";s:12:"profile_team";s:2:"on";s:15:"profile_gallery";s:2:"on";s:14:"profile_videos";s:2:"on";s:20:"privacy_introduction";s:2:"on";s:17:"privacy_languages";s:2:"on";s:18:"privacy_experience";s:2:"on";s:14:"privacy_awards";s:2:"on";s:21:"privacy_qualification";s:2:"on";s:15:"privacy_amenity";s:2:"on";s:17:"privacy_insurance";s:2:"on";s:17:"privacy_brochures";s:2:"on";s:20:"privacy_job_openings";s:2:"on";s:16:"privacy_articles";s:2:"on";s:13:"privacy_share";s:2:"on";}';
		
		
		$qualifications	 = 'a:3:{i:0;a:5:{s:5:"title";s:33:"Master In Marketing &amp; Finance";s:9:"institute";s:29:"True Cim Collection Institute";s:10:"start_date";i:1407801600;s:8:"end_date";i:1440806400;s:11:"description";s:154:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dolore magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:1;a:5:{s:5:"title";s:34:"Diploma In Marketing &amp; Finance";s:9:"institute";s:33:"Fast Track Communication Institue";s:10:"start_date";i:1441238400;s:8:"end_date";i:1473984000;s:11:"description";s:154:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dolore magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:2;a:5:{s:5:"title";s:19:"Entry Level Diploma";s:9:"institute";s:37:"Blue Bird College &amp; School System";s:10:"start_date";i:1473897600;s:8:"end_date";i:1496966400;s:11:"description";s:154:"Consectetur Adipisicing Elit Sed Do Eiusmod Tempor Incididunt Ut Labore Etiatoe Dolore Magna Aliqua Eni Minimat Quis Nostrud Exercitation Ullamco Laboris.";}}';
		
		$videos	= 'a:4:{i:0;s:43:"https://www.youtube.com/watch?v=nJNGO74luhM";i:1;s:43:"https://www.youtube.com/watch?v=ieYuoQ9sMvA";i:2;s:43:"https://www.youtube.com/watch?v=2Oxy8lh9jMY";i:3;s:43:"https://www.youtube.com/watch?v=XLZzJGab848";}';
		
		$professional_statement	= 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minimat quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat aute irure dolor reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam ab illo inventore veritatis quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut fugit sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.

Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minimat quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat aute irure dolor reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam ab illo inventore veritatis quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut fugit sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.

Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.';
		
		$profile_amenities	= 'a:6:{i:0;s:20:"accepts-credit-cards";i:1;s:11:"beauty-shop";i:2;s:12:"bike-parking";i:3;s:18:"comfortable-chairs";i:4;s:9:"courtyard";i:5;s:19:"free-coffee-and-tea";}';
		$profile_insurance	= 'a:5:{i:0;s:10:"abbey-life";i:1;s:9:"bgl-group";i:2;s:9:"bgl-group";i:3;s:25:"american-family-insurance";i:4;s:5:"aviva";}';
		$profile_brochure	= 'a:3:{s:9:"file_type";s:16:"profile_brochure";s:12:"default_file";i:171;s:9:"file_data";a:2:{i:171;a:6:{s:9:"file_type";s:4:"docx";s:9:"file_icon";s:17:"fa fa-file-word-o";s:10:"file_title";s:17:"listingo";s:12:"file_abspath";s:109:"/home/themographics/public_html/wordpress/listingo/wp-content/uploads/2017/08/service-providers.docx";s:12:"file_relpath";s:103:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/service-providers.docx";s:7:"file_id";i:171;}i:172;a:6:{s:9:"file_type";s:3:"csv";s:9:"file_icon";s:18:"fa fa-file-excel-o";s:10:"file_title";s:5:"users";s:12:"file_abspath";s:96:"/home/themographics/public_html/wordpress/listingo/wp-content/uploads/2017/08/users.csv";s:12:"file_relpath";s:90:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/users.csv";s:7:"file_id";i:172;}}}';
		
		$experience	= 'a:5:{i:0;a:6:{s:7:"current";s:0:"";s:5:"title";s:24:"Business Planner Manager";s:7:"company";s:33:"Bright Future Group &amp; Company";s:10:"start_date";i:1305158400;s:8:"end_date";i:1340064000;s:11:"description";s:154:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dolore magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:1;a:6:{s:7:"current";s:0:"";s:5:"title";s:20:"Sr. Business Planner";s:7:"company";s:37:"Delta Communication &amp; Development";s:10:"start_date";i:1341964800;s:8:"end_date";i:1376438400;s:11:"description";s:154:"Consectetur Adipisicing Elit Sed Do Eiusmod Tempor Incididunt Ut Labore Etiatoe Dolore Magna Aliqua Eni Minimat Quis Nostrud Exercitation Ullamco Laboris.";}i:2;a:6:{s:7:"current";s:0:"";s:5:"title";s:20:"Business Coordinator";s:7:"company";s:25:"Human Power &amp; Company";s:10:"start_date";i:1417132800;s:8:"end_date";i:1440806400;s:11:"description";s:154:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dolore magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:3;a:6:{s:7:"current";s:0:"";s:5:"title";s:16:"Business Planner";s:7:"company";s:12:"Company Name";s:10:"start_date";i:1441843200;s:8:"end_date";i:1471392000;s:11:"description";s:154:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dolore magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:4;a:6:{s:7:"current";s:0:"";s:5:"title";s:20:"Business Planner Jr.";s:7:"company";s:20:"Spring Town Services";s:10:"start_date";i:1475107200;s:8:"end_date";i:1514592000;s:11:"description";s:154:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dolore magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}}';
		
		$business_hours_format	= '12hour';
		$default_slots	= 'a:10:{s:6:"monday";a:9:{s:9:"0900-1000";i:1;s:9:"1005-1105";i:1;s:9:"1110-1210";i:1;s:9:"1215-1315";i:1;s:9:"1320-1420";i:1;s:9:"1425-1525";i:1;s:9:"1530-1630";i:1;s:9:"1635-1735";i:1;s:9:"1740-1840";i:1;}s:14:"monday-details";a:9:{s:9:"0900-1000";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1005-1105";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1110-1210";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1215-1315";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1320-1420";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1425-1525";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1530-1630";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1635-1735";a:1:{s:10:"slot_title";s:12:"Monday Slots";}s:9:"1740-1840";a:1:{s:10:"slot_title";s:12:"Monday Slots";}}s:7:"tuesday";a:9:{s:9:"0900-1000";i:3;s:9:"1005-1105";i:3;s:9:"1110-1210";i:3;s:9:"1215-1315";i:3;s:9:"1320-1420";i:3;s:9:"1425-1525";i:3;s:9:"1530-1630";i:3;s:9:"1635-1735";i:3;s:9:"1740-1840";i:3;}s:15:"tuesday-details";a:9:{s:9:"0900-1000";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1005-1105";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1110-1210";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1215-1315";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1320-1420";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1425-1525";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1530-1630";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1635-1735";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}s:9:"1740-1840";a:1:{s:10:"slot_title";s:13:"Tuesday Slots";}}s:9:"wednesday";a:9:{s:9:"0900-1000";i:2;s:9:"1005-1105";i:2;s:9:"1110-1210";i:2;s:9:"1215-1315";i:2;s:9:"1320-1420";i:2;s:9:"1425-1525";i:2;s:9:"1530-1630";i:2;s:9:"1635-1735";i:2;s:9:"1740-1840";i:2;}s:17:"wednesday-details";a:9:{s:9:"0900-1000";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1005-1105";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1110-1210";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1215-1315";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1320-1420";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1425-1525";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1530-1630";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1635-1735";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}s:9:"1740-1840";a:1:{s:10:"slot_title";s:14:"Wednesday Slot";}}s:8:"thursday";a:9:{s:9:"0900-1000";i:1;s:9:"1005-1105";i:1;s:9:"1110-1210";i:1;s:9:"1215-1315";i:1;s:9:"1320-1420";i:1;s:9:"1425-1525";i:1;s:9:"1530-1630";i:1;s:9:"1635-1735";i:1;s:9:"1740-1840";i:1;}s:16:"thursday-details";a:9:{s:9:"0900-1000";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1005-1105";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1110-1210";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1215-1315";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1320-1420";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1425-1525";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1530-1630";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1635-1735";a:1:{s:10:"slot_title";s:13:"thursday Slot";}s:9:"1740-1840";a:1:{s:10:"slot_title";s:13:"thursday Slot";}}s:6:"friday";a:9:{s:9:"0900-1000";i:1;s:9:"1005-1105";i:1;s:9:"1110-1210";i:1;s:9:"1215-1315";i:1;s:9:"1320-1420";i:1;s:9:"1425-1525";i:1;s:9:"1530-1630";i:1;s:9:"1635-1735";i:1;s:9:"1740-1840";i:1;}s:14:"friday-details";a:9:{s:9:"0900-1000";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1005-1105";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1110-1210";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1215-1315";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1320-1420";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1425-1525";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1530-1630";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1635-1735";a:1:{s:10:"slot_title";s:11:"Friday Slot";}s:9:"1740-1840";a:1:{s:10:"slot_title";s:11:"Friday Slot";}}}';
		
		$business_hours	= 'a:7:{s:6:"monday";a:2:{s:9:"starttime";a:3:{i:0;s:5:"09:00";i:1;s:5:"17:00";i:2;s:5:"00:00";}s:7:"endtime";a:3:{i:0;s:5:"17:00";i:1;s:5:"23:00";i:2;s:5:"09:00";}}s:7:"tuesday";a:2:{s:9:"starttime";a:2:{i:0;s:5:"09:00";i:1;s:5:"17:00";}s:7:"endtime";a:2:{i:0;s:5:"17:00";i:1;s:5:"23:00";}}s:9:"wednesday";a:2:{s:9:"starttime";a:1:{i:0;s:5:"09:00";}s:7:"endtime";a:1:{i:0;s:5:"17:00";}}s:8:"thursday";a:2:{s:9:"starttime";a:1:{i:0;s:5:"09:00";}s:7:"endtime";a:1:{i:0;s:5:"17:00";}}s:6:"friday";a:2:{s:9:"starttime";a:1:{i:0;s:5:"09:00";}s:7:"endtime";a:1:{i:0;s:5:"17:00";}}s:8:"saturday";a:3:{s:7:"off_day";s:2:"on";s:9:"starttime";a:1:{i:0;s:0:"";}s:7:"endtime";a:1:{i:0;s:0:"";}}s:6:"sunday";a:3:{s:7:"off_day";s:2:"on";s:9:"starttime";a:1:{i:0;s:0:"";}s:7:"endtime";a:1:{i:0;s:0:"";}}}';
		
		$featured_expiry	= '1535446220';
		$package_expiry		= '1511686220';
		$package_id			= '48';
		
		$sp_subscription	= 'a:11:{s:15:"subscription_id";i:48;s:19:"subscription_expiry";i:1538208223;s:28:"subscription_featured_expiry";i:1514448223;s:17:"subscription_jobs";i:50;s:25:"subscription_appointments";s:3:"yes";s:27:"subscription_profile_banner";s:3:"yes";s:22:"subscription_insurance";s:3:"yes";s:22:"subscription_favorites";s:3:"yes";s:18:"subscription_teams";s:3:"yes";s:27:"subscription_business_hours";s:3:"yes";s:21:"subscription_articles";s:1:"3";}';
		
		$awards				= 'a:3:{i:0;a:7:{s:13:"attachment_id";i:165;s:13:"thumbnail_url";s:99:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-10-150x150.jpg";s:10:"banner_url";s:91:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-10.jpg";s:8:"full_url";s:91:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-10.jpg";s:5:"title";s:21:"Best Service Provider";s:4:"date";s:12:"18 Mar, 2017";s:11:"description";s:152:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dole magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:1;a:7:{s:13:"attachment_id";i:166;s:13:"thumbnail_url";s:99:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-09-150x150.jpg";s:10:"banner_url";s:91:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-09.jpg";s:8:"full_url";s:91:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-09.jpg";s:5:"title";s:21:"Best Customer Support";s:4:"date";s:12:"11 Sep, 2017";s:11:"description";s:152:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dole magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}i:2;a:7:{s:13:"attachment_id";i:167;s:13:"thumbnail_url";s:99:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-08-150x150.jpg";s:10:"banner_url";s:91:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-08.jpg";s:8:"full_url";s:91:"https://themographics.com/wordpress/listingo/wp-content/uploads/2017/08/img-08.jpg";s:5:"title";s:25:"Client Satisfaction Award";s:4:"date";s:12:"08 Jul, 2017";s:11:"description";s:152:"Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore etiatoe dole magna aliqua eni minimat quis nostrud exercitation ullamco laboris.";}}';
		$profile_languages				= 'a:5:{i:0;s:5:"czech";i:1;s:7:"english";i:2;s:6:"french";i:3;s:6:"german";i:4;s:5:"hindi";}';
		
		$social_api				='a:1:{s:8:"facebook";a:1:{s:4:"chat";a:5:{s:7:"page_id";s:15:"236483310248819";s:6:"app_id";s:15:"185024605632278";s:11:"theme_color";s:0:"";s:16:"loggedin_message";s:35:"Welcome To Listingo WordPress Theme";s:17:"loggedout_message";s:35:"Welcome To Listingo WordPress Theme";}}}';
		
		$gallery	= '173,174,175,176,177,178,180,182';
		
		$teams	= array(12,11,9,48,2,29);
		
		$profile_photos	= '';
		$profile_photos	= '';
		$privacy_array	= unserialize( $privacy_settings );
		$offset 			= get_option('gmt_offset') * intval(60) * intval(60);
		
		foreach ($user_query->results as $user) {
			update_user_meta( $user->ID, 'show_admin_bar_front', 'false' );
			update_user_meta( $user->ID, 'professional_statements', $professional_statement );
			
			$status	= array("away","online","busy");
			shuffle($status);
			
			if( !empty( $status[0] ) ){
				update_user_meta($user->ID, 'profile_status', $status[0]);
			}

			update_user_meta( $user->ID, 'awards', unserialize( $awards ) );
			update_user_meta( $user->ID, 'business_hours', unserialize( $business_hours ) );
			update_user_meta( $user->ID, 'business_hours_format', $business_hours_format );
			update_user_meta( $user->ID, 'default_slots', unserialize( $default_slots ) );
			update_user_meta( $user->ID, 'experience', unserialize( $experience ) );
			update_user_meta( $user->ID, 'profile_brochure',  unserialize( $profile_brochure ) );
			update_user_meta( $user->ID, 'profile_insurance', unserialize( $profile_insurance ) );
			update_user_meta( $user->ID, 'profile_amenities', unserialize( $profile_amenities ) );
			update_user_meta( $user->ID, 'audio_video_urls', unserialize( $videos ) );
			update_user_meta( $user->ID, 'qualification', unserialize( $qualifications ) );
			update_user_meta( $user->ID, 'privacy', unserialize( $privacy_settings ) );
			update_user_meta( $user->ID, 'profile_languages', unserialize( $profile_languages ) );
			update_user_meta( $user->ID, 'sp_social_api', unserialize( $social_api ) );
			update_user_meta( $user->ID, 'is_avatar_available', 1);
			update_user_meta( $user->ID, 'set_profile_view', 0);
			
			if (!empty($privacy_array) && is_array($privacy_array)) {
				foreach ($privacy_array as $key => $privacy) {
					update_user_meta($user->ID, esc_attr($key), esc_attr($privacy));
				}
			}
			
			//update data
			$sp_duration = get_post_meta($package_id, 'sp_duration', true);
			$sp_featured = get_post_meta($package_id, 'sp_featured', true);
			$sp_jobs = get_post_meta($package_id, 'sp_jobs', true);
			$sp_appointments = get_post_meta($package_id, 'sp_appointments', true);
			$sp_banner = get_post_meta($package_id, 'sp_banner', true);
			$sp_insurance = get_post_meta($package_id, 'sp_insurance', true);
			$sp_favorites = get_post_meta($package_id, 'sp_favorites', true);
			$sp_teams = get_post_meta($package_id, 'sp_teams', true);
			$sp_hours = get_post_meta($package_id, 'sp_hours', true);
			$sp_articles = get_post_meta($package_id, 'sp_articles', true);
			$sp_page_design = get_post_meta($package_id, 'sp_page_design', true);
			$sp_gallery_photos = get_post_meta($package_id, 'sp_gallery_photos', true);
			$sp_videos = get_post_meta($package_id, 'sp_videos', true);
			$sp_photos_limit = get_post_meta($package_id, 'sp_photos_limit', true);
			$sp_banners_limit = get_post_meta($package_id, 'sp_banners_limit', true);
			
			$sp_number_of_ads 	= get_post_meta($package_id, 'sp_ads_limit', true);
			$sp_number_of_featured_ads 	= get_post_meta($package_id, 'sp_featured_ads_limit', true);
			$sp_featured_ads_duration 	= get_post_meta($package_id, 'sp_featured_ads_duration', true);

			$current_date = current_time('mysql');

			$sp_jobs 	 = !empty($sp_jobs) ? $sp_jobs : 0;
			
			//Featured
			$duration = $sp_featured; //no of days for a featured listings
			if ($duration > 0) {
				$featured_date = strtotime("+" . $duration . " days", strtotime($current_date));
				$featured_date = date('Y-m-d H:i:s', $featured_date);
			}
			
			//Package Expiry
			$package_expiry = current_time('mysql');
			$current_date 	= current_time('mysql');
			$package_duration = $sp_duration;
			if ($package_duration > 0) {
				$package_expiry = strtotime("+" . $package_duration . " days", strtotime($current_date));
				$package_expiry = date('Y-m-d H:i:s', $package_expiry);
			}
			
			$package_expiry = strtotime($package_expiry);
			$featured_date  = strtotime($featured_date);
			
			if( $featured_date > strtotime($current_date) ){
				$is_featured	= '1';
			} else{
				$is_featured	= '0';
			}
			
			//ads featured expiry
			$ad_expiry = current_time('mysql');
			$ad_featured_expiry = $sp_featured_ads_duration;
			if ($ad_featured_expiry > 0) {
				$ad_featured_expiry = strtotime("+" . $ad_duration . " days", strtotime($ad_expiry));
				$ad_featured_expiry = date('Y-m-d H:i:s', $ad_featured_expiry);
			}
			
			$sp_number_of_ads = $sp_number_of_ads;
			$sp_number_of_featured_ads = $sp_number_of_featured_ads;
			$sp_featured_ads_duration = $sp_featured_ads_duration;
			$ad_featured_expiry = strtotime($ad_featured_expiry);
			
			$package_data = array(
				'subscription_id' 		=> $package_id,
				'subscription_expiry' 	=> $package_expiry,
				'subscription_featured_expiry' 		=> $featured_date,
				'is_featured' 						=> $is_featured,
				'subscription_jobs' 				=> intval($sp_jobs),
				'subscription_appointments' 		=> $sp_appointments,
				'subscription_profile_banner' 		=> $sp_banner,
				'subscription_insurance' 			=> $sp_insurance,
				'subscription_favorites' 			=> $sp_favorites,
				'subscription_teams' 				=> $sp_teams,
				'subscription_business_hours' 		=> $sp_hours,
				'subscription_articles'  			=> $sp_articles,
				'subscription_page_design'  		=> $sp_page_design,
				'subscription_gallery_photos'  		=> $sp_gallery_photos,
				'subscription_videos'  				=> $sp_videos,
				'subscription_photos_limit'  		=> $sp_photos_limit,
				'subscription_banners_limit'  		=> $sp_banners_limit,
				'subscription_ads'  				=> $sp_number_of_ads,
				'subscription_featured_ads' 		=> $sp_number_of_featured_ads,
				'subscription_ad_featured_expiry'  	=> $ad_featured_expiry,
			);

			
			update_user_meta($user->ID, 'sp_subscription', $package_data);
			foreach ($package_data as $key => $value) {
				update_user_meta($user->ID, $key, $value);
			}
			
			//Appointment Dummy Data
			update_user_meta( $user->ID, 'appt_booking_approved', $booking_approved_default );
			update_user_meta( $user->ID, 'appt_booking_confirmed', $booking_confirmed_default );
			update_user_meta( $user->ID, 'appt_booking_cancelled', $booking_cancelled_default );
			update_user_meta( $user->ID, 'appt_cancelled_title', $appt_cancelled_title );
			update_user_meta( $user->ID, 'appt_approved_title', $appt_approved_title );
			update_user_meta( $user->ID, 'appt_confirmation_title', $appt_confirmation_title );
			update_user_meta( $user->ID, 'appointment_currency', $appointment_currency );
			update_user_meta( $user->ID, 'appointment_inst_desc', $appointment_inst_desc );
			update_user_meta( $user->ID, 'appointment_inst_title', $appointment_inst_title );
			update_user_meta( $user->ID, 'profile_services', unserialize( $profile_services ) );
			update_user_meta( $user->ID, 'appointment_reasons', unserialize( $appointment_reasons ) );
			update_user_meta( $user->ID, 'appointment_types', unserialize( $appointment_types ) );
			update_user_meta( $user->ID, 'rich_editing', 'true' );
			
			if( !empty( $gallery ) ){
				$user_gallery	= explode(',',$gallery);
				$metakey	= 'profile_gallery_photos';
				$gallery_data	= array();
				$gallery_data['image_type']	= 'profile_gallery';
				$gallery_data['default_image']	= $user_gallery[0];

				foreach( $user_gallery as $key => $value ){
					$full = listingo_prepare_image_source($value, 0, 0);
					$thumbnail = listingo_prepare_image_source($value, 150, 150);

					$gallery_data['image_data'][$value]['full'] = $full;
					$gallery_data['image_data'][$value]['thumb']  = $thumbnail;
					$gallery_data['image_data'][$value]['banner']  = $full;
					$gallery_data['image_data'][$value]['image_id']  = $value;
				}
				update_user_meta( $user->ID, $metakey, $gallery_data );
				
			}
			
			//Update Teams
			$team_id	= array();
			$team_id[]  = $user->ID;
			$teamsdata = array_diff( $teams , $team_id );	
			update_user_meta($user->ID,'teams_data',$teamsdata);
			update_user_meta($user->ID,'subscription_featured_expiry',1);
			
			
			//wp_update_user(array('ID' => 'Customer ID', 'user_pass' => 'Your Password'));
        }
		
		//Update ads authors
		listingo_update_ads();
		listingo_update_articles();
    }

}

//update demo articles
if (!function_exists('listingo_update_articles')) {
	function listingo_update_articles(){
		$data	= array(
			582 => array(
				'user'	=> 43,
				'category' => 32
			),
			587 => array(
				'user'	=> 51,
				'category' => 32
			),
			585 => array(
				'user'	=> 51,
				'category' => 25
			),
			588 => array(
				'user'	=> 51,
				'category' => 34
			),
			583 => array(
				'user'	=> 12,
				'category' => 34
			),
			578 => array(
				'user'	=> 3,
				'category' => 13
			),
			581 => array(
				'user'	=> 3,
				'category' => 13
			),
			584 => array(
				'user'	=> 3,
				'category' => 13
			),
			586 => array(
				'user'	=> 3,
				'category' => 13
			),
			580 => array(
				'user'	=> 3,
				'category' => 13
			),

		);

		foreach( $data as $key => $val){

			update_post_meta($key, 'provider_category', $val['category']);
			$arg = array(
				'ID' => intval($key ),
				'post_author' => intval($val['user']),
			);
            
			wp_update_post($arg);
		}
	}
}

//update demo articles
if (!function_exists('listingo_update_ads')) {
	function listingo_update_ads(){
		$authors	= array(51,34,31,36);
		
		//posts
		$query_args = array(
			'posts_per_page'        => -1,
			'post_type'             => 'sp_ads',
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1
		);
		
		$query = get_posts($query_args);
		
		foreach( $query as $key => $ad ){
			$author	= $authors[array_rand($authors)];
			
			$arg = array(
				'ID' => intval( $ad->ID ),
				'post_author' => intval($author),
			);
            
			wp_update_post($arg);
		}

	}
	
	//listingo_update_ads();
}

