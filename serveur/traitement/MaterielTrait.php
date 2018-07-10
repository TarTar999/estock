<?php 
	require('../objetDAO/MaterielDao.php');
	require('../config/config.php');
	$materieldao=new MaterielDAO();	
	function createObject($id, $nom, $numserie, $typ, $marque){											
		$markdao=new MarqueDAO();
		$typedao=new TypeDAO();
		$marks=$markdao->out("id_marque=".$data['marque']);
		$types=$typedao->out("id_type=".$data['type']);
		$mark=$marks[1]['object'][0]['objet'];
		$type=$types[1]['object'][0]['objet'];
		$obj= new Materiel($id, $nom, $numserie, $typ, $mark);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id_materiel= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$numserie = (isset($_POST['numserie'])? $_POST['numserie']: (isset($_GET['numserie'])? $_GET['numserie']:null));				
				$type = (isset($_POST['type'])? $_POST['type']: (isset($_GET['type'])? $_GET['type']:null));
				$mark = (isset($_POST['mark'])? $_POST['mark']: (isset($_GET['mark'])? $_GET['mark']:null));
				$sql= "INSERT INTO materiel (`id_materiel`, `nom_materiel`, `numero_serie`, `marque`, `type`) VALUES (NULL,?,?,?,?);";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$numserie,$mark,$type));
			break;
			case 'delete':
				$id_materiel= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM materiel WHERE id_materiel=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id_materiel));
	            echo json_encode("ok");
			break;
			case 'out':
				$materiels=$materieldao->out("1");
				echo json_encode($materiels[0]['resultat']);				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM materiel WHERE id_materiel=?;');
	            $req->execute(array($id));			
	            $results = array();				
	           	while($data=$req->fetch(PDO::FETCH_ASSOC)){											
					array_push($results,array('result' => $data));					
	            }		
				//echo ($commandes[1]['object'][1]['objet']);
				echo json_encode($results[0]);			
			break;
			case "update" :
				$id_materiel= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$numserie = (isset($_POST['numserie'])? $_POST['numserie']: (isset($_GET['numserie'])? $_GET['numserie']:null));				
				$type = (isset($_POST['type'])? $_POST['type']: (isset($_GET['type'])? $_GET['type']:null));
				$mark = (isset($_POST['mark'])? $_POST['mark']: (isset($_GET['mark'])? $_GET['mark']:null));			
				$sql="UPDATE materiel SET nom_materiel=?, numero_serie=?, marque=?, type=? WHERE id_materiel=?;";
				$req=$BDD->prepare($sql);
	            $req->execute(array($nom,$numserie,$mark,$type,$id_materiel));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}	
?>