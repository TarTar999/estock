<?php
	require('../classes/Entree.php');	
	class EntreeDAO{			
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
				
				$entrepotdao=new EntrepotDAO();
				$entrepots=$entrepotdao->out("id_entrepot=".$data['entrepot']);
				$ntrepot=$entrepots[1]['object'][0]['objet'];
				$obj= new Entree($data['id_entree'], $data['nbre_mat_entree'], $data['qte_mat_entree'], $data['date_entree'], $employe, $entrepot);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $obj);				
            }
			array_push($finals,array('resultat' => $results));
			array_push($finals,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($finals);
		}
		public function insert(Entree $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO entree (`id_entree`, `nbre_mat_entree`, `qte_mat_entree`, `date_entree`, `employe`, `entrepot`) VALUES (NULL, '".$arg->getNbreMatEntree()."', '".$arg->getQteMatEntree()."', '".$arg->getDateEntree()."','".$arg->getEmploye()->getIdEmp()."','".$arg->getEntrepot()->getIdEntrepot()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Entree $arg){
			include('../config/config.php');
			$sql="UPDATE entree SET qte_mat_entree='".$arg->getQteMatEntree()."', nbre_mat_entree='".$arg->getNbreeMatEntree()."', date_entree='".$entree->getDateEntree()."',employe='".$entree->getEmploye()->getIdEmploye()."',entrepot='".$arg->getEntrepot()->getIdEntrepot()."' WHERE id_entree=".$arg->getIdEntree()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Entree $arg){
			include('../config/config.php');
			$sql="DELETE FROM entree WHERE id_entree=".$arg->getIdEntree()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>