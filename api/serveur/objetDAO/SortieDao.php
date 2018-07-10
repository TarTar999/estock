<?php
	require('../classes/Sortie.php');	
	class SortieDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM sortie WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$sorties = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$employedao=new EmployeDAO();
				$employes=$employedao->employeOut("id_emp=".$data['employe']);
				$employe=$employes[1]['object'][0]['objet'];
				
				$entitedao=new EntiteDAO();
				$entites=$entitedao->entiteOut("id_entite=".$data['entite']);
				$entite=$entites[1]['object'][0]['objet'];
				
				$entrepotdao=new EntrepotDAO();
				$entrepots=$entrepotdao->entrepotOut("id_entrepot=".$data['entrepot']);
				$entrepot=$entrepots[1]['object'][0]['objet'];
				$sortie= new Sortie($data['id_sortie'], $data['nbre_mat_sortie'], $data['qte_mat_sortie'], $data['date_sortie'], $employe, $entite,$entrepot);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $role));				
            }
			array_push($sorties,array('resultat' => $results));
			array_push($sorties,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($sorties);
		}
		public function insert(Sortie $sortie){
			include('../config/config.php');			
			$sql= "INSERT INTO sortie (`id_sortie`, `nbre_mat_sortie`, `qte_mat_sortie`, `date_sortie`, `employe`, `entite`, `entrepot`) VALUES (NULL, '".$sortie->getNbreMatSortie()."', '".$sortie->getQteMatSortie()."', '".$sortie->getDateSortie()."','".$sortie->getEmploye()->getIdEmp()."','".$sortie->getEntite()->getIdEntite()."','".$sortie->getEntrepot()->getIdEntrepot()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Sortie $sortie){
			include('../config/config.php');
			$sql="UPDATE sortie SET qte_mat_sortie='".$sortie->getQteMatSortie()."', nbre_mat_sortie='".$sortie->getNbreeMatSortie()."', date_sortie='".$sortie->getDateSortie()."',employe='".$sortie->getEmploye()->getIdEmploye()."',entite='".$sortie->getEntite()->getIdEntite()."',entrepot='".$sortie->getEntrepot()->getIdEntrepot()."' WHERE id_sortie=".$sortie->getIdSortie()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Sortie $sortie){
			include('../config/config.php');
			$sql="DELETE FROM sortie WHERE id_sortie=".$sortie->getIdSortie()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>