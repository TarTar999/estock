<?php
	class Livraison{
		private $_idLivraison;
		private $_qteMatLivree;
		private $_nbreMatLivree;
		private $_dateLivraison;
		private $_employe;
		
		//Acesseurs		
		public function getIdLivraison(){
			return $this->_idLivraison;			
		}
		public function getqteMatLivree(){
			return $this->_qteMatLivree;			
		}
		public function getNbreMatLivree(){
			return $this->_nbreMatLivree;			
		}
		public function getdateLivraison(){
			return $this->_dateLivraison;			
		}
		public function getEmploye(){
			return $this->_employe;
		}
		//Mutateurs		
		public function setqteMatLivree($qte){
			$this->_qteMatLivree=$qte;			
		}
		public function setNbreMatLivree($nbreMat){
			$this->_nbreMatLivree=$nbreMat;			
		}
		public function setdateLivraison($date){
			$this->_dateLivraison=$date;			
		}
		public function setEmploye($emp){
			$this->_employe=$emp;
		}
?>