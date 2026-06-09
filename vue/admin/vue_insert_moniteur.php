<?php
function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>

<div class="form-card">
    <h3 class="admin-title"><?php echo (isset($leMoniteur) && $leMoniteur != null) ? "Modification" : "Ajout"; ?> d'un Moniteur</h3>
    
    <form method="post" class="elite-form">
        <div class="form-grid">
            <div class="input-group">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo ($leMoniteur != null) ? htmlspecialchars($leMoniteur['nom']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?php echo ($leMoniteur != null) ? htmlspecialchars($leMoniteur['prenom']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Email (pour connexion)</label>
                <input type="email" name="email" value="<?php echo ($leMoniteur != null) ? htmlspecialchars($leMoniteur['email']) : ''; ?>" required>
            </div>
            
            <!-- AJOUT: Champ mot de passe -->
            <?php if (!isset($leMoniteur) || $leMoniteur == null): ?>
                <div class="input-group">
                    <label>Mot de passe *</label>
                    <input type="password" name="mdp" required minlength="8" maxlength="100" placeholder="Mot de passe initial">
                    <small style="color: #666; display: block; margin-top: 4px;">Min. 8 caractères, une majuscule, un chiffre, sans espaces.</small>
                </div>
            <?php else: ?>
                <div class="input-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="mdp" minlength="8" maxlength="100" placeholder="Laisser vide si inchangé">
                    <small style="color: #666; display: block; margin-top: 4px;">Min. 8 caractères, une majuscule, un chiffre, sans espaces.</small>
                </div>
            <?php endif; ?>
            
            <div class="input-group">
                <label>Téléphone</label>
                <input type="text" name="tel" value="<?php echo ($leMoniteur != null) ? htmlspecialchars($leMoniteur['tel']) : ''; ?>">
            </div>
            <div class="input-group full">
                <label>Adresse</label>
                <input type="text" name="adresse" value="<?php echo ($leMoniteur != null) ? htmlspecialchars($leMoniteur['adresse']) : ''; ?>">
            </div>
            <div class="input-group">
                <label>Expérience (années)</label>
                <input type="number" name="experience" value="<?php echo ($leMoniteur != null) ? $leMoniteur['experience'] : ''; ?>">
            </div>
            <div class="input-group">
                <label>Type de permis</label>
                <select name="type_permis">
                    <option value="B" <?php echo ($leMoniteur != null && $leMoniteur['type_permis'] == 'B') ? 'selected' : ''; ?>>B (Voiture)</option>
                    <option value="A" <?php echo ($leMoniteur != null && $leMoniteur['type_permis'] == 'A') ? 'selected' : ''; ?>>A (Moto)</option>
                    <option value="B+A" <?php echo ($leMoniteur != null && $leMoniteur['type_permis'] == 'B+A') ? 'selected' : ''; ?>>B + A</option>
                </select>
            </div>
        </div>

        <div class="form-btns">
            <?php if (isset($leMoniteur) && $leMoniteur != null): ?>
                <input type="hidden" name="idmoniteur" value="<?php echo $leMoniteur['idmoniteur']; ?>">
                <input type="submit" name="ModifierMoniteur" value="Enregistrer les modifications" class="btn-primary">
            <?php else: ?>
                <input type="submit" name="valider_moniteur" value="Valider l'ajout" class="btn-primary">
            <?php endif; ?>
        </div>
    </form>
</div>