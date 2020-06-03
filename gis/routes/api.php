<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api\Gis\V1')->prefix('gis/v1')->group(function () {
    //Done
    Route::get('busca', 'BuscaController@getAll');
    Route::get('totais', 'BuscaController@getTotais');
    Route::post('filter', 'BuscaController@filter');
    Route::get('estatisticas', 'BuscaController@estatisticas');
    //To Do
    Route::post('pais', 'BuscaController@pais');
    Route::post('instituicao', 'BuscaController@instituicao');
});

Route::namespace('Api\Ind\V1')->prefix('ind/v1')->group(function () {
    //Done
    Route::get('quantEventos', 'BuscaController@getTrabEvePorAno');
    Route::get('quantCapLivros', 'BuscaController@getquantcapdelivrosporano');
    Route::get('quantArtigos', 'BuscaController@getArtigosPubPorAno');
    Route::get('qualisPorAno', 'BuscaController@getQualisPorAno');
    Route::post('atualizaQualis', 'BuscaController@atualizaQualis');
    Route::get('qualisPorEstrato', 'BuscaController@getQualisPorEstrato');
    Route::post('atualizaQualisPorEstrato', 'BuscaController@atualizaQualisPorEstrato');
    Route::post('getArtigosPubPorAnoCentro/{id}', 'BuscaController@getArtigosPubPorAnoCentro');
    Route::post('getQuantCapLivrosCentro/{id}', 'BuscaController@getQuantCapLivrosCentro');
    Route::post('getQuantEventosCentro/{id}', 'BuscaController@getQuantEventosCentro');
    Route::post('atualizaQualisCentro/', 'BuscaController@atualizaQualisCentro');
    Route::post('qualisPorAnoCentro/{id}', 'BuscaController@qualisPorAnoCentro');

});
