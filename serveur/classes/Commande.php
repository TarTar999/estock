<?php
	class Commande{
		private $_idCmd;
		private $_nbreMatCmd;
		private $_qteMatCmd;
		private $_dateCmd;
		private $_employeCmd;
		
		
		//Constructeurs
		public function __construct($id, $nbmat, $qte, $date,Employe $employe){
			$this->_idCmd=$id;
			$this->setNbreMatCmd($nbmat);
			$this->setQteMatCmd($qte);
			$this->setDateCmd($date);
			$this->setEmployeCmd($employe);
		}
		//Accesseurs
		public function getIdCmd(){
			return $this->_idCmd;
		}
		public function getNbreMatCmd(){
			return $this->_nbreMatCmd;
		}
		public function getQteMatCmd(){
			return $this->_qteMatCmd;
		}
		public function getDateCmd(){
			return $this->_dateCmd;
		}
		public function getEmployeCmd(){
			return $this->_employeCmd;
		}
		
		//Mutateurs		
		public function setNbreMatCmd($nbre){
			$this->_nbreMatCmd=$nbre;
		}
		public function setQteMatCmd($qte){
			$this->_qteMatCmd=$qte;
		}
		public function setDateCmd($date){
			$this->_dateCmd=$date;
		}
		public function setEmployeCmd(Employe $employe){
			$this->_employeCmd=$employe;
		}
				
	}
?>