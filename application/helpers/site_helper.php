<?php

if(!function_exists('pagination_config'))
{
	function pagination_config($url, $per_page, $total_rows, $num_links=4, $use_page_numbers=TRUE, $page_query_string=TRUE)
	{
		$config = array();
		$config["base_url"] 			= $url;
		$config["per_page"] 			= $per_page;
		$config["total_rows"] 			= $total_rows;
		$config['num_links'] 			= $num_links;
		$config['use_page_numbers']		= $use_page_numbers;
		$config['page_query_string'] 	= $page_query_string;

        $config['full_tag_open'] = '<ul class="pagination_ul">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li style="padding:0px 20px;">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li style="padding:0px 20px;"><a href="#" class="active">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li style="padding:0px 20px;">';
        $config['num_tag_close'] = '</li>';

        return $config;
	}
}


if(!function_exists('active_top_menu'))
{
	function active_top_menu($url)
	{
		$curr_url =  uri_string();
		if($curr_url == $url) {
			echo "color: #e8e497 !important;";
		}
	}
}

if(!function_exists('calculate_user_profile_rank'))
{
	function calculate_user_profile_rank($isVIP = 'no', $isUserVerified = 'no', $isProfilePicture = null, $isPictureApproved = false)
	{
		$rankVal = 16;
		if($isVIP == 'yes') {
			$rankVal -= 8;
		}
		if($isUserVerified == 'yes') {
			$rankVal -= 4;
		}
		if($isPictureApproved == true) {
			$rankVal -= 2;
		}
		if($isProfilePicture != null) {
			$rankVal -= 1;
		}

		return $rankVal;
	}
}
if(!function_exists('addLetterAfterEachNumber'))
{
	function addLetterAfterEachNumber($string) {
	    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$result_string = '';
	    $charactersLength = strlen($characters);
		for($j = 0 ; $j < strlen($string);$j++){
			$result_string.=$string[$j] . $characters[rand(0, $charactersLength - 1)]. $characters[rand(0, $charactersLength - 1)]. $characters[rand(0, $charactersLength - 1)]. $characters[rand(0, $charactersLength - 1)];
		}
	    return $result_string;
	}
}

if(!function_exists('active_admin_menu'))
{
	function active_admin_menu($url)
	{
		$curr_url =  uri_string();
		if($curr_url == $url) {
			echo "active";
		}
	}
}

if(!function_exists('convert_date_to_local'))
{

	function convert_date_to_local($utcdate, $format)
	{
		$CI =& get_instance();
        $date = new DateTime($utcdate, new DateTimeZone('GMT'));
        $date->setTimezone(new DateTimeZone($CI->session->userdata('site_timezone')));
        return $date->format($format);
	}
}

if(!function_exists('get_local_date'))
{
	function get_local_date($format)
	{
		$CI =& get_instance();
        $date = new DateTime(gmdate($format), new DateTimeZone('GMT'));
        $date->setTimezone(new DateTimeZone($CI->session->userdata('site_timezone')));
        return $date->format($format);
	}
}


if(!function_exists('distance'))
{
	function distance($lat1, $lon1, $lat2, $lon2, $unit="K")
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
}

/* START: Smileys */
/* For creating smiles: insert smiley text into chars and relative icon into icons array */
if(!function_exists('get_smiley_chars'))
{
	function get_smiley_chars()
	{	
		return ["*-*", ":)", ":D", "::-)", ":@)", ":O", ">-)", ":-|", ":-(", ":(", ":-<", ":-X", ":XH", ":-@", ":-O", "|-O", ":-#", "--@-", "\VVV/", "\%%%/", "-@--@-", ":P", ":X", ":good", ":yes", ":dislike", ":claps", ":thanks", ":inlove", ":stop", ":@" ,":chocalate", ":bear"];
	}
}

if(!function_exists('get_smiley_icons'))
{
	function get_smiley_icons()
	{	
		return [
			'<img src="images/smileys/1.png">',
			'<img src="images/smileys/1.png">',
			'<img src="images/smileys/2.png">',
			'<img src="images/smileys/3.png">',
			'<img src="images/smileys/4.png">',
			'<img src="images/smileys/5.png">',
			'<img src="images/smileys/6.png">',
			'<img src="images/smileys/7.png">',
			'<img src="images/smileys/8.png">',
			'<img src="images/smileys/9.png">',
			'<img src="images/smileys/10.png">',
			'<img src="images/smileys/11.png">',
			'<img src="images/smileys/12.png">',
			'<img src="images/smileys/13.png">',
			'<img src="images/smileys/14.png">',
			'<img src="images/smileys/15.png">',
			'<img src="images/smileys/16.png">',
			'<img src="images/smileys/17.png">',
			'<img src="images/smileys/18.png">',
			'<img src="images/smileys/19.png">',
			'<img src="images/smileys/20.png">',
			'<img src="images/smileys/21.png">',
			'<img src="images/smileys/22.png">',
			'<img src="images/smileys/23.png">',
			'<img src="images/smileys/24.png">',
			'<img src="images/smileys/25.png">',
			'<img src="images/smileys/26.png">',
			'<img src="images/smileys/27.png">',
			'<img src="images/smileys/28.png">',
			'<img src="images/smileys/29.png">',
			'<img src="images/smileys/30.png">',
			'<img src="images/smileys/31.png">',
			'<img src="images/smileys/32.png">'
		];
	}	
}

