<div class="admin-container">
    <h3 class="admin-title">Mon Planning Moniteur</h3>
    <p style="margin-bottom: 20px;">
        Bonjour <strong><?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?></strong>
    </p>

    <table class="elite-table">
        <thead>
            <tr>
                <th>DATE</th>
                <th>HORAIRE</th>
                <th>ÉLÈVE</th>
                <th>TÉLÉPHONE</th>
                <th>VÉHICULE</th>
                <th>STATUT</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lescours)): ?>
                <?php foreach ($lescours as $cours): ?>
                    <tr>
                        <td><strong><?= date('d/m/Y', strtotime($cours['date_cours'])) ?></strong></td>
                        <td><?= substr($cours['heure_debut'], 0, 5) ?> - <?= substr($cours['heure_fin'], 0, 5) ?></td>
                        <td><?= htmlspecialchars($cours['nom_candidat']) ?></td>
                        <td><?= htmlspecialchars($cours['tel_candidat']) ?></td>
                        <td><?= htmlspecialchars($cours['modele_vehicule']) ?> <span class="badge"><?= htmlspecialchars($cours['immatriculation']) ?></span></td>
                        <td>
                            <?php
                                $statut = $cours['statut'];
                                $bg = ($statut === 'Effectué') ? '#7bb27d'
                                    : (($statut === 'Annulé') ? '#999' : '#e78a6d');
                            ?>
                            <span class="badge" style="background: <?= $bg ?>; color: white;">
                                <?= htmlspecialchars($statut) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($cours['statut'] === 'À venir'): ?>
                                <form method="POST" action="index.php" style="display:inline;">
                                    <input type="hidden" name="idcours" value="<?= (int)$cours['idcours'] ?>">
                                    <button type="submit" name="action_cours" value="valider"
                                            class="btn-action" style="background:#2e7d32; color:white;">
                                        Valider
                                    </button>
                                </form>
                                <form method="POST" action="index.php" style="display:inline;"
                                      onsubmit="return confirm('Annuler ce cours ? (Le candidat devra reprendre RDV)');">
                                    <input type="hidden" name="idcours" value="<?= (int)$cours['idcours'] ?>">
                                    <button type="submit" name="action_cours" value="annuler"
                                            class="btn-action" style="background:#c62828; color:white;">
                                        Annuler
                                    </button>
                                </form>
                            <?php else: ?>
                                <span style="color:#999;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                        Aucun cours planifié pour le moment.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>