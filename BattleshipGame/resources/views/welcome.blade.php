<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Battle Ship</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <style type="text/css">
.inputcontrol {
    float: left;
    display: block;
    width: 50%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: black;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 1px;
    font-size: 27px;
}
.btn-submit{
    float: left;
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
    width: 30%;
    height: 48px;
    font-size: 27px;
}
.btn-submit:hover{
    cursor: pointer;
}
.btn-restart{
    float: right;
    color: #000;
    background-color: grey;
}
.action-div{
    width: 94%;
    float: left;
    height: auto;
    padding: 10px;
    background-color: rgb(83, 175, 19);
}
.message_OK {
  width: 94%;
  float: left;
  border-radius: 3px;
  padding: 10px;
  margin: 10px 0;
  background-color: #66ff33;
  text-align: center;
}
.message_NO {
  width: 94%;
  float: left;
  border-radius: 3px;
  padding: 10px;
  margin: 10px 0;
  background-color: #ffc2c2;
  text-align: center;
}
</style>

    </head>
    <body>
    
 <div  id="container">
    <h1 class="title_text">Battle Ship Game</h1>
        <table cellpadding="5" cellspacing="5" border="0" id="gameTable">
            <thead>
                <tr><td>&nbsp;</td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
            </tr>
        </thead>
        <tbody id="onScreenGridContent">
 

    </tbody>
</table>
 <div class="action-div">
   <input type="text" placeholder="A0" id="FireShip" onkeyup="changeToUpperCaseLetter();" class="inputcontrol">
  <input type="button" value="Fire!" onclick="fireShip();" class="btn-submit" id="btn-submit">
 </div>
 <div id="replyMessage"></div>
  <input type="button" value="Restart" onclick="restart();" class="btn-restart">
<input type="hidden" id="_token" value="{{ csrf_token() }}">

<script type="text/javascript" src="js/battleShip.js"></script>

</div>
    </body>
</html>















