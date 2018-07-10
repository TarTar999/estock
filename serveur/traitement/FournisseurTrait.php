<?php 	
	require('../config/config.php');	
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id_entrepot = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$adresse = (isset($_POST['adresse'])? $_POST['adresse']: (isset($_GET['adresse'])? $_GET['adresse']:null));
				$tel=(isset($_POST['tel'])? $_POST['tel']: (isset($_GET['tel'])? $_GET['tel']:null));
				$sql= "INSERT INTO fournisseur (`id_fournisseur`, `nom_fournisseur`, `adresse_fournisseur`, `tel_fournisseur`) VALUES (NULL, ?,?,?);";			
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$adresse,$tel)); 
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM fournisseur WHERE id_fournisseur=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case 'out':				
				$req=$BDD->prepare('SELECT * FROM fournisseur WHERE 1;');
	            $req->execute();			
	            $results = array();
				$objets = array();
				$finals = array();
	            while($data=$req->fetch(PDO::FETCH_ASSOC)){									
					array_push($results,array('result' => $data));					
	            }							
				echo json_encode($results);				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM fournisseur WHERE id_fournisseur=?;');
	            $req->execute(array($id));			
	            $results = array();				
	           	while($data=$req->fetch(PDO::FETCH_ASSOC)){											
					array_push($results,array('result' => $data));					
	            }		
				//echo ($commandes[1]['object'][1]['objet']);
				echo json_encode($results[0]);			
			break;
			case "update" :
				$id_fournisseur = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$adresse = (isset($_POST['adresse'])? $_POST['adresse']: (isset($_GET['adresse'])? $_GET['adresse']:null));				
				$tel = (isset($_POST['tel'])? $_POST['tel']: (isset($_GET['tel'])? $_GET['tel']:null));								
				$sql="UPDATE fournisseur SET nom_fournisseur=?, adresse_fournisseur=?, tel_fournisseur=? WHERE id_fournisseur=?;";
				$req=$BDD->prepare($sql);
				$req->execute(array($nom,$adresse,$tel,$id_fournisseur));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}	
 ?>