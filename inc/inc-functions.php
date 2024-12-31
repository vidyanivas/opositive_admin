<?php
if(!function_exists('get_doctors_list'))
{
	function get_doctors_list(){
		global $conn;
		//$res=array();
		$result = mysqli_query($conn, "Select count(id) as total_doctor FROM doctor ");
		if ($result && mysqli_num_rows($result) > 0) {
			$line_data = mysqli_fetch_array($result);
			$res = $line_data['total_doctor'];
		} else {
			$res = 0; // Return an empty value if no title is found
		}
		return $res;
	}
}
if(!function_exists('get_hospital_list'))
{
	function get_hospital_list(){
		global $conn;
		//$res=array();
		$result = mysqli_query($conn, "Select count(id) as total_hospital FROM hospital ");
		if ($result && mysqli_num_rows($result) > 0) {
			$line_data = mysqli_fetch_array($result);
			$res = $line_data['total_hospital'];
		} else {
			$res = 0; // Return an empty value if no title is found
		}
		return $res;
	}
}
if(!function_exists('get_appointment_list'))
{
	function get_appointment_list(){
		global $conn;
		//$res=array();
		$result = mysqli_query($conn, "Select count(id) as total_appointment FROM appointment ");
		if ($result && mysqli_num_rows($result) > 0) {
			$line_data = mysqli_fetch_array($result);
			$res = $line_data['total_appointment'];
		} else {
			$res = 0; // Return an empty value if no title is found
		}
		return $res;
	}
}
if(!function_exists('get_conditions_list'))
{
	function get_conditions_list(){
		global $conn;
		//$res=array();
		$result = mysqli_query($conn, "Select count(id) as total_condition FROM `condition` ");
		if ($result && mysqli_num_rows($result) > 0) {
			$line_data = mysqli_fetch_array($result);
			$res = $line_data['total_condition'];
		} else {
			$res = 0; // Return an empty value if no title is found
		}
		return $res;
	}
}
