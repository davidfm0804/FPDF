<?php
    require_once('../controladores/Cranking.php');
    require('../fpdf/fpdf.php');
    $objranking = new Cranking();
    $resultado = $objranking->cMostrarPuntuacion();

    if (isset($_POST['export_pdf'])) {
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Ranking', 0, 1, 'C');
        $pdf->Write(-20,"Volver al Ranking", 'verRanking.php');


        $totalWidth = 50 + 30 + 40 + 40; // Anchos de las celdas (Nombre, Puntos, Num Fallos, Tiempo)
        $leftMargin = (210 - $totalWidth) / 2;//$pdf->GetPageWidth() para sacar ancho de la pagina
        $pdf->SetX($leftMargin);
        // Títulos de las columnas (centrados)
        $pdf->Cell(50, 10, 'Nombre', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Puntos', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Num Fallos', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Tiempo', 1, 1, 'C');
            
        

        // Agregar los datos de la tabla al PDF
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $pdf->SetX($leftMargin); // Asegurarse de que cada fila comienza en la posición calculada
                $pdf->Cell(50, 10, $fila['nombre'], 1);
                $pdf->Cell(30, 10, $fila['puntos'], 1);
                $pdf->Cell(40, 10, $fila['numFallos'], 1);
                $pdf->Cell(40, 10, $fila['tiempo'], 1, 1);
            }
        }
        $pdf->Output('I', 'ranking.pdf');
        exit;
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Ranking</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <?php
    if ($resultado->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr>
                    <th>Nombre</th>
                    <th>Puntos</th>
                    <th>Número de Fallos</th>
                    <th>Tiempo</th>
                </tr>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['nombre']."</td>
                        <td>".$fila['puntos']."</td>
                        <td>".$fila['numFallos']."</td>
                        <td>".$fila['tiempo']."</td>
                    </tr>";
            }
            echo "</table>";
    }
    ?>
    <div class="center-form">
        <form method="post" target="_blank">
            <input type="submit" name="export_pdf" value="Exportar a PDF">
        </form>
    </div>
</body>
</html>
