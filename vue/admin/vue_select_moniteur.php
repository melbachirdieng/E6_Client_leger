<div class="admin-container">
    <h3 class="admin-title" style="color; margin-bottom:20px; text-transform:uppercase; letter-spacing:2px;">
        Gestion des Moniteurs
    </h3>

    <table class="elite-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>PRÉNOM</th>
                <th>TÉL</th>
                <th>ACTIONS</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($lesmoniteurs) && is_array($lesmoniteurs)): ?>
                <?php foreach ($lesmoniteurs as $unMoniteur): ?>
                    <tr>
                        <td>
                            <span class="badge">
                                <?= $unMoniteur['idmoniteur'] ?>
                            </span>
                        </td>

                        <td><?= htmlspecialchars($unMoniteur['nom']) ?></td>
                        <td><?= htmlspecialchars($unMoniteur['prenom']) ?></td>
                        <td><?= htmlspecialchars($unMoniteur['tel']) ?></td>

                        <td style="text-align:center;">
                            <a href="index.php?page=6&action=editMoniteur&idmoniteur=<?= $unMoniteur['idmoniteur'] ?>">
                                <img src="image/modifier.png" height="20" title="Modifier">
                            </a>
                            <a href="index.php?page=6&action=supMoniteur&idmoniteur=<?= $unMoniteur['idmoniteur'] ?>" onclick="return confirm('Supprimer ce moniteur ?');" style="margin-left:15px;">
                                <img src="image/supprimer.png" height="20" title="Supprimer">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; color:#666; padding:30px;">
                        Aucun moniteur enregistré dans la base de données.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
