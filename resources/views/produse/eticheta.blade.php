<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <title>Etichetă – {{ $produs->nume }}</title>
    <style>
        /* Print-only styling */
        @media print {
            @page { margin: 5mm; }
            body { margin: 0; }
        }
        /* Center content on both screen and print */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: sans-serif;
            text-align: center;
        }
        .label {
            width: 80mm; /* adjust to your label width */
            padding: 5mm;
        }
        .nume {
            margin-top: 5mm;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="label">
        {!! QrCode::size(200)->generate(route('inventar.show', $produs)) !!}
        <div class="nume">{{ $produs->nume }}</div>
    </div>

    <script>
        // auto-print on load
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
