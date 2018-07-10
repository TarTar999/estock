<?php
	require('../classes/Entite.php');	
	class EntiteDAO{			
		public function entiteOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM entite WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$entites = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$ent= new Entite($data['id_entite'], $data['nom_entite'], $data['nomenclature']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $role));				
            }
			array_push($entites,array('resultat' => $results));
			array_push($entites,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($entites);
		}
		public function insertEntite(Entite $entite){
			include('../config/config.php');
			$sql= "INSERT INTO entite (`id_entite`, `nom_entite`, `nomenclature`) VALUES (NULL, '".$entite->getNomEntite()."', '".$entite->getNomenclature()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function updateEntite(Entite $entite){
			include('../config/config.php');
			$sql="UPDATE entite SET nom_entite='".$entite->getNomEntite()."', nomenclature='".$entite->getNomEntite()."' WHERE id_entite=".$role->getIdEntite()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteEntite(Entite $entite){
			include('../config/config.php');
			$sql="DELETE FROM entite WHERE id_entite=".$entite->getIdEntite()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	//$rl=new Role(NULL, "pharmacien");
	//$cmddao=new CommandeDAO();
	//$commandes = array();
	//$commandes = $cmddao->commandeout("1");
	//echo json_encode($commandes);
	//$rl= $commandes[1]['object'][0]['objet'];
	//$rl->setNomRole("Theresa th");
	//$cmddao->deleteCommande($rl);
?>