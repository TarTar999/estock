<?php
	class EntreeLigne{
		private $_idSortieLigne;
		private $_qteSortie;
		private $_sortie;
		private $_materiel;
		
		//Constructeurs
		public function __construct($id, $qte, $entree, $materiel){
			$this->_idSortieLigne=id;
			$this->setQteSortie($qte);
			$this->setSortie($entree);
			$this->setMateriel($materiel);
		}
		
		//Accesseurs
		public function getIdSortieLigne(){
			return $this->_idEntreeLigne;		
		}
		public function getQteSortie(){
			return $this->_qteSortie;
		}
		public function getSortie(){
			return $this->_entree;
		}
		public function getMateriel(){
			return $this->_materiel;
		}
		
		//Mutateurs
		public function setQteSortie($qte){
			$this->_qteSortie=$qte;
		}
		public function setSortie($sortie){
			$this->_entree=$sortie;
		}
		public function setMateriel($materiel){
			$this->_materiel=$materiel;
		}
	}
?>