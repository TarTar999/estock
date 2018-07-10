<?php
	require('../classes/Role.php');	
	class RoleDAO{			
		public function roleOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM role WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$roles = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$role= new Role($data['id_role'], $data['nom_role']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $role));				
            }
			array_push($roles,array('resultat' => $results));
			array_push($roles,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($roles);
		}
		public function insertRole(Role $role){
			include('../config/config.php');
			$sql= "INSERT INTO role (`id_role`, `nom_role`) VALUES (NULL, '".$role->getNomRole()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function updateRole(Role $role){
			include('../config/config.php');
			$sql="UPDATE role SET nom_role='".$role->getNomRole()."' WHERE id_role=".$role->getIdRole()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteRole(Role $role){
			include('../config/config.php');
			$sql="DELETE FROM role WHERE id_role=".$role->getIdRole()."";
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