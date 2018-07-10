<?php
	require('../classes/Etat.php');	
	class EtatDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM etat WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$obj= new Etat($data['id_etat'], $data['nom_etat']);				
				//array_push($commandesObjet,$role);
				//echo ("ici");
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $obj));				
            }
			array_push($finals,array('resultat' => $results));
			array_push($finals,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($finals);
		}
		public function insert(Etat $arg){
			include('../config/config.php');
			$sql= "INSERT INTO etat (`id_etat`, `nom_etat`, `nomenclature`) VALUES (NULL, '".$arg->getNomEtat()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Etat $arg){
			include('../config/config.php');
			$sql="UPDATE etat SET nom_etat='".$arg->getNomEtat()."' WHERE id_etat=".$arg->getIdEtat()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Etat $arg){
			include('../config/config.php');
			$sql="DELETE FROM etat WHERE id_etat=".$arg->getIdEtat()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}		
	}	
?>