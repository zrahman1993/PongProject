 <?php
	session_start();
	class Product{
		private $user;
		private $country;
		
		
		//creates a new object of type Product
		public function __construct($user, $country){
			$this->user = $user;
			$this->country = $country;
		}
		
		//returns the name of the user
		public function getUser(){
			return $this->user;
		}
		
		//return the country
		public function getCountry(){
			return $this->country;
		}
	}
	
	class Info{
		private $user;
		private $products;
		private $pId; //next available product ID 
	
		public function __construct($user){
			$this->user = $user;
			$this->products = array();
			$this->pId = 1;
		}
		
		public function getUser(){
			return $this->user;
		}
		
		public function addProduct($prod){
			$this->products[$this->pId] = $prod;
			$this->pId ++;			
		}
		
		public function addNewProduct($user, $country){
			$prod =  new Product($user, $country);
			$this->addProduct($prod);		
		}		
		
		public function getProductById($id){
			if(array_key_exists($id, $this->products)){
				return $this->products[$id];
			}else{
				false;
			}
		}
		
		public function removeProduct()
		{
			//$this->products = array_pop();
			array_pop($this->products);
		}
		
		public function updateProduct($id, $value)
		{
			$prod = $this->products[$id];
			$prod->setPrice($value);
		}
		
		public function getProductTable(){
		
			$table = '<table align="center">';
			$table .= '<tr><th>#</th><th>Username</th><th>Country</th></tr>';
			foreach($this->products as $id => $prod){
				$table	.= '<tr><td align="center">' . $id . '</td>'
						. '<td align="center">' . $prod->getUser() .'</td>'
						. '<td align="center">' . $prod->getCountry() .'</td></tr>';
			}
			
			$table .= '</table>';
			return $table;
		
		}
	
	}
	
	//initialize session storage
	if(!isset($_SESSION['info'])){
		$product = new Product('Ziad', 'Canada');	
		
		$info = new Info('User Info');
		$info->addProduct($product);
		$info->addNewProduct('Marlon', 'Canada');
		$_SESSION['info'] = $info;

	//add products to inventory
	}else if(isset($_POST['submit'])){
	
		$submittedProduct = new Product($_POST['user'], $_POST['country']);
		$_SESSION['info']->addProduct($submittedProduct);
	}
	else if(isset($_POST['remove'])){
		$_SESSION['info']->removeProduct();
	}
	
	//$product = $_SESSION['store']->product[1];
	//echo $_SESSION['store']->getProductTable();
 ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            
        </style>
        <script>
        function login()
        {
            //alert("Please log in before playing.");

            if(document.getElementById('uid').value.length==0){
                alert("A user ID is required.");
             }
            else if
                (document.getElementById('country').value.length==0){
                alert("Everybody is born somewhere, enter a country!");
            }
            else
            {
                alert("Login successful");
                window.open("pong.php");
            }
        }
      </script>
    </head>
    <body>
        <h1>Welcome to Pong!</h1>
        <style>
            h1{
            text-align: center;
            }
            
            body{
            background-image: url("http://1.bp.blogspot.com/-qaiwlEU6pfQ/Utj-iSrmFgI/AAAAAAAAGu8/XNUlVLKO_sA/s1600/pin+(2).jpg");
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            }
            
            .wrapper {
            text-align: center;
            }

            .button {
            
            //top: 50%;
            }
            table{
				border: 1px solid black;
				border-collapse: collapse;
			}
			th, td{
				border:1px solid black;
				padding: 4px 10px;
			}
			
			tr:nth-child(even){
				background-color:lightgrey;
			}
			
			label{
				display:inline-block;
				width: 80px;
			}
			
			input[type=text]{
				margin-left: 20px;
			}
			
			textarea{
				margin-left: 100px;
			}
        </style>
       
     <div class="wrapper">
      <h1><?php echo $_SESSION['info']->getUser(); ?> Administration</h1>
		
		<h3>Current Users</h3>
		<?php echo $_SESSION['info']->getProductTable(); ?>
		
                
		<h3>Add User</h3>
		<form method="post">
                    
			<label>Username</label><input type="text" name="user" id="uid"><br>
			<label>Country</label><input type="text" name="country" id="country"><br>
			<br>
			<input type='submit' name='submit' onclick="login()" value="Login">
			<input type='submit' name='remove' value="Remove Recent User">
		
		</form>
        </div>
        
        <?php
           echo '<script language="javascript">';
           echo 'alert("Please enter a username and your country before playing.")';
           echo '</script>';
           
        ?>
    </body>
</html>
