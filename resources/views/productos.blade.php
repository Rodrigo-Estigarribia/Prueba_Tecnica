@extends('layout')

@section('title', 'Productos')

@section('content')
<h1 class="mb-4">Productos</h1>

<!-- Formulario para nuevo producto -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white" id="form-header">Nuevo Producto</div>
    <div class="card-body">
        <form id="formProducto" onsubmit="event.preventDefault(); enviarProducto();">
            <input type="hidden" id="producto_id">
            <div class="row g-3">
                <div class="col-md-3"><input type="text" id="nombre" class="form-control" placeholder="Nombre" required></div>
                <div class="col-md-2"><input type="number" id="precio" class="form-control" placeholder="Precio" required></div>
                <div class="col-md-2"><input type="number" id="stock" class="form-control" placeholder="Stock" required></div>
                <div class="col-md-2"><button type="submit" class="btn btn-success w-100" id="submitBtn">💾</button></div>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de producto -->
<div class="card">
    <div class="card-header bg-dark text-white">Lista de Productos</div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="productos-body"></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
let editMode = false;
let url = "http://localhost:8000";

// Cargar productos
async function cargarProductos() {
    let res = await fetch(`${url}/api/productos`);
    let productos = await res.json();
    let tbody = document.getElementById("productos-body");
    tbody.innerHTML = "";
    productos.forEach(p => {
        tbody.innerHTML += `
            <tr>
                <td>${p.id}</td>
                <td>${p.nombre}</td>
                <td>${p.precio}</td>
                <td>${p.stock}</td>
                <td>
                    <button class="btn btn-warning btn-sm me-1" onclick="editarProducto(${p.id})">🖊</button>
                    <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${p.id})">🗑</button>
                </td>
            </tr>
        `;
    });
}

// Crear o actualizar producto
async function enviarProducto() {
    let id = document.getElementById("producto_id").value;
    let nombre = document.getElementById("nombre").value;
    let precio = document.getElementById("precio").value;
    let stock = document.getElementById("stock").value;

    if (editMode) {
        // Editar
        await fetch(`${url}/api/productos/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre, precio, stock})
        });
        editMode = false;
        document.getElementById("form-header").innerText = "Nuevo Producto";
        document.getElementById("submitBtn").innerText = "✔";
    } else {
        // Crear
        await fetch(`${url}/api/productos`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre, precio, stock})
        });
    }

    document.getElementById("formProducto").reset();
    cargarProductos();
}

// Editar producto
async function editarProducto(id) {
    let res = await fetch(`${url}/api/productos/${id}`);
    let p = await res.json();
    document.getElementById("producto_id").value = p.id;
    document.getElementById("nombre").value = p.nombre;
    document.getElementById("precio").value = p.precio;
    document.getElementById("stock").value = p.stock;

    editMode = true;
    document.getElementById("form-header").innerText = "Editar Producto";
    document.getElementById("submitBtn").innerText = "✔";
}

// Eliminar producto
async function eliminarProducto(id) {
    await fetch(`${url}/api/productos/${id}`, { method: "DELETE" });
    cargarProductos();
}

window.onload = cargarProductos;
</script>
@endsection
