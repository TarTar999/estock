<?php
	class Reporting{
		private $_idReporting;
		private $_debutReporting;
		private $_finReporting;
		private $_reportEntite;
		private $_reportMateriel;
		private $_employe;
		
		//Accesseurs
		public function getIdReporting(){
			return $this->_idReporting;		
		}
		public function getDebutReporting(){
			return $this->_debutReporting;		
		}
		public function getFinReporting(){
			return $this->_finReporting;		
		}
		public function getReportEntite(){
			return $this->_reportEntite;		
		}
		public function getReportMateriel(){
			return $this->_reportMateriel;		
		}
		public function getEmploye(){
			return $this->_employe;		
		}		
		
		//Mutateurs
		public function setDebutReporting($dateDebut){
			$this->_debutReporting=$dateDebut;
		}
		public function setFinReporting($dateFin){
			$this->_finReporting=$dateFin;
		}
		public function setDebutReporting($dateDebut){
			$this->_reportEntite=$entite;
		}
		public function setReportMateriel($materiel){
			$this->_reportMateriel=$materiel;
		}
		public function setEmploye($emp){
			$this->_employe=$emp;
		}
	}
?>