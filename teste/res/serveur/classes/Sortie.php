<?php
	class Commande{
		private $_idSortie;
		private $_nbreMatSortie;
		private $_qteMatSortie;
		private $_dateSortie;
		private $_employe;
		private $_entite;
		private $_entrepot;
		
		//Constructeurs
		public function __construct($id, $nbmat, $qte, $date,Employe $employe,Entite $entite,Entrepot $entrepot){
			$this->_idSortie=$id;
			$this->setNbreMatSortie($nbmat);
			$this->setQteMatSortie($qte);
			$this->setDateSortie($date);
			$this->setEmploye($employe);
			$this->setEntite($entite);
			$this->setEntrepot($entrepot);
		}
		//Accesseurs
		public function getIdSortie(){
			return $this->_idEntree;
		}
		public function getNbreMatSortie(){
			return $this->_nbreMatEntree;
		}
		public function getQteMatSortie(){
			return $this->_qteMatEntree;
		}
		public function getDateSortie(){
			return $this->_dateSortie;
		}		
		public function getEmploye(){
			return $this->_employe;
		}
		public function getEntite(){
			return $this->_entite;
		}
		public function getEntrepot(){
			return $this->_entrepot;
		}
		
		//Mutateurs		
		public function setNbreMatSortie($nbre){
			$this->_nbreMatSortie=$nbre;
		}
		public function setQteMatSortie($qte){
			$this->_qteMatSortie=$qte;
		}
		public function setDateSortie($date){
			$this->_dateSortie=$date;
		}
		public function setEmploye($employe){
			$this->_employe=$employe;
		}
		public function setEntite(Entite $entite){
			$this->_entite=$entite;
		}public function setEntrepot(Entrepot $entrepot){
			$this->_entrepot=$entrepot;
		}
	}
?>