<?php
/**
 * item-demo2.php, based on demo_postback_nohtml.php is a single page web application that allows us to request and view 
 * a customer's name
 *
 * web applications.
 *
 * Any number of additional steps or processes can be added by adding keywords to the switch 
 * statement and identifying a hidden form field in the previous step's form:
 *
 *<code>
 * <input type="hidden" name="act" value="next" />
 *</code>
 * 
 * The above live of code shows the parameter "act" being loaded with the value "next" which would be the 
 * unique identifier for the next step of a multi-step process
 *
 * @package ITC281
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 1.1 2011/10/11
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo finish instruction sheet
 * @todo add more complicated checkbox & radio button examples
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
include 'items.php'; 
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

//END CONFIG AREA ----------------------------------------------------------

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}
switch ($myAction) 
{//check 'act' for type of process
	case "display": # 2)Display user's name!
	 
        showData();
    
	 	break;
	default: # 1)Ask user to enter their name 
	 	showForm();
}

function showForm()
{# shows form so user can enter their name.  Initial scenario
	global $config;
    get_header(); #defaults to header_inc.php	
	
	echo 
	'<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	 <script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.YourName,"Please Enter Your Name")){return false;}
            return true;//if all is passed, submit!
           
		}
	</script>
    <h3 align="center">' . smartTitle() . '</h3>
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
    <p align="center">Please enter your name<br></p>
    
    <p align="center"><b>Your Name:  </b><input type="text" name="isYourName" /><em>(<font color="red"><b>*</b> required field</font>)</p>
    ';
       
        echo '<table height=300px width =70% align="center"> <tr>
                <th width ="20%"><h3>Product</h3></th> 
                <th width ="20%"><h3>Price</h3></th> 
                <th><h3>Order Quantity</h3></th>
                <th><h3>Topping</h3></th>
                </tr>
                ';
		foreach($config->items as $item)
          {
            echo '<tr> <td align = "center">' . $item->Name . '</td>
            <td>' . $item->Price . '</td>
            <td><input type="text" size = "5" maxlenght = "5" name="item_' . $item->Name . '"/></td>
            <td><table>';
            $i=0;
            foreach($item->Extras as $extra)
            {echo '<tr><td><input type="checkbox" name ="toppings[]" value="' . $item->ID . $item->Extras[$i] . '" />' . $item->Extras[$i] . '</td></tr> ';
             $i++;
            }
            echo '</table><hr></td>
            </tr>';
            
             
        //      echo '<p>' . $item->Name . ' <input type="text" name="item_' . $item->ID . '" /></p>';
              
          }   
        echo '<td align = "center"><em><input type="submit" value="Purchase"></em></td>';
        echo '         
                </table>';
    
    
        echo    '<p align="center">
				<font color = "red">Each kind of added Topping will be up charged $0.25.</font>	
				</p>
		<input type="hidden" name="act" value="display" />
	</form>
	';
   
	get_footer(); #defaults to footer_inc.php
}


function showData()
{#form submits here we show entered name
	 
     get_header(); #defaults to header_inc.php
    echo '<h3 align="center">' . smartTitle() . '</h3>';//title of the page
    global $config;
    //dumpDie($_POST);
    
   
    
    $yourName = $_POST["isYourName"];
    echo '<p>Dear ' . $yourName . '</p>';
    echo '<p>You have ordered: </p>';    
    
    
   
    
    //table for showdata
    
    echo '<table align = "center"> <tr>
                <th width ="10%">Quatity</th> 
                <th width ="10%">Price</th>
                <th width ="10%">Product</th> 
                <th width ="20%">Topping</th>
                <th width = 10%">Subtotal</th>
                </tr>
                ';
    
    
    
    
    
    
    
    
    
    
    $i=0;
    $mainProduct = 0.00; 
	foreach($_POST as $name => $value)
    {
         
        //loop the form elements
        if(empty($value)){
            $value=0;
        }
        //if form name attribute starts with 'item_', process it
        if(substr($name,0,5)=='item_')
        {
            //explode the string into an array on the "_"
            $name_array = explode('_',$name);
            
            //id is the second element of the array
			//forcibly cast to an int in the process
           // $id = (int)$name_array[$i];
            
			/*
				Here is where you'll do most of your work
				Use $id to loop your array of items and return 
				item data such as price.
				
				Consider creating a function to return a specific item 
				from your items array, for example:
				
				$thisItem = getItem($id);
				
				Use $value to determine the number of items ordered 
				and create subtotals, etc.
			
			*/
           $mainProduct = $mainProduct + (int)$value * (float)$config->items[$i]->Price;
            
            //check order value, print only value>0         
            checkandPrint($value, $i);
          
            $i++;
     
        }

    }//end of foreach post->name
        $total = $mainProduct + totalTopping($i);
     echo '</table>';
    //print total
	 echo 'Your Total is : $' . round($total,2) . '<br>';
	//print tax
    $tax = $total * 0.10;
     echo 'Tax: $' . round($tax,2) . '<br>';
	//print net total
    $netTotal = $tax + $total;
     echo 'Net Total is : <font color="red">$' . round($netTotal,2) .'</font>';
    
	echo '<p align="center"><a href="' . THIS_PAGE . '">RESET</a></p>';
	get_footer(); #defaults to footer_inc.php
}

