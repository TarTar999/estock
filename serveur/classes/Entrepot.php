<?php
	class Entrepot{
		private $_idEntrepot;
		private $_nomEntrepot;
		private $_adresseEntrepot;
		private $_capacite;
		
		//Constructeur
		public function __construct($id, $nom, $adresse, $cap){
			$this->_idEntrepot=$id;
			$this->setNomEntrepot($nom);
			$this->setAdresseEntrepot($adresse);
			$this->setCapacite($cap);
		}
		//Accesseurs
		public function getIdEntrepot(){
			return $this->_idEntrepot;		
		}
		public function getNomEntrepot(){
			return $this->_NomEntrepot;		
		}
		public function getAdresseEntrepot(){
			return $this->_AdresseEntrepot;		
		}
		public function getCapacite(){
			return $this->_capacite;		
		}
		
		//Mutateurs		
		public function setNomEntrepot($nom){
			$this->_NomEntrepot=$nom;		
		}
		public function setAdresseEntrepot($adresse){
			$this->_AdresseEntrepot=$adresse;		
		}
		public function setCapacite($capacite){
			$this->_capacite=$capacite;		
		}
	}
?>