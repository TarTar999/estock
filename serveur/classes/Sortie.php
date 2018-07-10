<?php
	class Sortie{
		private $_idSortie;
		private $_nbreMatSortie;
		private $_qteMatSortie;
		private $_dateSortie;
		private $_employe;		
		private $_entrepot;
		
		public function __construct()
		{
		    $ctp = func_num_args();
		    $args = func_get_args();
		    switch($ctp)
		    {
		        case 6:
		            $this->_constructWithAll($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);
		            break;
		        case 1:
		            $this->_constructById($args[0]);
		            break;		        
		    }
		}

		//Constructeurs
		
		//Accesseurs
		public function getIdSortie(){
			return $this->_idSortie;
		}
		public function getNbreMatSortie(){
			return $this->_nbreMatSortie;
		}
		public function getQteMatSortie(){
			return $this->_qteMatSortie;
		}
		public function getDateSortie(){
			return $this->_dateSortie;
		}		
		public function getEmploye(){
			return $this->_employe;
		}		
		public function getEntrepot(){
			return $this->_entrepot;
		}
		
		//Mutateurs
		public function setIdSortie($id){
			$this->_idSortie=$id;
		}		
		public function setNbreMatSortie($nbre){
			$this->_nbreMatSortie=$nbre;
		}
		public function setQteMatSortie($qte){
			$this->_qteMatSortie=$qte;
		}
		public function setDateSortie($date){
			$this->_dateSortie=$date;
		}
		public function setEmploye(Employe $employe){
			$this->_employe=$employe;
		}		
		public function setEntrepot(Entrepot $entrepot){
			$this->_entrepot=$entrepot;
		}

		public function _constructById($id){
			$this->_idSortie=$id;
		}
		public function _constructWithAll($id, $nbmat, $qte, $date,Employe $employe,Entrepot $entrepot){
			$this->_idSortie=$id;
			$this->setNbreMatSortie($nbmat);
			$this->setQteMatSortie($qte);
			$this->setDateSortie($date);
			$this->setEmploye($employe);			
			$this->setEntrepot($entrepot);
		}		
	}
?>