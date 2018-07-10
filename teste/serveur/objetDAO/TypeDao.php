<?php
	require('../classes/Type.php');	
	class TypeDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM type WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$obj= new Type($data['id_type'], $data['nom_type']);				
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
		public function insert(Type $arg){
			include('../config/config.php');
			$sql= "INSERT INTO type (`id_type`, `nom_type`) VALUES (NULL, '".$arg->getNomType()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();			
            echo json_encode("ok");					
		}
		public function update(Type $arg){
			include('../config/config.php');
			$sql="UPDATE type SET nom_type='".$arg->getNomType()."' WHERE id_type=".$arg->getIdType()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Type $arg){
			include('../config/config.php');
			$sql="DELETE FROM type WHERE id_type=".$arg->getIdType()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>