<?php
	class Marque{
		private $_idMarque;
		private $_nomMarque;		
		
		//Constructeurs
		public function __construct($id, $nom){
			$this->_idMarque=$id;
			$this->setNomMarque($nom);
		}
		
		//Accesseurs
		public function getIdMarque(){
			return $this->_idMarque;		
		}
		public function getNomMarque(){
			return $this->_nomMarque;
		}
		
		//Mutateurs		
		public function setNomMarque($nom){
			$this->_nomMarque=$nom;
		}
	}
?>