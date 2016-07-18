<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */



   function postman($args)
   {
    var_dump($args['NAME']);
    // e/cho 'hi postman';
    var_dump($_POST);
    var_dump($_GET);
    var_dump($_REQUEST);
   }
	public function index() //insert single level coupon code
	{     
  $this->load->library('mongo_db');
 $db = $this->mongo_db->db;
       //  $this->multiple();
    $res  = $db->selectCollection('ProviderData')->find();
    foreach ($res as $key => $value) {
      var_dump($value);
      # code...
    }
 echo 'sdsfsd';
	}

 function pm1($args)
 {
  echo 'can u do reLLY';
  var_dump($_POST);
    var_dump($_GET);
    var_dump($_SERVER);
    var_dump($args);
 }
 function pm()
 { 
 


 }





	 function delete() //delete single level coupon code
	{
		 $db = $this->mongo_db->db;
		        //delete package
          $delete = array('$pull'=>array('Packages'=>array('RatePlan'=>array('$ne'=>''))));
          $cond = array("_id" => new MongoID("56a7940394b9a4474181e1ad"));
          $cond1= array("_id" => new MongoID("5768ffa0a07b344aedea437c"));
          $db->selectCollection('ProviderDataProto')->update($cond,$delete);
          $db->selectCollection('ProviderDataProto')->update($cond1,$delete);
	}

	
  function multiple() ////insert mulytilevel  coupon code
  {          
  	//$this->delete() ;
     	   $db = $this->mongo_db->db;
 
			$file_handle = fopen("TestPackages-MultipleCpn.csv", "r");
     	  // $file_handle = fopen("TestPackages-SingleCpn.csv", "r");

			$line_of_text =array();

		  while (!feof($file_handle) )
		  {

			$line_of_text[] = fgetcsv($file_handle, 1024);

		}
 	
		fclose($file_handle);

		foreach ($line_of_text as $key => $value) 
		{
               //var_dump(is_array($value));
                    //echo $key;
               if( $value !=false  && $key >0)
               	{
               		 // echo 'array'.'<br />';
					  	$st = $this->find($value[0],$value);


					  if($st == 1)
                         { 
                           
                         	$this->insertmultiple($value[0],$value);
                         }
                   	 else
                   	 	 { 
                   	 	 	$this->insertsingel($value[0],$value);

                   	 	 	
                   	 	 }
                }
               else
               {
						//array is empty
         
               }     
		
   }
}
    public function find($ratepaln ='',$value)
   { 
   	 
   	   if( !empty($ratepaln))
   	   {
            $db = $this->mongo_db->db; 

         	$cond = array("_id" => new MongoID("5768ffa0a07b344aedea437c"),
        	          'Packages.RatePlan'=>$ratepaln
        	          );
                    

        	$data = $db->selectCollection('ProviderDataProto')->find($cond)->count();

               return $data;
   	   }
   	   else
   	   		return 0;
   	
   }


    function insertmultiple($ratepaln,$value)
    { 
    	$db = $this->mongo_db->db;
         echo 'plan exist '.$ratepaln;
       
         //$addToSet inserts record onle 1 time  data is not duplicated
         //$psuh inserts evertime data duplicatec
         $update = array('$addToSet'=>array('NewPackages.$.Coupons'=>array(
            	 	                                                 'CouponID'=>$value[1],
            	 	                                                 'Description'=>$value[2],
            	 	                                                  'Price'=>$value[3]
            	 	                                                       )));

            	  $cond = array("_id" => new MongoID("5768ffa0a07b344aedea437c"),
        	          'Packages.RatePlan'=>$ratepaln
        	          );
  
 
               $res= $db->selectCollection('ProviderDataProto')->update($cond, $update);
               var_dump($res);
                 echo '<br />';
    }

    function insertsingel($ratepaln,$value)
    { 
    	 echo 'plan not exist '.$ratepaln;
            
    	     $db = $this->mongo_db->db;
             
        
                $update = array('$addToSet'=>array('Packages'=>array('RatePlan'=>$value[0],
                	  'Coupons'=>array(array('CouponID'=>$value[1],'Description'=>$value[2],'Price'=>$value[3])))));
               
                  $cond = array("_id" => new MongoID("5768ffa0a07b344aedea437c"));
                  
               if( !empty($value[0]) && !empty($value[1]) && !empty($value[2]) && !empty($value[3]) )
       			$up = $db->selectCollection('ProviderDataProto')->update($cond, $update);
       			var_dump($up);
       			  echo '<br />';

    }

  
    function deletem() // //delete multi level coupon code
	{
		 $db = $this->mongo_db->db;
		        //delete package
          $delete = array('$pull'=>array('Packages'=>array('RatePlan'=>array('$ne'=>''))));
          $cond = array("_id" => new MongoID("5768ffa0a07b344aedea437c"));

          $db->selectCollection('ProviderDataProto')->update($cond,$delete);
         
	}

	function fileupload()
	{
		//$this->load->view
	}
	
	
	function excel()
	{
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$stream = $this->excel->stream('asdasf.xls', array('one' => array(1, 3, 4)));
		 
		
		
	}
}
?>