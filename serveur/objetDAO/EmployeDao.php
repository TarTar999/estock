<?php
	require('../classes/Employe.php');
	require('EntiteDao.php');	
	require('RoleDao.php');	
	class EmployeDAO{			
		public function out($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM employe WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				//Récupération des objets marque et type
				$entdao=new EntiteDAO();
				$roledao=new RoleDAO();
				$ents=$entdao->out("id_entite=".$data['entite_emp']);
				
				$roles=$roledao->out("id_role=".$data['role_emp']);
				$ent=$ents[1]['object'][0]['objet'];
				$role=$roles[1]['object'][0]['objet'];
				$obj= new Employe($data['id_emp'], $data['matricule_emp'], $data['nom_emp'], $data['prenom_emp'], $data['login_emp'], $data['pwd_emp'], $ent, $role);				
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
		public function insert(Employe $arg){
			include('../config/config.php');
			
			$sql= "INSERT INTO employe (`id_emp`, `matricule_emp`, `nom_emp`, `prenom_emp`, `login_emp`, `pwd_emp`,`entite_emp`, `role_emp`) VALUES (NULL, '".$arg->getMatriculeEmp()."', '".$arg->getNomEmp()."', '".$arg->getPrenomEmp()."', '".$arg->getLoginEmp()."', '".$arg->getPwdEmp()."''".$arg->getEntiteEmp()->getIdEntite()."','".$arg->getRoleEmp()->getIdRole()."');";			
			echo($sql);
			$req=$BDD->prepare($sql);
            $req->execute();			
            echo json_encode("ok");					
		}
		public function update(Employe $arg){
			include('../config/config.php');
			$sql="UPDATE employe SET matricule_emp='".$arg->getMatriculeEmp()."',nom_emp='".$arg->getNomEmp()."',prenom_emp='".$arg->getPrenomEmp()."',login_emp='".$arg->getLoginEmp()."',pwd_emp='".$arg->getPwdEmp()."',entite_emp='".$arg->getEntiteEmp()->getIdEntite()."',role='".$arg->getRoleEmp()->getIdRole()."', WHERE id_emp=".$arg->getIdEmp()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Employe $arg){
			include('../config/config.php');
			$sql="DELETE FROM employe WHERE id_emp=".$arg->getIdEmp()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}	
?>