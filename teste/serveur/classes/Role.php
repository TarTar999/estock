<?php
	class Role{
		private $_idRole;
		private $_nomRole;		
		
		//Constructeurs
		public function __construct($id, $nom){
			$this->_idRole=$id;
			$this->setNomRole($nom);
		}
		
		//Accesseurs
		public function getIdRole(){
			return $this->_idRole;		
		}
		public function getNomRole(){
			return $this->_nomRole;
		}
		
		//Mutateurs		
		public function setNomRole($nom){
			$this->_nomRole=$nom;
		}
		
		//String
		public function __toString(){
			return "Role--> Nom : ".$this->getNomRole()." ID : ".$this->getIdRole()."";
		}
		
		//FONCTIONS
		public function conversiontableau(){
			$tableau=array(
				"id" => $this->getIdRole(),
				"nom" => $this->getNomRole(),
						   );
			return $tableau;
		}
	}
?>