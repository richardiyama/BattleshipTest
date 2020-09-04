<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
error_reporting(E_ALL);
error_reporting(E_ERROR);
class ShipController extends controller
{
  	//View start page
	public function index(){
		return view('welcome');
	}
    

    //Create BattileShip onscreen grid of cells aligned within a square 10 by 10.
	public static function create()
	{
		
		$map .='';
	    for ($i = A; $i < K; $i++){
	    $map .='<tr>
	            <td  class="index ng-binding">'.$i.'</td>';
	             for ($j = 1; $j < 11; $j++){
	             $map .='<td class="state_0" id="'.$i.''.$j.'"></td>';
	             }
	      $map .='</tr>';
	    }

	    return $map;
	}
	 //Ajax Create BattileShip onscreen grid of cells aligned within a square 10 by 10.
	public static function ajaxCreate()
	{
		
		$map .='';
	    for ($i = A; $i < K; $i++){
	    $map .='<tr>
	            <td  class="index ng-binding">'.$i.'</td>';
	             for ($j = 1; $j < 11; $j++){
	             $map .='<td class="state_0" id="'.$i.''.$j.'"></td>';
	             }
	      $map .='</tr>';
	    }

	   // return $map;
	   return response()->json($map);
	}

	

	//Restart Batttle Ship
	public function restart()
	{
		Session::forget('allBattleShips');
		Session::forget('totalShipsOnBoard');
		Session::forget('alreadyHitShips');
	}
	
	//Game Start
	public function startBattle(Request $request)
	{
		$this->restart();	
		if(Session::has('allBattleShips')){
           
        }else{
        	$this->saveOnScreenGrid($request->allShips);
        }

		 $outPut = array('status' => "OK",
                        'replyResult' => Session::get('allBattleShips'), );
        return response()->json($outPut);
	}

	//Save all Ships in  a session variable
	 public function saveOnScreenGrid($allShips)
	 {

	 	$getShips = trim($allShips, ".");
		$setShips = explode(",", $getShips);
		$totalShips = 0;
        if(Session::has('allBattleShips')){
        	foreach ($setShips as $value) {
				session()->push('allBattleShips', $value);
				$totalShips++;
			}
            
        }else{
            session()->put('allBattleShips', []);
            foreach ($setShips as $value) {
				session()->push('allBattleShips', $value);
				$totalShips++;
			}

        }
        session()->put('totalShipsOnBoard', $totalShips);
        return true;
     }

     //fire This Ship
     public function fire(Request $request)
     {
     	$ship = $request->shipLocation;
     	$allShips = Session::get('allBattleShips');
		$status = ""; $message= ""; $gameOver = "";
		if ($this->checkInput($ship)) {

			if ($this->checkAlreadyHit($ship)) {
				$message = "<div class='message_NO'>you already Hit this location</div>";
				$status = "NO";
				$gameOver = "On Going";
			}else if($this->hit($ship)){
				$this->sink();
				$message = "<div class='message_OK'>Hit!
							 <br>You have ".Session::get('totalShipsOnBoard')." targets for you to hit in order to sink all the ships</div>";
				$status = "OK";
				$gameOver = "On Going";
			}else{
				$message = "<div class='message_NO'>missed!</div>";
				$status = "NO";
				$gameOver = "On Going";
			}
        }
        else{
			$message = "<div class='message_NO'>target is not on the board.</div>";
				$status = "NoTarget";
				$gameOver = "On Going";
		}
		if ($this->checkIfAllShipSink()) {
			$message = "<div class='message_OK'>sink</div>";
				$status = "OK";
				$gameOver = "OK";
		}

		$outPut = array('status' => $status,
						'message' => $message,
						'gameOver' => $gameOver, 
					);
        return response()->json($outPut);
     }

     //Check if ship is hit
     public function hit($ship)
     {
     	 $status = false;
       if(Session::has('allBattleShips')){
            foreach (Session::get('allBattleShips') as $key => $value) {
                if($value === $ship){
                     Session::pull('allBattleShips.'.$key); 
                     $status = true;
                    break;
                 }
             }
          }

          $this->savealreadyHit($ship);

          return $status;
     }

     //Save already hit Ships and already missed hit to a session variable
	 public function savealreadyHit($ship)
	 {
	 	if(Session::has('alreadyHitShips')){
        	session()->push('alreadyHitShips', $ship); 
        }else{
	 	 session()->put('alreadyHitShips', []);
         session()->push('alreadyHitShips', $ship);
     }
        return true;
     }
     //Check if already hit Ships or already missed hit
	 public function checkAlreadyHit($ship)
	 {
	 	 $status = false;
            foreach (Session::get('alreadyHitShips') as $key => $value) {
                if($value === $ship){ 
                     $status = true;
                    break;
                 }
             }

          return $status;
     }
  	//sink hit ship
     public function sink()
     {
     	$totalShips = Session::get('totalShipsOnBoard');
     	$totalShips --;
     	Session::forget('totalShipsOnBoard');
     	session()->put('totalShipsOnBoard', $totalShips);
     }
     //sink all ship is hit
     public function checkIfAllShipSink()
     {
     	$totalShips = Session::get('totalShipsOnBoard');
     	if ($totalShips < 1) {
     		return true;
     	}else{
     		return false;
     	}
     }
     //Check if user input is in the OnScreenGrid
	public static function checkInput($input)
	{
		 $status = false; $check = '';
	    for ($i = A; $i < K; $i++){
	           
	           for ($j = 1; $j < 11; $j++){
	             $check = $i.''.$j;
		    	 if($check === $input){ 
	                    $status = true;
	                    break;
	                }
	            }
	      
	    }

	    return $status;
	}
}
