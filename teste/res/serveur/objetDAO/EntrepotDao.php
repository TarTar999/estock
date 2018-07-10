<?php
	require('../classes/Entrepot.php');	
	class RoleDAO{			
		public function roleOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM entrepot WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$entrepots = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$entrepot= new Entrepot($data['id_entrepot'], $data['nom_entrepot'], $data['adresse_entrepot'], $data['capacite']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $entrepot));				
            }
			array_push($entrepots,array('resultat' => $results));
			array_push($entrepots,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($entrepots);
		}
		public function insertEntrepot(Entrepot $ent){
			include('../config/config.php');
			$sql= "INSERT INTO entrepot (`id_entrepot`, `nom_entrepot`, `adresse_entrepot`, `capacite`) VALUES (NULL, '".$ent->getNomEntrepot()."', '".$ent->getAdresseEntrepot()."', '".$ent->getCapacite()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function updateRole(Entrepot $ent){
			include('../config/config.php');
			$sql="UPDATE entrepot SET nom_entrepot='".$ent->getNomEntrepot()."', adresse_entrepot='".$ent->getAdresseEntrepot()."', capacite='".$ent->getCapacite()."' WHERE id_entrepot=".$role->getIdEntrepot()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteRole(Entrepot $ent){
			include('../config/config.php');
			$sql="DELETE FROM entrepot WHERE id_entrepot=".$role->getIdEntrepot()."";
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