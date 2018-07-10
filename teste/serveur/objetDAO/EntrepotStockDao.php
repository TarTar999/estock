<?php
	require('../classes/EntrepotStock.php');	
	class EntrepotStockDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM entrepotstock WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$matdao=new MaterielDAO();
				$entdao=new EntrepotDAO();
				$mats=$matdao->out("id_materiel=".$data['materiel']);
				$entrepots=$entdao->out("id_entrepot=".$data['entrepot']);
				$materiel=$mats[1]['object'][0]['objet'];
				$entrepot=$entrepots[1]['object'][0]['objet'];
				$obj= new EntrepotStock($data['id_stockmat'], $data['qte_disponible'], $materiel, $entrepot);				
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
		public function insert(EntrepotStock $arg){
			include('../config/config.php');
			$sql= "INSERT INTO entrepotstock (`id_stockmat`, `qte_disponible`, `materiel`, `entrepot`) VALUES (NULL, '".$arg->getQteDisponible()."', '".$arg->getMateriel()->getIdMateriel()."', '".$arg->getEntrepot()->getIdEntrepot()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(EntrepotStock $arg){
			include('../config/config.php');
			$sql="UPDATE entrepotstock SET qte_disponible='".$arg->getQteDisponible()."', materiel='".$arg->getMateriel()->getIdMateriel()"',entrepot='".$arg->getEntrepot()->getIdEntrepot()."' WHERE id_stockmat=".$arg->getIdStockMat()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(EntrepotStock $arg){
			include('../config/config.php');
			$sql="DELETE FROM entrepotstock WHERE id_stockmat=".$arg->getIdstockmat()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>