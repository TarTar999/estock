<?php
	require('../classes/Employe.php');	
	class EmployeDAO{			
		public function employeOut($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM employe WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$employes = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				//Récupération des objets marque et type
				$entdao=new EntiteDAO();
				$roledao=new RoleDAO();
				$ents=$entdao->entiteOut("id_entite=".$data['entite_emp']);
				$roles=$roledao->typeOut("id_role=".$data['role_emp']);
				$ent=$ents[1]['object'][0]['objet'];
				$role=$roles[1]['object'][0]['objet'];
				$employe= new Materiel($data['id_emp'], $data['matricule_emp'], $data['nom_emp'], $data['prenom_emp'], $data['login_emp'], $data['pwd_emp'], $ent, $role);				
				//array_push($commandesObjet,$role);
				array_push($results,array('result' => $data));
				array_push($objets,array('objet' => $materiel));				
            }
			array_push($employes,array('resultat' => $results));
			array_push($employes,array('object' => $objets));
			//echo ($commandes[1]['object'][1]['objet']);
			//echo json_encode($commandes[0]['resultat']);
			return ($employes);
		}
		public function insertEmploye(Employe $employe){
			include('../config/config.php');
			
			$sql= "INSERT INTO employe (`id_emp`, `matricule_emp`, `nom_emp`, `prenom_emp`, `login_emp`, `pwd_emp`,`entite_emp`, `role_emp`) VALUES (NULL, '".$employe->getMatriculeEmp()."', '".$employe->getNomEmp()."', '".$employe->getPrenomEmp()."', '".$employe->getLoginEmp()."', '".$employe->getPwdEmp()."''".$employe->getEntiteEmp()->getIdEntite()."','".$employe->getRoleEmp()->getIdRole()."');";			
			echo($sql);
			$req=$BDD->prepare($sql);
            $req->execute();			
            echo json_encode("ok");					
		}
		public function updateEmploye(Employe $employe){
			include('../config/config.php');
			$sql="UPDATE employe SET matricule_emp='".$employe->getMatriculeEmp()."',nom_emp='".$employe->getNomEmp()."',prenom_emp='".$employe->getPrenomEmp()."',login_emp='".$employe->getLoginEmp()."',pwd_emp='".$employe->getPwdEmp()."',entite_emp='".$employe->getEntiteEmp()->getIdEntite()."',role='".$employe->getRoleEmp()->getIdRole()."', WHERE id_emp=".$role->getIdEmp()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function deleteMateriel(Employe $employe){
			include('../config/config.php');
			$sql="DELETE FROM employe WHERE id_emp=".$employe->getIdEmp()."";
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