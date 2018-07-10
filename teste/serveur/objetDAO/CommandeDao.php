<?php
	require('../classes/Commande.php');	
	class CommandeDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM commande WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$employedao=new EmployeDAO();
				$employes=$employedao->out("id_emp=".$data['employe_cmd']);
				$employe=$employes[1]['object'][0]['objet'];
				$obj= new Commande($data['id_cmd'], $data['nbre_mat_cmd'], $data['qte_mat_cmd'], $data['date_cmd'], $employe);				
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
		public function insert(Commande $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO commande (`id_cmd`, `nbre_mat_cmd`, `qte_mat_cmd`, `date_cmd`, `employe_cmd`) VALUES (NULL, '".$arg->getNbreMatCmd()."', '".$arg->getQteMatCmd()."', '".$arg->getDateCmd()."','".$arg->getEmployeCmd()->getIdEmp()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Commande $arg){
			include('../config/config.php');
			$sql="UPDATE commande SET qte_mat_cmd='".$arg->getQteMatCmd()."', nbre_mat_cmd='".$arg->getNbreeMatCmd()."', date_cmd='".$arg->getDateCmd()."',employe_cmd='".$arg->getEmployeCmd()->getIdEmploye()."' WHERE id_cmd=".$arg->getIdCmd()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Commande $arg){
			include('../config/config.php');
			$sql="DELETE FROM cmd WHERE id_cmd=".$arg->getIdCmd()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>