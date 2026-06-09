<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
  <h2 style="color: var(--primary-blue); margin-bottom: 8px;">Mon profil</h2>
  <p style="color: #666; margin-bottom: 25px;">
    Consultez vos informations personnelles. Cliquez sur « Modifier » pour les changer.
  </p>

  <!-- ====== VUE LECTURE (par défaut) ====== -->
  <div id="bloc-lecture" class="form-card">
    <div class="form-grid">
      <div>
        <div style="font-size:0.85rem; color:#666; margin-bottom:4px;">NOM</div>
        <div style="font-size:1.1rem; font-weight:600;"><?= htmlspecialchars($monProfil['nom'] ?? '—') ?></div>
      </div>
      <div>
        <div style="font-size:0.85rem; color:#666; margin-bottom:4px;">PRÉNOM</div>
        <div style="font-size:1.1rem; font-weight:600;"><?= htmlspecialchars($monProfil['prenom'] ?? '—') ?></div>
      </div>
    </div>

    <div style="margin-top:20px;">
      <div style="font-size:0.85rem; color:#666; margin-bottom:4px;">EMAIL</div>
      <div style="font-size:1.1rem; font-weight:600;"><?= htmlspecialchars($monProfil['email'] ?? '—') ?></div>
    </div>

    <div class="form-grid" style="margin-top:20px;">
      <div>
        <div style="font-size:0.85rem; color:#666; margin-bottom:4px;">TÉLÉPHONE</div>
        <div style="font-size:1.1rem; font-weight:600;">
          <?= !empty($monProfil['tel']) ? htmlspecialchars($monProfil['tel']) : '<span style="color:#999; font-weight:400;">Non renseigné</span>' ?>
        </div>
      </div>
      <div>
        <div style="font-size:0.85rem; color:#666; margin-bottom:4px;">ADRESSE</div>
        <div style="font-size:1.1rem; font-weight:600;">
          <?= !empty($monProfil['adresse']) ? htmlspecialchars($monProfil['adresse']) : '<span style="color:#999; font-weight:400;">Non renseignée</span>' ?>
        </div>
      </div>
    </div>

    <div style="margin-top:25px; text-align:center;">
      <button type="button" onclick="basculerEditionProfil(true)"
              class="btn btn-primary" style="padding: 10px 30px;">
        Modifier mes informations
      </button>
    </div>
  </div>

  <!-- ====== VUE ÉDITION (cachée par défaut) ====== -->
  <form id="bloc-edit" method="POST" action="index.php?page=53" class="form-card" style="display:none;">
    <div class="form-grid">
      <div>
        <label style="display:block; font-weight:600; margin-bottom:6px;">Nom *</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($monProfil['nom'] ?? '') ?>" required
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
      </div>
      <div>
        <label style="display:block; font-weight:600; margin-bottom:6px;">Prénom *</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($monProfil['prenom'] ?? '') ?>" required
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
      </div>
    </div>

    <div style="margin-top:15px;">
      <label style="display:block; font-weight:600; margin-bottom:6px;">Email *</label>
      <input type="email" name="email" value="<?= htmlspecialchars($monProfil['email'] ?? '') ?>" required
             style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
    </div>

    <div class="form-grid" style="margin-top:15px;">
      <div>
        <label style="display:block; font-weight:600; margin-bottom:6px;">Téléphone</label>
        <input type="tel" name="tel" value="<?= htmlspecialchars($monProfil['tel'] ?? '') ?>"
               placeholder="06 12 34 56 78"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
      </div>
      <div>
        <label style="display:block; font-weight:600; margin-bottom:6px;">Adresse</label>
        <input type="text" name="adresse" value="<?= htmlspecialchars($monProfil['adresse'] ?? '') ?>"
               placeholder="N° rue, ville"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
      </div>
    </div>

    <div style="margin-top:25px; text-align:center; display:flex; gap:15px; justify-content:center;">
      <button type="button" onclick="basculerEditionProfil(false)"
              class="btn btn-outline" style="padding: 10px 30px;">Annuler</button>
      <button type="submit" name="Modifier_mon_profil"
              class="btn btn-primary" style="padding: 10px 30px;">Enregistrer</button>
    </div>
  </form>
</div>

<script>
function basculerEditionProfil(editer) {
    document.getElementById('bloc-lecture').style.display = editer ? 'none'  : 'block';
    document.getElementById('bloc-edit').style.display    = editer ? 'block' : 'none';
}
</script>
