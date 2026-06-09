<div class="container">
  <h2>Mes candidats</h2>
  <p style="color:#666;">Liste des candidats que vous encadrez ou avez encadrés.</p>

  <?php if (empty($lescandidats)): ?>
    <p>Vous n'avez aucun candidat assigné pour le moment.</p>
  <?php else: ?>
    <table class="table-data">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Cours à venir</th>
          <th>Cours effectués</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lescandidats as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['nom']) ?></td>
            <td><?= htmlspecialchars($c['prenom']) ?></td>
            <td><?= htmlspecialchars($c['email']) ?></td>
            <td><?= htmlspecialchars($c['tel'] ?? '—') ?></td>
            <td><?= (int)$c['nb_a_venir'] ?></td>
            <td><?= (int)$c['nb_effectues'] ?></td>
            <td><strong><?= (int)$c['nb_cours'] ?></strong></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
