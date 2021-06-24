<?php
require_once("GeoIP/geoip2.phar");
use GeoIp2\Database\Reader;

class Geoip {

    public function get_country_info($ip_address)
    {
		// City DB
		$reader = new Reader(realpath(dirname(__FILE__)).'/GeoIP/db/GeoLite2-City.mmdb');
		$record = $reader->city($ip_address);
		return $record;
	}

}
