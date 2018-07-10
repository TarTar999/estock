<?php
	require('../classes/Role.php');	
	class RoleDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM role WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$obj= new Role($data['id_role'], $data['nom_role']);				
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
		public function insert(Role $arg){
			include('../config/config.php');
			$sql= "INSERT INTO role (`id_role`, `nom_role`) VALUES (NULL, '".$arg->getNomRole()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Role $arg){
			include('../config/config.php');
			$sql="UPDATE role SET nom_role='".$arg->getNomRole()."' WHERE id_role=".$arg->getIdRole()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Role $arg){
			include('../config/config.php');
			$sql="DELETE FROM role WHERE id_role=".$arg->getIdRole()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>