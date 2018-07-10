<?php
	require('../objetDAO/EntreeLigneDao.php');
	require('../objetDAO/EntreeDao.php');
	require('../objetDAO/EtatDao.php');	
	//require('../objetDAO/MaterielDao.php');	
	$eldao=new EntreeLigneDAO();	
	function createObject($id, $qte, $entre, $mat,$etat){											
		$entreedao=new EntreeDAO();
		$materieldao=new MaterielDAO();	
		$etatdao=new EtatDAO();	
		$entrees=$entreedao->out("id_entree=".$entre);
		$materiels=$materieldao->out("id_materiel=".$mat);
		$etats=$etatdao->out("id_etat=".$etat);
		$entree=$entrees[1]['object'][0]['objet'];
		$materiel=$materiels[1]['object'][0]['objet'];
		$eta=$etats[1]['object'][0]['objet'];
		$obj= new EntreeLigne($id, $qte, $entree, $materiel,$eta);
		return $obj;		
	}
	function createObjectById($id){		
		$obj= new EntreeLigne($id);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$entree = (isset($_POST['entree'])? $_POST['entree']: (isset($_GET['entree'])? $_GET['entree']:null));
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));
				$etat = (isset($_POST['etat'])? $_POST['etat']: (isset($_GET['etat'])? $_GET['etat']:null));								
				$ligneent=createObject($id,$qte,$entree,$materiel,$etat);
				$eldao->insert($ligneent);
			break;
			case 'update':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$entree = (isset($_POST['entree'])? $_POST['entree']: (isset($_GET['entree'])? $_GET['entree']:null));
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));
				$etat = (isset($_POST['etat'])? $_POST['etat']: (isset($_GET['etat'])? $_GET['etat']:null));								
				$ligneent=createObject($id,$qte,$entree,$materiel,$etat);
				$eldao->update($ligneent);
			break;
			case 'out':
				$ligneents=$eldao->out("1");
				echo json_encode($ligneents[0]['resultat']);				
			break;
			case 'outSpec':
				$filtre= (isset($_POST['filtre'])? $_POST['filtre']: (isset($_GET['filtre'])? $_GET['filtre']:null));
				$ligneents=$eldao->out($filtre);
				echo json_encode($ligneents[0]['resultat']);				
			break;
			case 'delete':
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$el=createObjectById($id);				
				$eldao->delete($el);	
				echo json_encode("supprime");			
			break;
		}
	}
?>