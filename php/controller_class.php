<?php
	require_once "recognizing_class.php";
	require_once "education_class.php";
	session_start();
	
	class Controller{
		
		public function to_receive_the_ajax_requests(){
			
			if(isset($_FILES) && isset($_FILES['image'])) {
				$_SESSION["size_of_fragments_for_recognizing"] = $_POST["size_of_fragments_for_recognizing"];
				//Переданный массив сохраняем в переменной
				$image = $_FILES['image'];
				if($image["name"] === ""){
					echo "file_no_selected";
					exit;
				}
				// Достаем формат изображения
				$imageFormat = explode('.', $image['name']);
				
				$imageFormat = $imageFormat[1];

				// Генерируем новое имя для изображения. Можно сохранить и со старым
				// но это не рекомендуется делать
				$imageName = hash('crc32',time()).'.'.$imageFormat;
				$imageFullName = './../images/training_set/test/'.$imageName;
				
				// Сохраняем тип изображения в переменную
				$imageType = $image['type'];

				// Сверяем доступные форматы изображений, если изображение соответствует,
				// копируем изображение в папку images
				if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
					if (move_uploaded_file($image['tmp_name'],$imageFullName)) {
						$recognize = new Recognizing();
						if(strpos($imageName, "png") !== false)
							$image = imageCreateFromPng("../images/training_set/test/".$imageName);
						if(strpos($imageName, "jpg") !== false)
							$image = imageCreateFromJpeg("../images/training_set/test/".$imageName);
						$recognize -> preprocessing_of_images($image);
					} 
				}	
			}
			
			if($_POST["submit_to_educate"] === "true"){
				$_SESSION["the_category_name_in_education"] = $_POST["the_category_name_in_education"];
				$_SESSION["directory_with_training_set"] = $_POST["directory_with_training_set"];
				$_SESSION["number_inputs_on_education"] = $_POST["number_inputs_on_education"];
				$_SESSION["threshold_of_a_element"] = $_POST["threshold_of_a_element"];
				$_SESSION["learning_algorithm"] = $_POST["learning_algorithm"];
				$_SESSION["arrangement_of_r_elements"] = $_POST["arrangement_of_r_elements"];
				$_SESSION["itetation_of_education"] = $_POST["itetation_of_education"];
				
				$category = $_POST["the_category_name_in_education"];
												
				$education = new Education();
				$education -> get_training_set();
				echo $_SESSION["weights_a_r"];
				unset($_SESSION["the_category_name_in_education"]);
				unset($_SESSION["directory_with_training_set"]);
			}
		}
	}
	
	$controller = new Controller();
	$controller -> to_receive_the_ajax_requests();

	
?>