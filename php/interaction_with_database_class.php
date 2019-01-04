<?php
	
	class DataBase{
		
		private static $db = null;
		private $mysqli;
		
		private function __construct(){
			$this -> mysqli = new mysqli("localhost", "root", "", "neural_network_for_products_of_1c");
			$this -> mysqli -> query("SET NAMES 'utf8'");
		}
		
		public static function getDB(){
			if(self::$db == null)
				self::$db = new DataBase();
			return self::$db;
		}
		
		private function resultSetToArray($result_set){
			$array = array();
			while(($row = $result_set -> fetch_assoc()) != false)
				$array[] = $row;
			return $array;
		}
		
		/* более частные методы */
		
		public function insert_category($the_category_name_in_education, $number_inputs_on_education, $threshold_of_a_element, $training_algorithm, $arrangement_of_r_elements, $itetation_of_education, $perfect_output, $best_output, $worst_output, $weights_a_r){
			$this -> mysqli -> query("INSERT INTO `neuro_education` (`category`, `number_of_inputs`, `treshold_A`, `training_algoritm`, `R_arrangement`, `number_of_iteration`, `perfect_output`, `best_output`, `worst_output`, `weights_A_R`) VALUES ('".$the_category_name_in_education."','".$number_inputs_on_education."', '".$threshold_of_a_element."', '".$training_algorithm."', '".$arrangement_of_r_elements."', '".$itetation_of_education."', '".$perfect_output."', '".$best_output."', '".$worst_output."', '".$weights_a_r."')");
		} 
		
		public function getAllCaregoriesWithAGivenSize($number_of_inputs){
			$result_set = $this -> mysqli -> query("SELECT * FROM `neuro_education` WHERE `number_of_inputs`='".$number_of_inputs."'");
			return $this -> resultSetToArray($result_set);
		} 
		
		public function isExistsCategory($category){
			$result_set = $this -> mysqli -> query("SELECT * FROM `neuro_education` WHERE `category`='".$category."'");
			return $this -> resultSetToArray($result_set);
		}
	}
?>