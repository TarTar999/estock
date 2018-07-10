<?php
	class Materiel{		
		private $_idMateriel;
		private $_nomMateriel;
		private $_numSerie;
		private $_marque;
		private $_type;
		
		//Constructeurs
		public function __construct($id, $nom, $numserie, Marque $mark, Type $type){
			$this->_idMateriel=$id;
			$this->setNomMateriel($nom);
			$this->setNumSerie($numserie);
			$this->setMarque($mark);
			$this->setType($type);
		}
		
		//Accesseurs
		public function getIdMateriel(){
			return $this->_idMateriel;		
		}
		public function getNomMateriel(){
			return $this->_nomMateriel;		
		}
		public function getNumSerie(){
			return $this->_numSerie;		
		}
		public function getMarque(){
			return $this->_marque;		
		}
		public function getType(){
			return $this->_type;		
		}		
		
		//Mutateurs
		public function setNomMateriel($nom){
			$this->_nomMateriel=$nom;
		}
		public function setNumSerie($ns){
			$this->_numSerie=$ns;
		}
		public function setMarque(Marque $mark){
			$this->_marque=$mark;
		}
		public function setType(Type $type){
			$this->_type=$type;
		}
	}
?>