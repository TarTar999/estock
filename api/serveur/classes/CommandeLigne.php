<?php
	class CommandeLigne{
		private $_idLigneCmd;
		private $_qteCmd;
		private $_materiel;
		private $_commande;
		
		//Accesseurs
		public function getIdLigneCmd(){
			return $this->_idLigneCmd;
		}
		public function getQteCmd(){
			return $this->_qteCmd;
		}
		public function getMateriel(){
			return $this->_materiel;
		}
		public function getCommande(){
			return $this->_commande;
		}
		
		//Mutateurs		
		public function setQteCmd($qte){
			$this->_qteCmd=$qte;
		}
		public function setMateriel($materiel){
			$this->_materiel=;
		}
		public function setCommande($cmd){
			$this->_commande=$cmd;
		}
	}
?>
