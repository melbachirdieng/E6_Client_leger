<div class="container">
  <h2>Véhicules de l'auto-école</h2>
  <p style="color:#666;">Liste complète du parc avec leur état actuel (lecture seule).</p>

  <table class="table-data">
    <thead>
      <tr>
        <th>Photo</th>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Immatriculation</th>
        <th>État</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($lesvehicules as $v): ?>
        <tr>
          <td>
            <?php $img = 'uploads/vehicules/' . $v['image']; ?>
            <?php if (!empty($v['image']) && file_exists($img)): ?>
              <img src="<?= htmlspecialchars($img) ?>" alt="" style="width:80px; height:50px; object-fit:cover; border-radius:4px;">
            <?php else: ?>
              <span style="color:#999;">—</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($v['marque']) ?></td>
          <td><?= htmlspecialchars($v['modele']) ?></td>
          <td><?= htmlspecialchars($v['immatriculation']) ?></td>
          <td>
            <?php
              $etat = $v['etat'];
              $couleur = ($etat === 'Disponible') ? '#2e7d32'
                       : (($etat === 'En réparation') ? '#e65100' : '#c62828');
            ?>
            <span style="color:<?= $couleur ?>; font-weight:600;">
              <?= htmlspecialchars($etat) ?>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
