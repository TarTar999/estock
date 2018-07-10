<?php
	require('../classes/CommandeLigne.php');	
	class CommandeLigneDAO{			
		public function out($filtre)
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM commandeligne WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$cmddao=new CommandeDAO();
				$cmds=$cmddao->out("id_commande=".$data['commande']);
				$cmd=$cmds[1]['object'][0]['objet'];
				
				$matdao=new MaterielDAO();
				$mats=$matdao->out("id_materiel=".$data['materiel']);
				$mat=$mats[1]['object'][0]['objet'];
				$obj= new CommandeLigne($data['id_lignecmd'], $data['qte_cmd'], $cmd, $mat);				
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
		public function insert(CommandeLigne $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO commandeligne (`id_lignecmd`, `qte_cmd`, `commande`, `materiel`) VALUES (NULL, '".$arg->getQteCmd()."', '".$arg->getCommande()->getIdCmd()."','".$arg->getMateriel()->getIdMateriel()."');";
			echo $sql;
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(CommandeLigne $arg){
			include('../config/config.php');
			$sql="UPDATE commandeligne SET qte_cmd='".$arg->getQteCmd()."',commande='".$arg->getCommande()->getIdCmd()."',materiel='".$arg->getMateriel()->getIdMateriel()."' WHERE id_lignecmd=".$arg->getIdLigneCmd()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(CommandeLigne $arg){
			include('../config/config.php');
			$sql="DELETE FROM commandeligne WHERE id_lignecmd=".$arg->getIdLigneCmd()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>