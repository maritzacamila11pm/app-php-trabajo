<?php
require_once 'vendor/autoload.php'; // Asegúrate de haber instalado Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;
//PARA EXCEL
use Shuchkin\SimpleXLSXGen;

class ReporteTController {
    private $tarea;
    private $db;

    public function __construct() {
        // Conexión a la base de datos
        $database = new Database();
        $this->db = $database->connect();
        $this->tarea = new Tarea($this->db); 
    }

    // Método para generar el reporte PDF de las tareas
    public function reporteTPdf() {
        try {
            // Obtener todas las tareas
            $result = $this->tarea->obtenerTareas();
            $tareas = $result->fetchAll(PDO::FETCH_ASSOC);

            // Configurar opciones de DOMPDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            // Crear instancia de DOMPDF
            $dompdf = new Dompdf($options);

            // Preparar el HTML para el reporte
            $html = $this->generatePDFTemplate($tareas);

            // Cargar el HTML
            $dompdf->loadHtml($html);

            // Configurar el tamaño del papel y la orientación
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar el PDF (sin mostrarlo aún)
            $dompdf->render();

            // Nombre del archivo PDF
            $filename = 'reporte_tareas_' . date('Y-m-d_H-i-s') . '.pdf';

            // Enviar el PDF al navegador
            $dompdf->stream($filename, array('Attachment' => false)); //dato
        } catch (Exception $e) {
            echo "Error al generar PDF: " . $e->getMessage();
        }
    }

    // Método para crear la plantilla HTML del reporte
    private function generatePDFTemplate($tareas) {
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Tareas</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    background-color: #f4f4f9;
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #6a4c9c; /* Color morado */
                    color: white;
                }
                tr:nth-child(even) {
                    background-color: #f3e9f9; /* Color morado claro */
                }
                tr:nth-child(odd) {
                    background-color: white;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    background-color: #6a4c9c;
                    padding: 20px;
                    color: white;
                    border-radius: 10px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 10px;
                    color: #666;
                }
                .date {
                    text-align: right;
                    margin-bottom: 20px;
                    font-size: 12px;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Reporte de Tareas</h1>
                <p>Sistema de Gestión de Tareas</p>
            </div>
            
            <div class="date">
                Fecha de generación: ' . date('d/m/Y H:i:s') . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipo</th>
                        <th>Responsable</th>
                        <th>Tarea</th>
                        <th>Descripción</th>
                        <th>Fecha Límite</th>
                        <th>Fase</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($tareas as $tarea) {
            $html .= '
                <tr>
                    <td>' . $tarea['id_tareas'] . '</td>
                    <td>' . htmlspecialchars($tarea['equipo']) . '</td>
                    <td>' . htmlspecialchars($tarea['responsable']) . '</td>
                    <td>' . htmlspecialchars($tarea['tarea']) . '</td>
                    <td>' . htmlspecialchars($tarea['descripcion']) . '</td>
                    <td>' . htmlspecialchars($tarea['fecha_limite']) . '</td>
                    <td>' . htmlspecialchars($tarea['fase']) . '</td>
                </tr>';
        }

        $html .= '
                </tbody>
            </table>

            <div class="footer">
                <p>Este reporte fue generado automáticamente.</p>
            </div>
        </body>
        </html>';

        return $html;
    }

public function reporteExcelTareas() {
    try {
        // Obtener tareas
        $resultTareas = $this->tarea->obtenerTareas();
        $tareas = $resultTareas->fetchAll(PDO::FETCH_ASSOC);

        // Preparar los datos para el Excel
        $data = [];

        // Agregar encabezados para tareas
        $data[] = [
            'ID Tarea',
            'Equipo',
            'Responsable',
            'Tarea',
            'Descripción',
            'Fecha Límite',
            'Fase'
        ];

        // Agregar datos de las tareas
        foreach ($tareas as $tarea) {
            $data[] = [
                $tarea['id_tareas'],
                $tarea['equipo'],
                $tarea['responsable'],
                $tarea['tarea'],
                $tarea['descripcion'],
                $tarea['fecha_limite'],
                $tarea['fase']
            ];
        }
        $data[] = ['', '', '', '', '', '', '']; // Fila vacía


        // Generar el Excel
        $xlsx = SimpleXLSXGen::fromArray($data);

        // Establecer el nombre del archivo
        $filename = 'productos_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Descargar el archivo
        $xlsx->downloadAs($filename);
        exit;

    } catch (Exception $e) {
        error_log("Error en exportación Excel: " . $e->getMessage());
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al generar el archivo Excel: ' . $e->getMessage()
        ]);
    }
}
}
?>