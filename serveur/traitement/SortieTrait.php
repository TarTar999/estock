<?php 
	require('../objetDao/SortieDao.php');
	require('../objetDao/SortieLigneDao.php');	
	require('../objetDao/EntrepotStockDao.php');
	$sortiedao=new SortieDAO();
	function createObject($id, $nbmat, $qte, $date,$emp,$entrep){
		$employedao=new EmployeDAO();
		$employes=$employedao->out("id_emp=".$emp);
		$employe=$employes[1]['object'][0]['objet'];
		//echo json_encode($employe->getIdEmp());
		//echo ("ENTITE");
		
		
		$entrepotdao=new EntrepotDAO();
		$entrepots=$entrepotdao->out("id_entrepot=".$entrep);
		$entrepot=$entrepots[1]['object'][0]['objet'];
		

		$obj= new Sortie($id, $nbmat, $qte, $date, $employe,$entrepot);
		//echo json_encode($obj->getEmploye()->getIdEmp());
		return $obj;		
	}
	function createObjectById($id){				
		$obj= new Sortie($id);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){
		
		switch ($action) {
			case 'insert':
				$id_sortie = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nbremat = (isset($_POST['nbre'])? $_POST['nbre']: (isset($_GET['nbre'])? $_GET['nbre']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$date = (isset($_POST['date'])? $_POST['date']: (isset($_GET['date'])? $_GET['date']:null));
				$datecr=date('Y-m-d', strtotime($date));
				$employe = (isset($_POST['employe'])? $_POST['employe']: (isset($_GET['employe'])? $_GET['employe']:null));				
				//echo json_encode($employe);
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$sortie=createObject($id_sortie,$nbremat,$qte,$datecr,$employe,$entrepot);
				//echo json_encode($sortie->getEmploye()->getIdEmp());
				$sortiecr=$sortiedao->insert($sortie);				
				echo json_encode($sortiecr);
				break;
			case 'update':
				$id_sortie = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nbremat = (isset($_POST['nbre'])? $_POST['nbre']: (isset($_GET['nbre'])? $_GET['nbre']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$date = (isset($_POST['date'])? $_POST['date']: (isset($_GET['date'])? $_GET['date']:null));
				$datecr=date('Y-m-d', strtotime($date));
				$employe = (isset($_POST['employe'])? $_POST['employe']: (isset($_GET['employe'])? $_GET['employe']:null));				
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$sortie=createObject($id_sortie,$nbremat,$qte,$datecr,$employe,$entrepot);
				$sortiedao->update($sortie);
				break;
			case 'delete':
				$id_sortie = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));					
				$sortie=createObjectById($id_sortie);				
				$sldao=new SortieLigneDao();			
				$esdao=new EntrepotStockDao();		
				$sls=$sldao->out("sortie=".$id_sortie);
				for($i=0; $i<sizeof($sls[1]['object']); $i++){
					$sort=$sls[1]['object'][$i]['objet'];
					echo json_encode(" id entrepot : ".$sort->getMateriel()->getIdMateriel());							
					$ess=$esdao->out("materiel=".$sort->getMateriel()->getIdMateriel()." AND entrepot=".$entrepot);
					$es=$ess[1]['object'][0]['objet'];
					$qte=$es->getQteDisponible() + $sort->getQteSortie();
					$es->setQteDisponible($qte);
					$esdao->update($es);
					$sldao->delete($sort);
				}
				$sortiedao->delete($sortie);	
				echo json_encode("Supprimé");			
				break;
			case 'out' :				
				$sorties=$sortiedao->out("1");
				echo json_encode($sorties[0]['resultat']);
				break;
			case 'outSpec':
				$filtre=(isset($_POST['filtre'])? $_POST['filtre']: (isset($_GET['filtre'])? $_GET['filtre']:null));
				$sorties=$sortiedao->out($filtre);
				echo json_encode($sorties[0]['resultat']);				
				break;
		}
	}
?>