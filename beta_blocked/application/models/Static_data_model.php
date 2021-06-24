<?php
class Static_data_model extends CI_Model
{
	public function get_hair_color_list() {
        return [
            "no_information",
            "light_blond",
            "dark_blond",
            "black", 
            "white",
            "brown",
            "red",
            "grey"
        ];
	}

	public function get_eye_color_list() {
        return [
            "no_information",
            //"black", 
            "blue",
            "brown",
            "green"
        ];
	}

	public function get_figure_list() {
        return [
            "no_information",
            "sporty",
            "slim",
            "strong",
            "a_few_pounds_too_a_lot_of",
            "i_will_say_that_later",            
        ];
	}

	public function get_ethnicity_list() {
        return [
            "no_information",
            "of_asian_descent",
            "black_or_african_origin",
            "southern_or_spanish",
            "indian",
            "middle_east",
            "mixed",
            "white_or_european",
            "other"
        ];
	}

	public function get_job_list() {
        return [
            "no_information",
            "independently",
            "businessman",
            "leading_position",
            "assistent",
            "employee",
            "worker",
            "student",
            "apprentice"
        ];
	}


}