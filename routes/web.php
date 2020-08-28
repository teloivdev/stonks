<?php

use Illuminate\Support\Facades\Route;
use voku\helper\HtmlDomParser;
use App\Player;
use App\Team;
use App\Events\PriceHistoryCreated;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    $opts = [
        "http" => [
            "method" => "GET",
            'header'=>"Accept-language: en\r\n" .
            "Accept-Encoding: gzip\r\n" . 
            "User-Agent: GamerStonks/1.0 (http://localhost/; teloivdev@gmail.com)\r\n"
        ]
    ];
    
    $context = stream_context_create($opts);
    // Get the currently authenticated user's ID...
    //return view('welcome');
    /*
    //$res = file_get_contents('https://liquipedia.net/overwatch/api.php?action=parse&format=json&page=Players&prop=text&section=1', false, $context);
    $res = file_get_contents('https://liquipedia.net/overwatch/api.php?action=parse&format=json&page=Portal:Players/North_America&prop=text', false, $context);
    $res = gzdecode($res);
    */
    
/*
    $res = json_decode($res, true);
    $text = $res["parse"]["text"]["*"];
    $text = htmlspecialchars($text);
*/
    
    

    //$response = file_get_contents('https://liquipedia.net/overwatch/api.php?action=parse&page=Portal:Teams/Africa&format=json&prop=text', false, $context);
    //file_put_contents('C:\Users\17707\Documents\Projects\stonks\resources\overwatch\players\playersOCE.json', gzdecode($response));   
    /*
    $response = file_get_contents('../resources/overwatch/teams/teamsOWL.json');
    $response = json_decode($response);
    
    foreach($response->competitors as $item)
    {
        $teamName = trim($item->competitor->name);
        foreach($item->competitor->players as $item)
        {               
            $p = $item->player;
            $player = Player::firstOrCreate(['handle' => $p->name, 'name' => $p->givenName . ' ' . $p->familyName, 'game' => 'overwatch',
            'team' => $teamName, 'role' => $p->attributes->role, 'portrait' => $p->headshot, 'country' => $p->nationality]);
        }
    }
    */
    /*
    foreach($html->find('table') as $element) {
        echo '<br/><hr/><br>';
        if ($element->findOne('th') != null)
            $name = trim($element->findOne('th')->textContent);
            $team = Team::firstOrCreate(['name' => $name]);
            echo $team->id;
            echo $team->name;
    }
    */
    

    /*
    $players = [];
    $response = json_decode(file_get_contents('../resources/overwatch/players/playersSA.json'), true);
    $response = $response["parse"]["text"]["*"];
    

    $html = HtmlDomParser::str_get_html($response);
    
    foreach($html->find('table') as $element) {
        echo '<br/><hr/><br>';
        $country = trim($element->findOne('th')->textContent);
        echo $country;
        foreach ($element->find('tr') as $row)
        {
            if ($row->childNodes->length > 1 && $row->childNodes[1]->tagName != 'th')
            {
                $game = 'overwatch';
                $handle = trim($row->childNodes[1]->textContent);
                $name = trim($row->childNodes[3]->textContent);
                $team = trim($row->childNodes[5]->textContent);
                echo 'Handle: ' . $handle . ' Real Name: ' . $name . ' Team: ' . $team . ' Country: ' . $country;
                $player = Player::firstOrCreate(['handle' => $handle], ['name' => $name, 'team' => $team, 'game' => $game, 'handle' => $handle, 'country' => $country]);
            }
            echo '<br/>';
            //echo $row->childNodes[3]->textContent;
            //echo $row->childNodes[5]->textContent;
     
            
        }
    }
    */
    


        // Overwatch
        /*
        foreach($html->findMulti('table') as $element) {
            echo '<br/><hr/><br>';
            echo $element->findOne('th')->textContent;
            foreach ($element->find('tr') as $row)
            {
                if ($row->firstChild->tagName == 'th')
                    continue;
                echo $row->textContent;
            }
        }
        */
/*
        foreach ($html->find('tr') as $row) 
        {
            if ($row->childNodes[1]->tagName == 'th')
                continue;
            $name = $row->childNodes[3]->textContent;
            $team = $row->childNodes[7]->textContent;
            $game = 'overwatch';
            echo 'Name ' . $row->childNodes[3]->textContent;
            echo 'Team ' . $row->childNodes[7]->textContent;
            $player = Player::firstOrCreate(['name' => $name, 'team' => $team, 'game' => $game]);
            echo $player->game;
            echo '<br/><hr/><br>';
        }
*/
    /*
    $response = str_replace('\n', '', $response->text);
    print_r($response);
    */
    //return view('welcome');

Route::get('/logout', 'Auth\LoginController@logout');


Route::get('/', function () {
    return redirect('overwatch/');
});

Route::get('/player/search', function () {
    return view('player.search');
});

Route::get('/overwatch', function() {
    return view('welcome');
});

Route::get('/overwatch/player/refresh/{id}', 'PlayerController@refresh');

Route::get('/overwatch/owl', 'TeamController@show');
Route::get('/overwatch/player/search/autocomplete', 'PlayerController@fetchAutocomplete')->defaults('game', 'overwatch');
Route::get('/overwatch/team/search/autocomplete', 'TeamController@fetchAutocomplete')->defaults('game', 'overwatch');

Route::get('/overwatch/player/{id}', 'PlayerController@index')->name('playerHome');

Route::get('/overwatch/player/price/graph/lastWeek/{id}', 'PlayerController@fetchLast7Graph');
Route::get('/overwatch/player/price/graph/lastTrades/{id}', 'PlayerController@fetchLastTrades');

Route::post('/overwatch/player/create/buy', 'BuyOrderController@create');
Route::post('/overwatch/player/create/sell', 'SellOrderController@create');
Route::delete('/overwatch/player/destroy/buy/{id}', 'BuyOrderController@destroy');
Route::delete('/overwatch/player/destroy/sell/{id}', 'SellOrderController@destroy');


Route::get('/overwatch/team/{id}', 'TeamController@index');
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/profile', function () {
    return view('auth.verify');
})->middleware('verified');