if(!function_exists('parse_text_smileys'))
{
	function parse_text_smileys($text)
	{
		$chars = get_smiley_chars();
		$icons = get_smiley_icons();
		$new_str = str_replace($chars, $icons, $text);
		
		return $new_str;
	}
}

if(!function_exists('parse_smileys_text'))
{
	function parse_smileys_text($text)
	{
		$chars = get_smiley_chars();
		$icons = get_smiley_icons();
		$new_str = str_replace($icons, $chars, $text);
		
		return $new_str;
	}
}
/* END: Smileys */
/* END: Smileys */

if(!function_exists('genUsername'))
{
 	function genUsername( $length = 8 )
	{
		$conso=array("b","c","d","f","g","h","j","k","l",
	    "m","n","p","r","s","t","v","w","x","y","z");
	    $vocal=array("a","e","i","o","u");
	    $password="";
	    srand ((double)microtime()*1000000);
	    $max = $length/2;
	    for($i=1; $i<=$max; $i++)
	    {
		    $password.=$conso[rand(0,19)];
		    $password.=$vocal[rand(0,4)];
	    }
	    return $password;
		
	}
}

if(!function_exists('get_country_name_by_code'))
{
	function get_country_name_by_code($name)
	{
		$countrycodes = array (
		  'AF' => 'Afghanistan',
		  'AX' => 'Åland Islands',
		  'AL' => 'Albania',
		  'DZ' => 'Algeria',
		  'AS' => 'American Samoa',
		  'AD' => 'Andorra',
		  'AO' => 'Angola',
		  'AI' => 'Anguilla',
		  'AQ' => 'Antarctica',
		  'AG' => 'Antigua and Barbuda',
		  'AR' => 'Argentina',
		  'AU' => 'Australia',
		  'AT' => 'Austria',
		  'AZ' => 'Azerbaijan',
		  'BS' => 'Bahamas',
		  'BH' => 'Bahrain',
		  'BD' => 'Bangladesh',
		  'BB' => 'Barbados',
		  'BY' => 'Belarus',
		  'BE' => 'Belgium',
		  'BZ' => 'Belize',
		  'BJ' => 'Benin',
		  'BM' => 'Bermuda',
		  'BT' => 'Bhutan',
		  'BO' => 'Bolivia',
		  'BA' => 'Bosnia and Herzegovina',
		  'BW' => 'Botswana',
		  'BV' => 'Bouvet Island',
		  'BR' => 'Brazil',
		  'IO' => 'British Indian Ocean Territory',
		  'BN' => 'Brunei Darussalam',
		  'BG' => 'Bulgaria',
		  'BF' => 'Burkina Faso',
		  'BI' => 'Burundi',
		  'KH' => 'Cambodia',
		  'CM' => 'Cameroon',
		  'CA' => 'Canada',
		  'CV' => 'Cape Verde',
		  'KY' => 'Cayman Islands',
		  'CF' => 'Central African Republic',
		  'TD' => 'Chad',
		  'CL' => 'Chile',
		  'CN' => 'China',
		  'CX' => 'Christmas Island',
		  'CC' => 'Cocos (Keeling) Islands',
		  'CO' => 'Colombia',
		  'KM' => 'Comoros',
		  'CG' => 'Congo',
		  'CD' => 'Zaire',
		  'CK' => 'Cook Islands',
		  'CR' => 'Costa Rica',
		  'CI' => 'Côte D\'Ivoire',
		  'HR' => 'Croatia',
		  'CU' => 'Cuba',
		  'CY' => 'Cyprus',
		  'CZ' => 'Czech Republic',
		  'DK' => 'Denmark',
		  'DJ' => 'Djibouti',
		  'DM' => 'Dominica',
		  'DO' => 'Dominican Republic',
		  'EC' => 'Ecuador',
		  'EG' => 'Egypt',
		  'SV' => 'El Salvador',
		  'GQ' => 'Equatorial Guinea',
		  'ER' => 'Eritrea',
		  'EE' => 'Estonia',
		  'ET' => 'Ethiopia',
		  'FK' => 'Falkland Islands (Malvinas)',
		  'FO' => 'Faroe Islands',
		  'FJ' => 'Fiji',
		  'FI' => 'Finland',
		  'FR' => 'France',
		  'GF' => 'French Guiana',
		  'PF' => 'French Polynesia',
		  'TF' => 'French Southern Territories',
		  'GA' => 'Gabon',
		  'GM' => 'Gambia',
		  'GE' => 'Georgia',
		  'DE' => 'Germany',
		  'GH' => 'Ghana',
		  'GI' => 'Gibraltar',
		  'GR' => 'Greece',
		  'GL' => 'Greenland',
		  'GD' => 'Grenada',
		  'GP' => 'Guadeloupe',
		  'GU' => 'Guam',
		  'GT' => 'Guatemala',
		  'GG' => 'Guernsey',
		  'GN' => 'Guinea',
		  'GW' => 'Guinea-Bissau',
		  'GY' => 'Guyana',
		  'HT' => 'Haiti',
		  'HM' => 'Heard Island and Mcdonald Islands',
		  'VA' => 'Vatican City State',
		  'HN' => 'Honduras',
		  'HK' => 'Hong Kong',
		  'HU' => 'Hungary',
		  'IS' => 'Iceland',
		  'IN' => 'India',
		  'ID' => 'Indonesia',
		  'IR' => 'Iran, Islamic Republic of',
		  'IQ' => 'Iraq',
		  'IE' => 'Ireland',
		  'IM' => 'Isle of Man',
		  'IL' => 'Israel',
		  'IT' => 'Italy',
		  'JM' => 'Jamaica',
		  'JP' => 'Japan',
		  'JE' => 'Jersey',
		  'JO' => 'Jordan',
		  'KZ' => 'Kazakhstan',
		  'KE' => 'KENYA',
		  'KI' => 'Kiribati',
		  'KP' => 'Korea, Democratic People\'s Republic of',
		  'KR' => 'Korea, Republic of',
		  'KW' => 'Kuwait',
		  'KG' => 'Kyrgyzstan',
		  'LA' => 'Lao People\'s Democratic Republic',
		  'LV' => 'Latvia',
		  'LB' => 'Lebanon',
		  'LS' => 'Lesotho',
		  'LR' => 'Liberia',
		  'LY' => 'Libyan Arab Jamahiriya',
		  'LI' => 'Liechtenstein',
		  'LT' => 'Lithuania',
		  'LU' => 'Luxembourg',
		  'MO' => 'Macao',
		  'MK' => 'Macedonia, the Former Yugoslav Republic of',
		  'MG' => 'Madagascar',
		  'MW' => 'Malawi',
		  'MY' => 'Malaysia',
		  'MV' => 'Maldives',
		  'ML' => 'Mali',
		  'MT' => 'Malta',
		  'MH' => 'Marshall Islands',
		  'MQ' => 'Martinique',
		  'MR' => 'Mauritania',
		  'MU' => 'Mauritius',
		  'YT' => 'Mayotte',
		  'MX' => 'Mexico',
		  'FM' => 'Micronesia, Federated States of',
		  'MD' => 'Moldova, Republic of',
		  'MC' => 'Monaco',
		  'MN' => 'Mongolia',
		  'ME' => 'Montenegro',
		  'MS' => 'Montserrat',
		  'MA' => 'Morocco',
		  'MZ' => 'Mozambique',
		  'MM' => 'Myanmar',
		  'NA' => 'Namibia',
		  'NR' => 'Nauru',
		  'NP' => 'Nepal',
		  'NL' => 'Netherlands',
		  'AN' => 'Netherlands Antilles',
		  'NC' => 'New Caledonia',
		  'NZ' => 'New Zealand',
		  'NI' => 'Nicaragua',
		  'NE' => 'Niger',
		  'NG' => 'Nigeria',
		  'NU' => 'Niue',
		  'NF' => 'Norfolk Island',
		  'MP' => 'Northern Mariana Islands',
		  'NO' => 'Norway',
		  'OM' => 'Oman',
		  'PK' => 'Pakistan',
		  'PW' => 'Palau',
		  'PS' => 'Palestinian Territory, Occupied',
		  'PA' => 'Panama',
		  'PG' => 'Papua New Guinea',
		  'PY' => 'Paraguay',
		  'PE' => 'Peru',
		  'PH' => 'Philippines',
		  'PN' => 'Pitcairn',
		  'PL' => 'Poland',
		  'PT' => 'Portugal',
		  'PR' => 'Puerto Rico',
		  'QA' => 'Qatar',
		  'RE' => 'Réunion',
		  'RO' => 'Romania',
		  'RU' => 'Russian Federation',
		  'RW' => 'Rwanda',
		  'SH' => 'Saint Helena',
		  'KN' => 'Saint Kitts and Nevis',
		  'LC' => 'Saint Lucia',
		  'PM' => 'Saint Pierre and Miquelon',
		  'VC' => 'Saint Vincent and the Grenadines',
		  'WS' => 'Samoa',
		  'SM' => 'San Marino',
		  'ST' => 'Sao Tome and Principe',
		  'SA' => 'Saudi Arabia',
		  'SN' => 'Senegal',
		  'RS' => 'Serbia',
		  'SC' => 'Seychelles',
		  'SL' => 'Sierra Leone',
		  'SG' => 'Singapore',
		  'SK' => 'Slovakia',
		  'SI' => 'Slovenia',
		  'SB' => 'Solomon Islands',
		  'SO' => 'Somalia',
		  'ZA' => 'South Africa',
		  'GS' => 'South Georgia and the South Sandwich Islands',
		  'ES' => 'Spain',
		  'LK' => 'Sri Lanka',
		  'SD' => 'Sudan',
		  'SR' => 'Suriname',
		  'SJ' => 'Svalbard and Jan Mayen',
		  'SZ' => 'Swaziland',
		  'SE' => 'Sweden',
		  'CH' => 'Switzerland',
		  'SY' => 'Syrian Arab Republic',
		  'TW' => 'Taiwan, Province of China',
		  'TJ' => 'Tajikistan',
		  'TZ' => 'Tanzania, United Republic of',
		  'TH' => 'Thailand',
		  'TL' => 'Timor-Leste',
		  'TG' => 'Togo',
		  'TK' => 'Tokelau',
		  'TO' => 'Tonga',
		  'TT' => 'Trinidad and Tobago',
		  'TN' => 'Tunisia',
		  'TR' => 'Turkey',
		  'TM' => 'Turkmenistan',
		  'TC' => 'Turks and Caicos Islands',
		  'TV' => 'Tuvalu',
		  'UG' => 'Uganda',
		  'UA' => 'Ukraine',
		  'AE' => 'United Arab Emirates',
		  'GB' => 'United Kingdom',
		  'US' => 'United States',
		  'UM' => 'United States Minor Outlying Islands',
		  'UY' => 'Uruguay',
		  'UZ' => 'Uzbekistan',
		  'VU' => 'Vanuatu',
		  'VE' => 'Venezuela',
		  'VN' => 'Viet Nam',
		  'VG' => 'Virgin Islands, British',
		  'VI' => 'Virgin Islands, U.S.',
		  'WF' => 'Wallis and Futuna',
		  'EH' => 'Western Sahara',
		  'YE' => 'Yemen',
		  'ZM' => 'Zambia',
		  'ZW' => 'Zimbabwe',
	    );
	    
	    if(array_key_exists($name, $countrycodes))
		    return $countrycodes[$name];
		else
			return "Unknown country";
	}
}

