<?php
	require('../classes/Sortie.php');	
	class SortieDAO{			
		public function commandeout($filtre)
		{
			include('../config/config.php');
			$req=$BDD->prepare('SELECT * FROM commande WHERE '.$filtre.';');
            $req->execute();			
            $results = array();
			$objets = array();
			$finals = array();
            while($data=$req->fetch(PDO::FETCH_ASSOC)){
				$employedao=new EmployeDAO();
				$employes=$employedao->out("id_emp=".$data['employe']);
				$employe=$employes[1]['object'][0]['objet'];
				
				$entitedao=new EntiteDAO();
				$entites=$entitedao->out("id_entite=".$data['entite']);
				$entite=$entites[1]['object'][0]['objet'];
				
				$entrepotdao=new EntrepotDAO();
				$entrepots=$entrepotdao->out("id_entrepot=".$data['entrepot']);
				$entrepot=$entrepots[1]['object'][0]['objet'];
				$obj= new Sortie($data['id_sortie'], $data['nbre_mat_sortie'], $data['qte_mat_sortie'], $data['date_sortie'], $employe, $entite,$entrepot);				
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
		public function insert(Sortie $arg){
			include('../config/config.php');			
			$sql= "INSERT INTO sortie (`id_sortie`, `nbre_mat_sortie`, `qte_mat_sortie`, `date_sortie`, `employe`, `entite`, `entrepot`) VALUES (NULL, '".$arg->getNbreMatSortie()."', '".$arg->getQteMatSortie()."', '".$arg->getDateSortie()."','".$arg->getEmploye()->getIdEmp()."','".$arg->getEntite()->getIdEntite()."','".$arg->getEntrepot()->getIdEntrepot()."');";			
			$req=$BDD->prepare($sql);
            $req->execute();    
            echo json_encode("ok");					
		}
		public function update(Sortie $arg){
			include('../config/config.php');
			$sql="UPDATE sortie SET qte_mat_sortie='".$arg->getQteMatSortie()."', nbre_mat_sortie='".$arg->getNbreeMatSortie()."', date_sortie='".$arg->getDateSortie()."',employe='".$arg->getEmploye()->getIdEmploye()."',entite='".$arg->getEntite()->getIdEntite()."',entrepot='".$arg->getEntrepot()->getIdEntrepot()."' WHERE id_sortie=".$arg->getIdSortie()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
		public function delete(Sortie $arg){
			include('../config/config.php');
			$sql="DELETE FROM cmd WHERE id_sortie=".$arg->getIdSortie()."";
			$req=$BDD->prepare($sql);
			$req->execute();
			$retour = array();
			$retour["status"] = true;
			echo json_encode($retour);			
		}
	}
	$sortiedao=new SortieDAO();
	function createObject($id, $nbmat, $qte, $date,$emp,$ent,$entrep){
		$employedao=new EmployeDAO();
		$employes=$employedao->out("id_emp=".$emp);
		$employe=$employes[1]['object'][0]['objet'];
		
		$entitedao=new EntiteDAO();
		$entites=$entitedao->out("id_entite=".$ent);
		$entite=$entites[1]['object'][0]['objet'];
		
		$entrepotdao=new EntrepotDAO();
		$entrepots=$entrepotdao->out("id_entrepot=".$entrep);
		$entrepot=$entrepots[1]['object'][0]['objet'];
		
		$obj= new Sortie($id, $nbmat, $qte, $date, $employe, $entite,$entrepot);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){
		
		switch ($action) {
			case 'Update':
				$id_sortie = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nbremat = (isset($_POST['nbre'])? $_POST['nbre']: (isset($_GET['nbre'])? $_GET['nbre']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$date = (isset($_POST['date'])? $_POST['date']: (isset($_GET['date'])? $_GET['date']:null));
				$employe = (isset($_POST['employe'])? $_POST['employe']: (isset($_GET['employe'])? $_GET['employe']:null));
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$sortie=createObject($id_sortie,$nbremat,$qte,$date,$employe,$entite,$entrepot);
				$sortiedao->update($sortie);
			break;
			case 'Delete':
				$id_sortie = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nbremat = (isset($_POST['nbre'])? $_POST['nbre']: (isset($_GET['nbre'])? $_GET['nbre']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$date = (isset($_POST['date'])? $_POST['date']: (isset($_GET['date'])? $_GET['date']:null));
				$employe = (isset($_POST['employe'])? $_POST['employe']: (isset($_GET['employe'])? $_GET['employe']:null));
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$sortie=createObject($id_sortie,$nbremat,$qte,$date,$employe,$entite,$entrepot);
				$sldao=new SortieLigneDao();				
				$sls=$sldao->out("where sortie=".$id_sortie);
				for($i=0; $i<$sls[1][object]->length; $i++){
					$sldao->delete($sls[1]['object'][$i]['objet']);
				}
				$sortiedao->delete($sortie);				
			break;
		}
	}
?>