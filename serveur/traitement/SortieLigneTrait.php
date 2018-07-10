<?php
	require('../objetDAO/SortieLigneDao.php');
	require('../objetDAO/SortieDao.php');	
	//require('../objetDAO/MaterielDao.php');	
	$sldao=new sortieLigneDAO();	
	function createObject($id, $qte, $sort, $mat,$ent,$etat){											
		$sortiedao=new SortieDAO();
		$materieldao=new MaterielDAO();	
		$entitedao=new EntiteDAO();

		$sorties=$sortiedao->out("id_sortie=".$sort);
		$materiels=$materieldao->out("id_materiel=".$mat);		
		$entites=$entitedao->out("id_entite=".$ent);

		$entite=$entites[1]['object'][0]['objet'];
		$sortie=$sorties[1]['object'][0]['objet'];
		$materiel=$materiels[1]['object'][0]['objet'];		
		$etatdao=new EtatDAO();	
		$etats=$etatdao->out("id_etat=".$etat);
		$eta=$etats[1]['object'][0]['objet'];
		$obj= new sortieLigne($id, $qte, $sortie, $materiel, $entite,$eta);
		//echo json_encode($obj->getSortie()->getIdSortie());
		return $obj;		
	}
	function createObjectById($id){		
		$obj= new SortieLigne($id);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$sortie = (isset($_POST['sortie'])? $_POST['sortie']: (isset($_GET['sortie'])? $_GET['sortie']:null));
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));							
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));
				$etat = (isset($_POST['etat'])? $_POST['etat']: (isset($_GET['etat'])? $_GET['etat']:null));
				$lignesort=createObject($id,$qte,$sortie,$materiel,$entite,$etat);
				$sldao->insert($lignesort);
			break;
			case 'update':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$qte = (isset($_POST['qte'])? $_POST['qte']: (isset($_GET['qte'])? $_GET['qte']:null));
				$sortie = (isset($_POST['sortie'])? $_POST['sortie']: (isset($_GET['sortie'])? $_GET['sortie']:null));
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));		
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));	
				$etat = (isset($_POST['etat'])? $_POST['etat']: (isset($_GET['etat'])? $_GET['etat']:null));				
				$lignesort=createObject($id,$qte,$sortie,$materiel,$entite,$etat);
				$sldao->update($lignesort);
			break;
			case 'out':
				$lignesorts=$eldao->out("1");
				echo json_encode($lignesorts[0]['resultat']);				
			break;
			case 'outSpec':
				$filtre= (isset($_POST['filtre'])? $_POST['filtre']: (isset($_GET['filtre'])? $_GET['filtre']:null));
				$lignesorts=$sldao->out($filtre);
				echo json_encode($lignesorts[0]['resultat']);				
			break;
			case 'delete':
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sl=createObjectById($id);										
				$sldao->delete($sl);	
				echo json_encode("supprime");			
			break;
		}
	}
?>