<?php
	require('../classes/Materiel.php');	
	class MaterielDAO{			
		public function materielOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM materiel WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$materiels = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				//Récupération des objets marque et type
				$markdao=new MarqueDAO();
				$typedao=new TypeDAO();
				$marks=$markdao->marqueOut("id_marque=".$data['marque']);
				$types=$typedao->typeOut("id_type=".$data['type']);
				$mark=$marks[1]['object'][0]['objet'];
				$type=$types[1]['object'][0]['objet'];
				$materiel= new Materiel($data['id_materiel'], $data['nom_materiel'], $data['numero_serie'], $mark, $type);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $materiel));				
            }
			array_push($materiels,array('resultat' => $results));
			array_push($materiels,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($materiels);
		}
		public function insertMateriel(Materiel $mat){
			include('../config/config.php');
			
			$sql= "INSERT INTO materiel (`id_materiel`, `nom_materiel`, `numero_serie`, `marque`, `type`) VALUES (NULL, '".$mat->getNomMateriel()."', '".$mat->getNumSerie()."','".$mat->getMarque()->getIdMarque()."','".$mat->getType()->getIdType()."');";			
			echo($sql);
			$req=$BDD->prepare($sql);
            $req->execute();			
            echo json_encode("ok");					
		}
		public function updateMateriel(Materiel $mat){
			include('../config/config.php');
			$sql="UPDATE materiel SET nom_materiel='".$mat->getNomMateriel()."',numero_serie='".$mat->getNumSerie()."',marque='".$mat->getMarque()->getIdMarque()."',type='".$mat->getType()->getIdType()."', WHERE id_materiel=".$role->getIdMateriel()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteMateriel(Materiel $mat){
			include('../config/config.php');
			$sql="DELETE FROM materiel WHERE id_materiel=".$mat->getIdMateriel()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	/*include('MarqueDao.php');
	include('TypeDao.php');	
	$mqdao=new MarqueDao();
	$tpdao=new TypeDao();	
	$mqs=$mqdao->marqueOut("1");	
	$types=$tpdao->typeOut("1");
	$tp=$types[1]['object'][0]['objet'];
	$mq=$mqs[1]['object'][0]['objet'];
	$rl=new Materiel(NULL, "materiel1", "serialnumber", $mq, $tp);
	$matdao=new MaterielDao();
	$matdao->insertMateriel($rl);*/
	//$cmddao=new CommandeDAO();
	//$commandes = array();
	//$commandes = $cmddao->commandeout("1");
	//echo json_encode($commandes);
	//$rl= $commandes[1]['object'][0]['objet'];
	//$rl->setNomRole("Theresa th");
	//$cmddao->deleteCommande($rl);
?>