if(!function_exists('get_country_code_by_name'))
{
	function get_country_code_by_name($name)
	{
		$countrycodes = array (
		  'AF' => 'Afghanistan',
		  'AX' => 'Åland Islands',
		  'AL' => 'Albania',
		  'DZ' => 'Algeria',
		  'AS' => 'American Samoa',
		  'AD' => 'Andorra',
		  'AO' => 'Angola',
		  'AI' => 'Anguilla',
		  'AQ' => 'Antarctica',
		  'AG' => 'Antigua and Barbuda',
		  'AR' => 'Argentina',
		  'AU' => 'Australia',
		  'AT' => 'Austria',
		  'AZ' => 'Azerbaijan',
		  'BS' => 'Bahamas',
		  'BH' => 'Bahrain',
		  'BD' => 'Bangladesh',
		  'BB' => 'Barbados',
		  'BY' => 'Belarus',
		  'BE' => 'Belgium',
		  'BZ' => 'Belize',
		  'BJ' => 'Benin',
		  'BM' => 'Bermuda',
		  'BT' => 'Bhutan',
		  'BO' => 'Bolivia',
		  'BA' => 'Bosnia and Herzegovina',
		  'BW' => 'Botswana',
		  'BV' => 'Bouvet Island',
		  'BR' => 'Brazil',
		  'IO' => 'British Indian Ocean Territory',
		  'BN' => 'Brunei Darussalam',
		  'BG' => 'Bulgaria',
		  'BF' => 'Burkina Faso',
		  'BI' => 'Burundi',
		  'KH' => 'Cambodia',
		  'CM' => 'Cameroon',
		  'CA' => 'Canada',
		  'CV' => 'Cape Verde',
		  'KY' => 'Cayman Islands',
		  'CF' => 'Central African Republic',
		  'TD' => 'Chad',
		  'CL' => 'Chile',
		  'CN' => 'China',
		  'CX' => 'Christmas Island',
		  'CC' => 'Cocos (Keeling) Islands',
		  'CO' => 'Colombia',
		  'KM' => 'Comoros',
		  'CG' => 'Congo',
		  'CD' => 'Zaire',
		  'CK' => 'Cook Islands',
		  'CR' => 'Costa Rica',
		  'CI' => 'Côte D\'Ivoire',
		  'HR' => 'Croatia',
		  'CU' => 'Cuba',
		  'CY' => 'Cyprus',
		  'CZ' => 'Czech Republic',
		  'DK' => 'Denmark',
		  'DJ' => 'Djibouti',
		  'DM' => 'Dominica',
		  'DO' => 'Dominican Republic',
		  'EC' => 'Ecuador',
		  'EG' => 'Egypt',
		  'SV' => 'El Salvador',
		  'GQ' => 'Equatorial Guinea',
		  'ER' => 'Eritrea',
		  'EE' => 'Estonia',
		  'ET' => 'Ethiopia',
		  'FK' => 'Falkland Islands (Malvinas)',
		  'FO' => 'Faroe Islands',
		  'FJ' => 'Fiji',
		  'FI' => 'Finland',
		  'FR' => 'France',
		  'GF' => 'French Guiana',
		  'PF' => 'French Polynesia',
		  'TF' => 'French Southern Territories',
		  'GA' => 'Gabon',
		  'GM' => 'Gambia',
		  'GE' => 'Georgia',
		  'DE' => 'Germany',
		  'GH' => 'Ghana',
		  'GI' => 'Gibraltar',
		  'GR' => 'Greece',
		  'GL' => 'Greenland',
		  'GD' => 'Grenada',
		  'GP' => 'Guadeloupe',
		  'GU' => 'Guam',
		  'GT' => 'Guatemala',
		  'GG' => 'Guernsey',
		  'GN' => 'Guinea',
		  'GW' => 'Guinea-Bissau',
		  'GY' => 'Guyana',
		  'HT' => 'Haiti',
		  'HM' => 'Heard Island and Mcdonald Islands',
		  'VA' => 'Vatican City State',
		  'HN' => 'Honduras',
		  'HK' => 'Hong Kong',
		  'HU' => 'Hungary',
		  'IS' => 'Iceland',
		  'IN' => 'India',
		  'ID' => 'Indonesia',
		  'IR' => 'Iran, Islamic Republic of',
		  'IQ' => 'Iraq',
		  'IE' => 'Ireland',
		  'IM' => 'Isle of Man',
		  'IL' => 'Israel',
		  'IT' => 'Italy',
		  'JM' => 'Jamaica',
		  'JP' => 'Japan',
		  'JE' => 'Jersey',
		  'JO' => 'Jordan',
		  'KZ' => 'Kazakhstan',
		  'KE' => 'KENYA',
		  'KI' => 'Kiribati',
		  'KP' => 'Korea, Democratic People\'s Republic of',
		  'KR' => 'Korea, Republic of',
		  'KW' => 'Kuwait',
		  'KG' => 'Kyrgyzstan',
		  'LA' => 'Lao People\'s Democratic Republic',
		  'LV' => 'Latvia',
		  'LB' => 'Lebanon',
		  'LS' => 'Lesotho',
		  'LR' => 'Liberia',
		  'LY' => 'Libyan Arab Jamahiriya',
		  'LI' => 'Liechtenstein',
		  'LT' => 'Lithuania',
		  'LU' => 'Luxembourg',
		  'MO' => 'Macao',
		  'MK' => 'Macedonia, the Former Yugoslav Republic of',
		  'MG' => 'Madagascar',
		  'MW' => 'Malawi',
		  'MY' => 'Malaysia',
		  'MV' => 'Maldives',
		  'ML' => 'Mali',
		  'MT' => 'Malta',
		  'MH' => 'Marshall Islands',
		  'MQ' => 'Martinique',
		  'MR' => 'Mauritania',
		  'MU' => 'Mauritius',
		  'YT' => 'Mayotte',
		  'MX' => 'Mexico',
		  'FM' => 'Micronesia, Federated States of',
		  'MD' => 'Moldova, Republic of',
		  'MC' => 'Monaco',
		  'MN' => 'Mongolia',
		  'ME' => 'Montenegro',
		  'MS' => 'Montserrat',
		  'MA' => 'Morocco',
		  'MZ' => 'Mozambique',
		  'MM' => 'Myanmar',
		  'NA' => 'Namibia',
		  'NR' => 'Nauru',
		  'NP' => 'Nepal',
		  'NL' => 'Netherlands',
		  'AN' => 'Netherlands Antilles',
		  'NC' => 'New Caledonia',
		  'NZ' => 'New Zealand',
		  'NI' => 'Nicaragua',
		  'NE' => 'Niger',
		  'NG' => 'Nigeria',
		  'NU' => 'Niue',
		  'NF' => 'Norfolk Island',
		  'MP' => 'Northern Mariana Islands',
		  'NO' => 'Norway',
		  'OM' => 'Oman',
		  'PK' => 'Pakistan',
		  'PW' => 'Palau',
		  'PS' => 'Palestinian Territory, Occupied',
		  'PA' => 'Panama',
		  'PG' => 'Papua New Guinea',
		  'PY' => 'Paraguay',
		  'PE' => 'Peru',
		  'PH' => 'Philippines',
		  'PN' => 'Pitcairn',
		  'PL' => 'Poland',
		  'PT' => 'Portugal',
		  'PR' => 'Puerto Rico',
		  'QA' => 'Qatar',
		  'RE' => 'Réunion',
		  'RO' => 'Romania',
		  'RU' => 'Russian Federation',
		  'RW' => 'Rwanda',
		  'SH' => 'Saint Helena',
		  'KN' => 'Saint Kitts and Nevis',
		  'LC' => 'Saint Lucia',
		  'PM' => 'Saint Pierre and Miquelon',
		  'VC' => 'Saint Vincent and the Grenadines',
		  'WS' => 'Samoa',
		  'SM' => 'San Marino',
		  'ST' => 'Sao Tome and Principe',
		  'SA' => 'Saudi Arabia',
		  'SN' => 'Senegal',
		  'RS' => 'Serbia',
		  'SC' => 'Seychelles',
		  'SL' => 'Sierra Leone',
		  'SG' => 'Singapore',
		  'SK' => 'Slovakia',
		  'SI' => 'Slovenia',
		  'SB' => 'Solomon Islands',
		  'SO' => 'Somalia',
		  'ZA' => 'South Africa',
		  'GS' => 'South Georgia and the South Sandwich Islands',
		  'ES' => 'Spain',
		  'LK' => 'Sri Lanka',
		  'SD' => 'Sudan',
		  'SR' => 'Suriname',
		  'SJ' => 'Svalbard and Jan Mayen',
		  'SZ' => 'Swaziland',
		  'SE' => 'Sweden',
		  'CH' => 'Switzerland',
		  'SY' => 'Syrian Arab Republic',
		  'TW' => 'Taiwan, Province of China',
		  'TJ' => 'Tajikistan',
		  'TZ' => 'Tanzania, United Republic of',
		  'TH' => 'Thailand',
		  'TL' => 'Timor-Leste',
		  'TG' => 'Togo',
		  'TK' => 'Tokelau',
		  'TO' => 'Tonga',
		  'TT' => 'Trinidad and Tobago',
		  'TN' => 'Tunisia',
		  'TR' => 'Turkey',
		  'TM' => 'Turkmenistan',
		  'TC' => 'Turks and Caicos Islands',
		  'TV' => 'Tuvalu',
		  'UG' => 'Uganda',
		  'UA' => 'Ukraine',
		  'AE' => 'United Arab Emirates',
		  'GB' => 'United Kingdom',
		  'US' => 'United States',
		  'UM' => 'United States Minor Outlying Islands',
		  'UY' => 'Uruguay',
		  'UZ' => 'Uzbekistan',
		  'VU' => 'Vanuatu',
		  'VE' => 'Venezuela',
		  'VN' => 'Viet Nam',
		  'VG' => 'Virgin Islands, British',
		  'VI' => 'Virgin Islands, U.S.',
		  'WF' => 'Wallis and Futuna',
		  'EH' => 'Western Sahara',
		  'YE' => 'Yemen',
		  'ZM' => 'Zambia',
		  'ZW' => 'Zimbabwe',
	    );
	    
	    $country_code = array_search($name, $countrycodes);
	    
	    if($country_code != FALSE)
		    return strtolower($country_code);
		else
			return "Unknown country";
	}
}

