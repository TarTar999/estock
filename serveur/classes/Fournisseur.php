<?php
	class Fournisseur{
		private $_idFournisseur;
		private $_nomFournisseur;
		private $_adresseFourn;
		private $_telFournisseur;
		
		//Constructeurs
		public function __construct($id, $nom, $adresse, $tel){
			$this->_idFournisseur=$id;
			$this->setNomFournisseur($nom);
			$this->setAdresseFournisseur($adresse);
			$this->setTelFournisseur($tel);
		}
		//Accesseurs
		public function getIdFournisseur(){
			return $this->_idFournisseur;
		}
		public function getNomFournisseur(){
			return $this->_nomFournisseur;
		}
		public function getAdresseFourn(){
			return $this->_adresseFourn;
		}
		public function getTelFournisseur(){
			return $this->_telFournisseur;
		}
		
		//Mutateurs		
		public function setNomFournisseur($nom){
			$this->_nomFournisseur=$nom;
		}
		public function setAdresseFourn($adresse){
			$this->_adresseFourn=$adresse;
		}
		public function setTelFournisseur($tel){
			$this->_telFournisseur=$tel;
		}		
	}
?>