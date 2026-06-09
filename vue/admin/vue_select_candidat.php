<div class="admin-container">
    <h3  class ="admin-title"style="margin-bottom:20px; text-transform:uppercase; letter-spacing:2px;">
        Gestion des Candidats
    </h3>
    
    <table class="elite-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>PRÉNOM</th>
                <th>EMAIL</th>
                <th>TÉL</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lescandidats) && is_array($lescandidats)): ?>
                <?php foreach ($lescandidats as $unCandidat): ?>
                    <tr>
                        <td><span class="badge"><?= $unCandidat['idcandidat'] ?></span></td>
                        <td><?= htmlspecialchars($unCandidat['nom']) ?></td>
                        <td><?= htmlspecialchars($unCandidat['prenom']) ?></td>
                        <td><?= htmlspecialchars($unCandidat['email']) ?></td>
                        <td><?= htmlspecialchars($unCandidat['tel']) ?></td>
                        <td style="text-align:center;">
                            <a href="index.php?page=5&action=edit&idcandidat=<?= $unCandidat['idcandidat'] ?>">
                                <img src="image/modifier.png" height="20" title="Modifier">
                            </a>
                            <a href="index.php?page=5&action=sup&idcandidat=<?= $unCandidat['idcandidat'] ?>" onclick="return confirm('Supprimer ce candidat ?');" style="margin-left:15px;">
                                <img src="image/supprimer.png" height="20" title="Supprimer">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; color:#666; padding:30px;">
                        Aucun candidat enregistré dans la base de données.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>