function nameError()
{#form submits here we show entered name
	
   //dumpDie($_POST);
    get_header(); #defaults to footer_inc.php
	
	echo '<h3 align="center">' . smartTitle() . '</h3>';
   
    echo '<h3 align="center"><font color="red">Your Name Must be entered. Please Reset Your Orders, and Enter Your Name!</font></h3>';
   
	

	echo '<p align="center"><a href="' . THIS_PAGE . '">RESET</a></p>';
	get_footer(); #defaults to footer_inc.php
}//end show data




function checkandPrint($quantity, $counter){
     global $config;
        if($quantity>0)
            {
                if($quantity!=1){
                    echo '<tr><td><font color ="red"><p align="left">' . $config->items[$counter]->Name . 's</p></font></td><td><font color ="red"><p align="left">$' . $config->items[$counter]->Price . '</p></font></td><td><font color ="red"><p align="left">' . $quantity. '</p></font></td>
                    <td>';
                    getTopping($counter); 
                    echo '</td>
                    <td algin="right"><p>';
                    subTotal($counter, $quantity);
                    echo '</p></td>
                    </tr>';}
                else{
                    echo '<tr><td><font color ="red"><p align="left">' . $config->items[$counter]->Name . '</p></font></td><td><font color ="red"><p align="left">$' . $config->items[$counter]->Price . '</p></font></td><td><font color ="red"><p align="left">' . $quantity. '</p></font></td>
                    <td>';
                    getTopping($counter); 
                    echo '</td>
                    <td algin="right"><p>';
                    subTotal($counter, $quantity);
                    echo '</p></td>
                    </tr>';
                }
            
        }
    
}//end checkandPrint

function getTopping($i)
{   $toppings = $_POST["toppings"];
    
    foreach($toppings as $topping)
        {   
            $topid = (int)substr($topping,0,1);
            $topName = substr($topping,1);
              if(($topid-1)==$i){echo '<font size="2"> ' . $topName . ' | </font>';}
            
        }//end loop the topping
}//end function getTopping

function subTotal($i, $quantity)
{   global $config; 
    $toppings = $_POST["toppings"];
    $ct=0;//counter of  topping
    foreach($toppings as $topping)
        {   
            $topid = (int)substr($topping,0,1);
             if(($topid-1)==$i)
             {   
                 $ct++;}
             
        }//end loop the topping
       $subtotal=0.25*$ct + $config->items[$i]->Price * $quantity;
       echo 'Added <font color ="red">' . $ct . ' </font>toppings<br>';
       echo "subtotal: $" . round($subtotal,2);
        
}//end subTotal

function totalTopping($i){
    global $config; 
    $toppings = $_POST["toppings"];
    $ct=0;//counter of  topping
    foreach($toppings as $topping)
        {   
            $topid = (int)substr($topping,0,1);
            
             {   
                 $ct++;}
             
        }//end loop the topping
       $toppingFree = 0.25*$ct;
        return $toppingFree;

    
    
}//end function finalBill

?>


















