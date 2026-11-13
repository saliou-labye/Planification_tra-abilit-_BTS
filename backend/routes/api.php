<?php

use App\Http\Controllers\Api\AffectationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollecteController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DechetTrieController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\PayementController;
use App\Http\Controllers\Api\QuartierController;
use App\Http\Controllers\Api\ReclamationController;
use App\Http\Controllers\Api\SignalementController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UtilisateurController;
use App\Http\Controllers\Api\VehiculeController;
use Illuminate\Support\Facades\Route;

// Public 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/quartiers', [QuartierController::class, 'index']); // liste utile à l'inscription

//Connecté (tous rôles)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Calendrier / liste des collectes (filtré automatiquement selon le rôle)
    Route::get('/collectes', [CollecteController::class, 'index']);
    Route::get('/collectes/{collecte}', [CollecteController::class, 'show']);

    // Administrateur
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', DashboardController::class);

        Route::get('/utilisateurs', [UtilisateurController::class, 'index']);
        Route::post('/utilisateurs', [UtilisateurController::class, 'store']);
        Route::delete('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'destroy']);

        Route::post('/quartiers', [QuartierController::class, 'store']);
        Route::put('/quartiers/{quartier}', [QuartierController::class, 'update']);
        Route::delete('/quartiers/{quartier}', [QuartierController::class, 'destroy']);

        Route::apiResource('vehicules', VehiculeController::class)->except('show');

        Route::get('/affectations', [AffectationController::class, 'index']);
        Route::post('/affectations', [AffectationController::class, 'store']);

        Route::post('/collectes', [CollecteController::class, 'store']);
        Route::patch('/collectes/{collecte}/annuler', [CollecteController::class, 'annuler']);

        Route::get('/payements/impayes', [PayementController::class, 'impayes']);
        Route::patch('/reclamations/{reclamation}', [ReclamationController::class, 'update']);
    });

    //Client 
    Route::middleware('role:client')->group(function () {
        Route::post('/payements', [PayementController::class, 'store']);
        Route::post('/reclamations', [ReclamationController::class, 'store']);
        Route::post('/evaluations', [EvaluationController::class, 'store']);
        Route::post('/signalements', [SignalementController::class, 'store']);
        Route::post('/dechets', [DechetTrieController::class, 'store']);
    });

    //Collecteur 
    Route::middleware('role:collecteur')->group(function () {
        Route::patch('/collectes/{collecte}/demarrer', [CollecteController::class, 'demarrer']);
        Route::patch('/collectes/{collecte}/confirmer', [CollecteController::class, 'confirmer']);
    });

    // Contrôleur
    Route::middleware('role:controlleur')->group(function () {
        Route::patch('/signalements/{signalement}/prendre-en-charge', [SignalementController::class, 'prendreEnCharge']);
        Route::patch('/signalements/{signalement}/statut', [SignalementController::class, 'changerStatut']);
    });

    //Service de tri 
    Route::middleware('role:service_trie')->group(function () {
        Route::patch('/collectes/{collecte}/receptionner', [CollecteController::class, 'receptionner']);
        Route::patch('/dechets/{dechet}/controler', [DechetTrieController::class, 'controler']);
        Route::post('/transactions', [TransactionController::class, 'store']);
    });

    //Consultations partagées 
    Route::get('/payements', [PayementController::class, 'index'])->middleware('role:client,admin');
    Route::get('/reclamations', [ReclamationController::class, 'index'])->middleware('role:client,admin');
    Route::get('/evaluations', [EvaluationController::class, 'index'])->middleware('role:collecteur,admin');
    Route::get('/signalements', [SignalementController::class, 'index'])->middleware('role:client,controlleur,admin');
    Route::get('/dechets', [DechetTrieController::class, 'index'])->middleware('role:client,service_trie,admin');
    Route::get('/stock', [DechetTrieController::class, 'stock'])->middleware('role:partenaire,service_trie,admin');
    Route::get('/transactions', [TransactionController::class, 'index'])->middleware('role:partenaire,service_trie,admin');
    Route::get('/partenaires', fn () => \App\Models\Partenaire::with('utilisateur')->get())
    ->middleware('role:service_trie,admin');
});