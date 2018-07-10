<?php
	class EntrepotStock{
		private $_idstockMat;
		private $_qteDisponible;
		private $_materiel;
		private $_entrepot;
		
		//Constructeurs
		public function __construct(){			
		    $ctp = func_num_args();
		    $args = func_get_args();		    
		    switch($ctp)
		    {
		        case 4:
		            $this->_constructWithAll($args[0],$args[1],$args[2],$args[3]);		            
		            break;
		        case 1:
		            $this->_constructById($args[0]);
		            break;		        
		    }
		}				
		
		//Accesseurs
		public function getIdStockMat(){
			return $this->_idstockMat;		
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
			$this->_materiel=$mat;
		}
		public function setEntrepot(Entrepot $entre){
			$this->_entrepot=$entre;
		}		

		public function _constructWithAll($id, $qte, Materiel $mat, Entrepot $entrepot){
			$this->_idstockMat=$id;
			$this->setQteDisponible($qte);
			$this->setMateriel($mat);
			$this->setEntrepot($entrepot);
		}
		public function _constructById($id){
			$this->_idstockMat=$id;			
		}
	}
?>