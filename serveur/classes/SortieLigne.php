<?php
	class SortieLigne{
		private $_idSortieLigne;
		private $_qteSortie;
		private $_sortie;
		private $_materiel;
		private $_entite;
		private $_etat;
		
		//Constructeurs
		public function __construct()
		{
		    $ctp = func_num_args();
		    $args = func_get_args();		    
		    switch($ctp)
		    {
		        case 6:
		            $this->_constructWithAll($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);		            
		            break;
		        case 1:
		            $this->_constructById($args[0]);
		            break;		        
		    }
		}		
		
		//Accesseurs
		public function getIdSortieLigne(){
			return $this->_idSortieLigne;		
		}
		public function getQteSortie(){
			return $this->_qteSortie;
		}
		public function getSortie(){
			return $this->_sortie;			
		}
		public function getMateriel(){
			return $this->_materiel;
		}
		public function getEntite(){
			return $this->_entite;
		}
		public function getEtat(){
			return $this->_etat;
		}
		
		//Mutateurs
		public function setQteSortie($qte){
			$this->_qteSortie=$qte;
		}
		public function setSortie($sortie){
			$this->_sortie=$sortie;
		}
		public function setMateriel($materiel){
			$this->_materiel=$materiel;
		}
		public function setEntite(Entite $entite){
			$this->_entite=$entite;
		}
		public function setEtat(Etat $etat){
			$this->_etat=$etat;
		}
		public function _constructWithAll($id, $qte, Sortie $sortie, $materiel,Entite $entite, Etat $etat){
			$this->_idSortieLigne=$id;
			$this->setQteSortie($qte);
			$this->setSortie($sortie);
			$this->setMateriel($materiel);
			$this->setEntite($entite);
			$this->setEtat($etat);
		}
		public function _constructById($id){
			$this->_idSortieLigne=$id;			
		}
	}
?>