<?php 
	require('../config/config.php');	
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'general':				
				$mois = (isset($_POST['mois'])? $_POST['mois']: (isset($_GET['mois'])? $_GET['mois']:null));				
				$year=date('Y',strtotime($mois));				
				$monthi=date('m',strtotime($mois));			
				$monthi=$monthi+1;												
				$debut=date('d-m-Y',(mktime(0, 0, 0, $monthi  ,2, $year)));							
				$fin=date('d-m-Y',mktime(0, 0, 0, $monthi  ,date("t",strtotime($debut)), $year));
				$week1=date('W', strtotime($debut));
				$week2=date('W', strtotime($fin));				
				$weeks = array();
				for ($k=$week1; $k<=$week2; $k++){
					array_push($weeks,array('semaine' =>$k));
				}																
				$results = array();
				$sql="SELECT materiel.nom_materiel,materiel.id_materiel,SUM(entreeligne.qte_entree) AS appro , SUM(sortieligne.qte_sortie) AS sorti FROM materiel, entree, sortie,entreeligne,sortieligne WHERE entreeligne.entree=entree.id_entree AND sortieligne.sortie=sortie.id_sortie AND entreeligne.materiel=materiel.id_materiel AND sortieligne.materiel=materiel.id_materiel AND MONTH(entree.date_entree)=? AND MONTH(sortie.date_sortie)=? GROUP BY materiel.nom_materiel;";			
				$req=$BDD->prepare($sql);
				$req->execute(array($monthi,$monthi));    
				while($data=$req->fetch(PDO::FETCH_ASSOC)){						
					$data['s1']=0;
					$data['s2']=0;
					$data['s3']=0;
					$data['s4']=0;
					$semaines= array();
					$sq="SELECT SUM(sortieligne.qte_sortie) AS semaine FROM sortie, sortieligne WHERE sortieligne.sortie=sortie.id_sortie AND sortieligne.materiel=? AND WEEK(sortie.date_sortie)=?;";
					for ($k=0; $k<sizeof($weeks); $k++){						
						$rq=$BDD->prepare($sq);
						$rq->execute(array($data['id_materiel'],$weeks[$k]['semaine']));  
						while($dt=$rq->fetch(PDO::FETCH_ASSOC)){
							array_push($semaines,array('sumsem' =>$dt['semaine']));
						}
						$rq->closeCursor();
					}
					$data['s1']=$semaines[0]['sumsem'];
					$data['s2']=$semaines[1]['sumsem'];
					$data['s3']=$semaines[2]['sumsem'];
					$data['s4']=$semaines[3]['sumsem'];
					if(sizeof($semaines)>4){
						$data['s4']=$data['s4']+$semaines[4]['sumsem'];
					}
					
					array_push($results,array('result' => $data));
            	}
            	echo json_encode($results);
            	$req->closeCursor();
			break;	
			case 'hebdomadaire' :
				$semaine = (isset($_POST['semaine'])? $_POST['semaine']: (isset($_GET['semaine'])? $_GET['semaine']:null));

				$wek=date('W', strtotime($semaine));
				$week=$wek-1;
				$results = array();
				$sql="SELECT materiel.nom_materiel,SUM(entreeligne.qte_entree) AS appro , SUM(sortieligne.qte_sortie) AS sorti FROM materiel, entree, sortie,entreeligne,sortieligne WHERE entreeligne.entree=entree.id_entree AND sortieligne.sortie=sortie.id_sortie AND entreeligne.materiel=materiel.id_materiel AND sortieligne.materiel=materiel.id_materiel AND WEEK(entree.date_entree)=? AND WEEK(sortie.date_sortie)=? GROUP BY materiel.nom_materiel;";			
				$req=$BDD->prepare($sql);
				$req->execute(array($week,$week));    
				while($data=$req->fetch(PDO::FETCH_ASSOC)){
					array_push($results,array('result' => $data));
            	}
            	echo json_encode($results);
            	$req->closeCursor();
			break;	
			case 'materiel' :
				$materiel = (isset($_POST['materiel'])? $_POST['materiel']: (isset($_GET['materiel'])? $_GET['materiel']:null));
				$debut = (isset($_POST['debut'])? $_POST['debut']: (isset($_GET['debut'])? $_GET['debut']:null));
				$fin = (isset($_POST['fin'])? $_POST['fin']: (isset($_GET['fin'])? $_GET['fin']:null));				
				$deb=date('Y-m-d', strtotime($debut));
				$fi=date('Y-m-d', strtotime($fin));
				/*$week1=date('W', strtotime($deb));
				$week2=date('W', strtotime($fi));				
				$weeks = array();
				for ($k=$week1; $k<=$week2; $k++){
					array_push($weeks,array('semaine' =>$k));
				}*/				
				$entrees = array();
				$sorties = array();
				$results = array();
				$sqlsortie="SELECT entrepot.id_entrepot, entrepot.nom_entrepot, entrepot.adresse_entrepot, materiel.nom_materiel,SUM(sortieligne.qte_sortie) AS sortie FROM entrepot, materiel, sortie, sortieligne WHERE materiel.id_materiel=? AND sortieligne.sortie=sortie.id_sortie AND sortieligne.materiel=materiel.id_materiel AND sortie.entrepot=entrepot.id_entrepot AND sortie.date_sortie>=? AND sortie.date_sortie<=? GROUP BY entrepot.nom_entrepot;";
				$sqlentree="SELECT entrepot.id_entrepot, entrepot.nom_entrepot, entrepot.adresse_entrepot, materiel.nom_materiel,SUM(entreeligne.qte_entree) AS appro FROM entrepot, materiel, entree, entreeligne WHERE materiel.id_materiel=? AND entreeligne.entree=entree.id_entree AND entreeligne.materiel=materiel.id_materiel AND entree.entrepot=entrepot.id_entrepot AND entree.date_entree>=? AND entree.date_entree<=? GROUP BY entrepot.nom_entrepot;";			
				$req=$BDD->prepare($sqlsortie);
				$req->execute(array($materiel,$deb,$fi));    
				while($data=$req->fetch(PDO::FETCH_ASSOC)){
					$data['appro']=0;
					array_push($results,array('result' => $data));
            	}
            	$req->closeCursor();

            	$req=$BDD->prepare($sqlentree);
				$req->execute(array($materiel,$deb,$fi));    
				while($data=$req->fetch(PDO::FETCH_ASSOC)){
					$data['sortie']=0;
					array_push($results,array('result' => $data));
            	}
            	for($k=0; $k<sizeof($results); $k++){
            		for($j=$k+1; $j<sizeof($results); $j++){
            			if($results[$k]['result']['id_entrepot']==$results[$j]['result']['id_entrepot']){
            				$results[$k]['result']['appro']=$results[$k]['result']['appro']+$results[$j]['result']['appro'];
            				$results[$k]['result']['sortie']=$results[$k]['result']['sortie']+$results[$j]['result']['sortie'];
            				array_splice($results, $j,1);
            				break;
            			}
            		}            	
            	}
            	echo json_encode($results);
            	$req->closeCursor();
            	header('Location : ../Reporting/materiel_pdf.php');
			break;
			case 'entite' :
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));
				$debut = (isset($_POST['debut'])? $_POST['debut']: (isset($_GET['debut'])? $_GET['debut']:null));
				$fin = (isset($_POST['fin'])? $_POST['fin']: (isset($_GET['fin'])? $_GET['fin']:null));				
				$deb=date('Y-m-d', strtotime($debut));
				$fi=date('Y-m-d', strtotime($fin));
				/*$week1=date('W', strtotime($deb));
				$week2=date('W', strtotime($fi));				
				$weeks = array();
				for ($k=$week1; $k<=$week2; $k++){
					array_push($weeks,array('semaine' =>$k));
				}*/							
				$resultats = array();
				$results = array();
				$sql="SELECT entite.nom_entite ,entrepot.id_entrepot,entrepot.nom_entrepot,entrepot.adresse_entrepot, materiel.nom_materiel,SUM(sortieligne.qte_sortie) AS sortie FROM entrepot ,entite, materiel, sortie, sortieligne WHERE entite.id_entite= ? AND sortieligne.sortie=sortie.id_sortie AND sortieligne.entite=entite.id_entite AND sortieligne.materiel=materiel.id_materiel AND sortie.entrepot=entrepot.id_entrepot AND sortie.date_sortie>=? AND sortie.date_sortie<=? GROUP BY materiel.nom_materiel;";				
				$req=$BDD->prepare($sql);
				$req->execute(array($entite,$deb,$fi));    
				while($data=$req->fetch(PDO::FETCH_ASSOC)){
					array_push($resultats,array('result' => $data));
            	}

            	$identrp= array();
            	array_push($identrp, array('id' => $resultats[0]['result']['id_entrepot']));
            	for ($i=0; $i < sizeof($resultats) ; $i++) { 
            		for ($j=0; $j < sizeof($identrp) ; $j++) { 

            			if($resultats[$i]['result']['id_entrepot']!=$identrp[$j]['id']){
            				array_push($identrp, array('id' => $resultats[$i]['result']['id_entrepot']));
            			}
            		}
            	}
            	for ($k=0; $k < sizeof($identrp) ; $k++) { 
					$ent= array();	
					//array_push($ent, array('identrepot' => $identrp[$k]['id']));				            		
					for ($i=0; $i < sizeof($resultats) ; $i++){
						if($resultats[$i]['result']['id_entrepot']==$identrp[$k]['id']){
            				array_push($ent, array('entrepot' => $resultats[$i]));
            			}
					}
					array_push($results, array('resultat' => $ent));
            	}
            	echo json_encode($results[0]['resultat'][1]['entrepot']['result']);
            	$req->closeCursor();                        	
			break;							
		}
	}	
?>