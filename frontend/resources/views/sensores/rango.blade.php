@extends('layouts.app')

@section('content')
<div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-blue-500 glow-effect">
    <div class="nasa-gradient px-4 py-5 sm:px-6 border-b border-blue-700">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-blue-300 space-font flex items-center">
                <i class="fas fa-clock text-blue-400 mr-3"></i>
                Datos por Rango de Tiempo
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

        <form action="{{ route('sensores.rango') }}" method="GET" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-5 space-y-1">
                    <label for="horas" class="block text-sm font-medium text-blue-300">Últimas horas</label>
                    <div class="relative">
                        <input type="number" 
                               class="mt-1 block w-full rounded-md bg-gray-800 border-blue-500 text-blue-300 shadow-lg focus:border-blue-400 focus:ring-blue-400 sm:text-sm" 
                               id="horas" 
                               name="horas" 
                               value="{{ $horas }}" 
                               min="1" 
                               max="168">
                        <div class="absolute inset-0 bg-blue-400/10 pointer-events-none rounded-md"></div>
                    </div>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-blue-100 font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border border-blue-400 shadow-lg transition-all duration-300 hover:shadow-blue-400/50">
                        Actualizar
                    </button>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-blue-800">
                <thead>
                    <tr class="bg-gray-800">
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Fecha/Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Temperatura</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Humedad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Presión</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">Gas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">CO</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">H2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">CH4</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">NH3</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider border-b border-blue-700">EtOH</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-900 divide-y divide-blue-800/30">
                    @foreach($datos as $dato)
                        <tr class="hover:bg-blue-900/20 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-300">{{ \Carbon\Carbon::parse($dato['timestamp'])->format('d/m/Y H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['temperatura'], 2) }} °C</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['humedad'], 2) }} %</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['presion'], 2) }} hPa</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['gas'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['co'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['h2'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['ch4'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['nh3'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-200">{{ number_format($dato['etoh'], 2) }}</td>
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