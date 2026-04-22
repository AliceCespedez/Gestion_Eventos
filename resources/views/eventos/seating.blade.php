<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seating Pro</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .container {
            display: flex;
            gap: 20px;
        }

        .invitados {
            width: 30%;
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 500px;
        }

        .invitado {
            padding: 6px;
            background: #2563eb;
            color: #fff;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: grab;
            font-size: 13px;
        }

        /* Invitado dentro del asiento */
        .asiento .invitado {
            background: transparent;
            color: black;
            font-size: 10px;
            margin: 0;
            padding: 0;
            cursor: grab;
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
            pointer-events: none;
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
                        $pos = [
                            'top:-10px;left:50%;transform:translate(-50%,-50%)',
                            'top:10px;right:-10px',
                            'top:50%;right:-10px;transform:translateY(-50%)',
                            'bottom:10px;right:-10px',
                            'bottom:-10px;left:50%;transform:translate(-50%,50%)',
                            'bottom:10px;left:-10px',
                            'top:50%;left:-10px;transform:translateY(-50%)',
                            'top:10px;left:-10px',
                        ];
                    @endphp

                    <div class="asiento {{ $asiento->id_invitado ? 'occupied' : '' }}"
                         data-id="{{ $asiento->id_asiento }}"
                         data-invitado="{{ $asiento->id_invitado ?? '' }}"
                         style="{{ $pos[$i % count($pos)] }}">

                        @if($asiento->invitado)
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const group = {
        name: 'seating',
        pull: true,
        put: true
    };

    /* LISTA INVITADOS */
    new Sortable(document.getElementById('invitados'), {
        group: group,
        animation: 150,
        sort: false
    });

    /* ASIENTOS */
    document.querySelectorAll('.asiento').forEach(asiento => {

        new Sortable(asiento, {
            group: group,
            animation: 150,

            onAdd(evt) {

                const invitadoId = evt.item.dataset.id;
                const destino = evt.to;

                // asiento ocupado
                if (destino.children.length > 1) {
                    document.getElementById('invitados').appendChild(evt.item);
                    return;
                }

                // guardar en BD
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

                // marcar ocupado
                destino.dataset.invitado = invitadoId;
                destino.classList.add('occupied');

                // limpiar asiento anterior
                if (evt.from.classList.contains('asiento')) {
                    evt.from.dataset.invitado = '';
                    evt.from.classList.remove('occupied');
                }
            }
        });

    });

});
</script>

</body>
</html>