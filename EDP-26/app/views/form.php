<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reajuste de Imóveis</title>
    <link rel="stylesheet" href="views/styles/resultado.css">
</head>
<body>
    <div class="resultado-container">
        <h1>Reajuste de Preço de Imóvel</h1>

        <?php if (!empty($erros)): ?>
            <div class="erro">
                <strong>Por favor, corrija os seguintes erros:</strong>
                <ul>
                    <?php foreach ($erros as $erro): ?>
                        <li><?= htmlspecialchars($erro); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="imoveis">Lista de Imóveis (JSON):</label>
                <textarea id="imoveis" name="imoveis" rows="10" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required placeholder='[
    {"id": 1, "descricao": "Casa", "preco": 200000, "disponibilidade": "disponivel"},
    {"id": 2, "descricao": "Apto", "preco": 300000, "disponibilidade": "indisponivel"}
]'><?= isset($_POST['imoveis']) ? htmlspecialchars($_POST['imoveis']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="percentual">Percentual de Reajuste (%):</label>
                <input type="number" id="percentual" name="percentual" step="0.01" required 
                       value="<?= isset($_POST['percentual']) ? htmlspecialchars($_POST['percentual']) : '' ?>">
            </div>

            <button type="submit">Calcular Reajuste</button>
        </form>
    </div>
</body>
</html>