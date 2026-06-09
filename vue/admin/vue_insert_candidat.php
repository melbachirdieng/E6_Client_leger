<?php
function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>

<div class="form-card">
    <h3 class="admin-title"><?php echo (isset($leCandidat) && $leCandidat != null) ? "Modification" : "Ajout"; ?> d'un Candidat</h3>
    
    <form method="post" class="elite-form">
        <div class="form-grid">
            <div class="input-group">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo ($leCandidat != null) ? htmlspecialchars($leCandidat['nom']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?php echo ($leCandidat != null) ? htmlspecialchars($leCandidat['prenom']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo ($leCandidat != null) ? htmlspecialchars($leCandidat['email']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Téléphone</label>
                <input type="text" name="tel" value="<?php echo ($leCandidat != null) ? htmlspecialchars($leCandidat['tel']) : ''; ?>">
            </div>
            
            <!-- AJOUT: Champ mot de passe -->
            <?php if (!isset($leCandidat) || $leCandidat == null): ?>
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
            
            <div class="input-group full">
                <label>Adresse</label>
                <input type="text" name="adresse" value="<?php echo ($leCandidat != null) ? h($leCandidat['adresse'] ?? '') : ''; ?>">
            </div>
            <div class="input-group">
                <label>Étudiant ?</label>
                <select name="est_etudiant">
                    <option value="0" <?php echo ($leCandidat != null && $leCandidat['est_etudiant'] == 0) ? 'selected' : ''; ?>>Non</option>
                    <option value="1" <?php echo ($leCandidat != null && $leCandidat['est_etudiant'] == 1) ? 'selected' : ''; ?>>Oui</option>
                </select>
            </div>
            <div class="input-group">
                <label>École</label>
                <input type="text" name="nom_ecole" value="<?php echo ($leCandidat != null) ? h($leCandidat['nom_ecole'] ?? '') : ''; ?>">
            </div>
            <div class="input-group">
                <label>Date Prévue Code</label>
                <input type="date" name="date_code" value="<?php echo ($leCandidat != null) ? $leCandidat['date_prevue_code'] : ''; ?>">
            </div>
            <div class="input-group">
                <label>Date Prévue Permis</label>
                <input type="date" name="date_permis" value="<?php echo ($leCandidat != null) ? $leCandidat['date_prevue_permis'] : ''; ?>">
            </div>
        </div>

        <div class="form-btns">
            <?php if (isset($leCandidat) && $leCandidat != null): ?>
                <input type="hidden" name="idcandidat" value="<?php echo $leCandidat['idcandidat']; ?>">
                <input type="submit" name="Modifier" value="Enregistrer les modifications" class="btn-primary">
            <?php else: ?>
                <input type="submit" name="valider" value="Valider l'ajout" class="btn-primary">
            <?php endif; ?>
        </div>
    </form>
</div>