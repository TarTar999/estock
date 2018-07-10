<?php
	class EntreeLigne{
		private $_idLigneRep;
		private $_stockDepart;
		private $_approvision;
		private $_sem1;
		private $_sem2;
		private $_sem3;
		private $_sem4;
		
		//Accesseurs
		public function getIdLigneRep(){
			return $this->_idLigneRep;		
		}
		public function getStockDepart(){
			return $this->_stockDepart;		
		}
		public function getApprovision(){
			return $this->_approvision;		
		}
		public function get()Sem1{
			return $this->_sem1;		
		}
		public function get()Sem2{
			return $this->_sem2;		
		}
		public function get()Sem3{
			return $this->_sem3;		
		}
		public function get()Sem4{
			return $this->_sem4;		
		}
		
		
		//Mutateurs
		public function setStockDepart($init){
			$this->_stockDepart=$init;
		}
		public function setApprovision($ajout){
			$this->_approvision=$ajout;
		}
		public function setSem1($s1){
			$this->_sem1=$s1;
		}
		public function setSem1($s2){
			$this->_sem1=$s2;
		}
		public function setSem1($s3){
			$this->_sem1=$s3;
		}
		public function setSem1($s4){
			$this->_sem1=$s4;
		}
	}
?>