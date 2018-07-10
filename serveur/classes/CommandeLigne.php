<?php
	class CommandeLigne{
		private $_idLigneCmd;
		private $_qteCmd;
		private $_materiel;
		private $_commande;
		
		//Constructeurs
		public function __construct($id, $qte, $commande, $materiel){
			$this->_idEntreeLigne=id;
			$this->setQteCmd($qte);
			$this->setCommande($commande);
			$this->setMateriel($materiel);
		}
		
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
		public function setMateriel(Materiel $materiel){
			$this->_materiel=;
		}
		public function setCommande(Commande $cmd){
			$this->_commande=$cmd;
		}
	}
?>
