<?php
	require('../classes/Sortie.php');
	require('../objetDAO/EmployeDao.php');	
	//require('../objetDAO/EntiteDao.php');	
	require('../objetDAO/EntrepotDao.php');	
	class SortieDAO{			
		public function out($filtre)
		{			
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM sortie WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$employedao=new EmployeDAO();
				$employes=$employedao->out("id_emp=".$data['employe']);
				$employe=$employes[1]['object'][0]['objet'];								
				
				$entrepotdao=new EntrepotDAO();
				$entrepots=$entrepotdao->out("id_entrepot=".$data['entrepot']);
				$entrepot=$entrepots[1]['object'][0]['objet'];
				$obj= new Sortie($data['id_sortie'], $data['nbre_mat_sortie'], $data['qte_mat_sortie'], $data['date_sortie'], $employe,$entrepot);				
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
		public function insert(Sortie $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO sortie (`id_sortie`, `nbre_mat_sortie`, `qte_mat_sortie`, `date_sortie`, `employe`, `entrepot`) VALUES (NULL, '".$arg->getNbreMatSortie()."', '".$arg->getQteMatSortie()."', '".$arg->getDateSortie()."','".$arg->getEmploye()->getIdEmp()."','".$arg->getEntrepot()->getIdEntrepot()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            $sql2="SELECT LAST_INSERT_ID() from entree";  
            $req2=$BDD->prepare($sql2);
            $req2->execute(); 
            while($data=$req2->fetch(PDO::FETCH_ASSOC)){
            	$id=$data["LAST_INSERT_ID()"];
            	$arg->setIdSortie($id);
            }            
            //echo json_encode("ok");					            
            return $id;				
		}
		public function update(Sortie $arg){
			include('../config/config.php');
			$sql="UPDATE sortie SET qte_mat_sortie='".$arg->getQteMatSortie()."', nbre_mat_sortie='".$arg->getNbreMatSortie()."', date_sortie='".$arg->getDateSortie()."',employe='".$arg->getEmploye()->getIdEmp()."',entrepot='".$arg->getEntrepot()->getIdEntrepot()."' WHERE id_sortie=".$arg->getIdSortie()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Sortie $arg){
			include('../config/config.php');
			$sql="DELETE FROM sortie WHERE id_sortie=".$arg->getIdSortie()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>