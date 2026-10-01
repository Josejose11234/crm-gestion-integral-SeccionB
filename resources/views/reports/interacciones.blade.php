<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Interacciones por Asesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">

    <h1 class="mb-4">📞 Interacciones por Asesor</h1>

    {{-- Tabla desglose por tipo --}}
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Desglose por Tipo</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Asesor</th>
                        <th>Llamadas</th>
                        <th>Visitas</th>
                        <th>WhatsApp</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($asesores as $a)
                    <tr>
                        <td><strong>{{ $a->name }}</strong></td>
                        <td><span class="badge bg-primary">{{ $a->llamadas }}</span></td>
                        <td><span class="badge bg-success">{{ $a->visitas }}</span></td>
                        <td><span class="badge bg-warning text-dark">{{ $a->whatsapp }}</span></td>
                        <td><span class="badge bg-dark">{{ $a->total }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Gráfico de barras apiladas --}}
    <div class="card mb-4">
        <div class="card-body">
            <canvas id="grafico" height="80"></canvas>
        </div>
    </div>

    {{-- RETO 2: Interacciones por día de la semana --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">📅 Interacciones por Día de la Semana</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr><th>Día</th><th>Total</th></tr>
                </thead>
                <tbody>
                @forelse($porDia as $d)
                    <tr>
                        <td>{{ $d->dia }}</td>
                        <td><span class="badge bg-info">{{ $d->total }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">Sin datos</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('reportes.zonas') }}" class="btn btn-secondary mb-5">
        ← Volver al reporte 1
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('grafico'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                { label: 'Llamadas', data: @json($llamadas), backgroundColor: '#0d6efd' },
                { label: 'Visitas',  data: @json($visitas),  backgroundColor: '#198754' },
                { label: 'WhatsApp', data: @json($whatsapp), backgroundColor: '#ffc107' }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>