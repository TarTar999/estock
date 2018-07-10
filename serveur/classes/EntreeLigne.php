<?php
	class EntreeLigne{
		private $_idEntreeLigne;
		private $_qteEntree;
		private $_entree;
		private $_materiel;
		private $_etat;

		
		//Constructeurs
		public function __construct()
		{
		    $ctp = func_num_args();
		    $args = func_get_args();
		    switch($ctp)
		    {
		        case 5:
		            $this->_constructWithAll($args[0],$args[1],$args[2],$args[3],$args[4]);
		            break;
		        case 1:
		            $this->_constructById($args[0]);
		            break;		        
		    }
		}
		
		//Accesseurs
		public function getIdEntreeLigne(){
			return $this->_idEntreeLigne;		
		}
		public function getQteEntree(){
			return $this->_qteEntree;
		}
		public function getEntree(){
			return $this->_entree;
		}
		public function getMateriel(){
			return $this->_materiel;
		}
		public function getEtat(){
			return $this->_etat;
		}

		//Mutateurs
		public function setQteEntree($qte){
			$this->_qteEntree=$qte;
		}
		public function setEntree(Entree $entree){
			$this->_entree=$entree;
		}
		public function setMateriel(Materiel $materiel){
			$this->_materiel=$materiel;
		}
		public function setEtat(Etat $etat){
			$this->_etat=$etat;
		}

		public function _constructWithAll($id, $qte,Entree $entree, Materiel $materiel,Etat $etat){
			$this->_idEntreeLigne=$id;
			$this->setQteEntree($qte);
			$this->setEntree($entree);
			$this->setMateriel($materiel);
			$this->setEtat($etat);
		}
		public function _constructById($id){
			$this->_idEntreeLigne=$id;			
		}
	}
?>