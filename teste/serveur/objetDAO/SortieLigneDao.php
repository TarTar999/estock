<?php
	require('../classes/SortieLigne.php');	
	class SortieeLigneDAO{			
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
				
				$matdao=new MaterielDAO();
				$mats=$matdao->out("id_materiel=".$data['materiel']);
				$mat=$mats[1]['object'][0]['objet'];
				$obj= new SortieLigne($data['id_lignesortie'], $data['qte_sortiee'], $sortiee, $mat);				
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
		public function insert(SortieLigne $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO sortieligne (`id_lignesortie`, `qte_sortie`, `sortie`, `materiel`) VALUES (NULL, '".$arg->getQteSortie()."', '".$arg->getSortie()->getIdSortie()."','".$arg->getMateriel()->getIdMateriel()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(SortieLigne $arg){
			include('../config/config.php');
			$sql="UPDATE sortieligne SET qte_sortie='".$arg->getQteSortie()."',sortie='".$arg->getSortie()->getIdSortie()."',materiel='".$arg->getMateriel()->getIdMateriel()."' WHERE id_lignesortie=".$arg->getIdSortieLigne()."";
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
	/**$rl=new Role(NULL, "pharmacien");
	$cmddao=new CommandeDAO();
	$commandes = array();
	$commandes = $cmddao->commandeout("1");
	echo json_encode($commandes);
	$rl= $commandes[1]['object'][0]['objet'];
	$rl->setNomRole("Theresa th");
	$cmddao->deleteCommande($rl);**/
?>