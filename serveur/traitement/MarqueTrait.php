<?php 
	require('../objetDao/MarqueDao.php');
	require('../config/config.php');
	$marquedao=new MarqueDAO();
	function createObject($id, $nom){											
		$obj= new Marque($id, $nom);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id_marque = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));				
				$sql= "INSERT INTO marque (`id_marque`, `nom_marque`) VALUES (NULL,?);";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom));
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM marque WHERE id_marque=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case 'out':
				$marques=$marquedao->out("1");
				echo json_encode($marques[0]['resultat']);				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM marque WHERE id_marque=?;');
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
				$sql="UPDATE marque SET nom_marque=? WHERE id_marque=?;";
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$id));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}	
 ?>