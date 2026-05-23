<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consultas</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .btn-leido i{
            font-size: 15px;
        }
        .btn-leido:hover .leido-normal{
            display: none;
        }
        .btn-leido .leido-hover{
            display: none;
        }
        .btn-leido:hover .leido-hover{
            display: inline;
        }
    </style>
</head>

<body class="bg-white normal-body text-white">

    @include('partials.header')            
        

    <div class="section-1" >

        <div class="normal-header">
                <h2 class="color-choco">Consultas</h2>
        </div>


        <div class="mt-5 container section-1">

            <table class="table table-choco mt-3">

                <thead class="table-dark">
                    <tr>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Tipo</th>
                        <th>Prioridad</th>
                        <th>Leído</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($consultas as $consulta)
                        <tr>

                            {{-- ID CLIENTE --}}
                            <td>
                                {{ $consulta->usuario->nombre ?? $consulta->id_usuario }}
                            </td>

                            <td>{{ \Carbon\Carbon::parse($consulta->created_at)->format('d/m/Y') }} </td>

                            <td style="min-width: 10vw;"><b>{{ $consulta->asunto }}</b></td>

                            <td>{{ $consulta->mensaje }}</td>

                            <td class="text-uppercase detalles text-center">{{ $consulta->tipo_consulta }}</td>

                            <td class="text-uppercase detalles text-center 
                                @if($consulta->prioridad === 'alta') text-danger
                                @elseif($consulta->prioridad === 'baja') color-medio
                                @endif">
                                {{ $consulta->prioridad }}
                            </td>

                            <td class="text-nowrap">
                                @if ($consulta->leido)
                                    <span class="badge bg-success">
                                        Sí
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        No
                                    </span>
                                @endif

                                {{-- BOTÓN MARCAR/DESMARCAR LEÍDO --}}
                                <form method="POST" action="{{ route('consultas.toggle', $consulta->id_consulta) }}" class="d-inline-block">
                                    @csrf
                                    @method('PATCH')
                                    
                                    @if ($consulta->leido)
                                        <button class="btn btn-sm detalles btn-leido" title="Marcar como no leído">
                                            <i class="bi bi-clipboard-check-fill leido-normal"></i>
                                            <i class="bi bi-clipboard-minus leido-hover"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-sm detalles btn-leido" title="Marcar como leído">
                                            <i class="bi bi-clipboard-check leido-normal"></i>
                                            <i class="bi bi-clipboard-check-fill leido-hover"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>

                            <td>

                                
                                {{-- MARCAR LEÍDO --}}
                                {{--
                                @if (!$consulta->leido)
                                    <form method="POST" action="{{ route('consultas.leer', $consulta->id_consulta) }}" class="d-inline-block">

                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-success btn-sm detalles" title="Marcar como leído">
                                            <i class="bi bi-clipboard-check"></i>
                                        </button>

                                    </form>
                                @endif
                                --}}

                                {{-- ELIMINAR --}}
                                <form method="POST" action="{{ route('consultas.destroy', $consulta->id_consulta) }}" class="d-inline-block">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm detalles" title="Eliminar" onclick="return confirm('¿Eliminar consulta?')">
                                        <i class="bi bi-trash3 color-white"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                No hay consultas
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        @include('partials.footer')     

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
