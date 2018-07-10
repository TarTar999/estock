<?php
	require('../classes/EntrepotStock.php');	
	class EntrepotStockDAO{			
		public function stockOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM entrepotstock WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$stocks = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$matdao=new MaterielDAO();
				$entdao=new EntrepotDAO();
				$mats=$matdao->materielOut("id_materiel=".$data['materiel']);
				$entrepots=$entdao->entrepotOut("id_entrepot=".$data['entrepot']);
				$materiel=$mats[1]['object'][0]['objet'];
				$entrepot=$entrepots[1]['object'][0]['objet'];
				$stock= new EntrepotStock($data['id_stockmat'], $data['qte_disponible'], $materiel, $entrepot);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $role));				
            }
			array_push($stocks,array('resultat' => $results));
			array_push($stocks,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($stocks);
		}
		public function insertEntrepotStock(EntrepotStock $stock){
			include('../config/config.php');
			$sql= "INSERT INTO entrepotstock (`id_stockmat`, `qte_disponible`, `materiel`, `entrepot`) VALUES (NULL, '".$stock->getQteDisponible()."', '".$stock->getMateriel()->getIdMateriel()."', '".$stock->getEntrepot()->getIdEntrepot()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function updateEntrepotStock(EntrepotStock $stock){
			include('../config/config.php');
			$sql="UPDATE entrepotstock SET qte_disponible='".$stock->getQteDisponible()."', materiel='".$stock->getMateriel()->getIdMateriel()"',entrepot='".$stock->getEntrepot()->getIdEntrepot()."' WHERE id_stockmat=".$role->getIdStockMat()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteEntrepotStock(EntrepotStock $stock){
			include('../config/config.php');
			$sql="DELETE FROM entrepotstock WHERE id_stockmat=".$stock->getIdstockmat()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	//$rl=new Role(NULL, "pharmacien");
	//$cmddao=new CommandeDAO();
	//$commandes = array();
	//$commandes = $cmddao->commandeout("1");
	//echo json_encode($commandes);
	//$rl= $commandes[1]['object'][0]['objet'];
	//$rl->setNomRole("Theresa th");
	//$cmddao->deleteCommande($rl);
?>