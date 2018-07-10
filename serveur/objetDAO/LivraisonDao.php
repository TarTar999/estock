<?php
	require('../classes/Livraison.php');	
	class LivraisonDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM livraison WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$employedao=new EmployeDAO();
				$employes=$employedao->out("id_emp=".$data['employe_cmd']);
				$employe=$employes[1]['object'][0]['objet'];
				
				$fourndao=new FournisseurDAO();
				$fourns=$fourndao->out("id_fournisseur=".$data['fournisseur']);
				$fourn=$fourns[1]['object'][0]['objet'];
				$obj= new Livraison($data['id_livraison'], $data['nbre_mat_livree'], $data['qte_mat_livree'], $data['date_livree'], $employe, $fourn);				
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
		public function insert(Livraison $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO livraison (`id_livraison`, `nbre_mat_livree`, `qte_mat_livree`, `date_livree`, `employe`, `fournisseur`) VALUES (NULL, '".$arg->getNbreMatLivree()."', '".$arg->getQteMatLivree()."', '".$arg->getDateLivree()."','".$arg->getEmploye()->getIdEmp()."','".$arg->getFournisseur()->getIdFournisseur()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Livraison $arg){
			include('../config/config.php');
			$sql="UPDATE livraison SET qte_mat_livree='".$arg->getQteMatLivree()."', nbre_mat_livree='".$arg->getNbreeMatLivree()."', date_livree='".$arg->getDateLivree()."',employe='".$arg->getEmploye()->getIdEmploye()."',fournisseur='".$arg->getFournisseur()->getIdFournisseur()."' WHERE id_livraison=".$arg->getIdLivraison()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Livraison $arg){
			include('../config/config.php');
			$sql="DELETE FROM livraison WHERE id_livraison=".$arg->getIdLivraison()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>