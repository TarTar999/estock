<?php
	class Livraison{
		private $_idLivraison;
		private $_qteMatLivree;
		private $_nbreMatLivree;
		private $_dateLivraison;
		private $_employe;
		private $_fournisseur;
			
		//Constructeur
		public function __construct($id, $qte, $nbre, $date,Employe $employe,Fournisseur $fourn){
			$this->_idLivraison=$id;
			$this->setQteMatLivree($qte);
			$this->setNbreMatLivree($nbre);
			$this->setDateLivraison($date);
			$this->setEmploye($employe);
			$this->setFournisseur($fourn);
		}
		
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
		public function getDateLivraison(){
			return $this->_dateLivraison;			
		}
		public function getEmploye(){
			return $this->_employe;
		}
		public function getFournisseur(){
			return $this->_fournisseur;
		}
		//Mutateurs		
		public function setQteMatLivree($qte){
			$this->_qteMatLivree=$qte;			
		}
		public function setNbreMatLivree($nbreMat){
			$this->_nbreMatLivree=$nbreMat;			
		}
		public function setDateLivraison($date){
			$this->_dateLivraison=$date;			
		}
		public function setEmploye(Employe $emp){
			$this->_employe=$emp;
		}
		public function setFournisseur(Fournisseur $fourn){
			$this->_fournisseur=$fourn;
		}
	}
?>