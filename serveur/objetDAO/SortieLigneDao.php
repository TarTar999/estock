<?php
	require('../classes/SortieLigne.php');	
	require('MaterielDao.php');	
	class SortieLigneDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM sortieligne WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$sortiedao=new SortieDAO();
				$sorties=$sortiedao->out("id_sortie=".$data['sortie']);
				$sortie=$sorties[1]['object'][0]['objet'];

				$entitedao=new EntiteDAO();
				$entites=$entitedao->out("id_entite=".$data['entite']);
				$entite=$entites[1]['object'][0]['objet'];

				$matdao=new MaterielDAO();
				$mats=$matdao->out("id_materiel=".$data['materiel']);
				$mat=$mats[1]['object'][0]['objet'];
				$obj= new SortieLigne($data['id_lignesortie'], $data['qte_sortie'], $sortie, $mat, $entite);				
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
		public function insert(SortieLigne $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO sortieligne (`id_lignesortie`, `qte_sortie`, `sortie`, `materiel`, `entite`, `etat`) VALUES (NULL, '".$arg->getQteSortie()."', '".$arg->getSortie()->getIdSortie()."','".$arg->getMateriel()->getIdMateriel()."','".$arg->getEntite()->getIdEntite()."','".$arg->getEtat()->getIdEtat()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(SortieLigne $arg){
			include('../config/config.php');
			$sql="UPDATE sortieligne SET qte_sortie='".$arg->getQteSortie()."',sortie='".$arg->getSortie()->getIdSortie()."',materiel='".$arg->getMateriel()->getIdMateriel()."',entite='".$arg->getEntite()->getIdEntite()."',etat='".$arg->getEtat()->getIdEtat()."' WHERE id_lignesortie=".$arg->getIdSortieLigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(SortieLigne $arg){
			include('../config/config.php');
			$sql="DELETE FROM sortieligne WHERE id_lignesortie=".$arg->getIdSortieLigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>