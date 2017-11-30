var shipExtraExist = false;
var widget;
var numberWidgets = 0;
var runningTotal = 0;
var feeCheck = false;
//stores all widget related values for later access.
var inputId = {
    inp1:{name:"37AX-L", price:12.45, id:"id1", subTotal:0, subQuantity:0},
    inp2:{name:"42XR-J", price:15.34, id:"id2", subTotal:0, subQuantity:0},
    inp3:{name:"93ZZ-A", price:28.99 , id:"id3", subTotal:0, subQuantity:0}
};
 //prevents order amounts below 0 and calls the script to update text             
function getAbs(a){
    document.getElementById(a.id).value = Math.abs(document.getElementById(a.id).value);
    //keeping track of subQuantities
    inputId[a.id]["subQuantity"] = document.getElementById(a.id).value;
    numberWidgets = Number(inputId.inp2.subQuantity) +  Number(inputId.inp3.subQuantity) + Number(inputId.inp1.subQuantity)
    writeDescription(a.id);
    runningTotal = Number(inputId.inp1.subTotal) + Number(inputId.inp2.subTotal) + Number(inputId.inp3.subTotal);

}
//Updates the text in the <p> element to accurately represent amount spent on each widget.
function writeDescription(a){
    //running this calculation through ALU ahead of other instructions
    var subPrice = (document.getElementById(a).value * inputId[a]["price"]).toFixed(2)
    var temp = inputId[a]["id"]
    widget = "$" + subPrice
    document.getElementById(temp).innerHTML = widget
    //caching this for use in total
    inputId[a]["subTotal"] = subPrice;

    //checking too see we've generated the extra shipping agreememnt box
    if(extraShipping() && !shipExtraExist){writeBox()}
}
function Order(){
    
}
function extraShipping(){
    //have to convert to numbers
    if(numberWidgets >= 30)
    {
        return true;
    }
    return false;
}
function writeBox(){
    document.getElementById("shipAgree").innerHTML = `<input type="checkbox" title="extraShipping" value="Agree"> I agree to be charged an additional fee of 3 schrute bucks for shipping over 30 items <br><br>`

    shipExtraExist = true;
}
function submit(){
    if(Number(inputId.inp1.subQuantity) < 0 || Number(inputId.inp2.subQuantity) < 0 || Number(inputId.inp3.subQuantity) < 0){
        alert("Negative quantity entered for widget, fix this and resubmit");
        return;
    }
    if(extraShipping())
    {
        alert("More than 30 items to be shipped, please check box saying you agree to the additional fee.")
        feeCheck? alert("Order Placed"): alert("Please check box agreeing to additional fee");
    }
    else{
        alert("Order Placed")
    }

}
function feeAgree(){
    //race concditions were occuring causing check box to get stuck on the  wrong display
    setTimeout('document.getElementById("shipAgree").disabled=true', 300)
    feeCheck = !feeCheck;
    console.log(feeCheck)
}
function total()
{
    document.getElementById("totalValue").innerHTML = "$" + runningTotal.toFixed(2);
}