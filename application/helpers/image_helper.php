<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( !function_exists('profile_image') ) {

		//set a user's image on the /user page
	function profile_image() {

		$CI = & get_instance();

		if(empty($CI->session->image)){ $image = base_url('assets/images/public/profile_pic.jpg');} else {
			if(strpos($CI->session->image, "/")){
				$image = $CI->session->image;} 
				else {
					$id = $CI->session->id ? $CI->session->id : $CI->session->customer_id;
					$image =  base_url('assets/images/uploads/customers/'.$id."/".$CI->session->image);
				}
			}
			return $image;
		}

	}

	if( !function_exists('user_image') ) {
	//set a user's image on the /user page
		function user_image($user_info){
			if(is_array($user_info)){
				if(!empty($user_info['image'])) {
					if(strpos($user_info['image'], '/')){
						return $user_info['image'];
					} else {
						return base_url('assets/images/uploads/customers/'.$user_info['id']."/".$user_info['image']);
					}	
					return '../../public/profile_pic.jpg';
				}
			}else if (is_object($user_info)) {
				if(!empty($user_info->image)){
					if(strpos($user_info->image, '/')){
						return $user_info->image;
					} else {
						return base_url('assets/images/uploads/customers/'.$user_info->id."/".$user_info->image);
					}
					return '../../public/profile_pic.jpg';
				}

			} return base_url('assets/images/public/profile_pic.jpg');
			

		}
	}

	?> 