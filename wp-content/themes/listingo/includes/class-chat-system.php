<?php
if (!class_exists('ChatSystem')) {
    /**
     * One to One Chat System
     * 
     * @package Listingo
     */
    class ChatSystem
    {
        
        /**
         * DB Variable
         * 
         * @var [string]
         */
        protected static $wpdb;
        /**
         * Initialize Singleton
         *
         * @var [void]
         */
        private static $_instance = null;

        /**
         * Call this method to get singleton
         *
         * @return ChatSystem Instance
         */
        public static function instance()
        {
            if (self::$_instance === null) {
                self::$_instance = new ChatSystem();
            }
            return self::$_instance;
        }

        /**
         * PRIVATE CONSTRUCTOR
         */
        private function __construct()
        {
            global $wpdb;
            self::$wpdb = $wpdb;
            add_action('after_setup_theme', array(__CLASS__, 'createChatTable'));
            add_action('fetch_users_threads', array(__CLASS__, 'fetchUserThreads'), 11, 1);
            add_action('wp_ajax_fetchUserConversation', array(__CLASS__, 'fetchUserConversation'));
            add_action('wp_ajax_nopriv_fetchUserConversation', array(__CLASS__, 'fetchUserConversation'));
            add_action('wp_ajax_sendUserMessage', array(__CLASS__, 'sendUserMessage'));
            add_action('wp_ajax_nopriv_sendUserMessage', array(__CLASS__, 'sendUserMessage'));
            add_action('wp_ajax_getIntervalChatHistoryData', array(__CLASS__, 'getIntervalChatHistoryData'));
            add_action('wp_ajax_nopriv_getIntervalChatHistoryData', array(__CLASS__, 'getIntervalChatHistoryData'));
            add_filter('get_user_info', array(__CLASS__, 'getUserInfoData'), 10, 3);
			add_action('am_chat_modal', array(__CLASS__, 'am_chat_modal'),11,1);
			add_action('listingo_chat_count', array(__CLASS__, 'countUnreadMessages'),11,1);
			
        }

        /**
         * Create Chat Table
         *
         * @return void
         */
        public static function createChatTable()
        {
            $privateChat = self::$wpdb->prefix . 'private_chat';

            if (self::$wpdb->get_var("SHOW TABLES LIKE '$privateChat'") != $privateChat) {
                $charsetCollate = self::$wpdb->get_charset_collate();            
                $privateChat = "CREATE TABLE $privateChat (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    sender_id int(11) UNSIGNED NOT NULL,
                    receiver_id int(11) UNSIGNED NOT NULL,
                    chat_message text NULL,
                    status tinyint(1) NOT NULL,
                    timestamp varchar(20) NOT NULL,
                    time_gmt datetime NOT NULL,
                    PRIMARY KEY (id)                           
                    ) $charsetCollate;";   
                                        
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($privateChat);     
            }
        }

        /**
         * Get Chat Users List Threads
         *
         * @return array
         */
        public static function getUsersThreadListData(
            $userId = '',
            $receiverID = '',
            $type = 'list',
            $data = array(),
            $msgID = '',
			$offset 		= ''
        ) {
            $privateChat = self::$wpdb->prefix . 'private_chat';
            $userTable = self::$wpdb->prefix . 'users';
            $fetchResults = array();

            switch ($type) {
            case "list":
                $fetchResults = self::$wpdb->get_results(
                    "SELECT * FROM $privateChat
                    WHERE id IN ( 
                        SELECT MAX(id) AS id 
                        FROM ( 
                            SELECT id, sender_id AS chat_sender 
                            FROM $privateChat 
                            WHERE receiver_id = $userId OR sender_id = $userId 
                        UNION ALL 
                            SELECT id, receiver_id AS chat_sender 
                            FROM $privateChat 
                            WHERE sender_id = $userId OR receiver_id = $userId ) t GROUP BY chat_sender ) ORDER BY id DESC", ARRAY_A
                );
                break;
            case "fetch_thread":
                $fetchResults = self::$wpdb->get_results(
                    "SELECT * FROM $privateChat
                    WHERE 
                        ($privateChat.sender_id = $userId 
                    AND 
                        $privateChat.receiver_id = $receiverID) 
                    OR 
                        ($privateChat.sender_id = $receiverID 
                    AND 
                        $privateChat.receiver_id = $userId) 
                    ", ARRAY_A
                );
                break;
			case "fetch_thread_last_items":
					
				$total	= 100;
				$limit	= $offset*$total;
					
                $fetchResults = self::$wpdb->get_results(
                    "SELECT * FROM ( SELECT * FROM $privateChat 
					
                    WHERE 
                        ($privateChat.sender_id = $userId 
                    AND 
                        $privateChat.receiver_id = $receiverID) 
                    OR 
                        ($privateChat.sender_id = $receiverID 
                    AND 
                        $privateChat.receiver_id = $userId) 

					ORDER BY id DESC LIMIT $limit , $total
					
					)  sub ORDER BY id ASC
						
                    ", ARRAY_A
                );
                break;
            case "fetch_interval_thread":
                $fetchResults = self::$wpdb->get_results(
                    "SELECT * FROM $privateChat
                    WHERE ($privateChat.sender_id = $userId 
                        AND $privateChat.receiver_id = $receiverID)
                    OR ($privateChat.sender_id = $receiverID 
                        AND $privateChat.receiver_id = $userId)
                    ORDER BY $privateChat.id ASC
                    ", ARRAY_A
                );
                break;
            case "set_thread_status":
                self::$wpdb->update(
                    $privateChat,
                    array("status" => intval(0)),
                    array(
                        "sender_id" => stripslashes_deep($receiverID),
                        "receiver_id" => stripslashes_deep($userId),
                        "status" => intval(1)
                    )
                );
                break;
            case "insert_msg":
                self::$wpdb->insert($privateChat, $data);
                return self::$wpdb->insert_id;
                break;
            case "fetch_recent_thread":
                $fetchResults = self::$wpdb->get_row(
                    "SELECT * FROM
                    $privateChat
                    WHERE $privateChat.id = $msgID", ARRAY_A
                );
                break;
            case "count_unread_msgs":
                $fetchResults = self::$wpdb->get_var(
                    "SELECT count(*) AS unread FROM $privateChat where $privateChat.receiver_id = $userId and status = 1"
                );
                break;
			 case "count_unread_msgs_by_user":
                $fetchResults = self::$wpdb->get_var(
                    "SELECT count(*) AS unread FROM $privateChat 
                    WHERE $privateChat.sender_id =  $userId
                    AND $privateChat.receiver_id = $receiverID
                    AND $privateChat.status = 1"
                );
                break;
            case "delete_thread_msg":
                self::$wpdb->delete($privateChat, $data);
                break;
            }
            
            return $fetchResults;
        }
		
		/**
         * display chat model on detail page
         *
         * @param string $userId
         * @return void
         */
        public static function am_chat_modal($userId = '')
        {
			$is_chat			= listingo_is_chat_enabled($userId);
			if( !empty($is_chat) && $is_chat === 'yes' ){
				?>
				<div class="modal fade wt-offerpopup" tabindex="-1" role="dialog" id="chatmodal">
					<div class="modal-dialog" role="document">
						<div class="wt-modalcontent modal-content">
							<div class="wt-popuptitle">
								<h2><?php esc_html_e('Send message','listingo');?></h2>
								<a href="javascript:;" class="wt-closebtn close"><i class="fa fa-close" data-dismiss="modal" aria-label="<?php esc_html_e('Close','listingo');?>"></i></a>
							</div>
							<div class="modal-body">
								<form class=" chat-form">
									<div class="wt-formtheme wt-formpopup">
										<fieldset class="wt-replaybox">
											<div class="form-group">
												<textarea class="form-control reply_msg" name="reply" placeholder="<?php esc_html_e('Type your message', 'listingo'); ?>"></textarea>
											</div>
											<div class="form-group wt-btnarea wt-iconboxv">
												<a href="javascript:;" class="wt-btnsendmsg wt-send" data-status="unread"  data-msgtype="modal" data-receiver_id="<?php echo esc_attr($userId);?>"><?php esc_html_e('Send message','listingo');?></a>
											</div>
										</fieldset>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		
        /**
         * Undocumented function
         *
         * @param string $userId
         * @return void
         */
        public static function fetchUserThreads($userId = '')
        {
            ob_start();
            $usersThreadUserList = self::getUsersThreadListData($userId, '', 'list', array(), '');
            ?>
            <ul>
                <li>							
                    <div class="wt-formtheme wt-formsearch">
                        <fieldset>
                            <div class="form-group">
                                <input type="text" name="fullname" class="form-control wt-filter-users" placeholder="<?php esc_html_e('Search Users', 'listingo'); ?>">
                                <a href="javascrip:;" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                            </div>
                        </fieldset>
                    </div>
                    <div class="wt-verticalscrollbar wt-dashboardscrollbar">
                        <?php
						if (!empty($usersThreadUserList)) { 
                        foreach ($usersThreadUserList as $userVal) {
							
                            $unreadNotifyClass  = '';
                            $chat_user_id 		= '';
							$message = !empty( $userVal['chat_message'] ) ? $userVal['chat_message'] : '';
							if (strlen($message) > 40) {
							  $message = substr( $message, 0, 26 );
							}
							
                            if ($userVal['status'] == 1) {
                                $unreadNotifyClass = 'wt-dotnotification';
                            }
							
                            if ($userId === intval($userVal['sender_id'])) {
                                $chat_user_id = intval($userVal['receiver_id']);
                            } else {
                                $chat_user_id = intval($userVal['sender_id']);
                            }

                            $userAvatar = self::getUserInfoData('avatar', $chat_user_id, array('width' => 100, 'height' => 100));
                            $userName 	= self::getUserInfoData('username', $chat_user_id, array());
							$userUrl 	= self::getUserInfoData('url', $chat_user_id, array());
							$count 		= self::getUsersThreadListData($chat_user_id,$userId,'count_unread_msgs_by_user');
							$unread		= !empty( $count ) ? $count : 0;
                            ?>
                            <div class="wt-ad wt-load-chat <?php echo esc_attr($unreadNotifyClass); ?>" id="load-user-chat-<?php echo intval($chat_user_id); ?>" data-userid="<?php echo intval($chat_user_id); ?>" data-currentid="<?php echo intval($userId); ?>" data-msgid="<?php echo intval($userVal['id']); ?>" data-img="<?php echo esc_url($userAvatar); ?>" data-name="<?php echo esc_attr($userName); ?>" data-url="<?php echo esc_url($userUrl); ?>">
                                <figure>
                                    <img src="<?php echo esc_url($userAvatar); ?>" alt="<?php echo esc_attr($userName); ?>">
                                </figure>
                                <div class="wt-adcontent">
                                    <h3><?php echo esc_attr($userName); ?></h3>
                                    <span class="list-last-message"><?php echo html_entity_decode( stripslashes($message), ENT_QUOTES );?></span>
                                </div>
                                <em class="wtunread-count"><?php echo intval( $unread );?></em>
                            </div>	
                        <?php }}?>
                    </div>
                </li>
                <li>
                    <div class="wt-chatarea load-wt-chat-message">
                        <div class="wt-chatarea wt-chatarea-empty">
                            <figure class="wt-chatemptyimg">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/message-img.png'); ?>" alt="<?php esc_attr_e('No Message Selected', 'listingo'); ?>">
                                <figcaption>
                                    <h3><?php esc_html_e('No message selected to display', 'listingo'); ?></h3>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </li>
            </ul>
            <?php
            echo ob_get_clean();
        }

      /**
         * Fetch User Conversation
         *
         * @return void
         */
        public static function fetchUserConversation()
        {
            $json = array();
			
			$senderID 		= !empty( $_POST['current_id'] ) ? intval( $_POST['current_id'] ) : '';
            $receiverID 	= !empty( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : '';
            $lastMsgId 		= !empty( $_POST['msg_id'] ) ? intval( $_POST['msg_id'] ) : '';
			$lastMsgId 		= !empty( $_POST['msg_id'] ) ? intval( $_POST['msg_id'] ) : '';
			$thread_page 		= !empty( $_POST['thread_page'] ) ? intval( $_POST['thread_page'] ) : 0;
			
            if (!empty($_POST) && $receiverID != $senderID ) {

                $usersThreadData = self::getUsersThreadListData($senderID, $receiverID, 'fetch_thread_last_items', array(), '',$thread_page);
                //Update Chat Status in DB
                self::getUsersThreadListData($senderID, $receiverID, 'set_thread_status', array(), '');
                //Prepare Chat Nodes
                $chat_nodes = array();

                if (!empty($usersThreadData)) {
                    foreach ($usersThreadData as $key => $val) {

                        $chat_nodes[$key]['chat_is_sender'] = 'no';
                        if ($val['sender_id'] == $senderID) {
                            $chat_nodes[$key]['chat_is_sender'] = 'yes';
                        }

                        $date = !empty($val['time_gmt']) ?  date(get_option('date_format'), strtotime($val['time_gmt'])) : '';
                        $chat_nodes[$key]['chat_avatar'] 			= self::getUserInfoData('avatar', $val['sender_id'], array('width' => 100, 'height' => 100));
                        $chat_nodes[$key]['chat_username'] 			= self::getUserInfoData('username', $val['sender_id'], array());
                        $chat_nodes[$key]['chat_message'] 			= html_entity_decode( stripslashes($val['chat_message']),ENT_QUOTES );
                        $chat_nodes[$key]['chat_date'] 				= $date;
                        $chat_nodes[$key]['chat_id'] 				= intval($val['id']);
                        $chat_nodes[$key]['chat_current_user_id'] 	= intval($senderID);
                    }


                    //Create Chat Sidebar Data
                    $chat_sidebar = array();
                    $chat_sidebar['avatar'] 		= self::getUserInfoData('avatar', $receiverID, array('width' => 100, 'height' => 100));
                    $chat_sidebar['username'] 		= self::getUserInfoData('username', $receiverID, array());
                    $chat_sidebar['user_register']  = self::getUserInfoData('user_register', $receiverID, array());

                    $json['type'] 			= 'success';
                    $json['chat_nodes'] 	= $chat_nodes;
                    $json['chat_receiver_id'] 		= intval($receiverID);
					$json['chat_sender_id'] 		= intval($senderID);
                    $json['chat_sidebar'] 			= $chat_sidebar;
                    $json['message'] = esc_html__('Chat Messages Found!', 'listingo');
                    wp_send_json($json);
					
                } else {
                    $json['type']       = 'error';
                    $json['message']    = esc_html__('No more messages...', 'listingo');
                    wp_send_json($json);
                }
            } else {
                $json['type']       = 'error';
                $json['message'] = esc_html__('No kiddies please.', 'listingo');
                wp_send_json($json);
            }
            
        }

        /**
         * Send user message function
         *
         * @return void
         */
        public static function sendUserMessage() 
		{
            global $current_user;
            $json = array();
			
			$receiver_id	= !empty( $_POST['receiver_id'] ) ? intval($_POST['receiver_id']) : '';
            $status			= !empty( $_POST['status'] ) && esc_attr( $_POST['status'] ) === 'read' ? 0 : 1;
            $msg_type		= !empty( $_POST['msg_type'] ) && esc_attr( $_POST['msg_type'] ) === 'modal' ? 'modal' : 'normals';
			$message		= !empty( $_POST['message'] ) ? esc_textarea($_POST['message']) : '';
			
            if (empty($receiver_id)) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('No kiddies please.', 'listingo');
                wp_send_json($json);
            }

            if ( intval( $receiver_id ) === intval( $current_user->ID ) ) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Something went wrong.', 'listingo');
                wp_send_json($json);
            }

            if (empty($message)) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Message field is required.', 'listingo');
                wp_send_json($json);
            }

            $senderId   = $current_user->ID;
            $receiverId = intval($receiver_id);

            //Prepare Insert Message Data Array
            $current_time  = current_time('mysql');
            $gmt_time      = get_gmt_from_date($current_time);

            $insert_data = array(
                'sender_id' 		=> $senderId,
                'receiver_id' 		=> $receiverId,
                'chat_message' 		=> $message,
                'status' 			=> $status,
                'timestamp' 		=> time(),
                'time_gmt' 			=> $gmt_time,
            );

            $msg_id = self::getUsersThreadListData($senderId, $receiverId, 'insert_msg', $insert_data, '');
            
            if (!empty($msg_id)) {
                $fetchRecentThread = self::getUsersThreadListData('', '', 'fetch_recent_thread', array(), $msg_id);

                $message = !empty( $fetchRecentThread['chat_message'] ) ?  $fetchRecentThread['chat_message'] : '';
                $date = !empty($fetchRecentThread['time_gmt']) ?  date(get_option('date_format'), strtotime($fetchRecentThread['time_gmt'])) : '';
                $chat_nodes[0]['chat_avatar'] 		= self::getUserInfoData('avatar', $fetchRecentThread['sender_id'], array('width' => 100, 'height' => 100));
                $chat_nodes[0]['chat_username'] 	= self::getUserInfoData('username', $fetchRecentThread['sender_id'], array());
                $chat_nodes[0]['chat_message'] 		= html_entity_decode( stripslashes($message),ENT_QUOTES ); ;
                $chat_nodes[0]['chat_date'] 		= $date;
                $chat_nodes[0]['chat_id'] 			= intval($fetchRecentThread['id']);
                $chat_nodes[0]['chat_current_user_id'] = intval($senderId);
                $chat_nodes[0]['chat_is_sender'] = 'yes';
				
				//excerpt
				if (strlen($message) > 40) {
					$message = substr($message, 0, 40);
				}

                $json['type'] 			= 'success';
                $json['msg_type']       = $msg_type;
                $json['chat_nodes'] 	= $chat_nodes;
				$json['chat_receiver_id'] 		= intval($receiverId);
				$json['chat_sender_id'] 		= intval($senderId);
				$json['last_id'] 				= intval($msg_id);
				
                $json['replace_recent_msg_user'] = self::getUserInfoData('username', $fetchRecentThread['receiver_id']);
                $json['replace_recent_msg'] = $message;
                $json['message'] = esc_html__('Message send!', 'listingo');

                wp_send_json($json);
            }
            
        }

        /**
         * Get Interval Chat History
         *
         * @return void
         */
        public static function getIntervalChatHistoryData()
        {
            $json = array();
			
			$senderID	= !empty( $_POST['sender_id'] ) ? intval($_POST['sender_id']) : '';
			$receiverID	= !empty( $_POST['receiver_id'] ) ? intval($_POST['receiver_id']) : '';
			$lastMsgId	= !empty( $_POST['last_msg_id'] ) ? intval($_POST['last_msg_id']) : '';
			
            if ( !empty($_POST) && $senderID != $receiverID ) {
                $usersThreadData = self::getUsersThreadListData($senderID, $receiverID, 'fetch_interval_thread', array(), '');

                $chat_nodes = array();
				
                $last_id 	= '';
				$newchat    = false; 
				$last_message = '';
                if (!empty($usersThreadData)) {
                    foreach ($usersThreadData as $key => $val) {
                        $last_id = intval( $val['id'] );
						$newchat = true;

						//Update Chat Status in DB
						self::getUsersThreadListData($senderID, $receiverID, 'set_thread_status', array(), '');

						$chat_nodes[$key]['chat_is_sender'] 	= 'no';

						if ($val['sender_id'] == $senderID) {
							$chat_nodes[$key]['chat_is_sender'] = 'yes';
						}

						$date = !empty($val['time_gmt']) ?  date(get_option('date_format'), strtotime($val['time_gmt'])) : '';
						$chat_nodes[$key]['chat_avatar'] 		= self::getUserInfoData('avatar', $val['sender_id'], array('width' => 100, 'height' => 100));
						$chat_nodes[$key]['chat_username'] 		= self::getUserInfoData('username', $val['sender_id'], array());
						$chat_nodes[$key]['chat_message'] 		= wp_kses_post(do_shortcode( $val['chat_message'] )) ;
						$chat_nodes[$key]['chat_date'] 			= $date;
						$chat_nodes[$key]['chat_id'] 			= intval($val['id']);
						$chat_nodes[$key]['chat_current_user_id'] = intval($senderID);

						$last_message = $val['chat_message'];
                    }
					
					if( $newchat ){
						$json['type'] 		= 'success';
					} else{
						$json['type']       = 'error';
					}
                    
					//excerpt
					if (strlen($last_message) > 40) {
						$last_message = substr($last_message, 0, 40);
					}
					
					
                    $json['chat_nodes'] 	= $chat_nodes;
                    $json['last_id'] 		= intval( $last_id );
                    $json['receiver_id'] 	= $receiverID;
					$json['last_message'] 	= $last_message;
                    $json['message'] 		= esc_html__('Chat messages found!', 'listingo');
                    wp_send_json($json);
                }

            } else {
                $json['type']       = 'error';
                $json['message'] = esc_html__('No kiddies please.', 'listingo');
                wp_send_json($json);
            }
        }

        /**
         * Delete chat message function
         *
         * @return void
         */
        public static function deleteChatMessage()
        {
            global $current_user;  
            $json = array();
			
			$senderID      = !empty( $_POST['user_id'] ) ? intval($_POST['user_id']) : '';  
            $messageID     = !empty( $_POST['msgid'] ) ? intval($_POST['msgid']) : '';
			
            //Validation
            if ( empty($senderID) || empty($messageID) ) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Something went wrong.', 'listingo');
                wp_send_json($json);
            }     


            //Check if valid User sent
            if ( $current_user->ID !== $senderID ) {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('No kiddies please.', 'listingo');
                wp_send_json($json);
            }

            //Delete Thread Message
            $delete_array_data = array(
                "id"            => $messageID,
                "sender_id"     => $senderID                 
            );

            self::getUsersThreadListData($senderID, '', 'delete_thread_msg', $delete_array_data, $messageID);

            //Response
            $json['type']    = 'success';
            $json['message'] = esc_html__('Message deleted.', 'listingo');
            wp_send_json($json); 
        }

        /**
         * Get User Information
         *
         * @param string $type
         * @param string $userID
         * @return void
         */
        public static function getUserInfoData($type = '', $userID = '', $sizes = array()) 
        {
            $userinfo = '';
            $user_data = get_userdata($userID);

            switch ($type) {
				case "avatar":
                    $userinfo = apply_filters(
                        'listingo_get_media_filter', listingo_get_user_avatar($sizes, $userID), $sizes //size width,height
                    );
					break;
				case "username":
					$userinfo = listingo_get_username($userID);
					break;
				case "user_register":
					$userinfo = esc_html__('Member Since','listingo').'&nbsp;'.date(get_option('date_format'), strtotime($user_data->user_registered));
					break;
				case "url":
					$userinfo = get_author_posts_url($userID);
					break;
            }

            return $userinfo;
        }
		
		/**
         * Get User Information
         *
         * @param string $type
         * @param string $userID
         * @return void
         */
        public static function countUnreadMessages($userID = '') 
        {
			
            $users_unread = self::getUsersThreadListData($userID,'','count_unread_msgs');
            echo !empty( $users_unread ) ? $users_unread  : '0';
        }
    }
	
    ChatSystem::instance();
}