<?php  
	// référence à la bibliothèque de fonctions
	include ('../../api/PHPExcel/Classes/PHPExcel.php');
	include ('../../api/PHPExcel/Classes/PHPExcel/IOFactory.php');
	include('../config/config.php');

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
	//echo json_encode($results);
	$req->closeCursor();
	
	$_POST['excel']="vrai";
	function stylecell($feuille, $cell, $bold,$size,$align, $border){
		$styl = $feuille->getStyle($cell);
		
		$styleAlign=$styl->getAlignment();
		$styleBorders=$styl->getBorders();
		$styleFont = $styl->getFont();

		$styleFont->setBold($bold);
		$styleFont->setSize($size);
		$styleFont->setName('Sakkal Majalla');

		$styleAlign->setHorizontal($align);
		if($border)	{
			$allBorders=array('style' => PHPExcel_Style_Border::BORDER_THIN  ,'color' => array('rgb'=> '000000'));
			$styleBorders->applyFromArray(array('allborders' =>$allBorders));			
		}
		
	}
	if(isset($_POST['excel'])) {

	    // création des objets de base et initialisation des informations d'entête

	    $classeur = new PHPExcel;

	    $classeur->getProperties()->setCreator("Annie Gagnon");

	    $classeur->setActiveSheetIndex(0);

	    $feuille=$classeur->getActiveSheet();

	 

	    // ajout des données dans la feuille de calcul

	    $feuille->setTitle('Materiel Type');

	    stylecell($feuille,'B2',false, 11,'left',false);
	    stylecell($feuille,'B3',false, 11, 'left', false);
	    stylecell($feuille,'C3',false, 11, 'left',false);

	    $feuille->SetCellValue('B2', 'MATERIEL');
	    $feuille->setCellValue('B3', 'MOIS DE  ');
	    $feuille->setCellValue('C3', 'JANVIER 2018  ');
	    $feuille->mergeCells('C5:E5');
	    $feuille->mergeCells('F5:J5');	    
	    
	    stylecell($feuille,'C5',true, 11, 'center',true);
	    stylecell($feuille,'D5',true, 11, 'center',true);
	    stylecell($feuille,'E5',true, 11, 'center',true);
	    stylecell($feuille,'F5',true, 11, 'center',true);
	    stylecell($feuille,'G5',true, 11, 'center',true);
	    stylecell($feuille,'H5',true, 11, 'center',true);
	    stylecell($feuille,'I5',true, 11, 'center',true);
	    stylecell($feuille,'J5',true, 11, 'center',true);	    

	    $feuille->SetCellValue('C5', 'Stock de départ');
	    $feuille->SetCellValue('F5', 'RETRAIT');

	    stylecell($feuille,'B6',true, 8, 'center',true);
	    stylecell($feuille,'C6',true, 8, 'center',true);
	    stylecell($feuille,'D6',true, 8, 'center',true);
	    stylecell($feuille,'E6',true, 8, 'center',true);
	    stylecell($feuille,'F6',true, 8, 'center',true);
	    stylecell($feuille,'G6',true, 8, 'center',true);
	    stylecell($feuille,'H6',true, 8, 'center',true);
	    stylecell($feuille,'I6',true, 8, 'center',true);
	    stylecell($feuille,'J6',true, 8, 'center',true);
	    stylecell($feuille,'K6',true, 8, 'center',true);	    

	    $feuille->SetCellValue('B6', 'DESIGNATION');
	    $feuille->SetCellValue('C6', 'STOCK DEBUT DU MOIS');
	    $feuille->SetCellValue('D6', 'Approvisionnement');
	    $feuille->SetCellValue('E6', 'STOCK TOTAL');
	    $feuille->SetCellValue('F6', '1er Semaine');
	    $feuille->SetCellValue('G6', '2eme Semaine');
	    $feuille->SetCellValue('H6', '3eme Semaine');
	    $feuille->SetCellValue('I6', '4eme Semaine');
	    $feuille->SetCellValue('J6', 'RETRAIT TOTAL');
	    $feuille->SetCellValue('K6', 'Reste');

	    $feuille->getColumnDimension('A')->setWidth(4);
	    $feuille->getColumnDimension('B')->setWidth(30,43);
	    $feuille->getColumnDimension('C')->setWidth(21,43);
	    $feuille->getColumnDimension('D')->setWidth(21,43);
	    $feuille->getColumnDimension('E')->setWidth(21,43);
	    $feuille->getColumnDimension('F')->setWidth(21,43);
	    $feuille->getColumnDimension('G')->setWidth(15,43);
	    $feuille->getColumnDimension('H')->setWidth(15,43);
	    $feuille->getColumnDimension('I')->setWidth(15,43);
	    $feuille->getColumnDimension('J')->setWidth(15,43);
	    $feuille->getColumnDimension('K')->setWidth(15,43);

	    

	    for ($i=0; $i < sizeof($results) ; $i++) { 
			$feuille->setCellValueByColumnAndRow(0, $i+7, ''.$i+1);			
	    }

	 

	    // envoi du fichier au navigateur

	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 

	    header('Content-Disposition: attachment;filename="gene.xlsx"'); 

	    header('Cache-Control: max-age=0'); 

	    $writer = PHPExcel_IOFactory::createWriter($classeur, 'Excel2007'); 

	    $writer->save('php://output');

	}

	else {

	    // on envoie de l'information à l'écran seulement si le bouton de génération n'a pas été cliqué
		echo 'rien' ;

	}

?>