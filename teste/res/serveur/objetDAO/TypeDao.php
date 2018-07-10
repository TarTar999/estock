<?php
	require('../classes/Type.php');	
	class TypeDAO{			
		public function typeOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM type WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$types = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){				
				$type= new Type($data['id_type'], $data['nom_type']);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $type));				
            }
			array_push($types,array('resultat' => $results));
			array_push($types,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($types);
		}		
		public function insertType(Type $type){
			include('../config/config.php');
			$sql= "INSERT INTO type (`id_type`, `nom_type`) VALUES (NULL, '".$type->getNomType()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();
			echo("Je suis ici");
            echo json_encode("ok");					
		}
		public function updateType(Type $type){
			include('../config/config.php');
			$sql="UPDATE type SET nom_type='".$role->getNomType()."' WHERE id_role=".$role->getIdType()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteType(Type $type){
			include('../config/config.php');
			$sql="DELETE FROM type WHERE id_type=".$role->getIdType()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	$tp=new Type(NULL, "type1");
	echo("Nom : ".$tp->getNomType());
	$tpdao=new TypeDAO();
	$tpdao->insertType($tp);
	//$cmddao=new CommandeDAO()
	//$commandes = array();
	//$commandes = $cmddao->commandeout("1");
	//echo json_encode($commandes);
	//$rl= $commandes[1]['object'][0]['objet'];
	//$rl->setNomRole("Theresa th");
	//$cmddao->deleteCommande($rl);
?>