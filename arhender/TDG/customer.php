<?php 
require "database.php"; 

class Customer { 

    private $id; 
    private $name; 
    private $email; 
    private $mobile; 
    
	
    public function insertRecord () { 
     
        $this->name = $_POST['name'];
        $this->email = $_POST['email'];
        $this->mobile = $_POST['mobile']; 
     
        $pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($this->name,$this->email,$this->mobile)); 
        Database::disconnect(); 
     
    }


	public function setid($id){
		
		$this->id=$id;
		
	}

	public function getid(){
		
		return $this->id;	
	}
	
	
	public function getname(){
		
		return $this->name;	
	}
	
	public function getemail(){
		
		return $this->email;	
	}
     
	 public function getphone(){
		
		return $this->mobile;	
	}
    

	 public function displayRecords() { 
     
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM customers ORDER BY id DESC'; 
        echo '<table class="table table-striped table-bordered"> 
                <thead> 
                <tr> 
                  <th>Name</th> 
                  <th>Email Address</th> 
                  <th>Mobile Number</th> 
                  <th>Action</th> 
                </tr> 
              </thead> 
              <tbody>'; 
         
        foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=250>'; 
            echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>'; 
            echo '&nbsp;'; 
            echo '<a class= "btn btn-success" href="update.php?id='.$row['id'].'">Update</a>'; 
            echo '&nbsp;'; 
            echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>'; 
            echo '</td>'; 
            echo '</tr>'; 
        } 
        echo '</tbody></table>'; 
        Database::disconnect(); 
    } 
     


  function deleteRecord($id) { 
     
       
        $pdo = Database::connect(); 
        $sql = "DELETE FROM customers WHERE id = ?"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($this->id)); 
        Database::disconnect(); 
         
    } 
     
    
    
    function __construct ($name=null,$email=null,$mobile=null) { 
		
		$this->id=0;
		$this->name = $name;
		$this->email = $email;
		$this->mobile = $mobile;
        
    
    } 
     
	 
} 


?>