<?php
function siteName()
{
	return "Fleemarket";
}

function siteLogo()
{
	return base_url('app_assets/images/logo.jpg');
}

function checkUserExists($table, $column = "", $value = "")
{
	$ci = &get_instance();

	$result = [];
	if ($column != "" && $value != "") {
		$ci->db->where($column, $value);
		$ci->db->where('is_deleted', "0");
		$check = $ci->db->get($table);
		$result = ($check->num_rows() > 0) ? $check->row_array() : [];
	}

	return $result;
}

function check_upload_exists($id = "")
{
	$ci = &get_instance();
	$result = [];
	if ($id != "") {
		$ci->db->where('fk_user_id', $id);
		$uploads = $ci->db->get("rudra_user_uploads");
		$result = ($uploads->num_rows() > 0) ? $uploads->result() : [];
	}

	return $result;
}


/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2018                  :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function calcDistance($lat1, $lon1, $lat2, $lon2, $unit)
{
	if (!is_numeric($lat1) && !is_numeric($lon1) && !is_numeric($lat2) && !is_numeric($lon2) && ($lat1 == $lat2) && ($lon1 == $lon2)) {
		return 0;
	} else {
		// $theta = $lon1 - $lon2;
		if (is_numeric($lon1) - is_numeric($lon2)) $theta = $lon1 - $lon2;
		else return 0;
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
	/* echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
	echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
	echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>"; */
}


/* End of file common.php */
