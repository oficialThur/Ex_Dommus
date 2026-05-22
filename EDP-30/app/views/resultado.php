<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Reajuste</title>
    <link rel="stylesheet" href="views/styles/resultado.css">
</head>
<body>
    <div class="resultado-container">
        <h1>Resultado do Reajuste de Imóvel</h1>

        <div class="sucesso">
            <strong>Reajuste realizado com sucesso!</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Preço Original</th>
                    <th>Preço Reajustado</th>
                    <th>Diferença</th>
                    <th>Disponibilidade</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($itens)): ?>
                    <?php foreach ($itens as $imovel): ?>
                    <tr>
                        <td><?= htmlspecialchars($imovel->getId()); ?></td>
                        <td><?= htmlspecialchars($imovel->getDescricao()); ?></td>
                        <td class="preco-original">R$ <?= number_format($imovel->getPrecoOriginal(), 2, ',', '.'); ?></td>
                        <td class="preco-novo">R$ <?= number_format($imovel->getPreco(), 2, ',', '.'); ?></td>
                        <td class="diferenca">R$ <?= number_format($imovel->getPreco() - $imovel->getPrecoOriginal(), 2, ',', '.'); ?></td>
                        <td><?= htmlspecialchars($imovel->getDisponibilidade()); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Nenhum imóvel processado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="botoes">
            <a href="index.php" class="voltar">← Voltar ao Formulário</a>
            <button onclick="window.print()">Imprimir</button>
        </div>
    </div>
</body>
</html>