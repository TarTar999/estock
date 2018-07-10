<?php
	class Personnage{
		private $_idEntite;
		private $_nomEntite;
		private $_nomenclature;		
		
		//Constructeurs
		public function __construct($id, $nom, $nomen){
			$this->_idEntite=$id;
			$this->setNomEntite($nom);
			$this->setNomenclature($nomen);
			$this->setChefEntite($chef);
		}
		//Accesseurs
		public function getIdEntite(){
			return $this->_idEntite;
		}
		public function getNomEntite(){
			return $this->_nomEntite;
		}
		public function getNomenclature(){
			return $this->_nomenclature;
		}		
		
		//Mutateurs		
		public function setNomEntite($entite){
			$this->_nomEntite=$entite;
		}
		public function setNomenclature($nomenclature){
			$this->_nomenclature=$nomenclature;
		}		
	}
?>