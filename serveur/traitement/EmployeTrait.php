<?php 
	require('../objetDAO/EmployeDao.php');
	include('../config/config.php');
	$employedao=new EmployeDAO();
	function createObject($id, $matricule, $nom, $prenom, $login, $pwd, $entite, $rl){											
		$entdao=new EntiteDAO();		
		$ents=$entdao->out("id_entite=".$entite);		
		$ent=$ents[1]['object'][0]['objet'];
		
		$roledao=new RoleDAO();
		$roles=$roledao->out("id_role=".$rl);		
		$role=$roles[1]['object'][0]['objet'];

		$obj= new Employe($id, $matricule, $nom, $prenom, $login, $pwd, $ent, $role);
		return $obj;		
	}
	$action = (isset($_POST['action'])? $_POST['action']: (isset($_GET['action'])? $_GET['action']:null ));
	if($action){		
		switch ($action) {
			case 'insert':
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$matricule = (isset($_POST['matricule'])? $_POST['matricule']: (isset($_GET['matricule'])? $_GET['matricule']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$prenom = (isset($_POST['prenom'])? $_POST['prenom']: (isset($_GET['prenom'])? $_GET['prenom']:null));
				$login = (isset($_POST['login'])? $_POST['login']: (isset($_GET['login'])? $_GET['login']:null));
				$pwd = (isset($_POST['pwd'])? $_POST['pwd']: (isset($_GET['pwd'])? $_GET['pwd']:null));
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));	
				$role = (isset($_POST['role'])? $_POST['role']: (isset($_GET['role'])? $_GET['role']:null));			

				$password=md5($pwd);
				$sql= "INSERT INTO employe (`id_emp`, `matricule_emp`, `nom_emp`, `prenom_emp`, `login_emp`, `pwd_emp`,`entite_emp`, `role_emp`) VALUES (NULL, ?,?,?,?,?,?,?);";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($matricule, $nom, $prenom, $login,$password, $entite,$role));			
	            echo json_encode("ok");
			break;
			case 'out':
				$employes=$employedao->out("1");
				echo json_encode($employes[0]['resultat']);				
			break;
			case 'delete':
				$id= (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));				
				$sql= "DELETE FROM employe WHERE id_emp=?";			
				echo($sql);
				$req=$BDD->prepare($sql);
	            $req->execute(array($id));
	            echo json_encode("ok");
			break;
			case 'connexion' : 
				$login = (isset($_POST['login'])? $_POST['login']: (isset($_GET['login'])? $_GET['login']:null));
				$pwd = (isset($_POST['pwd'])? $_POST['pwd']: (isset($_GET['pwd'])? $_GET['pwd']:null))
				;
				$password=md5($pwd);				
				$employes=$employedao->out("login_emp='".$login."' AND pwd_emp='".$password."'");
				if($employes){
					echo json_encode($employes[0]['resultat']);					
				}				
			break;
			case "outone" : 
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$req=$BDD->prepare('SELECT * FROM employe WHERE id_emp=?;');
	            $req->execute(array($id));			
	            $results = array();				
	           	while($data=$req->fetch(PDO::FETCH_ASSOC)){											
					array_push($results,array('result' => $data));					
	            }		
				//echo ($commandes[1]['object'][1]['objet']);
				echo json_encode($results[0]);			
			break;
			case "update" :
				$id = (isset($_POST['id'])? $_POST['id']: (isset($_GET['id'])? $_GET['id']:null));
				$matricule = (isset($_POST['matricule'])? $_POST['matricule']: (isset($_GET['matricule'])? $_GET['matricule']:null));
				$nom = (isset($_POST['nom'])? $_POST['nom']: (isset($_GET['nom'])? $_GET['nom']:null));
				$prenom = (isset($_POST['prenom'])? $_POST['prenom']: (isset($_GET['prenom'])? $_GET['prenom']:null));
				$login = (isset($_POST['login'])? $_POST['login']: (isset($_GET['login'])? $_GET['login']:null));
				$pwd = (isset($_POST['pwd'])? $_POST['pwd']: (isset($_GET['pwd'])? $_GET['pwd']:null));
				$entite = (isset($_POST['entite'])? $_POST['entite']: (isset($_GET['entite'])? $_GET['entite']:null));	
				$role = (isset($_POST['role'])? $_POST['role']: (isset($_GET['role'])? $_GET['role']:null));			

				$password=md5($pwd);
				$sql="UPDATE employe SET matricule_emp=? , nom_emp=? , prenom_emp=?, login_emp=?, pwd_emp=? ,entite_emp=?, role_emp=? WHERE id_emp=?;";
				$req=$BDD->prepare($sql);
	            $req->execute(array($matricule, $nom, $prenom, $login,$password, $entite,$role,$id));
				$retour = array();
				$retour["status"] = true;
				echo json_encode($retour);	
			break;
		}
	}
?>