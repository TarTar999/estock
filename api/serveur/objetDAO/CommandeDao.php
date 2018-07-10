<?php
	require('../classes/Commande.php');	
	class CommandeDAO{			
		public function commandeout($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM commande WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$commandes = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$employedao=new EmployeDAO();
				$employes=$employedao->employeOut("id_emp=".$data['employe_cmd']);
				$employe=$employes[1]['object'][0]['objet'];
				$commande= new Commande($data['id_cmd'], $data['nbre_mat_cmd'], $data['qte_mat_cmd'], $data['date_cmd'], $employe);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $role));				
            }
			array_push($commandes,array('resultat' => $results));
			array_push($commandes,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($commandes);
		}
		public function insertCommande(Commande $cmd){
			include('../config/config.php');			
			$sql= "INSERT INTO commande (`id_cmd`, `nbre_mat_cmd`, `qte_mat_cmd`, `date_cmd`, `employe_cmd`) VALUES (NULL, '".$cmd->getNbreMatCmd()."', '".$cmd->getQteMatCmd()."', '".$cmd->getDateCmd()."','".$cmd->getEmployeCmd()->getIdEmp()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function updateCommande(Commande $cmd){
			include('../config/config.php');
			$sql="UPDATE commande SET qte_mat_cmd='".$cmd->getQteMatCmd()."', nbre_mat_cmd='".$cmd->getNbreeMatCmd()."', date_cmd='".$cmd->getDateCmd()."',employe_cmd='".$cmd->getEmployeCmd()->getIdEmploye()."' WHERE id_cmd=".$cmd->getIdCmd()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteCommande(Commande $cmd){
			include('../config/config.php');
			$sql="DELETE FROM cmd WHERE id_cmd=".$cmd->getIdCmd()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	/**$rl=new Role(NULL, "pharmacien");
	$cmddao=new CommandeDAO();
	$commandes = array();
	$commandes = $cmddao->commandeout("1");
	echo json_encode($commandes);
	$rl= $commandes[1]['object'][0]['objet'];
	$rl->setNomRole("Theresa th");
	$cmddao->deleteCommande($rl);**/
?>