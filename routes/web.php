<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seguridad\Autenticacion;
use App\Http\Controllers\Catalogo\Moneda;
use App\Http\Controllers\Negocio\Empresas;
use App\Http\Controllers\Seguridad\AuditoriaController;
use App\Http\Controllers\Procesos\Contrato;
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

Route::post('/prevision.autenticacion.valida-credenciales',[Autenticacion::class, 'fnValidarCredenciales']);
Route::get('/prevision.inicio',[Autenticacion::class, 'fnIndice']);
Route::post('/prevision.general.querys',[AuditoriaController::class, 'fnBusquedaGeneral']);
Route::middleware(['autorizacion.defecto'])->group(function () {
    Route::get('/prevision.principal',[Autenticacion::class, 'fnVistaPrincipal']);
    
    Route::get('/prevision.catalogo.moneda',[Moneda::class, 'fnIndice']);
    Route::get('/prevision.catalogo.moneda.update/{clavePrincipal}',[Moneda::class, 'fnUpdateIndice']);
    Route::post('/prevision.catalogo.moneda.update.validar',[Moneda::class, 'fnValidarUpdate']);
    Route::get('/prevision.catalogo.moneda.create',[Moneda::class, 'fnCreateIndice']);
    Route::post('/prevision.catalogo.moneda.create.validar',[Moneda::class, 'fnValidarCreate']);

    Route::get('/prevision.negocio.empresas',[Empresas::class, 'fnCreateIndice']);
    Route::get('/prevision.negocio.empresas.update/{clavePrincipal}',[Empresas::class, 'fnUpdateIndice']);
    Route::post('/prevision.negocio.empresas.update.validar',[Empresas::class, 'fnValidarUpdate']);
    Route::get('/prevision.negocio.empresas.create',[Empresas::class, 'fnCreateIndice']);
    Route::post('/prevision.negocio.empresas.create.validar',[Empresas::class, 'fnValidarCreate']);

    Route::get('/prevision.negocio.empresas.domicilio.create/{codigoPersona}',[Empresas::class, 'fnCreateDomicilioIndice']);
    Route::post('/prevision.negocio.empresas.domicilio.create.validar',[Empresas::class, 'fnValidarDomicilioCreate']);

    Route::get('/prevision.procesos.cartera.cotizacion',[Contrato::class, 'fnCotizacion']);

    Route::post('/prevision.procesos.cartera.generar-cotizacion',[Contrato::class, 'fnGenerarCotizacion']);
    Route::post('/prevision.procesos.cartera.valida-asegurados',[Contrato::class, 'fnValidarAsegurados']);
    Route::post('/prevision.procesos.cartera.emision-contrato',[Contrato::class, 'fnEmision']);

    



});





