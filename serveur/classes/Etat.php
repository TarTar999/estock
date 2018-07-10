<?php
	class Etat{
		private $_idEtat;
		private $_nomEtat;			
		
		//Constructeurs
		public function __construct($id, $nom){
			$this->_idEtat=$id;
			$this->setNomEtat($nom);			
		}
		//Accesseurs
		public function getIdEtat(){
			return $this->_idEtat;
		}
		public function getNomEtat(){
			return $this->_nomEtat;
		}		
		
		//Mutateurs		
		public function setNomEtat($nom){
			$this->_nomEtat=$nom;
		}		
	}
?>