<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-logo {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .company-details {
            text-align: left;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
        }

        .invoice-info {
            text-align: right;
            margin-bottom: 10px;
        }

        .address-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .address-section div {
            width: 48%;
        }

        .instructions {
            font-size: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #cce5ff;
            text-align: center;
            font-size: 10px;
        }

        .product-image {
            max-width: 50px;
            max-height: 50px;
        }

        .summary {
            text-align: right;
            margin-top: 10px;
        }

        .summary table {
            width: 40%;
            float: right;
            margin-top: 20px;
        }

        .summary td {
            padding: 8px;
        }

        .note {
            font-size: 10px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="ruta/a/logo.png" alt="Logo de la empresa" class="company-logo">
        <h1>[NOMBRE DE SU COMPAÑÍA]</h1>
        <p>[ESLOGAN DE SU COMPAÑÍA]</p>
    </header>

    <div class="company-details">
        <p>[DIRECCIÓN COMPLETA]</p>
        <p>Teléfono: [NÚMERO DE TELÉFONO] | Fax: [NÚMERO DE FAX]</p>
    </div>

    <div class="invoice-title">
        Factura
    </div>

    <div class="invoice-info">
        <p>N.º DE FACTURA: <no aplica</p>
        <p>FECHA: No disponible</p>
    </div>

    <div class="address-section">
        <div>
            <strong>Facturar a:</strong>
            <p>Nombre: [Cliente]</p>
            <p>Dirección: [Dirección]</p>
        </div>
        <div>
            <strong>Enviar a:</strong>
            <p>Nombre: [Cliente]</p>
            <p>Dirección: [Dirección]</p>
        </div>
    </div>

    <div class="instructions">
        Comentarios o instrucciones especiales: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
    </div>

    <table>
        <thead>
            <tr>
                <th>CANTIDAD</th>
                <th>IMAGEN</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO UNITARIO</th>
                <th>FECHA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>
                        @if ($producto->image_base64)
                            <img src="{{ $producto->image_base64 }}" alt="Imagen de {{ $producto->nombre }}" class="product-image">
                        @else
                            <em>No hay imagen</em>
                        @endif
                    </td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>${{ $producto->precio}}</td>
                    <td>{{ $producto->updated_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>${{ number_format( 2) }}</td>
            </tr>
            <tr>
                <td>Impuesto:</td>
                <td>${{ number_format(2) }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td><strong>${{ number_format( 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="note">
        <p>Emita todos los cheques a pagar a [NOMBRE DE SU COMPAÑÍA]</p>
        <p>Gracias por su compra.</p>
    </div>

    <footer class="footer">
        <p>Este documento es generado electrónicamente y no requiere firma.</p>
    </footer>
</body>
</html>
