<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Http\Resources\ImovelResource;
use App\Http\Resources\ImovelCollection;
use App\Contracts\ReajustePrecoInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImovelController extends Controller
{
    private ReajustePrecoInterface $reajusteService;

    public function __construct(ReajustePrecoInterface $reajusteService)
    {
        $this->reajusteService = $reajusteService;
    }

    public function index(Request $request)
    {
        $query = Imovel::query();

        if ($request->has('preco_min')) {
            $query->where('preco', '>=', $request->input('preco_min'));
        }

        if ($request->has('preco_max')) {
            $query->where('preco', '<=', $request->input('preco_max'));
        }

        if ($request->has('disponibilidade')) {
            $query->where('disponibilidade', $request->input('disponibilidade'));
        }

        $perPage = $request->input('per_page', 15);
        $imoveis = $query->paginate($perPage);

        return response()->json(new ImovelCollection($imoveis));
    }

    public function show($id)
    {
        $imovel = Imovel::findOrFail($id);
        return response()->json(new ImovelResource($imovel));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0.01',
            'disponibilidade' => 'required|in:DISPONIVEL,VENDIDO',
        ], [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.max' => 'A descrição não pode exceder 255 caracteres.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um número válido.',
            'preco.min' => 'O preço deve ser maior que 0.',
            'disponibilidade.required' => 'A disponibilidade é obrigatória.',
            'disponibilidade.in' => 'A disponibilidade deve ser DISPONIVEL ou VENDIDO.',
        ]);

        $validated = $request->only(['descricao', 'preco', 'disponibilidade']);
        $validated['ativo'] = true;

        $imovel = Imovel::create($validated);

        return response()->json(
            new ImovelResource($imovel),
            201
        );
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'descricao' => 'sometimes|string|max:255',
            'preco' => 'sometimes|numeric|min:0.01',
            'disponibilidade' => 'sometimes|in:DISPONIVEL,VENDIDO',
        ], [
            'descricao.max' => 'A descrição não pode exceder 255 caracteres.',
            'preco.numeric' => 'O preço deve ser um número válido.',
            'preco.min' => 'O preço deve ser maior que 0.',
            'disponibilidade.in' => 'A disponibilidade deve ser DISPONIVEL ou VENDIDO.',
        ]);

        $imovel = Imovel::findOrFail($id);
        $imovel->update($request->only(['descricao', 'preco', 'disponibilidade']));

        return response()->json(new ImovelResource($imovel));
    }

    public function destroy($id)
    {
        $imovel = Imovel::findOrFail($id);
        
        if ($imovel->disponibilidade !== 'DISPONIVEL') {
            return response()->json([
                'message' => 'Não é possível excluir imóvel que não está DISPONÍVEL'
            ], 422);
        }

        $imovel->softDelete();

        return response()->json(null, 204);
    }

    public function reajusteEmMassa(Request $request)
    {
        $this->validate($request, [
            'percentual' => 'required|numeric|min:0.01|max:100',
        ], [
            'percentual.required' => 'O percentual de reajuste é obrigatório.',
            'percentual.numeric' => 'O percentual deve ser um número válido.',
            'percentual.min' => 'O percentual deve ser maior que 0.',
            'percentual.max' => 'O percentual não pode exceder 100.',
        ]);

        $percentual = $request->input('percentual');

        $query = Imovel::query();

        if ($request->has('preco_min')) {
            $query->where('preco', '>=', $request->input('preco_min'));
        }

        if ($request->has('preco_max')) {
            $query->where('preco', '<=', $request->input('preco_max'));
        }

        if ($request->has('disponibilidade')) {
            $query->where('disponibilidade', $request->input('disponibilidade'));
        }

        $imoveis = $query->get();

        $quantidadeReajustada = $this->reajusteService->aplicarReajuste(
            $imoveis,
            $percentual
        );

        return response()->json([
            'message' => 'Reajuste aplicado com sucesso',
            'quantidade_reajustada' => $quantidadeReajustada
        ]);
    }

    public function exportarCsv()
    {
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Descrição', 'Preço', 'Disponibilidade']);

            foreach (Imovel::cursor() as $imovel) {
                fputcsv($handle, [
                    $imovel->id,
                    $imovel->descricao,
                    number_format($imovel->preco, 2, ',', '.'),
                    $imovel->disponibilidade
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="imoveis.csv"');

        return $response;
    }
}