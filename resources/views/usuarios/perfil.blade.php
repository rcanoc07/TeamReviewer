@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <!-- Tarjeta de bienvenida -->
        <div class="d-flex justify-content-center">
            <div class="bg-white p-5 rounded-3 shadow-lg text-center border border-2 border-light w-50">
                <i class="bi bi-person-circle display-1 text-primary"></i>
                <h1 class="mt-3 fw-bold text-dark">
                    ¡Hola, {{ auth()->user()->name }}!
                </h1>
                <p class="text-muted">
                    Aquí puedes actualizar tu información personal.
                </p>
            </div>
        </div>

        <!-- Formulario de edición -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Editar Perfil</h4>
                        <!-- Botón de Descartar Cambios -->
                        <button type="button" class="btn btn-outline-light d-none" id="cancel-btn">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('perfil.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nombre</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" disabled>
                                    <button type="button" class="btn btn-outline-primary edit-btn" data-target="name">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" disabled>
                                    <button type="button" class="btn btn-outline-primary edit-btn" data-target="email">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Botón de Guardar -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success d-none" id="save-btn">
                                    <i class="bi bi-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para habilitar/descartar edición -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".edit-btn");
            const cancelBtn = document.getElementById("cancel-btn");
            const saveBtn = document.getElementById("save-btn");

            let originalValues = {};

            function enableField(input, button) {
                if (!originalValues[input.id]) {
                    originalValues[input.id] = input.value; // Guardar el valor original antes de editar
                }
                input.disabled = false; // Habilita el campo
                input.focus();
                saveBtn.classList.remove("d-none");
                cancelBtn.classList.remove("d-none");
                button.classList.add("disabled");
            }

            function disableEditing() {
                document.querySelectorAll("input").forEach(input => {
                    input.disabled = true; // Bloquea edición
                    if (originalValues[input.id]) {
                        input.value = originalValues[input.id]; // Restaura valores originales
                    }
                });
                editButtons.forEach(button => button.classList.remove("disabled"));
                saveBtn.classList.add("d-none");
                cancelBtn.classList.add("d-none");
                originalValues = {}; // Limpiar valores guardados
            }

            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const targetId = this.getAttribute("data-target");
                    const input = document.getElementById(targetId);
                    enableField(input, this);
                });
            });

            cancelBtn.addEventListener("click", disableEditing);
        });
    </script>
@endsection
