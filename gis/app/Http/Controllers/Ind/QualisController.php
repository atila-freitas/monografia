<?php

namespace Gis\Http\Controllers\Ind;
use Gis\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QualisController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function index(){

    $jsonurl = "http://localhost:9000/ind/qualisStatistics";
    $json = file_get_contents($jsonurl);
    $jsonresult = json_decode($json);
    $results = (object) $jsonresult->results;
    $estratos = array();
    foreach ($results as $result){
        array_push($estratos , $result->estrato);
    }

    $estratosCount = $jsonresult->results;
    
    $jsonurl = "http://localhost:9000/ind/articleYear";
    $json = file_get_contents($jsonurl);
    $jsonresult = json_decode($json);
    $anos = $jsonresult->results;
    
    $jsonurl = "http://localhost:9000/ind/publishedArticles/count=true";
    $json = file_get_contents($jsonurl);
    $totalArtigosPublicados = (int) $json;

    $jsonurl = "http://localhost:9000/ind/publishedArticlesWithoutQualis";
    $json = file_get_contents($jsonurl);
    $artigosSemQualis = (int) $json;
    
    return view('ind/qualis', compact(['estratos','anos','estratosCount','totalArtigosPublicados','artigosSemQualis']));

}


}



