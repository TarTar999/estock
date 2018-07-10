<?php
	require('../classes/LivraisonLigne.php');	
	class LivraisonLigneDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM livraisonligne WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$livreedao=new LivraisonDAO();
				$livrees=$livreedao->out("id_livraison=".$data['livraison']);
				$livree=$livrees[1]['object'][0]['objet'];
				
				$matdao=new MaterielDAO();
				$mats=$matdao->materielOut("id_materiel=".$data['materiel']);
				$mat=$mats[1]['object'][0]['objet'];
				$obj= new LivraisonLigne($data['id_ligneentree'], $data['qte_entree'], $livree, $mat);				
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
		public function insert(LivraisonLigne $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO livraisonligne (`id_lignelivraison`, `qte_livree`, `livraison`, `materiel`) VALUES (NULL, '".$arg->getQteLivree()."', '".$arg->getLivraison()->getIdLivraison()."','".$arg->getMateriel()->getIdMateriel()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(LivraisonLigne $arg{
			include('../config/config.php');
			$sql="UPDATE livraisonligne SET qte_livree='".$arg->getQteLivree()."',livraison='".$arg->getLivraison()->getIdLivraison()."',materiel='".$arg->getMateriel()->getIdMateriel()."' WHERE id_lignelivraison=".$arg->getIdLivraisonLigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(LivraisonLigne $arg){
			include('../config/config.php');
			$sql="DELETE FROM livraisonligne WHERE id_lignelivraison=".$arg->getIdLivraisonLigne()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>