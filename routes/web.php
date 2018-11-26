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







Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('confirm/{id}/{token}','Auth\RegisterController@confirm');

Route::group(['middleware'=>'auth'],function (){

Route::get('/', function () {

    return view('home');

});




Route::resource('convocation','ConvocationController');

Route::resource('personnel','PersonnelController');

Route::post('imprimer','ConvocationController@imprimer')->name('convocation.imprimer');

Route::get('next/{jugement}','ConvocationController@next')->name('convocation.next')->where('jugement','(.*)');

Route::post('notification','ConvocationController@notify')->name('convocation.notify');

Route::resource('immobilier','ImmobiliersController');

Route::resource('procureur','ProcureurController');

Route::resource('defendeur','DefendeurController');

Route::resource('autre','AutreController');

Route::resource('avocat','AvocatController');

Route::post('avocat/dataav','AvocatController@dataav')->name('avocat.dataav');

Route::post('jugement','JugementController@saveNB')->name('jugement.saveNb');

Route::get('dossier','DossierController@getDossier')->name('dossier.getDossier');

Route::get('dossier/delete/{id}','DossierController@destroy')->name('dossier.destroy')->where('id','(.*)');

Route::post('dossier/{id}/confirmer','DossierController@confirmer')->name('dossier.confirmer')->where('id','(.*)');

Route::post('dossier/{id}/declaration','DossierController@declaration')->name('dossier.declaration')->where('id','(.*)');

Route::post('dossier/{id}/prolongement','DossierController@prolongement')->name('dossier.prolongement')->where('id','(.*)');

Route::get('dossier/{id}/edit','DossierController@edit')->name('dossier.edit')->where('id','(.*)');

Route::put('dossier/{id}/modif','DossierController@update')->name('dossier.update')->where('id','(.*)');

Route::get('dossier/excel','DossierController@excel')->name('dossier.excel');

Route::get('dossier/search','DossierController@search')->name('dossier.search');

Route::post('dossier/imprimerFeuile','DossierController@imprimerFeuile')->name('dossier.imprimerFeuile');

Route::post('dossier/deposer','DossierController@deposer')->name('dossier.deposer');

Route::get('deposerDossier','DossierController@deposerDossier')->name('dossier.deposerDossier');

Route::get('deposerDossier/searchDeposer','DossierController@searchDeposer')->name('dossier.searchDeposer');

Route::get('deposerDossier/excelDeposer','DossierController@excelDeposer')->name('dossier.excelDeposer');

Route::get('dossier/ticket','DossierController@ticket')->name('dossier.ticket');

Route::get('dossier/sticky','DossierController@sticky')->name('dossier.sticky');

Route::get('dossier/report','DossierController@printPPT')->name('dossier.report');

Route::get('gImmobilier/gestion_images','ImmobiliersController@gImages')->name('immobiliers.g_image');

Route::post('gImmobilier/images_add','ImmobiliersController@add_images')->name('immobiliers.imagesAdd');

Route::get('gImmobilier','ImmobiliersController@gImmobilier')->name('immobiliers.gImmobilier');

Route::post('gImmobilier/valider','ImmobiliersController@validerPr')->name('immobiliers.valider_pourcentage');

Route::get('gImmobilier/{id}/pourcentagePropriete','ImmobiliersController@pourcentagePropriete')->name('immobiliers.pourcentagePropriete')->where('id','(.*)');

Route::get('gImmobilier/delete','ProcureurController@delete')->name('procureur.delete');
 
Route::get('procureur/administration/{id}', 'ProcureurController@administration')->name('procureur.administration')->where('id', '(.*)');

Route::get('defendeur/administration/{id}', 'DefendeurController@administration')->name('defendeur.administration')->where('id', '(.*)');

Route::get('defendeur/{id}/edit/{d}', 'DefendeurController@edit')->name('defendeur.edit')->where('id', '(.*)')->where('d', '(.*)');;

Route::get('procureur/{id}/edit/{d}', 'ProcureurController@edit')->name('procureur.edit')->where('id', '(.*)')->where('d', '(.*)');;

Route::get('gImmobilier/ajout_pourcentage_pr','ProcureurController@addpourcentage')->name('procureur.addpourcentage');

Route::get('gImmobilier/ajout_pourcentage_de','DefendeurController@addpourcentage')->name('defendeur.addpourcentage');

Route::get('gImmobilier/ajout_p','ProcureurController@add_procureur')->name('procureur.addp');

Route::get('gImmobilier/def/delete','DefendeurController@delete')->name('defendeur.delete');

Route::get('gImmobilier/arr/delete','ProcureurController@deleteArr')->name('arrivant.delete');

Route::get('gImmobilier/modif','ProcureurController@modifier')->name('procureur.modifier');

Route::get('gImmobilier/def/modif','DefendeurController@modifier')->name('defendeur.modifier');

Route::get('gImmobilier/def/arr','ProcureurController@modifier')->name('procureur.modifierArr');

Route::get('decision_jugement','DossierController@decision')->name('dossier.decision');

Route::post('decision_jugement/add','DossierController@decisionAdd')->name('dossier.decisionAdd');

Route::get('statistic','DossierController@getStatistic')->name('dossier.statistic');

Route::get('statistic/chart','DossierController@chart_date')->name('dossier.chart');

Route::post('procureur/create_procureur', 'ProcureurController@create_procureur')->name('procureur.create_procureur');

Route::get('procureur/create/{id}', 'ProcureurController@create')->name('procureur.create')->where('id', '(.*)');

Route::post('defendeur/create_defendeur', 'DefendeurController@create_defendeur')->name('defendeur.create_defendeur');

Route::get('defendeur/create/{id}', 'DefendeurController@create')->name('defendeur.create')->where('id', '(.*)');

Route::get('autre/administration/{id}', 'AutreController@administration')->name('autre.administration')->where('id', '(.*)');

Route::get('autre/{id}/edit/{d}', 'AutreController@edit')->name('autre.edit')->where('id', '(.*)')->where('d', '(.*)');;

Route::post('autre/create_autre', 'AutreController@create_autre')->name('autre.create_autre');

Route::get('autre/create/{id}', 'AutreController@create')->name('autre.create')->where('id', '(.*)');

Route::get('dossier/cms', 'DossierController@cms')->name('dossier.cms');
 
Route::get('dossier/edit_report/{id}', 'DossierController@manage_report')->name('dossier.manage_report')->where('id', '(.*)');

Route::post('dossier/add_content_report/{id}', 'DossierController@addContent')->name('dossier.add_content_report')->where('id', '(.*)');

Route::get('procureur/delete_pr/{id}', 'ProcureurController@destroy_pr')->name('procureur.destroy_pr')->where('id', '(.*)');

Route::get('defendeur/delete_def/{id}', 'DefendeurController@destroy_def')->name('procureur.destroy_def')->where('id', '(.*)');

Route::get('autre/delete_a/{id}', 'AutreController@destroy_a')->name('autre.destroy_a')->where('id', '(.*)');
 Route::get('dossier/img_immo/{id}', 'DossierController@addImg_immo')->name('dossier.addImg_immo')->where('id', '(.*)');
 
 Route::post('dossier/img_immo_add/{id}', 'DossierController@addImg_immo_add')->name('dossier.addImg_immo_add')->where('id', '(.*)');

Route::get('dossier/cms_next/{id}', 'DossierController@cms_next')->name('dossier.cms_next')->where('id', '(.*)');;

});

