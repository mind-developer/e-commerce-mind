<?php

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) exit;



class PN_Server_Request{

	public static $notificationServerUrl = 'https://pushnotifications.io/api/'; //slash necessary at last 

	public static $notificationlanding = 'https://pushnotifications.io/'; //slash necessary at last

	public function __construct(){}



	public static function varifyUser($user_token){  

		$verifyUrl = 'validate/user';

		if ( is_multisite() ) {

            $weblink = get_site_url();              

        }

        else {

            $weblink = home_url();

        }    

		$data = array("user_token"=>$user_token, "website"=>   $weblink);

		$response = self::sendRequest($verifyUrl, $data, 'post');

		$push_notification_auth_settings = get_option('push_notification_auth_settings');

		$push_notification_auth_settings['user_token'] = sanitize_text_field($user_token);

		if($response['status']==200){

			$response['response'] = array_map( 'sanitize_text_field',  $response['response']  );

			$push_notification_auth_settings['token_details'] = $response['response'];

			$push_notification_auth_settings['messageManager'] = $response['response']['messageManager'];

		}



		update_option('push_notification_auth_settings', $push_notification_auth_settings);

		return $response;

	}



	public static function registerSubscribers($token_id, $user_agent, $os, $ip_address, $category){

		$verifyUrl = 'register/audience/token';

		if ( is_multisite() ) {

            $weblink = get_site_url();              

        }

        else {

            $weblink = home_url();

        }    

        $push_notification_auth_settings = get_option('push_notification_auth_settings');

        $user_token = $push_notification_auth_settings['user_token'];

		$data = array("website"=>  $weblink, 

					'token_id' => $token_id, 

					'user_agent'=>$user_agent, 

					'os'=>$os, 

					'user_token'=> $user_token,

					'ip_address'=> $ip_address,

					'category'=> $category

				);

		$response = self::sendRequest($verifyUrl, $data, 'post');

		return $response;

	}



	public static function getsubscribersData($user_token){

		$verifyUrl = 'audience/details';

		if ( is_multisite() ) {

            $weblink = get_site_url();              

        }

        else {

            $weblink = home_url();

        }    

		$data = array("user_token"=>$user_token, "website"=>   $weblink);

		$response = self::sendRequest($verifyUrl, $data, 'post');

		$push_notification_auth_settings = get_option('push_notification_details_settings', array());

		if($response['status']==200){

			$push_notification_auth_settings['subscriber_count'] = sanitize_text_field($response['subscriber_count']);

			$push_notification_auth_settings['updated_at'] = date('Y-m-d H:i:s');

		}

		update_option('push_notification_details_settings', $push_notification_auth_settings);

		return $response;

	}

	public static function getCompaignsData($user_token,$page = 1){
		$verifyUrl = 'campaign/compaign-list';
		if ( is_multisite() ) {
            $weblink = get_site_url();              
        }
        else {
            $weblink = home_url();
        }    
		$data = array("user_token"=>$user_token, "website"=> $weblink, "page" => $page);
		$response = self::sendRequest($verifyUrl, $data, 'post');
		return $response;
	}



	public static function sendPushNotificatioData($user_token, $title, $message, $link_url, $icon_url, $image_url, $category){

		$verifyUrl = 'campaign/create';

		if ( is_multisite() ) {

            $weblink = get_site_url();              

        }

        else {

            $weblink = home_url();

        }   

		$data = array("user_token"=>$user_token, "website"=>   $weblink, 

					'title'=>$title, 

					'message'=>$message, 

					'link_url'=>$link_url, 

					'icon_url'=>$icon_url,

					'image_url'=>$image_url,

					'category'=>$category

				);

		$response = self::sendRequest($verifyUrl, $data, 'post');

		return $response;

	}



	public static function sendPushNotificatioClickData( $campaign ){

		$verifyUrl = 'campaign/click';

		    

		$data = array( "campaign_id"=>$campaign );

		$response = self::sendRequest($verifyUrl, $data, 'post');

		return $response;

	}



	protected static function sendRequest($suffixUrl, $data, $method="post"){



		if($method==='post'){

				$url = self::$notificationServerUrl.$suffixUrl;

				$postdata = array('body'=> $data);

				$remoteResponse = wp_remote_post($url, $postdata);

		}

		// print_r($remoteResponse);

		if( is_wp_error( $remoteResponse ) ){

			$remoteData = array('status'=>401, "response"=>"could not connect to server");

		}else{

			$remoteData = wp_remote_retrieve_body($remoteResponse);

			$remoteData = json_decode($remoteData, true);

		}

		return $remoteData;



	}



}