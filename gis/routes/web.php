<?php

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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/ind', 'HomeController@indica');

// Conversor
Route::get('init', ['as' => 'conversor.init', 'uses' => 'ConversorController@init']);
Route::get('conversor', ['as' => 'conversor.index', 'uses' => 'ConversorController@index']);
Route::post('conversor/upload', ['as' => 'conversor.upload', 'uses' => 'ConversorController@upload']);
Route::get('conversor/todos', 'ConversorController@converterTodos');
Route::get('conversor/todoscomcurso', 'ConversorController@converterTodosComCurso');
Route::get('conversor/areacursos/converter', 'ConversorController@converterAreaCurso');
Route::get('conversor/qualis/converter', 'ConversorController@converterQualis');
Route::get('conversor/teste', ['as' => 'conversor.teste', 'uses' => 'ConversorController@teste']);

// GIS UECE
Route::namespace('Gis')->prefix('gis')->name('gis.')->group(function () {
    //Done
    Route::get('titulacoes', ['as' => 'titulacoes', 'uses' => 'TitulacoesController@index']);
    Route::get('titulacoes/instituicao/{instituicao}', ['as' => 'titulacoes.instituicao', 'uses' => 'TitulacoesController@instituicao']);
    Route::get('titulacoes/estatisticas', ['as' => 'titulacoes.estatisticas', 'uses' => 'TitulacoesController@estatisticas']);
    Route::get('titulacoes/pais/{sigla}', ['as' => 'titulacoes.pais', 'uses' => 'TitulacoesController@pais']); 
});

// Indica UECE
Route::namespace('Ind')->prefix('ind')->name('ind.')->group(function () {
    //Done
    Route::get('centers', 'CentersController@index')->name('centers');
    Route::get('centerDetais/{id}', 'CentersController@centerDetails')->name('centerDetails');
    Route::get('professors', 'ProfessorsController@index')->name('professors');
    Route::get('professorDetails/{id}', 'ProfessorsController@professorDetails')->name('professorDetails');
    Route::get('compararProfessores/{nome1}/{nome2}', 'ProfessorsController@compararProfessores')->name('compararProfessores');
    Route::get('general', 'GeneralController@index')->name('general');
    Route::get('destaques', 'GeneralController@destaques')->name('destaques');
    Route::get('comparar', 'GeneralController@comparar')->name('comparar');
    Route::get('compararCentros/{centro1}/{centro2}', 'GeneralController@compararCentros')->name('compararCentos');
    Route::get('qualis', 'QualisController@index')->name('qualis');
    Route::get('indica', 'HomeController@indica')->name('indica');
    
    

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
