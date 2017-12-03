var shipExtraExist = false;
var widget;
var numberWidgets = 0;
var runningsubTotal = 0;
var feeCheck = false;
//stores all widget related values for later access.
var inputId = {
    inp1:{name:"37AX-L", price:12.45, id:"id1", unitSubTotal:0, subQuantity:0},
    inp2:{name:"42XR-J", price:15.34, id:"id2", unitSubTotal:0, subQuantity:0},
    inp3:{name:"93ZZ-A", price:28.99 , id:"id3", unitSubTotal:0, subQuantity:0}
};
 //prevents order amounts below 0 and calls the script to update text             
function getAbs(a){
    document.getElementById(a.id).value = Math.abs(document.getElementById(a.id).value);
    //keeping track of subQuantities
    inputId[a.id]["subQuantity"] = document.getElementById(a.id).value;
    numberWidgets = Number(inputId.inp2.subQuantity) +  Number(inputId.inp3.subQuantity) + Number(inputId.inp1.subQuantity)
    writeDescription(a.id);
    runningsubTotal = Number(inputId.inp1.unitSubTotal) + Number(inputId.inp2.unitSubTotal) + Number(inputId.inp3.unitSubTotal);

    subTotal();

}
//Updates the text in the <p> element to accurately represent amount spent on each widget.
function writeDescription(a){
    //running this calculation through ALU ahead of other instructions
    var subPrice = (document.getElementById(a).value * inputId[a]["price"]).toFixed(2)
    var temp = inputId[a]["id"]
    widget = "$" + subPrice
    document.getElementById(temp).innerHTML = widget
    //caching this for use in subTotal
    inputId[a]["unitSubTotal"] = subPrice;

    //checking too see we've generated the extra shipping agreememnt box
    if(extraShipping() && !shipExtraExist){
        writeBox()
    }
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
    document.getElementById("shipAgree").innerHTML = ` I agree to be charged an additional fee for shipping over 30 items <input type="checkbox" title="extraShipping" value="Agree" onClick="feeAgree()">`
    feeAgree()
    feeCheck = false
    shipExtraExist = true
}
function submit(){
    if(Number(inputId.inp1.subQuantity) < 0 || Number(inputId.inp2.subQuantity) < 0 || Number(inputId.inp3.subQuantity) < 0){
        alert("Negative quantity entered for widget, fix this and resubmit");
        return;
    }
    if(extraShipping() && !feeCheck)
    {
        alert("More than 30 items to be shipped, please check box saying you agree to the additional fee.")
        
    }
    else{
        document.getElementById("thisForm").submit();
    }

}
function feeAgree(){
    //race concditions were occuring causing check box to get stuck on the  wrong display
    setTimeout('document.getElementById("shipAgree").disabled=true', 300)
    feeCheck = !feeCheck

    if(feeCheck){
        document.getElementById("buttonLocation").innerHTML = `<button id="button" type="button" onclick=submit() >Submit</button>`
    }
    else if(!feeCheck){
        document.getElementById("buttonLocation").innerHTML = `<button id="button" type="button" >Submit</button>`
    }
    else{
        console.log("dafuq?")
    }
    
}
function subTotal()
{
    document.getElementById("subTotalValue").innerHTML = "$" + runningsubTotal.toFixed(2);
}