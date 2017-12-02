<?php
// Grab vars
$inp1 = $_POST['37AX-L'];
$inp2 = $_POST['42XR-j'];
$inp3 = $_POST['93ZZ-A'];
$state = $_POST['State'];

//prices correspond to part above respectively.
$price1 = '12.45';
$price2 = '15.34';
$price3 = '28.99';

//calculate hte number of items
$numItems = $inp1 + $inp2 + $inp3;

$subPrice1 = $price1 * $inp1;
$subPrice2 = $price2 * $inp2;
$subPrice3 = $price3 * $inp3;

//All the sub prices added up
$subTotal = $subPrice1 + $subPrice2 + $subPrice3;

$total = ($subTotal + calcShipping($numItems))*calcDiscount($numItems);
$tax = calcTax($state, $subTotal, $numItems);

//returns number to multiply by if there is a discount
function calcDiscount($numItems){
    return ($numItems>50 ? 0.95 : 1);
}
//returns tax rate for state as a decimal representation of a percentage
function calcTax($state, $subTotal, $numItems){
    switch ($state) {
        case 'KS':
            return 0.04375*($subTotal + calcShipping($numItems));
        case 'FL':
            return 0.06265*$subTotal;
        default:
            return 0;
    }
}
function getTaxRate($state){
    switch($state){
        case 'KS':
            return '+ 4.375%';
        case 'FL':
            return '+ 6.265%';
        default:
            return '+ 0.000%';
    }
}
//returns amount to be charged for shipping
function calcShipping($numItems){
    return ($numItems < 30 ? 8.74 : 15.35);
}
function calcTotal($numItems, $tax, $subTotal){
    return calcShipping($numItems) + $subTotal + $tax;
}
function printTax($state, $tax, $numItems){
        echo '<tr><td> Taxes Due</td>';
        echo '<td>State: ' . abbrevToName($state) . '</td>';
        echo '<td>' . getTaxRate($state) . '</td>';
        echo '<td>' . $tax*calcDiscount($numItems) . '</td></tr>';
}
function printShipping($numItems){
    echo '<tr><td>Shipping cost:</td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td>$' . calcShipping($numItems) . '</td></tr>';
}
function extendTable($numItems, $state, $tax, $subTotal){
    if(calcDiscount($numItems) == 0.95){
        echo '<tr><td>Discount:</td>';
        echo '<td></td>';
        echo '<td>-5%</td>';
        echo '<td>' . (calcTotal($numItems, $tax, $subTotal))*0.05 . '</td></tr>';    
    }
    if($state == 'KS'){
        printShipping($numItems);
        printTax($state, $tax, $numItems);

    }
    else{
        printTax($state, $tax, $numItems);
        printShipping($numItems);
    }
    


}
function abbrevToName($state){
    $fullName = array(
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
);
    return $fullName[$state];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="proj3.js"></script>
        <link rel="stylesheet" href="proj3.css">
    </head>
    <table class="table-minimal">
        <thead>
            <tr>
                <th>Unit</th>
                <th>Unit Cost</th>
                <th>Quantity</th>
                <th>Unit Subtotal</th>
            </tr>  
        </thead>
        <tbody>
            <tr>
                <td>37AX-L</td>
                <td>$12.45ea</td>
                <?php echo '<td>' . $inp1 . '</td>';?>
                <?php echo '<td>$' . $subPrice1 . '</td>';?>
            </tr>
            <tr>
                <td>42XR-J</td>
                <td>$15.34ea</td>
                <?php echo '<td>' . $inp2 . '</td>';?>
                <?php echo '<td>$' . $subPrice2 . '</td>';?>
            </tr>
            <tr>
                <td>93ZZ-A</td>
                <td>$28.99ea</td>
                <?php echo '<td>' . $inp3 . '</td>';?>
                <?php echo '<td> $' . $subPrice3 . '</td>';?>
            </tr>
            <tr>
                <td>Your SubTotal is:</td>
                <td></td>
                <?php echo '<td>' . $numItems . '</td>';?>
                <?php echo '<td>' . $subTotal . '</td>';?>
            </tr>
            <?php extendTable($numItems, $state, $tax, $subTotal); ?>
        </tbody>
    </table>
    <br>
    <div id="shipAgree"></div>
</html>
    
