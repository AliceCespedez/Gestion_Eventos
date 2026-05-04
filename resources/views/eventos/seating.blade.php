<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seating Pro</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

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
            color: white;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: grab;
            user-select: none;
            font-size: 13px;
        }

        .invitado.assigned {
            background: #dc2626;
            opacity: 0.7;
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
            width: 50px;
            height: 50px;
            border: 1px dashed #aaa;
            border-radius: 6px;
            background: #f3f4f6;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .asiento.occupied {
            background: #22c55e;
        }

        .asiento .invitado {
            background: transparent;
            color: black;
            font-size: 10px;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- INVITADOS -->
    <div class="invitados" id="seating-invitados">
        <h3>🎟 Invitados</h3>

        @foreach ($evento->invitados as $inv)
            <div class="invitado {{ $inv->asiento ? 'assigned' : '' }}" data-id="{{ $inv->id_invitado }}">
                {{ $inv->nombre }}
            </div>
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
                        $angle = $count > 1 ? (2 * pi() * $i) / $count : 0;
                        $radius = 50;
                        $x = 50 + cos($angle) * $radius;
                        $y = 50 + sin($angle) * $radius;
                        $style = "top:{$y}%;left:{$x}%;transform:translate(-50%,-50%)";
                    @endphp

                    <div class="asiento {{ $asiento->invitado ? 'occupied' : '' }}"
                         data-id="{{ $asiento->id_asiento }}"
                         style="{{ $style }}">

                        @if ($asiento->invitado)
                            <div class="invitado"
                                 data-id="{{ $asiento->invitado->id_invitado }}">
                                {{ $asiento->invitado->nombre }}
                            </div>
                        @endif

                    </div>
                @endforeach

            </div>
        @endforeach

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    console.log("SEATING OK");
    console.log('Sortable loaded:', typeof Sortable);

    const invitadosEl = document.getElementById('seating-invitados');
    console.log('Seating invitados element:', invitadosEl);
    console.log('Seating invitados children:', invitadosEl ? invitadosEl.children.length : 'null');
    console.log('Seating invitados with class invitado:', invitadosEl ? invitadosEl.querySelectorAll('.invitado').length : 'null');

    // LISTA DE INVITADOS
    try {
        new Sortable(document.getElementById('seating-invitados'), {
            group: 'seating',
            animation: 150,
            draggable: ".invitado",
            sort: false,
            onStart: function(evt) {
                console.log('Drag started from seating invitados', evt.item.dataset.id);
                console.log('Item:', evt.item);
            }
        });
        console.log(' Sortable invitados initialized');
    } catch (e) {
        console.error(' Error initializing Sortable invitados:', e);
    }
    // CADA ASIENTO ES DROP TARGET
    document.querySelectorAll('.asiento').forEach(asiento => {
        console.log('Initializing asiento:', asiento.dataset.id);

        try {
            new Sortable(asiento, {
                group: 'seating',
                animation: 150,
                draggable: ".invitado",
                sort: false,

                onStart: function(evt) {
                    console.log(' Drag started from asiento', asiento.dataset.id);
                    console.log('Item:', evt.item);
                },

                onAdd(evt) {

                const item = evt.item;
                const invitadoId = item.dataset.id;
                const asientoId = asiento.dataset.id;

                console.log(" Drop en asiento:", asientoId);

                const invitadosEnAsiento = Array.from(asiento.querySelectorAll('.invitado'))
                    .filter(el => el !== item);

                if (invitadosEnAsiento.length > 0) {
                    evt.from.appendChild(item);
                    return;
                }
                // Si viene de otro asiento, desasignar primero
                const desasignarPromise = evt.from.classList.contains('asiento') ? 
                    fetch("{{ route('asientos.desasignar') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf
                        },
                        body: JSON.stringify({
                            invitado_id: invitadoId
                        })
                    }) : Promise.resolve();

                desasignarPromise
                    .then(() => fetch("{{ route('asientos.asignar') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf
                        },
                        body: JSON.stringify({
                            invitado_id: invitadoId,
                            asiento_id: asientoId
                        })
                    }))
                    .then(res => {
                        if (!res.ok) throw new Error("backend error");
                        asiento.classList.add('occupied');
                        console.log(" ASIGNADO");
                    })
                    .catch(err => {
                        console.log(" ERROR", err);
                        evt.from.appendChild(item);
                    });
            },

            onRemove() {
                if (!asiento.querySelector('.invitado')) {
                    asiento.classList.remove('occupied');
                }
            }
        });
        console.log(' Sortable asiento initialized for', asiento.dataset.id);
    } catch (e) {
        console.error(' Error initializing Sortable for asiento', asiento.dataset.id, e);
    }

    });

});
</script>

</body>
</html>