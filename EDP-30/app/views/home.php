<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar Planeta</title>
    <link rel="stylesheet" href="views/styles.css">
</head>
<body>
    <div class="card">
    <?php if(isset($erro)): ?>
        <p class="error"><?= $erro ?></p>
    <?php endif; ?>
    <form action="index.php" method="GET">
        <input type="hidden" name="action" value="buscar">
        <label><strong>Digite o ID do Planeta:</strong></label>
        <input type="number" name="id" required>
        <button type="submit">Buscar</button>
    </form>
    <div style="margin-top: 15px;">
        <a href="index.php?action=listar">Ver todos os planetas</a>
    </div>
    </div>
</body>
</html>