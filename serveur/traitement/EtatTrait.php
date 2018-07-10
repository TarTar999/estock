<?php 
	require('../objetDAO/EtatDao.php');
	require('../config/config.php');
	$etatdao=new EtatDAO();
	function createObject($id, $nom){											
		$obj= new Etat($id, $nom);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$sql= "INSERT INTO etat (`id_etat`, `nom_etat`) VALUES (NULL,?);";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom));
			break;
			case 'out':
				$etats=$etatdao->out("1");
				echo json_encode($etats[0]['resultat']);				
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM etat WHERE id_etat=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM etat WHERE id_etat=?;');
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
				$sql="UPDATE etat SET nom_etat=? WHERE id_etat=?;";
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$id));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}
?>