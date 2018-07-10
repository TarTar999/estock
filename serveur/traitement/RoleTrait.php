<?php 
	require('../objetDao/RoleDao.php');
	require('../config/config.php');
	$roledao=new RoleDAO();
	function createObject($id, $nom){											
		$obj= new Role($id, $nom);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id_role = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));				
				$sql= "INSERT INTO role (`id_role`, `nom_role`) VALUES (NULL,?);";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom));
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM role WHERE id_role=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case 'out':
				$roles=$roledao->out("1");
				echo json_encode($roles[0]['resultat']);				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM role WHERE id_role=?;');
	            $req->execute(array($id));			
	            $results = array();				
	           	while($data=$req->fetch(PDO::FETCH_ASSOC)){											
					array_push($results,array('result' => $data));					
	            }		
				//echo ($commandes[1]['object'][1]['objet']);
				echo json_encode($results[0]);			
			break;
			case "update" :
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));								
				$sql="UPDATE role SET nom_role=? WHERE id_role=?;";
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$id));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}	
 ?>