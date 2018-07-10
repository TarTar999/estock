<?php
	require('../classes/Marque.php');	
	class MarqueDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM marque WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$obj= new Marque($data['id_marque'], $data['nom_marque']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $obj));				
            }
			array_push($finals,array('resultat' => $results));
			array_push($finals,array('object' => $objets));			
			return ($finals);
		}
		public function insert(Marque $arg){
			include('../config/config.php');
			$sql= "INSERT INTO marque (`id_marque`, `nom_marque`) VALUES (NULL, '".$arg->getNomMarque()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Marque $arg){
			include('../config/config.php');
			$sql="UPDATE marque SET nom_marque='".$arg->getNomMarque()."' WHERE id_marque=".$arg->getIdMarque()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Marque $arg){
			include('../config/config.php');
			$sql="DELETE FROM marque WHERE id_marque=".$arg->getIdMarque()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>