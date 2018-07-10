var app = angular.module("estock", []);
//var sousmodule=""
app.run(function($rootScope,$http){
	$rootScope.start=function(){
		$http({
	        method: 'POST',
	        url: '../serveur/MANIFEST/session.php',
	        params:{
	        	"action":"getConnected"
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
				if(response.data===""){
					console.log("response.data");
					creerCookie("nextPage", 'admin.html', 7)
					window.location='login.html';
				}
				else{
					$rootScope.emp=response.data;
				}
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
	}	
	$rootScope.stop=function(){
		$http({
	        method: 'POST',
	        url: '../serveur/MANIFEST/session.php',
	        params:{
	        	"action":"deconnexion"
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
				if(response.data===""){
					console.log("response.data");
					window.location='stockaction.html';
				}				
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
	}	
});

app.controller('StockCtrl', function($scope, $http, $compile) {		

	$http({
        method: 'POST',
        url: '../serveur/traitement/EntrepotTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.entrepots=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../serveur/traitement/MaterielTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.materiels=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );

	$(".classy").click(function(){
		$(".premier").css('box-shadow','0px 0px 0px white');
		$(".classy").css('box-shadow','0px 0px 0px white');
		$(this).css('box-shadow','15px 15px 5px #CECECE');
	})
	//$scope.sousmodule="sortie";	
	$scope.sendCookies=function(actionpage,id){		
		creerCookie("pageact",actionpage);
		creerCookie("idsousmodule",id);
	}
	$scope.go = function (){				
		window.location='actionWeb/stockaction.html';		
		//$scope.$broadcast('echange',{message :sousmodule})
	}
    $scope.affiche = function (bouton){    	

    	//console.log(bouton)    	
    	$scope.entrees=null;
    	$scope.sortis=null;
    	$scope.stocks=null;
		$scope.entete=[];
		$scope.title="";
		//$rootScope.change(bouton);
		$scope.sousmodule=bouton	
		//creerCookie("pageact",bouton);
		console.log($scope.sousmodule);
		if(bouton=='sortie'){						
			$scope.title="Materiel(s) sorti(s) du stock";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Date Enregistrement";
			$scope.entete[2] = "Quantite Materiel";
			$scope.entete[3] = "Nombre Materiel";
			$scope.entete[4] = "Entrepot";			
			$scope.entete[5] = "Action";

			$http({
				method : 'POST',
				url : '../serveur/traitement/SortieTrait.php',
				params :{
					"action" : "out"					
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success");                      									
					console.log(response.data);
					if(response.data!=null){
						$scope.sortis=response.data;
						for (var b = 0; b < $scope.sortis.length ; b++) {							
							for (var i = 0; i < $scope.entrepots.length ; i++) {							
								if($scope.entrepots[i].result.id_entrepot==$scope.sortis[b].result.entrepot){
									$scope.sortis[b].result.nom_entrepot=$scope.entrepots[i].result.nom_entrepot+' '+$scope.entrepots[i].result.adresse_entrepot;
									break;
								}
							}	
						}											
					}					
					console.log("resultat :"+response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    );				
		}
		if(bouton=='entree'){						
			$scope.title="Materiel(s) entré(s) en stock"
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Date d'entree";
			$scope.entete[2] = "Nombre Materiel";
			$scope.entete[3] = "Quantite Materiel";
			$scope.entete[4] = "Entrepot de Destination";			
			$scope.entete[5] = "Action";
			$http({
				method : 'POST',
				url : '../serveur/traitement/EntreeTrait.php',
				params :{
					"action" : "out"					
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success"); 
					console.log(response.data);
					if(response.data!=null){
						$scope.entrees=response.data;	
						for (var b = 0; b < $scope.entrees.length ; b++) {							
							for (var i = 0; i < $scope.entrepots.length ; i++) {							
								if($scope.entrepots[i].result.id_entrepot==$scope.entrees[b].result.entrepot){
									$scope.entrees[b].result.nom_entrepot=$scope.entrepots[i].result.nom_entrepot+' '+$scope.entrepots[i].result.adresse_entrepot;
									break;
								}
							}	
						}											
					}                     														
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    );				
		}
		if(bouton=='stock'){						
			$scope.title="Materiel(s) disponible(s) en stock"
			$scope.entete[0] = "ID";			
			$scope.entete[1] = "Nom Materiel";
			$scope.entete[2] = "Entrepot";			
			$scope.entete[3] = "Quantite en stock";
			//$scope.entete[4] = "Action";

			$http({
				method : 'POST',
				url : '../serveur/traitement/EntrepotStockTrait.php',
				params :{
					"action" : "out"					
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("resultat :");    
					console.log(response.data);
					if(response.data!=null){
						$scope.stocks=response.data;
						for (var b = 0; b < $scope.stocks.length ; b++) {							
							for (var i = 0; i < $scope.entrepots.length ; i++) {							
								if($scope.entrepots[i].result.id_entrepot==$scope.stocks[b].result.entrepot){
									$scope.stocks[b].result.nom_entrepot=$scope.entrepots[i].result.nom_entrepot+' '+$scope.entrepots[i].result.adresse_entrepot;
									break;
								}
							}
							for (var j = 0; j < $scope.materiels.length ; j++) {							
								if($scope.materiels[j].result.id_materiel==$scope.stocks[b].result.materiel){
									$scope.stocks[b].result.nom_materiel=$scope.materiels[j].result.nom_materiel;
									break;
								}
							}	
						}											
					}                     														                  														
					
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    );												
		}				
	}
	$scope.delete = function(id,entrepot){
		var type=$scope.sousmodule;
		$(".modal-body").empty();
		$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/loarder.gif\" width='40%' height='auto'></p>");
		if(type=='sortie'){									
			$http({
				method : 'POST',
				url : '../serveur/traitement/SortieTrait.php',
				params :{
					"action" : "delete",
					"id" : id,
					"entrepot" : entrepot					
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success");                      									
					$scope.sortis=response.data;
					console.log("resultat :"+response.data);
					$scope.affiche(type);

					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		

		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    );				
		}
		if(type=='entree'){									
			$http({
				method : 'POST',
				url : '../serveur/traitement/EntreeTrait.php',
				params :{
					"action" : "delete",
					"id" : id,
					"entrepot" : entrepot
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success");                      									
					$scope.sortis=response.data;
					console.log("resultat :"+response.data);
					$scope.affiche(type);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    );				
		}
	}
	$scope.modalView=function(date, id, entrepot){
		if (id) {
			$scope.dated=date;
			$scope.ide=id;
			$scope.entpot=entrepot;
			$(".modal-body").empty();
			$(".modal-body").append($compile('<p>Voulez vous supprimer <span ng-if="sousmodule==\'entree\'">l\'entrée</span><span ng-if="sousmodule==\'sortie\'">la sortie</span>:'+$scope.dated+'</p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+$scope.ide+','+$scope.entpot+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));
			$scope.$apply(); 
		}			
	}
	$scope.refreshmodal=function(){
		$(".modal-body").empty();
		$(".modal-body").html('<p>Voulez vous supprimer <span ng-if="sousmodule==\'entree\'">l\'entrée</span><span ng-if="sousmodule==\'sortie\'">la sortie</span>: '+$scope.dated+'</p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete(ide)">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>');
		
	}
});
app.controller('ActionStockCtrl', function($scope, $http) {			

	function searchInArray(table,element1, element2){
		var k=-1;		
		for (var i = 0; i<table.length; i++) {			
			if(table[i].materiel == element1 && table[i].entite == element2){
				k=i;
				break;
			}
		}
		return k;
	}
	function insertStock(idmateriel, qte,entrepot){
		$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EntrepotStockTrait.php',
	        params:{
	        	"action":"insert",
	        	"qte" : qte,
	        	"entrepot" : entrepot,
	        	"materiel" : idmateriel
	    	}
	        })
		.then(
			function successCallback(response) {                       				
				console.log("insert stock : ");
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
	}
	function updateStock(idstock,idmateriel, qte,entrepot){
		$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EntrepotStockTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : idstock,
	        	"qte" : qte,
	        	"entrepot" : entrepot,
	        	"materiel" : idmateriel
	    	}
	        })
		.then(
			function successCallback(response) {                       				
				console.log("update stock : ");
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
	}
	

	$scope.sousmodule="";
	//var lignes=[];	
	$scope.lignes=[];
	var type=lireCookie("pageact");	
	$scope.type = type;		
	$scope.idsousmod=lireCookie("idsousmodule");		
	supprimerCookie("pageact");
	supprimerCookie("idsousmodule");		
	$scope.entete=[];
	$scope.title="";
	$scope.i=0;
	if(type=='sortie'){
			$scope.title="Enregistrement Sortie";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Materiel";
			$scope.entete[2] = "Quantite sortie";
			$scope.entete[3] = "Etat";			
			$scope.entete[4] = "Entite";
			$scope.entete[5] = "Action";
	}
	if(type=='entree'){
			$scope.title="Enregistrement Entree";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Materiel";
			$scope.entete[2] = "Quantite entree";			
			$scope.entete[3] = "Etat";
			$scope.entete[4] = "Action";
	}
	$http({
            method: 'POST',
            url: '../../serveur/traitement/EtatTrait.php',
            params:{"action":"out"}
        })
	.then(			
		function successCallback(response) { 
			console.log("Success");                      				
			$scope.etat=response.data;				
			console.log(response.data[1].result);
        }
        , function errorCallback(response) {
         	console.log(response);
        }
    );
	$http({
            method: 'POST',
            url: '../../serveur/traitement/EntiteTrait.php',
            params:{"action":"out"}
        })
	.then(			
		function successCallback(response) { 
			console.log("Success");                      				
			$scope.entite=response.data;				
			console.log(response.data[1].result);
        }
        , function errorCallback(response) {
         	console.log(response);
        }
    );
    $http({
        method: 'POST',
        url: '../../serveur/traitement/EntrepotStockTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.stock=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../../serveur/traitement/EntrepotTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.entrepot=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../../serveur/traitement/MaterielTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.materiel=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );

	$scope.chargeMax=function(idmateriel){
		$scope.qteMax=5;
		$scope.idd=idmateriel;
		for (var i = 0; i < $scope.materielsortable.length; i++) {
			if($scope.materielsortable[i].result.id_materiel==idmateriel){
				$scope.qteMax=$scope.materielsortable[i].result.qte_dispo;			
				break;
			}
		}
	}

	$scope.chargeMat=function(id_entrepot){		
		$scope.materielsortable=[]
		if(id_entrepot=='' || id_entrepot==0 || id_entrepot==null || id_entrepot==undefined){
			for (var i = 0; i < $scope.materiel.length; i++) {
				for (var j = 0; j <$scope.stock.length; j++) {
					var qte=0;
					if($scope.materiel[i].result.id_materiel==$scope.stock[j].result.materiel){
						qte=qte+parseInt($scope.stock[j].result.qte_disponible);												
					}					
				}	
				var ligne ={"materiel" : $scope.materiel[i], "quantite" : qte};
				$scope.materielsortable.push(ligne)
			}		
			console.log("entrepot null : ")
		}
		else{
			$scope.materielsortable.splice(0,$scope.materielsortable.length)
			for (var i = 0; i <$scope.materiel.length; i++) {
				for (var j = 0; j <$scope.stock.length; j++) {
					var qte=0;
					if($scope.stock[j].result.materiel==$scope.materiel[i].result.id_materiel && $scope.stock[j].result.entrepot==id_entrepot){
						qte=parseInt($scope.stock[j].result.qte_disponible);												
						$scope.materiel[i].result.qte_dispo=qte;						
						$scope.materielsortable.push($scope.materiel[i]);
						break;
					}					
				}					
			}				
			console.log("entrepot non null : ")
		}	
		console.log($scope.materielsortable)
	}
    
	$scope.tata=function(ligne,qt){
		console.log("fgdhgd : ")
		console.log(ligne)
		console.log("quantite")
		console.log(qt)
	}
	$scope.delete=function(idmateriel, identite,entrepot){
		var index=searchInArray($scope.lignes, idmateriel, identite);		
		if($scope.lignes[index].id!=0){
			$scope.deleteligneDef($scope.lignes[index].id,entrepot);
		}
		$scope.lignes.splice(index,1);
	}
	$scope.countQte=function(){		
		$scope.qtemat=0
		for (var i = 0; i<$scope.lignes.length; i++) {			
			console.log("compter quantite")
			$scope.qtemat=$scope.qtemat+$scope.lignes[i].quantite
		}
	}

	$scope.deleteligneDef=function(idlign,entrpot){		
		if(type=='entree'){	
			for (var i = 0 ; i < $scope.entrLignes.length; i++) {				
				if($scope.entrLignes[i].id_ligneentre==idlign){
					for (var j = 0 ; j < $scope.stock.length; j++) {
						if($scope.stock[j].materiel==$scope.entrLignes[i].materiel && $scope.stock[j].entrepot==entrpot){
							var qte=$scope.stock[j].qte_disponible-$scope.entrLignes[i].materiel;
							updateStock($scope.stock[j].id_stockmat,$scope.stock[j].materiel,qte,entrpot);
							break
						}												
					}									
					break;
				}		
			}
			
			$http({
				method : 'POST',
				url : '../../serveur/traitement/EntreeLigneTrait.php',
				params :{
					"action" : "delete",
					"id" : idlign
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("SUCCESS");				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )		   
		}
		if(type=='sortie'){	
			for (var i = 0 ; i < $scope.sortLignes.length; i++) {				
				if($scope.sortLignes[i].id_lignesortie==idlign){
					for (var j = 0 ; j < $scope.stock.length; j++) {
						if($scope.stock[j].materiel==$scope.sortLignes[i].materiel && $scope.stock[j].entrepot==entrpot){
							var qte=$scope.stock[j].qte_disponible+$scope.sortLignes[i].materiel;
							updateStock($scope.stock[j].id_stockmat,$scope.stock[j].materiel,qte,$scope.stock[j].entrepot);
							break
						}												
					}									
					break;
				}		
			}
			$http({
				method : 'POST',
				url : '../../serveur/traitement/SortieLigneTrait.php',
				params :{
					"action" : "delete",
					"id" : idlign
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("SUCCESS");				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )		    	
		}

	}		
	$scope.saveligneDef=function(idact,idmateriel,quant,entite,entrepot,etat){		
		console.log("etat : "+etat);
		if(type=='entree'){		
			$http({
				method : 'POST',
				url : '../../serveur/traitement/EntreeLigneTrait.php',
				params :{
					"action" : "insert",
					"qte" : quant,
					"entree" : idact,
					"materiel" : idmateriel,
					"etat" : etat			
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("SUCCESS : ");				
					console.log(response.data);

					console.log("en stock : ");
					var exist=false;
					for (var i = 0 ; i < $scope.stock.length; i++) {											
						if($scope.stock[i].result.materiel==idmateriel && $scope.stock[i].result.entrepot==entrepot){						
							exist=true;
							console.log("update : " +parseInt($scope.stock[i].result.qte_disponible));
							console.log("update2 : "+quant);							
							var qte=parseInt($scope.stock[i].result.qte_disponible)+quant
							console.log("resultats: "+qte);
							updateStock($scope.stock[i].result.id_stockmat,$scope.stock[i].result.materiel,qte,$scope.stock[i].result.entrepot)
							break;						
						}
						else{							
							exist=false;
						}
					}
					if(exist==false){
						insertStock(idmateriel,quant,entrepot)
					}
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )		   
		}
		if(type=='sortie'){		
			$http({
				method : 'POST',
				url : '../../serveur/traitement/SortieLigneTrait.php',
				params :{
					"action" : "insert",
					"qte" : quant,
					"sortie" : idact,
					"materiel" : idmateriel,				
					"entite" : entite,
					"etat" : etat				
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("SUCCESS");				
					console.log(response.data);

					for (var i = 0 ; i < $scope.stock.length; i++) {
						if($scope.stock[i].result.materiel==idmateriel && $scope.stock[i].result.entrepot==entrepot){
							var qte=parseInt($scope.stock[i].result.qte_disponible) - quant
							updateStock($scope.stock[i].result.id_stockmat,$scope.stock[i].result.materiel,qte,$scope.stock[i].result.entrepot)
							break;
						}						
					}
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )		    	
		}
	}	

	$scope.updateligneDef=function(idact,idlign,idmateriel,quant, entite,entrepot,etat){		
		if(type=='entree'){		
			$http({
				method : 'POST',
				url : '../../serveur/traitement/EntreeLigneTrait.php',
				params :{
					"action" : "update",
					"id" : idlign,
					"qte" : quant,
					"entree" : idact,
					"materiel" : idmateriel,
					"etat" : etat
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("SUCCESS");				
					console.log(response.data);


					for (var i = 0 ; i < $scope.stock.length; i++) {
						if($scope.stock[i].result.materiel==idmateriel && $scope.stock[i].result.entrepot==entrepot){
							for (var j = 0 ; j < $scope.entrLignes.length; j++) {
								if($scope.entrLignes[j].result.materiel==idmateriel){
									var oldqte=parseInt($scope.entrLignes[j].result.quantite)
									break;
								}									
							}
						
							var qte1=parseInt($scope.stock[i].result.qte_disponible) - oldqte;
							var qte=qte1+quant;
							console.log("QTE "+qte1+" QTE 2 : "+qte+" quant: "+quant);
							updateStock($scope.stock[i].result.id_stockmat,idmateriel,qte,entrepot)
							break;
						}												
					}
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )		   
		}
		if(type=='sortie'){		
			$http({
				method : 'POST',
				url : '../../serveur/traitement/SortieLigneTrait.php',
				params :{
					"action" : "update",
					"id" : isdlign,
					"qte" : quant,
					"sortie" : idact,
					"materiel" : idmateriel,			
					"entite" : entite,
					"etat" : etat			
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("SUCCESS");				
					console.log(response.data);


					for (var i = 0 ; i < $scope.stock.length; i++) {
						if($scope.stock[i].result.materiel==idmateriel && $scope.stock[i].result.entrepot==entrepot){
							for (var j = 0 ; j < $scope.sortLignes.length; j++) {
								if($scope.sortLignes[j].result.materiel==idmateriel){
									var oldqte=parseInt($scope.sortLignes[j].result.quantite)
									break;
								}		
							}
						
							var qte1=parseInt($scope.stock[i].result.qte_disponible) + oldqte;
							var qte=qte1 - quant;
							updateStock($scope.stock[i].result.id_stockmat,idmateriel,qte,entrepot)
						}												
					}
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )		    	
		}
	}

	$scope.saveligneTemp=function(idlign,idmateriel,nommateriel,quant,id_etat, nometat,id_entite,nomentite){
		var ligne={'id' : idlign, 'materiel' : idmateriel, 'materielnom' : nommateriel, 'quantite' : quant, 'nometat' : nometat, 'etat' : id_etat, 'entite' : id_entite, 'entitenom' : nomentite};	
		console.log('Ligne : ')
		console.log(ligne)	;
		var index=searchInArray($scope.lignes, idmateriel, id_entite);		
		if(index!=-1){
			//$scope.lignes[index].id=idlign;					
			$scope.lignes[index].quantite=$scope.lignes[index].quantite+quant;					
		}
		else{			
			/*ligne[0]=idlign;
			ligne[1]=idmateriel;
			ligne[2]=quant;*/
			$scope.lignes.push(ligne);	
		}
		console.log("index : ");		
		console.log($scope.lignes);
	}

	$scope.updateligneTemp=function(idlign,materielold,idmateriel,nommateriel,quant,id_etat, nometat,entiteold,id_entite,nomentite){
		var ligne={'id' : idlign, 'materiel' : idmateriel, 'materielnom' : nommateriel, 'quantite' : quant, 'nometat' : nometat, 'etat' : id_etat, 'entite' : id_entite, 'entitenom' : nomentite};	
		var index=searchInArray($scope.lignes, materielold, entiteold);		
		if(index!=-1){
			$scope.lignes[index]=ligne;
		}		
	}
	$scope.updateligneAsk=function(idlign,idmateriel,quant,id_entite){		
		for (var i = 0; i < $scope.entite.length ; i++) {
			if($scope.entite[i].result.id_entite==id_entite){
				$scope.identite=$scope.entite[i];
				break;
			}
		}
		for (var i = 0; i < $scope.materiel.length ; i++) {
			if($scope.materiel[i].result.id_idmateriel==idmateriel){
				$scope.idmateriel=$scope.materiel[i];
				break;
			}
		}
		$scope.qte=quant;
	}

	$scope.saveee=function(qtemat,nbremat,date,employe,entrepot){
		console.log("savde");
		var id_entr="";
		var id_sort="";
		if(type=='entree'){
			$http({
			method : 'POST',
			url : '../../serveur/traitement/EntreeTrait.php',
			params :{
				"action" : "insert",
				"qte" : qtemat,
				"nbre" : nbremat,
				"date" : date, 
				"employe" : employe,
				"entrepot" : entrepot
			}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success entree");
					id_entr=response.data
					for (var i = 0 ; i < $scope.lignes.length; i++) {			    	
				    	 $scope.saveligneDef(id_entr,$scope.lignes[i].materiel,$scope.lignes[i].quantite,$scope.lignes[i].entite,entrepot,$scope.lignes[i].etat)	
				    }
					//console.log("id"+id_);
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )	    
		}	
		if(type=='sortie'){
			$http({
			method : 'POST',
			url : '../../serveur/traitement/SortieTrait.php',
			params :{
				"action" : "insert",
				"qte" : qtemat,
				"nbre" : nbremat,
				"date" : date, 
				"employe" : employe,
				"entrepot" : entrepot				
			}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success sortie : "+response.data);
					id_sort=response.data
					for (var i = 0 ; i < $scope.lignes.length; i++) {			    	
				    	$scope.saveligneDef(id_sort,$scope.lignes[i].materiel,$scope.lignes[i].quantite,$scope.lignes[i].entite,entrepot,$scope.lignes[i].etat)	
				    }
					//console.log("id"+id_);
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )	    
		}
		/*console.log(lignes);
		$scope.tablignes=lignes;		*/
	}

	$scope.update=function(id,qtemat,nbremat,date,employe,entrepot){
		console.log("modification");
		var id_entr="";
		var id_sort="";
		if(type=='entree'){
			$http({
				method : 'POST',
				url : '../../serveur/traitement/EntreeTrait.php',
				params :{
					"action" : "update",
					"id" : id, 
					"qte" : qtemat,
					"nbre" : nbremat,
					"date" : date, 
					"employe" : employe,
					"entrepot" : entrepot
				}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success update");
					id_entr=id;
					for (var i = 0 ; i < $scope.lignes.length; i++) {			    	
				    	if($scope.lignes[i].id!=0){
				    		$scope.updateligneDef(id_entr,$scope.lignes[i].id,$scope.lignes[i].materiel,$scope.lignes[i].quantite, entrepot,$scope.lignes[i].etat);
				    	}
				    	else{
				    		$scope.saveligneDef(id_entr,$scope.lignes[i].materiel,$scope.lignes[i].quantite,entrepot,$scope.lignes[i].etat);
				    	}
				    }
					//console.log("id"+id_);
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )	    
		}	
		if(type=='sortie'){
			$http({
			method : 'POST',
			url : '../../serveur/traitement/SortieTrait.php',
			params :{
				"action" : "update",
				"id" : id,
				"qte" : qtemat,
				"nbre" : nbremat,
				"date" : date, 
				"employe" : employe,
				"entrepot" : entrepot				
			}
			})
			.then(			
				function successCallback(response) { 
					console.log("Success entree");
					id_sort=id;
					for (var i = 0 ; i < $scope.lignes.length; i++) {			    	
				    	if($scope.lignes[i].id!=0){
				    		$scope.updateligneDef(id_sort,$scope.lignes[i].id,$scope.lignes[i].materiel,$scope.lignes[i].quantite,$scope.lignes[i].entite,$scope.lignes[i].etat);
				    	}
				    	else{
				    		$scope.saveligneDef(id_sort,$scope.lignes[i].materiel,$scope.lignes[i].quantite,$scope.lignes[i].entite,entrepot,$scope.lignes[i].etat);
				    	}	
				    }
					//console.log("id"+id_);
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		        	console.log("ERREUR");
		         	console.log(response);
		        }
		    )	    
		}		
	}

	$scope.initial = function (){		
		$scope.empploy=0;
		if($scope.idsousmod!=0 && $scope.idsousmod!=null && $scope.idsousmod!=undefined){
			if(type=='sortie'){
				$http({
		            method: 'POST',
		            url: '../../serveur/traitement/SortieTrait.php',
		            params:{
		            	"action" : "outSpec",
		            	"filtre" : "id_sortie="+$scope.idsousmod
	        		}
		        })
				.then(
					function successCallback(response) {                       
						$scope.sorties=response.data[0];
						$scope.empploy=$scope.sorties.result.employe;
						console.log("employe sortie 1 : "+$scope.empploy)	
						for (var i = 0; i < $scope.entrepot.length ; i++) {							
							if($scope.entrepot[i].result.id_entrepot==$scope.sorties.result.entrepot){
								$scope.entrpo=$scope.entrepot[i];
								break;
							}
						}						
						//$scope.datecr=$scope.sorties.result.date
						console.log("sorties : ");
						console.log(response.data);	
						console.log($scope.entrpo);					
						//console.log(response.data);
		            }
		            , function errorCallback(response) {	             
		            }
	        	);
				$http({
		            method: 'POST',
		            url: '../../serveur/traitement/SortieLigneTrait.php',
		            params:{
		            	"action" : "outSpec",
		            	"filtre" : "sortie="+$scope.idsousmod
	        		}
		        })
				.then(
					function successCallback(response) {                       
						$scope.sortLignes=response.data;							
						$scope.qtemat=0;
						$scope.nbrmat=response.data.length;										
						for (var i =0; i<response.data.length; i++) {
								for (var j = 0; j < $scope.entite.length ; j++) {
									if($scope.entite[j].result.id_entite==response.data[i].result.entite){
										var nom_entite=$scope.entite[j].result.nom_entite;
										break;
									}
								}
								for (var k = 0; k < $scope.materiel.length ; k++) {
									if($scope.materiel[k].result.id_materiel==response.data[i].result.materiel){
										var nom_materiel=$scope.materiel[k].result.nom_materiel;
										break;
									}
								}
							$scope.saveligneTemp(response.data[i].result.id_lignesortie,response.data[i].result.materiel,nom_materiel,parseInt(response.data[i].result.qte_sortie),response.data[i].result.entite,nom_entite);
							$scope.countQte();
							//$scope.qtemat=$scope.qtemat+parseInt(response.data[i].result.qte_sortie);
						}						
						console.log(response.data);
		            }
		            , function errorCallback(response) {	             
		            }
	        	);						
			}
			if(type=='entree'){
				$http({
		            method: 'POST',
		            url: '../../serveur/traitement/EntreeTrait.php',
		            params:{
		            	"action" : "outSpec",
		            	"filtre" : "id_entree="+$scope.idsousmod
	        		}
		        })
				.then(
					function successCallback(response) {                       
						$scope.entrees=response.data[0];
						$scope.empploy=$scope.entrees.result.employe;
						console.log("employe sortie : "+$scope.empploy)	
						for (var i = 0; i < $scope.entrepot.length ; i++) {							
							if($scope.entrepot[i].result.id_entrepot==$scope.entrees.result.entrepot){
								$scope.entrpo=$scope.entrepot[i];
								break;
							}
						}												
						//$scope.entrpo=$scope.entrees.result.entrepot
						$scope.datecr=$scope.entrees.result.date
						console.log(response.data[0]);					
		            }
		            , function errorCallback(response) {	             
		            }
	        	);						
				$http({
		            method: 'POST',
		            url: '../../serveur/traitement/EntreeLigneTrait.php',
		            params:{
		            	"action" : "outSpec",
		            	"filtre" : "entree="+$scope.idsousmod
	        		}
		        })
				.then(
					function successCallback(response) {                       
						$scope.entrLignes=response.data;									
						$scope.nbrmat=response.data.length;								
						for (var i =0; i<response.data.length; i++) {														
							for (var k = 0; k < $scope.materiel.length ; k++) {
								if($scope.materiel[k].result.id_materiel==response.data[i].result.materiel){
									var nom_materiel=$scope.materiel[k].result.nom_materiel;
									break;
								}
							}
							$scope.saveligneTemp(response.data[i].result.id_ligneentre,response.data[i].result.materiel,nom_materiel,parseInt(response.data[i].result.qte_entree),0,'')							
							$scope.countQte();
							//$scope.qtemat=$scope.qtemat+parseInt(response.data[i].result.qte_entree)															
						}									
						console.log(response.data);
		            }
		            , function errorCallback(response) {	             
		            }
	        	);						
			}
			//console.log(lignes);
			//$scope.tablignes=lignes;

		}
		else{								
			//$scope.change("entree")						
		}
		console.log("employe sortie : "+$scope.empploy)		;
	}    
});
app.controller('LoginCtrl', function($scope,$http){	
	$scope.connexion=function(login, pwd){
		$http({
	        method: 'POST',
	        url: '../serveur/traitement/EmployeTrait.php',
	        params:{
	        	"action":"connexion",
	        	"login" : login,
	        	"pwd" : pwd
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
				if(response.data===""){
					console.log("ERREUR connexion");				
				}
				else{			
					console.log("SUCCESS connexion");
					$scope.employe=response.data;		
					$http({
				        method: 'POST',
				        url: '../serveur/MANIFEST/session.php',
				        params:{
				        	"action":"connected",
				        	"id" : $scope.employe[0].result.id_emp
				    	}
				    })
					.then(
						function successCallback(response) {                       														
							if(response.data!=null){
								console.log("session cree");								
								console.log(response.data);
								var page=lireCookie("nextPage");
								if(page!=null){
									window.location=page;	
								}
								else{
									window.location='stock.html';
								}
								
							}
							else{
								console.log("session echec");						
							}
				        }
				        , function errorCallback(response) {
				         
				        }
				    );
					//window.location='login.html';
				}
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
	}
});
app.controller('AdminCtrl', function($scope,$http,$compile){	   
                      
    $scope.affiche = function (bouton){    	
		//console.log(bouton)    	
    	$scope.materiels=null;
    	$scope.marques=null;
    	$scope.types=null;
    	$scope.entrepots=null;
    	$scope.entites=null;
    	$scope.employes=null;
    	$scope.roles=null;
    	$scope.fournisseurs=null;
		$scope.entete=[];
		$scope.title="";		
		$scope.sousmodule=bouton			
		console.log($scope.sousmodule);
		if(bouton=='materiel'){						
			$scope.title="Materiel(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";
			$scope.entete[2] = "Numéro de série";
			$scope.entete[3] = "Marque";
			$scope.entete[4] = "Type";			
			$scope.entete[5] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/MaterielTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.materiels=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='type'){						
			$scope.title="Type(s) de Materiel";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";					
			$scope.entete[2] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/TypeTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.types=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='marque'){						
			$scope.title="Marque(s) Materiel";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";		
			$scope.entete[2] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/MarqueTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.marques=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='entrepot'){						
			$scope.title="Entrepot(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";
			$scope.entete[2] = "Adresse";
			$scope.entete[3] = "Capacite";					
			$scope.entete[4] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EntrepotTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.entrepots=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
    		);
		}
		if(bouton=='entite'){						
			$scope.title="Entite(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";
			$scope.entete[2] = "Nomenclature";
			$scope.entete[3] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EntiteTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.entites=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='fournisseur'){						
			$scope.title="Fournisseur(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";					
			$scope.entete[2] = "Adresse";					
			$scope.entete[3] = "Téléphone";					
			$scope.entete[4] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/FournisseurTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.fournisseurs=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='employe'){						
			$scope.title="Employe(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Matricule";		
			$scope.entete[2] = "Nom";		
			$scope.entete[3] = "Prénom";		
			$scope.entete[4] = "Entité";		
			$scope.entete[5] = "Role";		
			$scope.entete[6] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EmployeTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.employes=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='role'){						
			$scope.title="Role(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";			
			$scope.entete[3] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/RoleTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.roles=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if(bouton=='etat'){						
			$scope.title="Etat(s)";
			$scope.entete[0] = "ID";
			$scope.entete[1] = "Nom";			
			$scope.entete[3] = "Action";

			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EtatTrait.php',
		        params:{"action":"out"}
		        })
			.then(
				function successCallback(response) {                       
					$scope.etats=response.data;				
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
	}
	$scope.go=function(){
		window.location='actionWeb/adminaction.html';
	}
	$scope.delete = function(id){
		console.log("delete")		
		$(".modal-body").empty();
		$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/loarder.gif\" width='40%' height='auto'></p>");
		if($scope.sousmodule=='materiel'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/MaterielTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if($scope.sousmodule=='type'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/TypeTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if($scope.sousmodule=='marque'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/MarqueTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );	
		}
		if($scope.sousmodule=='entrepot'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EntrepotTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if($scope.sousmodule=='entite'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EntiteTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );	
		}
		if($scope.sousmodule=='fournisseur'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/FournisseurTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );	
		}
		if($scope.sousmodule=='employe'){
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EmployeTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );		
		}
		if($scope.sousmodule=='role'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/RoleTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
		if($scope.sousmodule=='etat'){						
			$http({
		        method: 'POST',
		        url: '../serveur/traitement/EtatTrait.php',
		        params:{
		        	"action" : "delete",
		        	"id" : id
		    	}
		        })
			.then(
				function successCallback(response) {                       								
					console.log(response.data);
					$scope.affiche($scope.sousmodule);
					$(".modal-body").empty();
					$(".modal-body").html("<p style=\"text-align: center;\"><img src=\"../img/logo-validation.jpg\" width='40%' height='auto'></p>");
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
		}
	}
	$scope.modalView=function(id,nom){		
		if (id) {
			//$scope.dated=date;
			//$scope.ide=id;
			//$scope.entpot=entrepot;
			$(".modal-body").empty();						
			if($scope.sousmodule=='materiel'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer le materiel '+ nom+' <br> Il pourrait concerné des actions dans le stock </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));			
			}
			if($scope.sousmodule=='type'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer le type '+ nom+' <br> Il pourrait concerné un matériel du stock </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));	
			}
			if($scope.sousmodule=='marque'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer la marque '+ nom+' <br> Elle pourrait concerné un matériel du stock </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));					
			}
			if($scope.sousmodule=='entrepot'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer l\'entrepot '+ nom+' <br> Il pourrait contenir du matériel en stock </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));									
			}
			if($scope.sousmodule=='entite'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer l\'entite '+ nom+' <br> Il pourrait contenir des employés </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));									
			}
			if($scope.sousmodule=='fournisseur'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer le fournissuer '+ nom+' <br> Il pourrait avoir déjà effectuer plusieurs livraisons </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));										
			}
			if($scope.sousmodule=='employe'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer l\'employe '+ nom+' <br> Il pourrait avoir déjà effectuer plusieurs actions sur le stock </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));											
			}
			if($scope.sousmodule=='role'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer le role '+ nom+' <br> Certains employes pourrait l\'avoir </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));												
			}
			if($scope.sousmodule=='etat'){						
				$(".modal-body").append($compile('<p>Voulez vous supprimer l\'etat '+ nom+' <br> Certains matériels pourraient être dans cet état </p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete('+id+')">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>')($scope));												
			}
			$scope.$apply(); 
		}			
	}
	$scope.refreshmodal=function(){
		$(".modal-body").empty();
		$(".modal-body").html('<p>Voulez vous supprimer <span ng-if="sousmodule==\'entree\'">l\'entrée</span><span ng-if="sousmodule==\'sortie\'">la sortie</span>: '+$scope.dated+'</p><div class="modal-footer"><button type="button" class="btn btn-success"  ng-click ="delete(ide)">Oui</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" data-dismiss="modal" ng-click=\'refreshmodal()\'>Non</button></div>');
	}
	$scope.sendCookies=function(actionpage,id){		
		creerCookie("pageact",actionpage);
		creerCookie("idsousmodule",id);
	}
});
app.controller('ActionAdminCtrl', function($scope, $http) {
	$scope.sousmodule=lireCookie("pageact");			
	$scope.idsousmod=lireCookie("idsousmodule");		
	supprimerCookie("pageact");
	supprimerCookie("idsousmodule");			
	
	$http({
        method: 'POST',
        url: '../../serveur/traitement/TypeTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.types=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../../serveur/traitement/RoleTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.roles=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../../serveur/traitement/EntiteTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.entites=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../../serveur/traitement/MarqueTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.marques=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $scope.initial=function(){
		$("#"+$scope.sousmodule).addClass("show active");
		$("#"+$scope.sousmodule+"-tab").addClass("active");	
		if($scope.idsousmod!=0 && $scope.idsousmod!=null && $scope.idsousmod!=undefined){			
			if($scope.sousmodule=='materiel'){										
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/MaterielTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var materiel=response.data.result;										

						$scope.matname=materiel.nom_materiel;
						$scope.modenum=materiel.numero_serie;
						var tipe=materiel.type;
						var mark=materiel.marque;
						console.log($scope.types.length)
						for(var i=0; i<$scope.types.length; i++){
							if($scope.types[i].result.id_type==tipe){
								$scope.type=$scope.types[i];
								break;
							}
						}
						for(var i=0; i<$scope.marques.length; i++ ){
							if($scope.marques[i].result.id_marque==mark){
								$scope.marque=$scope.marques[i];
								break;
							}
						}						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );													
			}
			if($scope.sousmodule=='type'){						
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/TypeTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var type=response.data.result;				
						console.log(response.data.result.nom_type);
						//console.log(entite[0].result.nom_entite);

						$scope.typenom=type.nom_role;						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );	
			}
			if($scope.sousmodule=='marque'){						
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/MarqueTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var marque=response.data.result;				
						console.log(response.data.result.nom_marque);
						//console.log(entite[0].result.nom_entite);

						$scope.marquenom=marque.nom_marque;						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );		
			}
			if($scope.sousmodule=='entrepot'){					
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/EntrepotTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var entrepot=response.data.result;				
						console.log(response.data.result.nom_entrepot);
						//console.log(entrepot[0].result.nom_entrepot);

						$scope.entrnom=entrepot.nom_entrepot;
						$scope.entradr=entrepot.adresse_entrepot;
						$scope.capacite=parseInt($scope.entrepot.capacite);
			        }
			        , function errorCallback(response) {
			         
			        }
			    );
			}
			if($scope.sousmodule=='entite'){						
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/EntiteTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var entite=response.data.result;				
						console.log(response.data.result.nom_entite);
						//console.log(entite[0].result.nom_entite);

						$scope.entnom=entite.nom_entite;
						$scope.entnomen=entite.nomenclature;						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );	
			}
			if($scope.sousmodule=='fournisseur'){						
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/FournisseurTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var fournisseur=response.data.result;				
						console.log(response.data.result.nom_fournisseur);
						//console.log(fournisseur[0].result.nom_fournisseur);

						$scope.fourname=fournisseur.nom_fournisseur;
						$scope.fouradr=fournisseur.adresse_fournisseur;
						$scope.fourtel=fournisseur.tel_fournisseur;
			        }
			        , function errorCallback(response) {
			         
			        }
			    );	
			}
			if($scope.sousmodule=='employe'){	
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/EmployeTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var employe=response.data.result;										

						$scope.empmat=employe.matricule_emp;
						$scope.empnom=employe.nom_emp;
						$scope.emppre=employe.prenom_emp;
						var ent=employe.entite_emp;
						var rol=employe.role_emp_;
						console.log($scope.entites.length)
						for(var i=0; i<$scope.entites.length; i++){
							if($scope.entites[i].result.id_entite==ent){
								$scope.entite=$scope.entites[i];
								console.log($scope.entites[i]);
								break;
							}
						}
						for(var i=0; i<$scope.roles.length; i++ ){
							if($scope.roles[i].result.id_role==rol){
								$scope.role=$scope.roles[i];
								break;
							}
						}						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );						
			}
			if($scope.sousmodule=='role'){						
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/RoleTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var role=response.data.result;				
						console.log(response.data.result.nom_role);
						//console.log(entite[0].result.nom_entite);

						$scope.rolenom=role.nom_role;						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );	
			}
			if($scope.sousmodule=='etat'){						
				$http({
			        method: 'POST',
			        url: '../../serveur/traitement/EtatTrait.php',
			        params:{
			        	"action":"outone",
			        	"id" : $scope.idsousmod
			    	}
			     })
				.then(
					function successCallback(response) {                       
						var etat=response.data.result;				
						console.log(response.data.result.nom_etat);
						//console.log(entite[0].result.nom_entite);

						$scope.etatnom=etat.nom_etat;						
			        }
			        , function errorCallback(response) {
			         
			        }
			    );	
			}

		}				
	}
    $scope.materieladd=function(nom,modele,marque,type){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/MaterielTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom,
	        	"numserie" : modele,
	        	"mark" : marque,
	        	"type" : type

	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.marqueadd=function(nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/MarqueTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }

    $scope.typeadd=function(nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/TypeTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.roleadd=function(nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/RoleTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.etatadd=function(nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EtatTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.fournisseuradd=function(nom,adresse,tel){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/FournisseurTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom,
	        	"adresse"  : adresse,
	        	"tel" : tel
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.entrepotadd=function(nom,adresse,capacite){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EntrepotTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom,
	        	"adresse"  : adresse,
	        	"capacite" : capacite
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );	    
    }
    $scope.entiteadd=function(nom,nomenclature){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EntiteTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom,
	        	"nomenclature"  : nomenclature
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );	    
    }
    $scope.employeadd=function(matricule,nom,prenom,entite,role){
    	var login=nom.substr(0,4)+prenom.substr(0,4);
    	var password="camtel123";
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EmployeTrait.php',
	        params:{
	        	"action":"insert",
	        	"nom" : nom,
	        	"matricule" : matricule,
	        	"prenom" : prenom,
	        	"role" : role,
	        	"entite" : entite,
	        	"login" : login,
	        	"pwd" : password
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );	    
    }

    //UPDATE
	$scope.materielupdate=function(id,nom,modele,marque,type){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/MaterielTrait.php',
	        params:{
	        	"action": "update",
	        	"id" : id,
	        	"nom" : nom,
	        	"numserie" : modele,
	        	"mark" : marque,
	        	"type" : type

	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.marqueupdate=function(id,nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/MarqueTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.typeupdate=function(id,nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/TypeTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.roleupdate=function(id,nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/RoleTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.etatupdate=function(id,nom){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EtatTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.fournisseurupdate=function(id,nom,adresse,tel){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/FournisseurTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom,
	        	"adresse"  : adresse,
	        	"tel" : tel
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );
    }
    $scope.entrepotupdate=function(id,nom,adresse,capacite){
    	//var cap=parseInt(capacite);    	

    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EntrepotTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom,
	        	"adresse"  : adresse,
	        	"capacite" : capacite
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );	    
    }
    $scope.entiteupdate=function(id,nom,nomenclature){
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EntiteTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom,
	        	"nomenclature"  : nomenclature
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );	    
    }
    $scope.employeupdate=function(id,matricule,nom,prenom,entite,role){
    	var login=nom.substr(0,4)+prenom.substr(0,4);
    	var password="camtel123";
    	$http({
	        method: 'POST',
	        url: '../../serveur/traitement/EmployeTrait.php',
	        params:{
	        	"action":"update",
	        	"id" : id,
	        	"nom" : nom,
	        	"matricule" : matricule,
	        	"prenom" : prenom,
	        	"role" : role,
	        	"entite" : entite,
	        	"login" : login,
	        	"pwd" : password
	    	}
        })
		.then(
			function successCallback(response) {                       							
				console.log(response.data);
	        }
	        , function errorCallback(response) {
	         
	        }
	    );	    
    }    
    
});
app.controller('ReportingCtrl', function($scope, $http) {	
});
app.controller('DemandeCtrl', function($scope, $http) {	
});
app.controller('ActionDemandeCtrl', function($scope, $http) {	
});
app.controller('ApproCtrl', function($scope, $http) {	
});
app.controller('ActionApproCtrl', function($scope, $http) {	
});
app.controller('ReportingCtrl', function($scope, $http) {	
	$http({
        method: 'POST',
        url: '../serveur/traitement/MaterielTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.materiels=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
    $http({
        method: 'POST',
        url: '../serveur/traitement/EntiteTrait.php',
        params:{"action":"out"}
        })
	.then(
		function successCallback(response) {                       
			$scope.entites=response.data;				
			console.log(response.data);
        }
        , function errorCallback(response) {
         
        }
    );
	$scope.general=function(month){
		console.log(month);
		$http({
	        method: 'POST',
	        url: '../serveur/traitement/ReportingTrait.php',
	        params:{
	        	"action":"general",
	        	"mois" : month	        	
	    	}
        })
        .then(
				function successCallback(response) {                       					

					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
	}
	$scope.hebdomadaire=function(semaine){
		console.log(semaine);
		$http({
	        method: 'POST',
	        url: '../serveur/traitement/ReportingTrait.php',
	        params:{
	        	"action":"hebdomadaire",
	        	"semaine" : semaine	        	
	    	}
        })
        .then(
				function successCallback(response) {                       					
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
	}
	$scope.materiel=function(materiel,debut, fin){
		console.log(materiel+debut+fin);
		$http({
	        method: 'POST',
	        url: '../serveur/traitement/ReportingTrait.php',
	        params:{
	        	"action":"materiel",
	        	"materiel" : materiel,
	        	"debut" : debut,
	        	"fin" : fin
	    	}
        })
        .then(
				function successCallback(response) {                       					
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
	}
	$scope.entite=function(entite,debut, fin){
		console.log(entite+debut+fin);
		$http({
	        method: 'POST',
	        url: '../serveur/traitement/ReportingTrait.php',
	        params:{
	        	"action":"entite",
	        	"entite" : entite,
	        	"debut" : debut,
	        	"fin" : fin
	    	}
        })
        .then(
				function successCallback(response) {                       					
					console.log(response.data);
		        }
		        , function errorCallback(response) {
		         
		        }
		    );
	}
});
app.directive('initModel', function($compile) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			scope[attrs.initModel] = element[0].value;
			element.attr('ng-model', attrs.initModel);
			element.removeAttr('init-model');
			$compile(element)(scope);
		}
	};
});
