<?php
	class Entree{
		private $_idEntree;
		private $_nbreMatEntree;
		private $_qteMatEntree;
		private $_dateEntree;
		private $_employe;		
		private $_entrepot;
		
		public function __construct($id, $nbmat, $qte, $date,Employe $employe,Entrepot $entrepot){
			$this->_idEntree=$id;
			$this->setNbreMatEntree($nbmat);
			$this->setQteMatEntree($qte);
			$this->setDateEntree($date);
			$this->setEmploye($employe);
			$this->setEntrepot($entrepot);
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
		}public function setEntrepot(Entrepot $entrepot){
			$this->_entrepot=$entrepot;
		}
	}
?>