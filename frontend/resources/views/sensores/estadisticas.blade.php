@extends('layouts.app')

@section('content')
<div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-blue-500 glow-effect">
    <div class="nasa-gradient px-4 py-5 sm:px-6 border-b border-blue-700">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-blue-300 space-font flex items-center">
                <i class="fas fa-chart-bar text-blue-400 mr-3"></i>
                Estadísticas de Sensores
            </h2>
            <div class="text-blue-400 space-font text-sm">
                <i class="fas fa-satellite-dish mr-2"></i>
                <span>Control de Misión</span>
            </div>
        </div>
    </div>
    <div class="p-4 bg-gray-900">
        @if(session('error'))
            <div class="bg-red-900/50 border-l-4 border-red-400 p-4 mb-4 text-red-300">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('sensores.estadisticas') }}" method="GET" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label for="inicio" class="block text-sm font-medium text-blue-300">Fecha Inicio</label>
                    <div class="relative">
                        <input type="datetime-local" 
                               class="mt-1 block w-full rounded-md bg-gray-800 border-blue-500 text-blue-300 shadow-lg focus:border-blue-400 focus:ring-blue-400 sm:text-sm" 
                               id="inicio" 
                               name="inicio" 
                               value="{{ request('inicio') }}">
                        <div class="absolute inset-0 bg-blue-400/10 pointer-events-none rounded-md"></div>
                    </div>
                </div>
                <div class="space-y-1">
                    <label for="fin" class="block text-sm font-medium text-blue-300">Fecha Fin</label>
                    <div class="relative">
                        <input type="datetime-local" 
                               class="mt-1 block w-full rounded-md bg-gray-800 border-blue-500 text-blue-300 shadow-lg focus:border-blue-400 focus:ring-blue-400 sm:text-sm" 
                               id="fin" 
                               name="fin" 
                               value="{{ request('fin') }}">
                        <div class="absolute inset-0 bg-blue-400/10 pointer-events-none rounded-md"></div>
                    </div>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-blue-100 font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border border-blue-400 shadow-lg transition-all duration-300 hover:shadow-blue-400/50">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-blue-800">
                <thead>
                    <tr class="bg-gray-800">
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Sensor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Promedio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Mínimo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Máximo</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 divide-y divide-blue-800/30">
                                @foreach($estadisticas as $sensor => $datos)
                                    <tr class="hover:bg-blue-900/20 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-300">{{ ucfirst($sensor) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($datos['promedio'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($datos['minimo'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($datos['maximo'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection