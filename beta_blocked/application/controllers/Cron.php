<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function index() {
        $this->rankAllUsers();
    }

	function rankAllUsers() {
        
        $this->load->model(['user_model', 'photo_model']);

        $users = $this->user_model->get_all_users();

        if(!empty($users)) {
            foreach ($users as $urow) {

                $isProfilePicture = false;
                $isPictureApproved = false;

                if(empty($urow['user_active_photo_thumb'])) {
                    $isPictureApproved = false;
                    $isProfilePicture  = $this->photo_model->is_pending_profile_picture_for_user($urow['user_id']);
                } else {
                    $isProfilePicture = true;
                    $isPictureApproved = true;
                }

                $user_data = array(
                    'user_rank' => calculate_user_profile_rank($urow['user_is_vip'], $urow['user_verified'], $isProfilePicture, $isPictureApproved)
                );
                $this->user_model->update_user($urow['user_id'], $user_data);
            }
        }
        echo "Rank Users: Cron Job Success";
	}


}
