<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SensorDataController extends Controller
{
    private $apiUrl = 'http://localhost:5000/api';

    public function index()
    {
        try {
            $response = Http::get($this->apiUrl . '/datos');
            $datos = $response->json();
            return view('sensores.index-arduino', compact('datos'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener los datos de los sensores: ' . $e->getMessage());
        }
    }

    public function estadisticas(Request $request)
    {
        try {
            $query = [];
            if ($request->inicio && $request->fin) {
                $query = [
                    'inicio' => $request->inicio,
                    'fin' => $request->fin
                ];
            }

            $response = Http::get($this->apiUrl . '/estadisticas', $query);
            $estadisticas = $response->json();
            return view('sensores.estadisticas', compact('estadisticas'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener las estadísticas: ' . $e->getMessage());
        }
    }

    public function datosRango(Request $request)
    {
        try {
            $horas = $request->horas ?? 24;
            $response = Http::get($this->apiUrl . '/datos/rango', [
                'horas' => $horas
            ]);
            $datos = $response->json();
            return view('sensores.rango', compact('datos', 'horas'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al obtener los datos por rango: ' . $e->getMessage());
        }
    }
}