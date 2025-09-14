@extends('layout')

@section('title', 'Simulación de Compra')

@section('content')
<h1 class="mb-4">Descuento de Stock</h1>

<!-- Seleccionar Cliente -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Cliente</div>
    <div class="card-body position-relative">
        <input type="text" id="cliente_input" class="form-control" placeholder="Escribe el nombre del cliente">
        <div id="cliente_suggestions" class="list-group position-absolute w-100" style="z-index:1000;"></div>
    </div>
</div>

<!-- Seleccionar Productos -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Productos</div>
    <div class="card-body position-relative">
        <input type="text" id="producto_input" class="form-control mb-2" placeholder="Escribe el nombre del producto">
        <div id="producto_suggestions" class="list-group position-absolute w-100" style="z-index:1000;"></div>
        <table class="table table-striped mt-4">
            <thead>
                <tr><th>Producto</th><th>Stock</th><th>Cantidad</th><th>Acción</th></tr>
            </thead>
            <tbody id="productos-body"></tbody>
        </table>
    </div>
</div>

<button class="btn btn-success mb-4" onclick="finalizarCompra()">Finalizar Compra</button>

<div id="mensaje"></div>
@endsection

@section('scripts')
<script>
let clientes = [];
let productos = [];
let compra = [];
let clienteSeleccionado = null;

// Cargar clientes y productos al inicio
async function cargarDatos() {
    let resClientes = await fetch('http://localhost:8000/api/clientes');
    clientes = await resClientes.json();
    let resProductos = await fetch('http://localhost:8000/api/productos');
    productos = await resProductos.json();
}

// Autocompletado cliente
document.getElementById('cliente_input').addEventListener('input', function() {
    let query = this.value.toLowerCase();
    let div = document.getElementById('cliente_suggestions');
    div.innerHTML = '';
    if(query.length === 0) return;
    clientes.filter(c => c.nombre.toLowerCase().includes(query))
            .forEach(c => {
                let item = document.createElement('a');
                item.classList.add('list-group-item', 'list-group-item-action');
                item.innerText = c.nombre + ' (' + c.email + ')';
                item.href = '#';
                item.onclick = () => {
                    clienteSeleccionado = c;
                    document.getElementById('cliente_input').value = c.nombre;
                    div.innerHTML = '';
                }
                div.appendChild(item);
            });
});

// Autocompletado producto
document.getElementById('producto_input').addEventListener('input', function() {
    let query = this.value.toLowerCase();
    let div = document.getElementById('producto_suggestions');
    div.innerHTML = '';
    if(query.length === 0) return;
    productos.filter(p => p.nombre.toLowerCase().includes(query))
             .forEach(p => {
                let item = document.createElement('a');
                item.classList.add('list-group-item', 'list-group-item-action');
                item.innerText = p.nombre + ' (Stock: '+p.stock+')';
                item.href = '#';
                item.onclick = () => {
                    agregarProductoTabla(p);
                    div.innerHTML = '';
                    document.getElementById('producto_input').value = '';
                }
                div.appendChild(item);
             });
});

// Agregar producto a la tabla de compra
function agregarProductoTabla(p) {
    if(compra.find(x => x.id === p.id)) return alert('Producto ya agregado');
    compra.push({ ...p, cantidad: 1 });
    renderTabla();
}

function renderTabla() {
    let tbody = document.getElementById('productos-body');
    tbody.innerHTML = '';
    compra.forEach(p => {
        tbody.innerHTML += `
            <tr>
                <td>${p.nombre}</td>
                <td id="stock-${p.id}">${p.stock}</td>
                <td><input type="number" min="1" max="${p.stock}" value="${p.cantidad}" class="form-control" style="width:100px;" onchange="updateCantidad(${p.id}, this.value)"></td>
                <td><button class="btn btn-danger btn-sm" onclick="quitarProducto(${p.id})">Quitar</button></td>
            </tr>
        `;
    });
}

function updateCantidad(id, cantidad) {
    let p = compra.find(x => x.id === id);
    p.cantidad = parseInt(cantidad);
}

// Quitar producto
function quitarProducto(id) {
    compra = compra.filter(x => x.id !== id);
    renderTabla();
}

// Finalizar compra
async function finalizarCompra() {
    if(!clienteSeleccionado) return alert('Seleccione un cliente');
    if(compra.length === 0) return alert('Agregue al menos un producto');

    let mensajeDiv = document.getElementById('mensaje');
    mensajeDiv.innerHTML = '';

    for(let p of compra) {
        let res = await fetch('http://localhost:8000/api/webhook/stock', {
            method: 'POST',
            headers: {"Content-Type":"application/json"},
            body: JSON.stringify({ producto_id: p.id, cantidad: p.cantidad })
        });

        if(res.ok) {
            let data = await res.json();
            document.getElementById(`stock-${p.id}`).innerText = data.stock;
        } else {
            let error = await res.json();
            mensajeDiv.innerHTML += `<div class="alert alert-danger">${error.error}</div>`;
        }
    }

    alert('Compra finalizada!');
    compra = [];
    renderTabla();
}

window.onload = cargarDatos;
</script>
@endsection
