<?php
	require('../classes/EntreeLigne.php');	
	class EntreeLigneDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM entreeligne WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$entreedao=new EntreeDAO();
				$entrees=$entreedao->out("id_entree=".$data['entree']);
				$entree=$entrees[1]['object'][0]['objet'];
				
				$matdao=new MaterielDAO();
				$mats=$matdao->out("id_materiel=".$data['materiel']);
				$mat=$mats[1]['object'][0]['objet'];
				$obj= new EntreeLigne($data['id_ligneentree'], $data['qte_entree'], $entree, $mat);				
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
		public function insert(EntreeLigne $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO entreeligne (`id_ligneentree`, `qte_entree`, `entree`, `materiel`) VALUES (NULL, '".$arg->getQteEntree()."', '".$arg->getEntree()->getIdEntree()."','".$arg->getMateriel()->getIdMateriel()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(EntreeLigne $arg){
			include('../config/config.php');
			$sql="UPDATE entreeligne SET qte_entree='".$arg->getQteEntree()."',entree='".$arg->getEntree()->getIdEntree()."',materiel='".$arg->getMateriel()->getIdMateriel()."' WHERE id_ligneentree=".$arg->getIdEntreeLigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(EntreeLigne $arg){
			include('../config/config.php');
			$sql="DELETE FROM entreeligne WHERE id_ligneentree=".$arg->getIdEntreeigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>