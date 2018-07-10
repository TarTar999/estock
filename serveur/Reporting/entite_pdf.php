<?php  	
	require('../config/config.php');	
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
	ob_start();
?>
<page backtop="60mm" backbottom="2mm" backleft="5mm" backright="5mm" >
    <!--link rel="stylesheet" type="text/css" href="../css/style.css"-->
    <style type="text/css">  
	      	.fact td{
		        height:5px;
		        border:2px solid black;
		        padding: 3px;
	        }
	        .fact {
		        border:2px solid black;
		        border-collapse: collapse;
		        font-weight: normal;
	        }
	        .aside {
	          	display:table-cell;
	          	vertical-align:middle;
	          	padding:0;
	        }
	        .aside p {
	          	display:table;/* so it takes width of text */
	          	text-indent:1em;
	          	white-space:nowrap;
	          	transform:rotate(90deg) translate( -50%,0);
	          	transform-origin:0.6em center;
	        }
   	</style>
   	<page_header> 
   		<div>
	        <div style="width:100%; float: left;">
	          	<img src="../../img/camtel.jpg" style="width:140px;height:140px;margin-left:30px">
	          	<img src="../../img/motcamtel.jpg" style="width:140px;height:60px;margin-left:5px; margin-top: 60px">          	
	        </div>
	        <div  style="width:100%; float: right; margin-top: 0px;">
	        	<b style="margin-left:500px;font-size:10px;">
			        REPUBLIQUE DU CAMEROUN		        
	        	</b>
	        </div>
	        <br>
	        <div  style="width:100%; float: right; margin-top: 0px;">
	        	<b style="margin-left:530px;font-size:10px;">		        
					Paix-Travail-Patrie	        					       
	        	</b>
	        </div>
	        <br>	
	        <div  style="width:100%; float: right; margin-top: 0px;">
	        	<b style="margin-left:550px;font-size:10px;">		        				
					------	        
	        	</b>
	        </div>
        </div>        
        <b style='margin-left:320px;'>N°BF/2016/0988</b><br>
        <br>
        <table style="width:700px;">
          	<tr style="width:100%;">
	            <td style="width:60%;padding-left:6mm">Reporting de l'entite : <b>
	            	<?php  
	            		echo $results[0]['resultat'][0]['entrepot']['result']['nom_entite'];
	            	?>
	            </b></td>	            
          	</tr>
          	<tr style="width:100%;">
	            <td style="width:60%;padding-left:6mm"></td>	            
          	</tr>
          	<tr style="width:100%;">
	            <td style="width:60%;padding-left:6mm"></td>	            
          	</tr>
          	<tr>
          		<td style="width:60%;padding-left:6mm"></td>
	            <td style='padding-left:6mm'>
	            	Période : DU 
	            	<b>
	            		<?php  
	            			echo $deb;
	            		?>
	        		</b> 
	        		AU 
	        		<b>
	        			<?php  
	            			echo $fi;
	            		?>
	        		</b>
	        	</td>
          	</tr>                
        </table>
   	</page_header> 
    <page_footer> 
    </page_footer> 
    <br><br><br><br><br><br><br>    
    <table class="fact" style="width:1400px; margin-left: 10px">          
       	<!--tr style="height: 20px">
          	<td colspan='4' style="width:100%;text-align:left;">Entrepot : 
          		<br>
          		<b>Nom + Adresse Entrepôt</b>
          	</td>
        </tr-->
    	<tr style="background:black;color:#FFF;text-align:center"> 
    		<!--td style="width:50%;text-align:left;">Entrepot </td-->     		
      		<td style="width:25%">Materiel</td>
      		<td style='width:15%'>Sorties</td>
    	</tr>
    	<?php  
    		$sorties=0;    		
    		for($k=0; $k < sizeof($results); $k++){    			    			
    			//$res=$results[$k]['resultat'];
	    ?>
	    <tr style="background:blue;color:#FFF;text-align:center"> 
    		<td colspan="2" style="width:50%;text-align:left;">
    			<?php  
			    	echo $results[$k]['resultat'][0]['entrepot']['result']['nom_entrepot'];	   
	    		?>
    		</td>     		      		
    	</tr>
    	<?php      		   	
		    for($j=0; $j < sizeof($results[$k]['resultat']); $j++){    			
		    	$sorties=$sorties+$results[$k]['resultat'][$j]['entrepot']['result']['sortie']; 
    	?>
    	<tr>    

    		<td>
    			<b>
    				<?php  
			    		echo $results[$k]['resultat'][$j]['entrepot']['result']['nom_materiel'];
	    			?>
    			</b>
    		</td>		     		                    	      		
      		<td style="height:0.5mm">
      			<?php  
			    	echo $results[$k]['resultat'][$j]['entrepot']['result']['sortie'];
	    		?>
      		</td>
    	</tr>
    	<?php      		
    			}
    		}	    

	    ?>
    	<!--tr>   
    		<td><b>Nom + Adresse Entrepôt</b></td>   		                 
      		<td>2</td>
      		<td style="height:0.5mm">10</td>
    	</tr-->             	      
    	<tr style="border: 2px solid black">
      		<td style="height:4mm;font-weight:bold;font-size:19px">Total</td>      	
      		<td>
      			<?php  
			    	echo $sorties;
	    		?>
      		</td>
    	</tr>    	    	
    </table>        
  	<br><br>
  	<table style="width:700px;">
    	<tr style='width:100%'>
          	<td  style="float:left;width:70%">Fait à Douala, le
            	<?php echo date('Y/m/d'); ?>
          	</td>
      		<!--td style="float:right;width:30%;text-align:left">
        		Michel LEGRAND,<br>Administrateur délégué.
      		</td-->
    	</tr>                  
  	</table>                  
</page>
<?php 
  	$content = ob_get_clean();
  	ob_end_clean(); 
  	require_once('../../api/html2pdf/html2pdf.class.php'); 
  	$pdf = new HTML2PDF('P','A4','fr'); 
  	$pdf->writeHTML($content); 
  	$pdf->Output("billan.pdf"); 
?>
