<?php
	require('../objetDao/EntreeDao.php');
	require('../objetDao/EntrepotStockDao.php');
	require('../objetDao/EntreeLigneDao.php');
	$entreedao=new EntreeDAO();	
	function createObject($id, $nbre, $qte, $date, $emp, $entr){
		$employedao=new EmployeDAO();
		$employes=$employedao->out("id_emp=".$emp);
		$employe=$employes[1]['object'][0]['objet'];
		
		$entrepotdao=new EntrepotDAO();
		$entrepots=$entrepotdao->out("id_entrepot=".$entr);
		$entrepot=$entrepots[1]['object'][0]['objet'];
		$obj= new Entree($id, $nbre, $qte, $date, $employe, $entrepot);
		return $obj;		
	}
	function createObjectById($id){		
		$obj= new Entree($id);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nbre = (isset($_POST['nbre'])? $_POST['nbre']: (isset($_GET['nbre'])? $_GET['nbre']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));		
				$date = (isset($_POST['date'])? $_POST['date']: (isset($_GET['date'])? $_GET['date']:null));
				$datecr=date('Y-m-d', strtotime($date));
				$emp = (isset($_POST['employe'])? $_POST['employe']: (isset($_GET['employe'])? $_GET['employe']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$entree=createObject($id,$nbre,$qte,$datecr,$emp,$entrepot);
				$entrecr=$entreedao->insert($entree);	
				echo json_encode($entrecr);			
			break;
			case 'update':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$nbre = (isset($_POST['nbre'])? $_POST['nbre']: (isset($_GET['nbre'])? $_GET['nbre']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));		
				$date = (isset($_POST['date'])? $_POST['date']: (isset($_GET['date'])? $_GET['date']:null));
				$datecr=date('Y-m-d', strtotime($date));
				$emp = (isset($_POST['employe'])? $_POST['employe']: (isset($_GET['employe'])? $_GET['employe']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$entree=createObject($id,$nbre,$qte,$datecr,$emp,$entrepot);
				$entreedao->update($entree);	
				//echo json_encode($entrecr);			
			break;			
			case 'out':
				$entrees=$entreedao->out("1");
				echo json_encode($entrees[0]['resultat']);				
			break;
			case 'outSpec':
				$filtre=(isset($_POST['filtre'])? $_POST['filtre']: (isset($_GET['filtre'])? $_GET['filtre']:null));
				$entrees=$entreedao->out($filtre);
				echo json_encode($entrees[0]['resultat']);				
			break;
			case 'delete':
				$id_entree = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));	
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));			
				$entree=createObjectById($id_entree);
				$eldao=new EntreeLigneDao();	
				$esdao=new EntrepotStockDao();			
				$els=$eldao->out("entree=".$id_entree);
				for($i=0; $i<sizeof($els[1]['object']); $i++){
					$ent=$els[1]['object'][$i]['objet'];							
					$ess=$esdao->out("materiel=".$ent->getMateriel()->getIdMateriel()." AND entrepot=".$entrepot);
					$es=$ess[1]['object'][0]['objet'];
					$qte=$es->getQteDisponible() - $ent->getQteEntree();
					$es->setQteDisponible($qte);
					$esdao->update($es);
					$eldao->delete($ent);
					//$eldao->delete($els[1]['object'][$i]['objet']);
				}
				$entreedao->delete($entree);	
				echo json_encode("supprime");			
			break;
		}
	}
 ?>