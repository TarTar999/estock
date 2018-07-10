<?php
	require('../objetDAO/EntrepotStockDao.php');
	require('../objetDAO/EntrepotDao.php');	
	require('../objetDAO/MaterielDao.php');	
	$esdao=new EntrepotStockDAO();	
	function createObject($id, $qte, $mat, $entre){											
		$entrepotdao=new EntrepotDAO();
		$materieldao=new MaterielDAO();	
		$entrepots=$entrepotdao->out("id_entrepot=".$entre);
		$materiels=$materieldao->out("id_materiel=".$mat);

		$entrepot=$entrepots[1]['object'][0]['objet'];
		$materiel=$materiels[1]['object'][0]['objet'];		
		$obj= new EntrepotStock($id, $qte, $materiel, $entrepot);
		return $obj;		
	}
	function createObjectById($id){
		$obj=new EntrepotStock($id);
		return $obj;
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));								
				$entstock=createObject($id,$qte,$materiel,$entrepot);
				$esdao->insert($entstock);
			break;
			case 'update':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$entrepot = (isset($_POST['entrepot'])? $_POST['entrepot']: (isset($_GET['entrepot'])? $_GET['entrepot']:null));
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));								
				$entstock=createObject($id,$qte,$materiel,$entrepot);
				$esdao->update($entstock);
			break;
			case 'out':
				$entstocks=$esdao->out("1");
				echo json_encode($entstocks[0]['resultat']);				
			break;
			case 'delete':
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$entstock=createObjectById($id);										
				$esdao->delete($entstock);	
				echo json_encode("supprime");			
			break;
		}
	}
?>