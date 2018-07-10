<?php
	require('../classes/EntreeLigne.php');
	require('../objetDAO/MaterielDAO.php');	
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
				$obj= new EntreeLigne($data['id_ligneentre'], $data['qte_entree'], $entree, $mat);				
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
		public function insert(EntreeLigne $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO entreeligne (`id_ligneentre`, `qte_entree`, `entree`, `materiel`, `etat`) VALUES (NULL, '".$arg->getQteEntree()."', '".$arg->getEntree()->getIdEntree()."','".$arg->getMateriel()->getIdMateriel()."','".$arg->getEtat()->getIdEtat()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(EntreeLigne $arg){
			include('../config/config.php');
			$sql="UPDATE entreeligne SET qte_entree='".$arg->getQteEntree()."',entree='".$arg->getEntree()->getIdEntree()."',materiel='".$arg->getMateriel()->getIdMateriel()."',etat='".$arg->getEtat()->getIdEtat()."' WHERE id_ligneentre=".$arg->getIdEntreeLigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(EntreeLigne $arg){
			include('../config/config.php');
			$sql="DELETE FROM entreeligne WHERE id_ligneentre=".$arg->getIdEntreeligne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}		
?>