<?php
	class EntreeLigne{
		private $_idEntreeLigne;
		private $_qteEntree;
		private $_entree;
		private $_materiel;
		
		//Accesseurs
		public function getIdEntreeLigne(){
			return $this->_idEntreeLigne;		
		}
		public function getQteEntree(){
			return $this->_qteEntree;
		}
		public function getEntree(){
			return $this->_entree;
		}
		public function getMateriel(){
			return $this->_materiel;
		}
		
		//Mutateurs
		public function setQteEntree($qte){
			$this->_qteEntree=$qte;
		}
		public function setEntree($entree){
			$this->_entree=$entree;
		}
		public function setMateriel($materiel){
			$this->_materiel=$materiel;
		}
	}
?>