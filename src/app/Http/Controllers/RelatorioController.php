<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class RelatorioController extends Controller
{
    public function index()
    {
        // Use view from structure.sql
        $rawData = DB::table('vw_livros_autores_assuntos')
            ->orderBy('titulo')
            ->get();
        
        $dados = $this->aggregateReportData($rawData);
        
        return view('relatorio.index', compact('dados'));
    }

    public function gerar(Request $request)
    {
        // Use view from structure.sql and aggregate
        $rawData = DB::table('vw_livros_autores_assuntos')
            ->orderBy('titulo')
            ->get();
        
        $dados = $this->aggregateReportData($rawData);
        $html = view('relatorio.pdf', compact('dados'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('relatorio_livros.pdf', ['Attachment' => false]);
    }

    /**
     * Export data as XML for ReportViewer Remote Data Processing
     */
    public function exportXml()
    {
        $rawData = DB::table('vw_livros_autores_assuntos')
            ->orderBy('titulo')
            ->get();
        
        $dados = $this->aggregateReportData($rawData);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<ReportData>' . PHP_EOL;
        $xml .= '  <Livros>' . PHP_EOL;

        foreach ($dados as $livro) {
            $xml .= '    <Livro>' . PHP_EOL;
            $xml .= '      <Id>' . htmlspecialchars($livro->livro_id) . '</Id>' . PHP_EOL;
            $xml .= '      <Titulo>' . htmlspecialchars($livro->livro_titulo) . '</Titulo>' . PHP_EOL;
            $xml .= '      <Editora>' . htmlspecialchars($livro->livro_editora ?? '') . '</Editora>' . PHP_EOL;
            $xml .= '      <Edicao>' . htmlspecialchars($livro->livro_edicao ?? '') . '</Edicao>' . PHP_EOL;
            $xml .= '      <Ano>' . htmlspecialchars($livro->livro_ano ?? '') . '</Ano>' . PHP_EOL;
            $xml .= '      <Valor>' . htmlspecialchars($livro->livro_valor) . '</Valor>' . PHP_EOL;
            $xml .= '      <Autores>' . htmlspecialchars($livro->autores ?? 'Sem autores') . '</Autores>' . PHP_EOL;
            $xml .= '      <Assuntos>' . htmlspecialchars($livro->assuntos ?? 'Sem assuntos') . '</Assuntos>' . PHP_EOL;
            $xml .= '    </Livro>' . PHP_EOL;
        }

        $xml .= '  </Livros>' . PHP_EOL;
        $xml .= '</ReportData>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Content-Disposition', 'inline; filename="relatorio_livros.xml"');
    }

    /**
     * Export data as JSON for JavaScript-based report viewers
     */
    public function exportJson()
    {
        $rawData = DB::table('vw_livros_autores_assuntos')
            ->orderBy('titulo')
            ->get();
        
        $dados = $this->aggregateReportData($rawData)->map(function ($livro) {
            return [
                'id' => $livro->livro_id,
                'titulo' => $livro->livro_titulo,
                'editora' => $livro->livro_editora ?? '',
                'edicao' => $livro->livro_edicao ?? '',
                'ano' => $livro->livro_ano ?? '',
                'valor' => (float) $livro->livro_valor,
                'autores' => $livro->autores ?? 'Sem autores',
                'assuntos' => $livro->assuntos ?? 'Sem assuntos',
            ];
        });

        return response()->json([
            'data' => $dados,
            'total' => $dados->count(),
            'generated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Aggregate report data from vw_livros_autores_assuntos view
     * Uses view from structure.sql
     */
    private function aggregateReportData($rawData)
    {
        return $rawData->groupBy('livro_id')->map(function ($items) {
            $first = $items->first();
            return (object) [
                'livro_id' => $first->livro_id,
                'livro_titulo' => $first->titulo,
                'livro_editora' => $first->editora,
                'livro_edicao' => $first->edicao,
                'livro_ano' => $first->anopublicacao,
                'livro_valor' => $first->valor,
                'autores' => $items->pluck('autor')->filter()->unique()->sort()->implode(', '),
                'assuntos' => $items->pluck('assunto')->filter()->unique()->sort()->implode(', '),
            ];
        })->values();
    }
}
