<?php
session_name('e-stock');
session_start();
require('../objetDAO/EmployeDao.php');

$employedao=new EmployeDAO();
$entitedao=new EntiteDAO();
$roledao=new RoleDAO();

$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
if($action){
	switch ($action) {

		case "getConnected": 
			if(isset($_SESSION['employe'])){
				echo json_encode($_SESSION['employe']);	
			}			
		break;
		case "connected":
			$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));		
			$employes=$employedao->out("id_emp=".$id);
			$employe=$employes[0]['resultat'][0];
			//echo json_encode($employe);
			$entites=$entitedao->out("id_entite=".$employe['result']['entite_emp']);
			$entite=$entites[0]['resultat'][0];

			$roles=$roledao->out("id_role=".$employe['result']['role_emp']);
			$role=$roles[0]['resultat'][0];

			$employe_json = array('employe' => $employe , 'entite' => $entite, 'role' => $role);

			$_SESSION['employe'] = $employe_json;			
			echo json_encode($employe_json);
		break;
		case "deconnexion":
			session_destroy();
		break;

	}

}

	
?>