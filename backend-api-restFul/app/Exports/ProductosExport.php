<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    // Retorna los productos para ser exportados
    public function collection()
    {
        return Producto::all();  // Obtén todos los productos de la base de datos
    }

    // Define los encabezados de las columnas
    public function headings(): array
    {
        return [
            'ID', 'Nombre', 'Precio', 'Descripción', 'image_url', 'Fecha de Creación', 'Fecha de Actualización'
        ];
    }

    // Mapea los datos a las columnas
    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->nombre,
            $producto->precio,
            $producto->descripcion,
            $producto->image_url ? 'Imagen' : 'No disponible',  // Solo mostrar texto en la celda de imagen
            $producto->created_at ? $producto->created_at->format('Y-m-d H:i:s') : 'N/A',
            $producto->updated_at ? $producto->updated_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }

    

    // Método que se llama después de que la hoja ha sido creada
    public function afterSheet($event)
    {
        $sheet = $event->sheet;
        $row = 2; // Comienza desde la fila 2 (después de los encabezados)

        // Aplicar estilo general para las celdas
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Estilo para las celdas de datos
        $sheet->getStyle('A2:G' . (count($this->collection()) + 1))->applyFromArray([
            'font' => [
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'A9A9A9'],
                ],
            ],
        ]);

        // Ajustar el tamaño de las columnas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        // Agregar imágenes en las celdas correspondientes
        foreach ($this->collection() as $index => $producto) {
            if ($producto->image_url) {
                $imagePath = public_path('storage/' . $producto->image_url);


                if (file_exists($imagePath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Imagen de Producto');
                    $drawing->setDescription('Imagen de ' . $producto->nombre);
                    $drawing->setPath($imagePath); // Ruta de la imagen
                    $drawing->setHeight(50); // Ajustar altura de la imagen
                    $drawing->setWidth(50);  // Ajustar anchura de la imagen
                    $drawing->setCoordinates('E' . ($index + 2)); // Establecer la celda de la imagen
                    $drawing->setWorksheet($sheet);
                }
            }
        }
    }
}
