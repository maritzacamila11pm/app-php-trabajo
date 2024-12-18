<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

use Shuchkin\SimpleXLSXGen;

class ReporteTdController {
    private $tipoDocumento;
    private $db;

    public function __construct() {
        // Aquí iría la conexión con la base de datos
        $database = new Database();
        $this->db = $database->connect();
        $this->tipoDocumento = new TipoDocumento($this->db);
    }

    public function reportetdPdf() {
        try {
            // Obtener los tipos de documentos
            $result = $this->tipoDocumento->obtenerTipoDocumento();
            $tiposDocumento = $result->fetchAll(PDO::FETCH_ASSOC);

            // Configurar DOMPDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            // Crear instancia de DOMPDF
            $dompdf = new Dompdf($options);

            // Preparar el HTML
            $html = $this->generatePDFTemplate($tiposDocumento);

            // Cargar HTML
            $dompdf->loadHtml($html);

            // Configurar papel y orientación
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar PDF
            $dompdf->render();

            // Nombre del archivo
            $filename = 'tipos_documento_' . date('Y-m-d_H-i-s') . '.pdf';

            // Enviar al navegador
            $dompdf->stream($filename, array('Attachment' => false));

        } catch (Exception $e) {
            echo "Error al generar PDF: " . $e->getMessage();
        }
    }

    private function generatePDFTemplate($tiposDocumento) {
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Tipos de Documento</title>
            <style>
                 <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Tipos de Documento</title>
            <style>
                body {
                    font-family: "Verdana", sans-serif;
                    font-size: 14px;
                    background-color: #f4f7f9;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .header {
                    text-align: center;
                    margin-bottom: 40px;
                    background-color:rgb(255, 21, 0);
                    padding: 20px;
                    color: #fff;
                    border-radius: 8px;
                }
                .header h1 {
                    font-size: 28px;
                    margin: 0;
                }
                .header p {
                    font-size: 16px;
                    margin-top: 10px;
                }
                .date {
                    text-align: right;
                    margin-bottom: 30px;
                    font-size: 12px;
                    color: #555;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    background-color: #fff;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }
                th, td {
                    padding: 12px 15px;
                    text-align: left;
                    font-size: 14px;
                }
                th {
                    background-color:rgb(255, 0, 0);
                    color: #fff;
                    font-weight: bold;
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:nth-child(odd) {
                    background-color: #fff;
                }
                td {
                    border-bottom: 1px solid #ddd;
                }
                td:last-child {
                    text-align: center;
                }
                .footer {
                    text-align: center;
                    margin-top: 50px;
                    font-size: 12px;
                    color: #999;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Reporte de Tipos de Documento</h1>
                <p>Sistema de Gestión de Tipos de Documento</p>
            </div>
            
            <div class="date">
                Fecha de generación: ' . date('d/m/Y H:i:s') . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($tiposDocumento as $tipoDocumento) {
            $html .= '
                <tr>
                    <td>' . $tipoDocumento['id_tipo_documento'] . '</td>
                    <td>' . htmlspecialchars($tipoDocumento['nombre']) . '</td>
                    <td>' . htmlspecialchars($tipoDocumento['descripcion']) . '</td>
                    <td>' . ($tipoDocumento['esta_activo'] == 1 ? 'Activo' : 'Inactivo') . '</td>
                </tr>';
        }

        $html .= '
                </tbody>
            </table>

            <div class="footer">
                <p>Este reporte fue generado automáticamente.</p>
                <p>Página 1 de 1</p>
            </div>
        </body>
        </html>';

        return $html;
    }

    public function reporteExcelTipoDocumento() {
        try {
            // Obtener tipos de documento
            $resultTipoDocumento = $this->tipoDocumento->obtenerTipoDocumento();
            $tiposDocumento = $resultTipoDocumento->fetchAll(PDO::FETCH_ASSOC);

            // Preparar los datos para el Excel
            $data = [];

            // Agregar encabezados para tipos de documento
            $data[] = [
                'ID Tipo Documento',
                'Nombre',
                'Descripción'
            ];

            // Agregar datos de tipo de documento
            foreach ($tiposDocumento as $tipoDocumento) {
                $data[] = [
                    $tipoDocumento['id_tipo_documento'],
                    $tipoDocumento['nombre'],
                    $tipoDocumento['descripcion']
                ];
            }

            // Generar el Excel para tipos de documento
            $xlsx = SimpleXLSXGen::fromArray($data);

            // Establecer el nombre del archivo para tipos de documento
            $filename = 'reporte_tipo_documento_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Descargar el archivo de tipos de documento
            $xlsx->downloadAs($filename);
            exit;

        } catch (Exception $e) {
            error_log("Error en exportación Excel Tipo Documento: " . $e->getMessage());

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al generar el archivo Excel de Tipo Documento: ' . $e->getMessage()
            ]);
        }
    }
}
?>
