<?php 

class Ticket5Model extends Model{
	
	// Phương thức khới tạo
	public function __construct(){
		parent::__construct();
	}
	
	// Phương thức loadsellerproduct
	public function loadSellerproductId($id){
		return $this->loadRecord('sellerproduct', [ 'sellerProductId' => $id]);
	}
	
	// Phương thức load publication
	public function loadPublicationSellerProductId($id){
		return $this->loadRecord('publication', [ 'sellerProductId' => $id]);
	}
	
	// Phương thức load contact
	public function loadContactSellerProductId($id){
		$sql = 'SELECT `contactId`, `contactType`, `contactUseType`, `contact`  FROM `'.$this->setTable('contacts').'` WHERE `sellerProductId`='.$id;
		$this->setQuery($sql);
		return $this->read();		
	}

	// Phương thức load user
	public function loadUser($idx){
		return $this->loadRecord('user', ['idx' => $idx]);		
	}
	
	// Phương thức load userinfo
	public function loadUserinfo($userid){
		return $this->loadRecord('userinfo', ['userid' => $userid]);
	}

    // Phương thức load contacts1
    public function loadContacts1($sellerProductId){
        return $this->loadRecord('contacts1', ['sellerProductId' => $sellerProductId]);
    }
}

?>