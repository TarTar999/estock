<?php
	class EntrepotStock{
		private $_idstockMat;
		private $_qteDisponible;
		private $_materiel;
		private $_entrepot;
		
		//Constructeurs
		public function __construct($id, $qte, Materiel $mat, Entrepot $entrepot){
			$this->_idstockMat=$id;
			$this->setQteDisponible($qte);
			$this->setMateriel($mat);
			$this->setEntrepot($entrepot);
		}		
		
		//Accesseurs
		public function getIdStockMat(){
			return $this->_idStockMat;		
		}
		public function getQteDisponible(){
			return $this->_qteDisponible;
		}
		public function getMateriel(){
			return $this->_materiel;
		}
		public function getEntrepot(){
			return $this->_entrepot;
		}
		
		//Mutateurs
		public function setQteDisponible($qte){
			$this->_qteDisponible=$qte;
		}
		public function setMateriel(Materiel $mat){
			$this->_Materiel=$mat;
		}
		public function setEntrepot(Entrepot $entre){
			$this->_entrepot=$entre;
		}		
	}
?>