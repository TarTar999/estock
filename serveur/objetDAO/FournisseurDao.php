<?php
	require('../classes/Fournisseur.php');	
	class FournisseurDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM fournisseur WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$obj= new Fournisseur($data['id_fournisseur'], $data['nom_fournisseur'], $data['adresse_fournisseur'],$data['tel_fournisseur'] );				
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
		public function insert(Fournisseur $arg){
			include('../config/config.php');
			$sql= "INSERT INTO fournisseur (`id_fournisseur`, `nom_fournisseur`, `adresse_fournisseur`, `tel_fournisseur`) VALUES (NULL, '".$arg->getNomFournisseur()."', '".$arg->getAdresseFourn()."', '".$arg->getTelFournisseur()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Fournisseur $arg){
			include('../config/config.php');
			$sql="UPDATE fournisseur SET nom_fournisseur='".$arg->getNomFournisseur()."', adresse_fournisseur='".$arg->getAdresseFourn()."', tel_fournisseur='".$arg->getTelFournisseur()."' WHERE id_fournisseur=".$arg->getIdFournisseur()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Fournisseur $arg){
			include('../config/config.php');
			$sql="DELETE FROM fournisseur WHERE id_fournisseur=".$arg->getIdFournisseur()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>