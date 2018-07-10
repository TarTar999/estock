<?php
	require('../classes/Entrepot.php');	
	class RoleDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM entrepot WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$obj= new Entrepot($data['id_entrepot'], $data['nom_entrepot'], $data['adresse_entrepot'], $data['capacite']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $obj));				
            }
			array_push($finals,array('resultat' => $results));
			array_push($finals,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($finals);
		}
		public function insertEntrepot(Entrepot $arg){
			include('../config/config.php');
			$sql= "INSERT INTO entrepot (`id_entrepot`, `nom_entrepot`, `adresse_entrepot`, `capacite`) VALUES (NULL, '".$arg->getNomEntrepot()."', '".$arg->getAdresseEntrepot()."', '".$arg->getCapacite()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Entrepot $arg){
			include('../config/config.php');
			$sql="UPDATE entrepot SET nom_entrepot='".$arg->getNomEntrepot()."', adresse_entrepot='".$arg->getAdresseEntrepot()."', capacite='".$arg->getCapacite()."' WHERE id_entrepot=".$arg->getIdEntrepot()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Entrepot $arg){
			include('../config/config.php');
			$sql="DELETE FROM entrepot WHERE id_entrepot=".$arg->getIdEntrepot()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>