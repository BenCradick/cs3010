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

$total = $subTotal*calcDiscount($numItems) + calcShipping($numItems);
$tax = $total*calcTax($state);

//returns number to multiply by if there is a discount
function calcDiscount($numItems){
    return ($numItems>=50 ? 0.95 : 1);
}
//returns tax rate for state as a decimal representation of a percentage
function calcTax($state){
    switch ($state) {
        case 'KS':
            return 0.04375;
        case 'FL':
            return 0.06265;
        default:
            return 0;
    }
}
//returns amount to be charged for shipping
function calcShipping($numItems){
    return ($numItems > 30 ? 8.74 : 15.35);
}
function calcTotal(){

}
function extendTable($numItems, $state, $tax, $subTotal){
    echo "<tr>\n";
    echo "\t<td>";

}
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="proj3.js"></script>
        <link rel="stylesheet" href="proj3.css" type="text/css">   
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
                <?php echo "<td>" . $inp1 . "</td>";?>
                <?php echo "<td>$" . $subPrice1 . "</td>";?>
            </tr>
            <tr>
                <td>42XR-J</td>
                <td>$15.34ea</td>
                <?php echo "<td>" . $inp2 . "</td>";?>
                <?php echo "<td>$" . $subPrice2 . "</td>";?>
            </tr>
            <tr>
                <td>93ZZ-A</td>
                <td>$28.99ea</td>
                <?php echo "<td>" . $inp3 . "</td>";?>
                <?php echo '<td> $' . $subPrice3 . '</td>';?>
            </tr>
            <tr>
                <td>Your SubTotal is:</td>
                <td></td>
                <td></td>
                <?php echo '<td>' . $subTotal . '</td>';?>
            </tr>
        </tbody>
    </table>
    <br>
    <div id="shipAgree"></div>
</html>
    
