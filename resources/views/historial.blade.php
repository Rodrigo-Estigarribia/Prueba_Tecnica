@extends('layout')

@section('title', 'Historial de Compras')

@section('content')
<h1 class="mb-4">Historial de Compras</h1>

<div class="card">
    <div class="card-header bg-dark text-white">Registro de compras</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="historial-body"></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
let url = "http://localhost:8000";

async function cargarHistorial() {
    let res = await fetch(`${url}/api/historial`);
    let historial = await res.json();
    let tbody = document.getElementById('historial-body');
    tbody.innerHTML = '';

    historial.forEach(h => {
        tbody.innerHTML += `
            <tr>
                <td>${h.id}</td>
                <td>${h.cliente ? h.cliente.nombre : 'Cliente eliminado'}</td>
                <td>${h.producto ? h.producto.nombre : 'Producto eliminado'}</td>
                <td>${h.cantidad}</td>
                <td>${new Date(h.created_at).toLocaleString()}</td>
            </tr>
        `;
    });
}

window.onload = cargarHistorial;
</script>
@endsection
