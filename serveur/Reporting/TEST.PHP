<?php  	
	require('../config/config.php');		
	$semaine = (isset($_POST['semaine'])? $_POST['semaine']: (isset($_GET['semaine'])? $_GET['semaine']:null));

	$wek=date('W', strtotime($semaine));
	$week=$wek-1;
	$results = array();
	$sql="SELECT materiel.nom_materiel,SUM(entreeligne.qte_entree) AS appro , SUM(sortieligne.qte_sortie) AS sortie FROM materiel, entree, sortie,entreeligne,sortieligne WHERE entreeligne.entree=entree.id_entree AND sortieligne.sortie=sortie.id_sortie AND entreeligne.materiel=materiel.id_materiel AND sortieligne.materiel=materiel.id_materiel AND WEEK(entree.date_entree)=? AND WEEK(sortie.date_sortie)=? GROUP BY materiel.nom_materiel;";			
	$req=$BDD->prepare($sql);
	$req->execute(array($week,$week));    
	while($data=$req->fetch(PDO::FETCH_ASSOC)){
		array_push($results,array('result' => $data));
	}
	echo json_encode($results);
	$req->closeCursor();	
	ob_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>PDF HEBDO</title>
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
</head>
<body>
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
	            <td style="width:60%;padding-left:6mm"><b>Reporting Hebdomadiare</b></td>	            
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
	            			echo "deb";
	            		?>
	        		</b> 
	        		AU 
	        		<b>
	        			<?php  
	            			echo "fi";
	            		?>
	        		</b>
	        	</td>
          	</tr>                
        </table>
	<br><br><br><br><br><br><br>    
    <table class="fact" style="width:700px; margin-left: 40px">          
       	<!--tr style="height: 20px">
          	<td colspan='4' style="width:100%;text-align:left;">Entrepot : 
          		<br>
          		<b>Nom + Adresse Entrepôt</b>
          	</td>
        </tr-->
    	<tr style="background:black;color:#FFF;text-align:center"> 
    		<td style="width:50%;text-align:left;">Materiel </td>     		
      		<td style="width:25%">Entrées</td>
      		<td style='width:15%'>Sorties</td>
    	</tr>
    	<?php  
    		$sorties=0;
    		$entrees=0;
    		for($k=0; $k<sizeof($results); $k++){    			
    			$sorties=$sorties+$results[$k]['result']['sortie'];
    			$entrees=$entrees+$results[$k]['result']['appro'];
	    ?>
    	<tr>    
    		<td>
    			<b>
    				<?php  
			    		echo $results[$k]['result']['nom_materiel'];
	    			?>
    			</b>
    		</td>		     		                    	
      		<td>
      			<?php  
			    	echo $results[$k]['result']['appro'];
	    		?>
      		</td>
      		<td style="height:0.5mm">
      			<?php  
			    	echo $results[$k]['result']['sortie'];
	    		?>
      		</td>
    	</tr>
    	<?php      		
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
			    	echo $entrees;
	    		?>
      		</td>
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
</body>
</html>