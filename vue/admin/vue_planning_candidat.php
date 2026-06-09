<div class="section">
    <h1 class="section-title">Mon Planning</h1>
    <p style="color: var(--text-medium); font-size: 1.1rem; margin-bottom: 30px;">
        Bonjour <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?>
    </p>

    <?php if(!empty($lescours) && is_array($lescours)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Horaire</th>
                        <th>Moniteur</th>
                        <th>Véhicule</th>
                        <th>Immatriculation</th>
                        <th>Statut</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lescours as $cours): ?>
                        <tr>
                            <td>
                                <strong><?= date('d/m/Y', strtotime($cours['date_cours'])) ?></strong>
                            </td>
                            <td>
                                <?= substr($cours['heure_debut'], 0, 5) ?> - <?= substr($cours['heure_fin'], 0, 5) ?>
                            </td>
                            <td><?= htmlspecialchars($cours['nom_moniteur']) ?></td>
                            <td><?= htmlspecialchars($cours['modele_vehicule']) ?></td>
                            <td>
                                <span class="vehicle-plate" style="font-size: 0.85rem;">
                                    <?= htmlspecialchars($cours['immatriculation']) ?>
                                </span>
                            </td>
                            <td>
                            <?php if ($cours['statut'] == 'Effectué'): ?>
                                <span class="badge" style="background: #7bb27d; color: white;">Effectué</span>
                            <?php else: ?>
                                <span class="badge" style="background: #e78a6d; color: white;">À venir</span>
                            <?php endif; ?>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 60px; background: var(--bg-light);">
            <h3 style="color: var(--text-medium); margin-bottom: 20px;">Aucune leçon planifiée</h3>
            <p style="color: var(--text-medium);">
                Vos prochaines leçons apparaîtront ici une fois qu'elles seront planifiées par notre équipe.
            </p>
        </div>
    <?php endif; ?>

    <div class="card" style="margin-top: 30px; background: var(--bg-light); border-left-color: var(--accent-salmon);">
        <h3>Informations importantes</h3>
        <ul style="margin-top: 15px; padding-left: 20px; color: var(--text-medium); line-height: 2;">
            <li>Merci de vous présenter 10 minutes avant l'heure de votre leçon</li>
            <li>N'oubliez pas votre pièce d'identité et votre livret d'apprentissage</li>
            <li>En cas d'empêchement, prévenez-nous au moins 48h à l'avance</li>
            <li>Pour toute question, contactez-nous au 04 XX XX XX XX</li>
        </ul>
    </div>
</div>