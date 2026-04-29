<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seating Pro</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ✅ SORTABLE CORRECTO -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <style>
        .container {
            display: flex;
            gap: 20px;
        }

        .invitados {
            width: 30%;
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 300px;
        }

        .invitado {
            padding: 6px;
            background: #2563eb;
            color: #fff;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: grab;
            user-select: none;
            font-size: 13px;
        }

        .asiento .invitado {
            background: transparent;
            color: black;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .mesas {
            width: 70%;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .mesa {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            border: 2px solid #999;
            position: relative;
        }

        .mesa-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        .asiento {
            width: 35px;
            height: 35px;
            border: 1px dashed #aaa;
            border-radius: 4px;
            background: #f3f4f6;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .asiento.occupied {
            background: #22c55e;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- INVITADOS -->
        <div class="invitados" id="invitados">
            <h3>🎟 Invitados</h3>

            @foreach ($evento->invitados as $inv)
                @if (!$inv->asiento)
                    <div class="invitado" data-id="{{ $inv->id_invitado }}">
                        {{ $inv->nombre }}
                    </div>
                @endif
            @endforeach
        </div>

        <!-- MESAS -->
        <div class="mesas">

            @foreach ($evento->mesas as $mesa)
                <div class="mesa">

                    <div class="mesa-title">
                        Mesa {{ $mesa->numero_mesa }}
                    </div>

                    @foreach ($mesa->asientos as $i => $asiento)
                        @php
                            $count = count($mesa->asientos);
                            $angle = $count > 1 ? (2 * pi() * $i / $count) : 0;
                            $radius = 50;
                            $x = 50 + cos($angle) * $radius;
                            $y = 50 + sin($angle) * $radius;
                            $style = "top:{$y}%;left:{$x}%;transform:translate(-50%,-50%)";
                        @endphp

                        <div class="asiento {{ $asiento->id_invitado ? 'occupied' : '' }} dropzone"
                            data-id="{{ $asiento->id_asiento }}" style="{{ $style }}">

                            @if ($asiento->invitado)
                                <div class="invitado" data-id="{{ $asiento->invitado->id_invitado }}">
                                    {{ $asiento->invitado->nombre }}
                                </div>
                            @endif

                        </div>
                    @endforeach

                </div>
            @endforeach

        </div>

    </div>

    <!-- ✅ SCRIPT FUNCIONANDO -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            // ======================
            // INVITADOS (ORIGEN)
            // ======================
            new Sortable(document.getElementById('invitados'), {
                group: 'seating',
                animation: 150,
                draggable: ".invitado",
                sort: false
            });

            // ======================
            // ASIENTOS (DROP ZONES)
            // ======================
            document.querySelectorAll('.dropzone').forEach(zone => {

                new Sortable(zone, {
                    group: 'seating',
                    animation: 150,
                    draggable: ".invitado",
                    sort: false,
                    filter: '.occupied', // No permitir drop en ocupados

                    onAdd(evt) {

                        const invitadoId = evt.item.dataset.id;
                        const destino = evt.to;

                        // Si el destino ya tiene invitado, cancelar
                        if (destino.classList.contains('occupied')) {
                            evt.from.appendChild(evt.item);
                            return;
                        }

                        // Limpiar asiento anterior
                        if (evt.from.classList.contains('dropzone')) {
                            evt.from.classList.remove('occupied');
                            fetch("{{ route('asientos.desasignar') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrf
                                },
                                body: JSON.stringify({
                                    invitado_id: invitadoId
                                })
                            });
                        }

                        // Asignar nuevo
                        fetch("{{ route('asientos.asignar') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrf
                            },
                            body: JSON.stringify({
                                invitado_id: invitadoId,
                                asiento_id: destino.dataset.id
                            })
                        });

                        destino.classList.add('occupied');
                    }
                });

            });

        });
    </script>

</body>

</html>
