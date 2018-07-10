<?php
	require('../classes/Materiel.php');	
	require('MarqueDao.php');	
	require('TypeDao.php');	
	class MaterielDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM materiel WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				//Récupération des objets marque et type
				$markdao=new MarqueDAO();
				$typedao=new TypeDAO();
				$marks=$markdao->out("id_marque=".$data['marque']);
				$types=$typedao->out("id_type=".$data['type']);
				$mark=$marks[1]['object'][0]['objet'];
				$type=$types[1]['object'][0]['objet'];
				$obj= new Materiel($data['id_materiel'], $data['nom_materiel'], $data['numero_serie'], $mark, $type);				
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
		public function insert(Materiel $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO materiel (`id_materiel`, `nom_materiel`, `numero_serie`, `marque`, `type`) VALUES (NULL, '".$arg->getNomMateriel()."', '".$arg->getNumSerie()."','".$arg->getMarque()->getIdMarque()."','".$arg->getType()->getIdType()."');";			
			echo($sql);
			$req=$BDD->prepare($sql);
            $req->execute();			
            echo json_encode("ok");					
		}
		public function update(Materiel $arg){
			include('../config/config.php');
			$sql="UPDATE materiel SET nom_materiel='".$arg->getNomMateriel()."',numero_serie='".$arg->getNumSerie()."',marque='".$arg>getMarque()->getIdMarque()."',type='".$arg->getType()->getIdType()."', WHERE id_materiel=".$arg->getIdMateriel()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Materiel $arg){
			include('../config/config.php');
			$sql="DELETE FROM materiel WHERE id_materiel=".$arg->getIdMateriel()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>