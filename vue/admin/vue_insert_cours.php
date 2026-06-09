<?php
function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>

<div class="form-card">
    <h3 class="admin-title"><?php echo (isset($leCours) && $leCours != null) ? "Modification" : "Planifier"; ?> un Cours</h3>
    
    <form method="post" class="elite-form">
        <div class="form-grid">
            <div class="input-group">
                <label>Date du cours</label>
                <input type="date" name="date_cours" value="<?php echo ($leCours != null) ? $leCours['date_cours'] : ''; ?>" required>
            </div>
            
            <div class="input-group">
                <label>Heure début</label>
                <input type="time" name="heure_debut" value="<?php echo ($leCours != null) ? $leCours['heure_debut'] : ''; ?>" required>
            </div>
            
            <div class="input-group">
                <label>Heure fin</label>
                <input type="time" name="heure_fin" value="<?php echo ($leCours != null) ? $leCours['heure_fin'] : ''; ?>" required>
            </div>

            <!-- AJOUT: Sélection statut -->
            <div class="input-group">
                <label>Statut</label>
                <select name="statut" required>
                    <option value="À venir" <?php echo ($leCours != null && $leCours['statut'] == 'À venir') ? 'selected' : ''; ?>>À venir</option>
                    <option value="Effectué" <?php echo ($leCours != null && $leCours['statut'] == 'Effectué') ? 'selected' : ''; ?>>Effectué</option>
                </select>
            </div>
            
            <div class="input-group">
                <label>Candidat</label>
                <select name="idcandidat" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach($lescandidats as $cand): ?>
                        <option value="<?= $cand['idcandidat'] ?>" 
                            <?php echo ($leCours != null && $leCours['idcandidat'] == $cand['idcandidat']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($cand['nom']) ?> <?= htmlspecialchars($cand['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group">
                <label>Moniteur</label>
                <select name="idmoniteur" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach($lesmoniteurs as $mon): ?>
                        <option value="<?= $mon['idmoniteur'] ?>" 
                            <?php echo ($leCours != null && $leCours['idmoniteur'] == $mon['idmoniteur']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($mon['nom']) ?> <?= htmlspecialchars($mon['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group">
                <label>Véhicule</label>
                <select name="idvehicule" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach($lesvehicules as $veh): ?>
                        <option value="<?= $veh['idvehicule'] ?>" 
                            <?php echo ($leCours != null && $leCours['idvehicule'] == $veh['idvehicule']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($veh['marque']) ?> <?= htmlspecialchars($veh['modele']) ?> (<?= $veh['immatriculation'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-btns">
            <?php if (isset($leCours) && $leCours != null): ?>
                <input type="hidden" name="idcours" value="<?php echo $leCours['idcours']; ?>">
                <input type="submit" name="ModifierCours" value="Enregistrer les modifications" class="btn-primary">
            <?php else: ?>
                <input type="submit" name="planifier" value="Planifier le cours" class="btn-primary">
            <?php endif; ?>
        </div>
    </form>
</div>