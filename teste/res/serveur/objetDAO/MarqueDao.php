<?php
	require('../classes/Marque.php');	
	class MarqueDAO{			
		public function marqueOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM marque WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$marques = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$marque= new Marque($data['id_marque'], $data['nom_marque']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $marque));				
            }
			array_push($marques,array('resultat' => $results));
			array_push($marques,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($marques);
		}
		public function insertMarque(Marque $mark){
			include('../config/config.php');
			$sql= "INSERT INTO marque (`id_marque`, `nom_marque`) VALUES (NULL, '".$mark->getNomMarque()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function updateMarque(Marque $mark){
			include('../config/config.php');
			$sql="UPDATE marque SET nom_marque='".$mark->getNomMarque()."' WHERE id_marque=".$role->getIdMarque()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteMarque(Marque $mark){
			include('../config/config.php');
			$sql="DELETE FROM marque WHERE id_marque=".$mark->getIdMarque()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	/*$mq=new Marque(NULL, "marque1" );
	$mqdao=new MarqueDAO();
	$mqdao->insertMarque($mq);*/
	//$rl=new Role(NULL, "pharmacien");
	//$cmddao=new CommandeDAO();
	//$commandes = array();
	//$commandes = $cmddao->commandeout("1");
	//echo json_encode($commandes);
	//$rl= $commandes[1]['object'][0]['objet'];
	//$rl->setNomRole("Theresa th");
	//$cmddao->deleteCommande($rl);
?>