function randomCountry()
{
	$countrycodes = array (
	  'AF' => 'Afghanistan',
	  'AX' => 'Åland Islands',
	  'AL' => 'Albania',
	  'DZ' => 'Algeria',
	  'AS' => 'American Samoa',
	  'AD' => 'Andorra',
	  'AO' => 'Angola',
	  'AI' => 'Anguilla',
	  'AQ' => 'Antarctica',
	  'AG' => 'Antigua and Barbuda',
	  'AR' => 'Argentina',
	  'AU' => 'Australia',
	  'AT' => 'Austria',
	  'AZ' => 'Azerbaijan',
	  'BS' => 'Bahamas',
	  'BH' => 'Bahrain',
	  'BD' => 'Bangladesh',
	  'BB' => 'Barbados',
	  'BY' => 'Belarus',
	  'BE' => 'Belgium',
	  'BZ' => 'Belize',
	  'BJ' => 'Benin',
	  'BM' => 'Bermuda',
	  'BT' => 'Bhutan',
	  'BO' => 'Bolivia',
	  'BA' => 'Bosnia and Herzegovina',
	  'BW' => 'Botswana',
	  'BV' => 'Bouvet Island',
	  'BR' => 'Brazil',
	  'IO' => 'British Indian Ocean Territory',
	  'BN' => 'Brunei Darussalam',
	  'BG' => 'Bulgaria',
	  'BF' => 'Burkina Faso',
	  'BI' => 'Burundi',
	  'KH' => 'Cambodia',
	  'CM' => 'Cameroon',
	  'CA' => 'Canada',
	  'CV' => 'Cape Verde',
	  'KY' => 'Cayman Islands',
	  'CF' => 'Central African Republic',
	  'TD' => 'Chad',
	  'CL' => 'Chile',
	  'CN' => 'China',
	  'CX' => 'Christmas Island',
	  'CC' => 'Cocos (Keeling) Islands',
	  'CO' => 'Colombia',
	  'KM' => 'Comoros',
	  'CG' => 'Congo',
	  'CD' => 'Zaire',
	  'CK' => 'Cook Islands',
	  'CR' => 'Costa Rica',
	  'CI' => 'Côte D\'Ivoire',
	  'HR' => 'Croatia',
	  'CU' => 'Cuba',
	  'CY' => 'Cyprus',
	  'CZ' => 'Czech Republic',
	  'DK' => 'Denmark',
	  'DJ' => 'Djibouti',
	  'DM' => 'Dominica',
	  'DO' => 'Dominican Republic',
	  'EC' => 'Ecuador',
	  'EG' => 'Egypt',
	  'SV' => 'El Salvador',
	  'GQ' => 'Equatorial Guinea',
	  'ER' => 'Eritrea',
	  'EE' => 'Estonia',
	  'ET' => 'Ethiopia',
	  'FK' => 'Falkland Islands (Malvinas)',
	  'FO' => 'Faroe Islands',
	  'FJ' => 'Fiji',
	  'FI' => 'Finland',
	  'FR' => 'France',
	  'GF' => 'French Guiana',
	  'PF' => 'French Polynesia',
	  'TF' => 'French Southern Territories',
	  'GA' => 'Gabon',
	  'GM' => 'Gambia',
	  'GE' => 'Georgia',
	  'DE' => 'Germany',
	  'GH' => 'Ghana',
	  'GI' => 'Gibraltar',
	  'GR' => 'Greece',
	  'GL' => 'Greenland',
	  'GD' => 'Grenada',
	  'GP' => 'Guadeloupe',
	  'GU' => 'Guam',
	  'GT' => 'Guatemala',
	  'GG' => 'Guernsey',
	  'GN' => 'Guinea',
	  'GW' => 'Guinea-Bissau',
	  'GY' => 'Guyana',
	  'HT' => 'Haiti',
	  'HM' => 'Heard Island and Mcdonald Islands',
	  'VA' => 'Vatican City State',
	  'HN' => 'Honduras',
	  'HK' => 'Hong Kong',
	  'HU' => 'Hungary',
	  'IS' => 'Iceland',
	  'IN' => 'India',
	  'ID' => 'Indonesia',
	  'IR' => 'Iran, Islamic Republic of',
	  'IQ' => 'Iraq',
	  'IE' => 'Ireland',
	  'IM' => 'Isle of Man',
	  'IL' => 'Israel',
	  'IT' => 'Italy',
	  'JM' => 'Jamaica',
	  'JP' => 'Japan',
	  'JE' => 'Jersey',
	  'JO' => 'Jordan',
	  'KZ' => 'Kazakhstan',
	  'KE' => 'KENYA',
	  'KI' => 'Kiribati',
	  'KP' => 'Korea, Democratic People\'s Republic of',
	  'KR' => 'Korea, Republic of',
	  'KW' => 'Kuwait',
	  'KG' => 'Kyrgyzstan',
	  'LA' => 'Lao People\'s Democratic Republic',
	  'LV' => 'Latvia',
	  'LB' => 'Lebanon',
	  'LS' => 'Lesotho',
	  'LR' => 'Liberia',
	  'LY' => 'Libyan Arab Jamahiriya',
	  'LI' => 'Liechtenstein',
	  'LT' => 'Lithuania',
	  'LU' => 'Luxembourg',
	  'MO' => 'Macao',
	  'MK' => 'Macedonia, the Former Yugoslav Republic of',
	  'MG' => 'Madagascar',
	  'MW' => 'Malawi',
	  'MY' => 'Malaysia',
	  'MV' => 'Maldives',
	  'ML' => 'Mali',
	  'MT' => 'Malta',
	  'MH' => 'Marshall Islands',
	  'MQ' => 'Martinique',
	  'MR' => 'Mauritania',
	  'MU' => 'Mauritius',
	  'YT' => 'Mayotte',
	  'MX' => 'Mexico',
	  'FM' => 'Micronesia, Federated States of',
	  'MD' => 'Moldova, Republic of',
	  'MC' => 'Monaco',
	  'MN' => 'Mongolia',
	  'ME' => 'Montenegro',
	  'MS' => 'Montserrat',
	  'MA' => 'Morocco',
	  'MZ' => 'Mozambique',
	  'MM' => 'Myanmar',
	  'NA' => 'Namibia',
	  'NR' => 'Nauru',
	  'NP' => 'Nepal',
	  'NL' => 'Netherlands',
	  'AN' => 'Netherlands Antilles',
	  'NC' => 'New Caledonia',
	  'NZ' => 'New Zealand',
	  'NI' => 'Nicaragua',
	  'NE' => 'Niger',
	  'NG' => 'Nigeria',
	  'NU' => 'Niue',
	  'NF' => 'Norfolk Island',
	  'MP' => 'Northern Mariana Islands',
	  'NO' => 'Norway',
	  'OM' => 'Oman',
	  'PK' => 'Pakistan',
	  'PW' => 'Palau',
	  'PS' => 'Palestinian Territory, Occupied',
	  'PA' => 'Panama',
	  'PG' => 'Papua New Guinea',
	  'PY' => 'Paraguay',
	  'PE' => 'Peru',
	  'PH' => 'Philippines',
	  'PN' => 'Pitcairn',
	  'PL' => 'Poland',
	  'PT' => 'Portugal',
	  'PR' => 'Puerto Rico',
	  'QA' => 'Qatar',
	  'RE' => 'Réunion',
	  'RO' => 'Romania',
	  'RU' => 'Russian Federation',
	  'RW' => 'Rwanda',
	  'SH' => 'Saint Helena',
	  'KN' => 'Saint Kitts and Nevis',
	  'LC' => 'Saint Lucia',
	  'PM' => 'Saint Pierre and Miquelon',
	  'VC' => 'Saint Vincent and the Grenadines',
	  'WS' => 'Samoa',
	  'SM' => 'San Marino',
	  'ST' => 'Sao Tome and Principe',
	  'SA' => 'Saudi Arabia',
	  'SN' => 'Senegal',
	  'RS' => 'Serbia',
	  'SC' => 'Seychelles',
	  'SL' => 'Sierra Leone',
	  'SG' => 'Singapore',
	  'SK' => 'Slovakia',
	  'SI' => 'Slovenia',
	  'SB' => 'Solomon Islands',
	  'SO' => 'Somalia',
	  'ZA' => 'South Africa',
	  'GS' => 'South Georgia and the South Sandwich Islands',
	  'ES' => 'Spain',
	  'LK' => 'Sri Lanka',
	  'SD' => 'Sudan',
	  'SR' => 'Suriname',
	  'SJ' => 'Svalbard and Jan Mayen',
	  'SZ' => 'Swaziland',
	  'SE' => 'Sweden',
	  'CH' => 'Switzerland',
	  'SY' => 'Syrian Arab Republic',
	  'TW' => 'Taiwan, Province of China',
	  'TJ' => 'Tajikistan',
	  'TZ' => 'Tanzania, United Republic of',
	  'TH' => 'Thailand',
	  'TL' => 'Timor-Leste',
	  'TG' => 'Togo',
	  'TK' => 'Tokelau',
	  'TO' => 'Tonga',
	  'TT' => 'Trinidad and Tobago',
	  'TN' => 'Tunisia',
	  'TR' => 'Turkey',
	  'TM' => 'Turkmenistan',
	  'TC' => 'Turks and Caicos Islands',
	  'TV' => 'Tuvalu',
	  'UG' => 'Uganda',
	  'UA' => 'Ukraine',
	  'AE' => 'United Arab Emirates',
	  'GB' => 'United Kingdom',
	  'US' => 'United States',
	  'UM' => 'United States Minor Outlying Islands',
	  'UY' => 'Uruguay',
	  'UZ' => 'Uzbekistan',
	  'VU' => 'Vanuatu',
	  'VE' => 'Venezuela',
	  'VN' => 'Viet Nam',
	  'VG' => 'Virgin Islands, British',
	  'VI' => 'Virgin Islands, U.S.',
	  'WF' => 'Wallis and Futuna',
	  'EH' => 'Western Sahara',
	  'YE' => 'Yemen',
	  'ZM' => 'Zambia',
	  'ZW' => 'Zimbabwe',
    );
    
    
    return $countrycodes[array_rand($countrycodes)];
	
}

?>