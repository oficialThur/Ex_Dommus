<?php

class PlanetaHtmlRenderer {

    public function renderPlaneta(array $planeta): string {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Detalhes do Planeta</title>
            <link rel="stylesheet" href="views/styles.css">
        </head>
        <body>
        <div class="card">
            <h2><?= htmlspecialchars($planeta['name']) ?></h2>
            <p><strong>População:</strong> <?= htmlspecialchars($planeta['population']) ?></p>
            <p><strong>Clima:</strong> <?= htmlspecialchars($planeta['climate']) ?></p>
            <p><strong>Terreno:</strong> <?= htmlspecialchars($planeta['terrain']) ?></p>
            <a href="index.php">Voltar</a>
        </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    public function renderTabela(array $planetas): string {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Lista de Planetas</title>
            <link rel="stylesheet" href="views/styles.css">
        </head>
        <body>
        <div class="card wide">
            <h2>Lista de Planetas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Terreno</th>
                        <th>População</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($planetas as $planeta): ?>
                        <tr>
                            <td><?= htmlspecialchars($planeta['name']) ?></td>
                            <td><?= htmlspecialchars($planeta['terrain']) ?></td>
                            <td><?= htmlspecialchars($planeta['population']) ?></td>
                            <td><a href="index.php?action=buscar&id=<?= $planeta['id'] ?>">Ver</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php">Voltar</a>
        </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}