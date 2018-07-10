<?php
	class Type{
		private $_idType;
		private $_nomType;		
		
		//constructeur
		public function __construct($id, $nom){
			echo("Je suis leconstructeur");
			$this->_idType=$id;
			$this->setNomType($nom);
		}
		
		//Accesseurs
		public function getIdType(){
			return $this->_idType;		
		}
		public function getNomType(){
			return $this->_nomType;
		}
		
		//Mutateurs		
		public function setNomType($nom){			
			$this->_nomType=$nom;
		}
	}
?>