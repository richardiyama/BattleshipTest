var allShips = [];
//return element by ID
function el(id) {
  return document.getElementById(id);
}
//Return Random Number
function getRandNumber(bottom, top) {
        return Math.floor( Math.random() * ( 1 + top - bottom ) ) + bottom;
}
//Get Letter to Number
function letterToNumberDataProvider(char){
    const index = JSON.parse('{"A": "1", "B": "2", "C": "3", "D": "4", "E": "5", "F": "6", "G": "7", "H": "8", "I": "9", "J": "10"}');
     return index[char];
}
//Get Number to Letter
function numberToLetterDataProvider(num){
    const index = JSON.parse('{"1": "A", "2": "B", "3": "C", "4": "D", "5": "E", "6": "F", "7": "G", "8": "H", "9": "I", "10": "J"}');
     return index[num];
}
//Load all OnScreenGrid
function loadGrid(){
var CSRF_TOKEN = el("_token").value;
var vars = "_token="+CSRF_TOKEN;
var url = "loadGrid";
var hr = new XMLHttpRequest();
hr.open("GET", url, true);
hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
hr.onreadystatechange = function() {
  if(hr.readyState == 4 && hr.status == 200) {
    var return_data = JSON.parse(hr.responseText);
    el("onScreenGridContent").innerHTML = return_data;
      //Show three battleships
      BattleShips();
      BattleShips();
      BattleShips();
    startgame(allShips);
   }
}
 hr.send(vars); 
 el("onScreenGridContent").innerHTML = "Loading Ships .......";
}


//Create BatteShips
function BattleShips(){
    let MAP_X = getRandNumber(1, 7);
    let MAP_Y = getRandNumber(1, 7);
    let currentIdex = MAP_Y;
    let chekIdex = numberToLetterDataProvider(currentIdex)+MAP_X;
    chekIdex = el(chekIdex).style.backgroundColor;
    if(chekIdex == "blue" || chekIdex == "Blue"){
        BattleShips();
    }else{
        for (let i = 1; i < 5; i++) {

        let indexCell = numberToLetterDataProvider(currentIdex)+MAP_X;
        el(indexCell).style.backgroundColor  = "Blue";
       
        allShips.push(""+indexCell+"");

        let next = letterToNumberDataProvider(numberToLetterDataProvider(currentIdex));
        next ++;
        currentIdex = next;
        
        }
    }
    
}


function startgame(allShips){
var CSRF_TOKEN = el("_token").value;
var vars = "_token="+CSRF_TOKEN+"&allShips="+allShips;
var url = "index";
var hr = new XMLHttpRequest();
hr.open("POST", url, true);
hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
hr.onreadystatechange = function() {
  if(hr.readyState == 4 && hr.status == 200) {
    var return_data = JSON.parse(hr.responseText);
    
   }else{
   
   }
}
 hr.send(vars); 
}





//Change character to upper case letter
function changeToUpperCaseLetter(){
var ship = el("FireShip").value;
el("FireShip").value = ship.toUpperCase();
}
//fire a Ship
function fireShip(){
var ship = el("FireShip").value;
var CSRF_TOKEN = el("_token").value;
var vars = "_token="+CSRF_TOKEN+"&shipLocation="+ship;
var url = "fireShip";
var hr = new XMLHttpRequest();
hr.open("POST", url, true);
hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
hr.onreadystatechange = function() {
  if(hr.readyState == 4 && hr.status == 200) {
    var return_data = JSON.parse(hr.responseText);
    if (return_data.status == "OK") {
        el("replyMessage").innerHTML = return_data.message;
        el(ship).style.backgroundColor  = "SpringBlue";
        el(ship).innerHTML = "X";
    }else{
         el("replyMessage").innerHTML = return_data.message;
         if (return_data.status != "NoTarget") {
         el(ship).style.backgroundColor  = "Grey";
         el(ship).innerHTML = "-";
         }
    }
    if (return_data.gameOver == "OK") {
        el("btn-submit").style.backgroundColor  = "Grey";
        el("btn-submit").disabled = true;
    }
    el("FireShip").value = "";
    console.log(return_data);
   }
}
 hr.send(vars); 
}
//Restart game warning
function warningRestart(){
var con = confirm("Are you sure you want to Restart The Battle Ship?");
if(con != true){
    return false;
}else{
    loadGrid();
}

}
//Check page Refresh
function checkPageRefresh(){
if (window.performance) {
  console.info("window.performance works fine on this browser");
}
  if (performance.navigation.type == 1) {
    console.info( "This page is Refreshed");
    warningRestart();
  } else {
    console.info( "This page is not Refreshed");
  }
}
//Restart Battle Ship
function restart(){
loadGrid();
}
loadGrid();
checkPageRefresh();