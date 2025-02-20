{{-- GRUPO DE AMIGOS INVISIBLES --}}
<div class="col-lg-4 col-md-6 col-sm-12 p-1 pb-3 m-0">
    <div class="card text-center">
        <div class="card-header">
            Número de participantes: {{ $grupo->participantes->count() }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $grupo->name }}</h5>
            <p class="card-text mb-0"><i class="bi bi-person-lock"></i> {{ $grupo->propietario->name }}</p>
            <p class="card-text mb-0">Creado el {{  date("d-m-Y", strtotime($grupo->created_at)) }}</p>


                @switch($grupo->estado)
                    @case(0)
                        <p class="card-text mb-0">{{ "SIN SORTEAR" }}</p>
                        <p class="card-text mb-0">Sorteo previsto el {{  date("d-m-Y", strtotime($grupo->fechasorteo)) }}</p>
                    @break
                    @case(1)
                        <p class="card-text mb-0">{{ "Sorteado el " . date("d-m-Y", strtotime($grupo->fechasorteoreal)) }}</p>
                        <p class="card-text mb-0">Entrega de regalos el {{  date("d-m-Y", strtotime($grupo->fechaentregaregalos)) }}</p>
                    @break
                    @case(2)
                        <p class="card-text mb-0">{{ "REGALO ENTREGADO" }}</p>
                        @break
                @endswitch



            <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                @if ($botonver)
                    <a href="{{ route('grupos.show', ["grupo" => $grupo->id]) }}" class="btn btn-outline-primary">Ver</a>
                @endif


@if (($grupo->propietario_id == auth()->user()->id)  || (auth()->user()->hasRole("admin")))
                        <a href="{{ route("grupos.edit", ["grupo" => $grupo->id]) }}" class="btn btn-outline-primary">Editar</a>
                        <a href='{{ route ("grupos.intromasiva",["grupoid" => $grupo->id]) }}' class="btn btn-outline-primary">Intro</a>
                        <button type="submit" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#borrar{{ $grupo->id }}">
                        Borrar
                    </button>
@endif
            </div>

        </div>
        <div class="card-footer">
            <small>Código de acceso: {{ $grupo->codigoacceso }}</small>
            @if ($grupo->propietario->id == auth()->user()->id)
                <i class="bi bi-lock"></i>
            @endif
        </div>
    </div>
</div>
{{-- GRUPO DE AMIGOS INVISIBLES --}}


<!-- Modal -->
<div class="modal fade" id="borrar{{ $grupo->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación de borrado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 ¿Desea borrar el grupo <strong>{{ $grupo->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route("grupos.destroy", ["grupo" => $grupo->id]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-primary">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
