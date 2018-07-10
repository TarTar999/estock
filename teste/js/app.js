var app = angular.module("estock", ["ngRoute"]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "asset/login.html",
        controller:"LogCtrl"
    })
    .when("/ajout", {
        templateUrl : "asset/stockaction.html",
        controller:"AddCtrl"
    })
    .when("/red/:msg", {
        templateUrl : "./asset/red.htm",
        controller: "AppCtrl"
    })
    .when("/blue", {
        templateUrl : "./asset/blue.htm"
    });
});
//var sousmodule=""
app.run(function($rootScope){
    //$rootScope.sousmodule=""
    $rootScope.change= function(action){
        console.log("Changement : "+$rootScope.sousmodule);
        $rootScope.sousmodule=action;
        console.log("changé : "+$rootScope.sousmodule);
    }
});
app.controller('ActionStockCtrl', function($scope, $rootScope, $http) {  
    /*$scope.$emit('echange',function(event,args){
        sousmodule=args.message;
    })*/
    console.log("action : "+$scope.sousmodule);
    $scope.initial = function (){
        $http({
            method: 'POST',
            url: '../serveur/objetDAO/EntiteDao.php',
            params:{"action":"out"}
            })
        .then(
            function successCallback(response) {                       
                $scope.entite=response.data;                
                console.log(response.data[1].result);
            }
            , function errorCallback(response) {
             
            }
        );
        /*$http({
            method: 'POSTT',
            url: '../serveur/objetDAO/EntrepotDao.php',
            params:{"action":"out"}
            })
        .then(
            function successCallback(response) {                       
                $scope.entite=response.data;                
                console.log(response.data[1].result);
            }
            , function errorCallback(response) {
             
            }
        );*/
        $scope.entete=[];
        $scope.title="";
        $scope.change("entree")
        var type=$scope.sousmodule;
        if(type=='sortie'){
            $scope.title="Enregistrement Sortie";
            $scope.entete[0] = "ID";
            $scope.entete[1] = "Materiel";
            $scope.entete[2] = "Quantite sortie";           
            $scope.entete[3] = "Action";
        }
        if(type=='entree'){
            $scope.title="Enregistrement Entrée";
            $scope.entete[0] = "ID";
            $scope.entete[1] = "Materiel";
            $scope.entete[2] = "Quantite entrée";           
            $scope.entete[3] = "Action";
        }
        if(type=='livraison'){
            
        }
        if(type=='stock'){
            
        }
    }    
});
app.controller('LogCtrl', function($scope, $rootScope, $http) {
    $scope.connect = function () {
        window.location='#!ajout';
    }
})
app.controller('AddCtrl', function($scope, $rootScope, $http) {
    
})
app.controller('StockCtrl', function($scope, $rootScope, $http) {
    //$scope.sousmodule="sortie";   
    $scope.go = function (){
        window.location='stockaction.html';
        $scope.$broadcast('echange',{message :sousmodule})
    }
    $scope.click = function (bouton){
        //console.log(bouton)
        $scope.entete=[];
        $scope.title="";
        $rootScope.change(bouton);
        sousmodule=bouton
        console.log($scope.sousmodule);
        if(bouton=='sortie'){           
            $scope.title="Materiel(s) sorti(s) du stock";
            $scope.entete[0] = "ID";
            $scope.entete[1] = "Nombre Materiel";
            $scope.entete[2] = "Quantite Materiel";
            $scope.entete[3] = "Entrepot de Départ";
            $scope.entete[4] = "Entite de Destination";
            $scope.entete[5] = "Date de sortie";
            $scope.entete[6] = "Action";
        }
        if(bouton=='entree'){           
            $scope.title="Materiel(s) entré(s) en stock"
            $scope.entete[0] = "ID";
            $scope.entete[1] = "Nombre Materiel";
            $scope.entete[2] = "Quantite Materiel";
            $scope.entete[3] = "Entrepot de Destination";
            $scope.entete[4] = "Date d'entree";
            $scope.entete[5] = "Action";
        }
        if(bouton=='stock'){            
            $scope.title="Materiel(s) disponible(s) en stock"
            $scope.entete[0] = "ID";
            $scope.entete[1] = "Type";
            $scope.entete[2] = "Nom Materiel";
            $scope.entete[3] = "Numero Série";
            $scope.entete[4] = "Marque";
            $scope.entete[5] = "Action";                                
        }
        if(bouton=='livraison'){            
            $scope.title="Materiel(s) livré(s)"
            $scope.entete[0] = "ID";
            $scope.entete[1] = "Nombre Materiel";
            $scope.entete[2] = "Quantite Materiel";
            $scope.entete[3] = "Fournisseur";
            $scope.entete[4] = "Date de Livraison";
            $scope.entete[5] = "Action";
        }
    }
})
