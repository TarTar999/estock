<?php
	class Employe{
		private $_idEmp;
		private $_matriculeEmp;
		private $_nomEmp;
		private $_prenomEmp;
		private $_loginEmp;
		private $_pwdEmp;
		private $_entiteEmp;
		private $_roleEmp;
		
		//Constructeurs
		public function __construct($id, $matricule, $nom, $prenom, $login, $pwd,Entite $entite,Role $role){
			$this->_idEmp=$id;
			$this->setMatriculeEmp($matricule);
			$this->setNomEmp($nom);
			$this->setPrenomEmp($prenom);
			$this->setloginEmp($login);
			$this->setPwdEmp($pwd);
			$this->setEntiteEmp($entite);
			$this->setRoleEmp($role);
		}
		
		//Accesseurs
		public function getIdEmp(){
			return $this->_idEmp;
		}
		public function getMatriculeEmp(){
			return $this->_matriculeEmp;
		}
		public function getNomEmp(){
			return $this->_nomEmp;
		}
		public function getPrenomEmp(){
			return $this->_prenomEmp;
		}
		public function getloginEmp(){
			return $this->_loginEmp;
		}
		public function getPwdEmp(){
			return $this->_pwdEmp;
		}
		public function getEntiteEmp(){
			return $this->_entiteEmp;
		}
		public function getRoleEmp(){
			return $this->_roleEmp;
		}
		
		//Mutateurs		
		public function setMatriculeEmp($matricule){
			$this->_matriculeEmp=$matricule;
		}
		public function setNomEmp($nom){
			$this->_nomEmp=$nom;
		}
		public function setPrenomEmp($prenom){
			$this->_prenomEmp=$prenom;
		}
		public function setloginEmp($login){
			$this->_loginEmp=$login;
		}
		public function setPwdEmp($pwd){
			$this->_pwdEmp=$pwd;
		}
		public function setEntiteEmp(Entite $entite){
			$this->_entiteEmp=$entite;
		}
		public function setRoleEmp(Role $role){
			$this->_roleEmp=$role;
		}
	}
?>