<?php 
	require('../objetDao/EntrepotDao.php');
	require('../config/config.php');
	$entrepotdao=new EntrepotDAO();
	function createObject($id, $nom, $adresse, $capacite){											
		$obj= new Entrepot($id, $nom, $adresse, $capacite);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id_entrepot = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$adresse = (isset($_POST['adresse'])? $_POST['adresse']: (isset($_GET['adresse'])? $_GET['adresse']:null));				
				$capacite = (isset($_POST['capacite'])? $_POST['capacite']: (isset($_GET['capacite'])? $_GET['capacite']:null));	
				$sql= "INSERT INTO entrepot (`id_entrepot`, `nom_entrepot`, `adresse_entrepot`, `capacite`) VALUES (NULL, ?,?,?);";			
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$adresse,$capacite));    
            echo json_encode("ok");	
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM entrepot WHERE id_entrepot=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case 'out':
				$entrepots=$entrepotdao->out("1");
				echo json_encode($entrepots[0]['resultat']);				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM entrepot WHERE id_entrepot=?;');
	            $req->execute(array($id));			
	            $results = array();				
	           	while($data=$req->fetch(PDO::FETCH_ASSOC)){											
					array_push($results,array('result' => $data));					
	            }		
				//echo ($commandes[1]['object'][1]['objet']);
				echo json_encode($results[0]);			
			break;
			case "update" :
				$id_entrepot = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$adresse = (isset($_POST['adresse'])? $_POST['adresse']: (isset($_GET['adresse'])? $_GET['adresse']:null));				
				$capacite = (isset($_POST['capacite'])? $_POST['capacite']: (isset($_GET['capacite'])? $_GET['capacite']:null));								
				$sql="UPDATE entrepot SET nom_entrepot=?, adresse_entrepot=?, capacite=? WHERE id_entrepot=?;";
				$req=$BDD->prepare($sql);
				$req->execute(array($nom,$adresse,$capacite,$id_entrepot));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}	
 ?>