<?php
	class Entree{
		private $_idEntree;
		private $_nbreMatEntree;
		private $_qteMatEntree;
		private $_dateEntree;
		private $_employe;		
		private $_entrepot;
				
		//Constructeurs
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

		//Accesseurs
		public function getIdEntree(){
			return $this->_idEntree;
		}
		public function getNbreMatEntree(){
			return $this->_nbreMatEntree;
		}
		public function getQteMatEntree(){
			return $this->_qteMatEntree;
		}
		public function getDateEntree(){
			return $this->_dateEntree;
		}		
		public function getEmploye(){
			return $this->_employe;
		}		
		public function getEntrepot(){
			return $this->_entrepot;
		}
		
		//Mutateurs
		public function setIdEntree($id){
			$this->_idEntree=$id;
		}		
		public function setNbreMatEntree($nbre){
			$this->_nbreMatEntree=$nbre;
		}
		public function setQteMatEntree($qte){
			$this->_qteMatEntree=$qte;
		}
		public function setDateEntree($date){
			$this->_dateEntree=$date;
		}
		public function setEmploye($employe){
			$this->_employe=$employe;
		}		
		public function setEntrepot(Entrepot $entrepot){
			$this->_entrepot=$entrepot;
		}

		public function _constructWithAll($id, $nbmat, $qte, $date,Employe $employe,Entrepot $entrepot){
			$this->_idEntree=$id;
			$this->setNbreMatEntree($nbmat);
			$this->setQteMatEntree($qte);
			$this->setDateEntree($date);
			$this->setEmploye($employe);
			$this->setEntrepot($entrepot);
		}
		public function _constructById($id){
			$this->_idEntree=$id;			
		}
	}
?>