@extends('layout')

@section('title', 'Clientes')

@section('content')
<h1 class="mb-4">Clientes</h1>

<!-- Formulario para nuevo cliente -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white" id="form-header">Nuevo Cliente</div>
    <div class="card-body">
        <form id="formCliente" onsubmit="event.preventDefault(); enviarCliente();">
            <input type="hidden" id="cliente_id">
            <div class="row g-3">
                <div class="col-md-4"><input type="text" id="nombre" class="form-control" placeholder="Nombre" required></div>
                <div class="col-md-4"><input type="email" id="email" class="form-control" placeholder="Email" required></div>
                <div class="col-md-3"><input type="text" id="telefono" class="form-control" placeholder="Teléfono"></div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success w-100" id="submitBtn">💾</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Clientes -->
<div class="card">
    <div class="card-header bg-dark text-white">Lista de Clientes</div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Acciones</th></tr>
            </thead>
            <tbody id="clientes-body"></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
let editMode = false;
let url = "http://localhost:8000";

async function cargarClientes() {
    let res = await fetch("http://localhost:8000/api/clientes");
    let clientes = await res.json();
    let tbody = document.getElementById("clientes-body");
    tbody.innerHTML = "";
    clientes.forEach(c => {
        tbody.innerHTML += `
            <tr>
                <td>${c.id}</td>
                <td>${c.nombre}</td>
                <td>${c.email}</td>
                <td>${c.telefono}</td>
                <td>
                    <button class="btn btn-warning btn-sm me-1" onclick="editarCliente(${c.id})">🖊</button>
                    <button class="btn btn-danger btn-sm" onclick="eliminarCliente(${c.id})">🗑</button>
                </td>
            </tr>
        `;
    });
}

async function enviarCliente() {
    let id = document.getElementById("cliente_id").value;
    let nombre = document.getElementById("nombre").value;
    let email = document.getElementById("email").value;
    let telefono = document.getElementById("telefono").value;

    if (editMode) {
        // Editar
        await fetch(`${url}/api/clientes/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre, email, telefono })
        });
        editMode = false;
        document.getElementById("form-header").innerText = "Nuevo Cliente";
        document.getElementById("submitBtn").innerText = "Guardar";
    } else {
        // Crear
        await fetch(`${url}/api/clientes`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nombre, email, telefono })
        });
    }

    document.getElementById("formCliente").reset();
    cargarClientes();
}

async function editarCliente(id) {
    let res = await fetch(`${url}/api/clientes/${id}`);
    let c = await res.json();
    document.getElementById("cliente_id").value = c.id;
    document.getElementById("nombre").value = c.nombre;
    document.getElementById("email").value = c.email;
    document.getElementById("telefono").value = c.telefono;
    editMode = true;
    document.getElementById("form-header").innerText = "Editar Cliente";
    document.getElementById("submitBtn").innerText = "✔";
}

async function eliminarCliente(id) {
    await fetch(`${url}/api/clientes/${id}`, { method: "DELETE" });
    cargarClientes();
}

window.onload = cargarClientes;
</script>
@endsection
