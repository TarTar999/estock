<?php
	$page=(isset($_POST['page'])? $_POST['page']: (isset($_GET['page'])? $_GET['page']:null ));
	if($page){
		$actions=array();
		switch ($page) {			
			case 'sendactionstock':
				$act=(isset($_POST['act'])? $_POST['act']: (isset($_GET['act'])? $_GET['act']:null ));
				array_push($actions,array('actionstock' => $act));
								
				echo json_encode($act);

				break;
			case 'takeactionstock':				
				echo json_encode($actions);
				break;
			
			default:
				# code...
				break;
		}
	}

?>