<div class="admin-container">
    <h3 class="admin-title">Planning des Cours</h3>
    
    <table class="elite-table">
        <thead>
            <tr>
                <th>DATE</th>
                <th>HORAIRE</th>
                <th>CANDIDAT</th>
                <th>MONITEUR</th>
                <th>VÉHICULE</th>
                <th>STATUT</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lescours) && is_array($lescours)): ?>
                <?php foreach ($lescours as $unCours): ?>
                    <tr>
                        <td><strong><?= date('d/m/Y', strtotime($unCours['date_cours'])) ?></strong></td>
                        <td><?= substr($unCours['heure_debut'], 0, 5) ?> - <?= substr($unCours['heure_fin'], 0, 5) ?></td>
                        <td><?= htmlspecialchars($unCours['nom_candidat']) ?> <?= htmlspecialchars($unCours['prenom_candidat']) ?></td>
                        <td><?= htmlspecialchars($unCours['nom_moniteur']) ?> <?= htmlspecialchars($unCours['prenom_moniteur']) ?></td>
                        <td><?= htmlspecialchars($unCours['modele_vehicule']) ?> <span class="badge"><?= $unCours['immatriculation'] ?></span></td>
                        <td>
                            <?php if ($unCours['statut'] == 'Effectué'): ?>
                                <span class="badge" style="background: #7bb27d; color: white;">Effectué</span>
                            <?php else: ?>
                                <span class="badge" style="background: #e78a6d; color: white;">À venir</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <a href="index.php?page=8&action=editCours&idcours=<?= $unCours['idcours'] ?>">
                                <img src="image/modifier.png" height="20" title="Modifier">
                            </a>
                            <a href="index.php?page=8&action=supCours&idcours=<?= $unCours['idcours'] ?>" onclick="return confirm('Supprimer ce cours ?');" style="margin-left:15px;">
                                <img src="image/supprimer.png" height="20" title="Supprimer">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center; color:#666; padding:30px;">
                        Aucun cours planifié dans la base de données.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>