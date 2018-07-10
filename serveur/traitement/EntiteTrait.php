<?php 
	require('../objetDAO/EntiteDao.php');
	require('../config/config.php');
	$entitedao=new EntiteDAO();
	function createObject($id, $nom, $nomenclature){											
		$obj= new Entite($id, $nom, $nomenclature);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$nomenclature = (isset($_POST['nomenclature'])? $_POST['nomenclature']: (isset($_GET['nomenclature'])? $_GET['nomenclature']:null));				
				$sql= "INSERT INTO entite (`id_entite`, `nom_entite`, `nomenclature`) VALUES (NULL,?,?);";			
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$nomenclature));    
            	echo json_encode("ok");	
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM entite WHERE id_entite=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case 'out':
				$entites=$entitedao->out("1");
				echo json_encode($entites[0]['resultat']);				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM entite WHERE id_entite=?;');
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
				$nomenclature = (isset($_POST['nomenclature'])? $_POST['nomenclature']: (isset($_GET['nomenclature'])? $_GET['nomenclature']:null));				
				$sql="UPDATE entite SET nom_entite=? , nomenclature=? WHERE id_entite=?;";
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$nomenclature,$id));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}
?>