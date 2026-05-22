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
            <label for="percentual">Percentual de Reajuste (%):</label>
            <div class="form-group">
                <input type="number" id="percentual" name="percentual" step="0.01" required 
                       value="<?= isset($_POST['percentual']) ? htmlspecialchars($_POST['percentual']) : '' ?>">
            </div>

            <button type="submit">Calcular Reajuste</button>
        </form>
    </div>
</body>
</html>