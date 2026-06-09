<div class="form-card">
    <h3 class="admin-title"><?php echo (isset($leVehicule) && $leVehicule != null) ? "Modification" : "Ajout"; ?> d'un Véhicule</h3>
    
    <form method="post" class="elite-form" enctype="multipart/form-data">
        <div class="form-grid">
            <div class="input-group">
                <label>Marque *</label>
                <input type="text" name="marque" value="<?php echo ($leVehicule != null) ? htmlspecialchars($leVehicule['marque']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Modèle *</label>
                <input type="text" name="modele" value="<?php echo ($leVehicule != null) ? htmlspecialchars($leVehicule['modele']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>Immatriculation *</label>
                <input type="text" name="immatriculation" value="<?php echo ($leVehicule != null) ? htmlspecialchars($leVehicule['immatriculation']) : ''; ?>" required placeholder="AA-123-BB">
            </div>
            
            <div class="input-group">
                <label>État *</label>
                <select name="etat" required>
                    <option value="Disponible" <?php echo ($leVehicule != null && $leVehicule['etat'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                    <option value="En réparation" <?php echo ($leVehicule != null && $leVehicule['etat'] == 'En réparation') ? 'selected' : ''; ?>>En réparation</option>
                    <option value="Indisponible" <?php echo ($leVehicule != null && $leVehicule['etat'] == 'Indisponible') ? 'selected' : ''; ?>>Indisponible</option>
                </select>
            </div>
            
            <!-- Upload image -->
            <div class="input-group" style="grid-column: 1 / -1;">
                <label>Image du véhicule</label>
                <input type="file" name="image" accept="image/jpeg,image/jpg,image/png,image/webp" style="padding: 10px; border: 2px dashed #0F4C81; background: #f8f9fa;">
                <small style="color: #666; display: block; margin-top: 8px;">
                    <strong>Formats acceptés:</strong> JPG, PNG, WEBP | <strong>Taille max:</strong> 5 Mo
                </small>
            </div>
            
            <!-- Afficher image actuelle si modification -->
            <?php if (isset($leVehicule) && $leVehicule != null): ?>
                <div class="input-group" style="grid-column: 1 / -1;">
                    <label>Image actuelle :</label>
                    <?php if (!empty($leVehicule['image'])): ?>
                        <div style="margin-top: 10px;">
                            <img src="uploads/vehicules/<?= htmlspecialchars($leVehicule['image']) ?>" 
                                 style="max-width: 300px; max-height: 200px; border-radius: 8px; border: 3px solid #0F4C81; display: block;" 
                                 alt="Image actuelle"
                                 onerror="this.style.border='3px solid red'; this.alt='Image introuvable: <?= $leVehicule['image'] ?>';">
                            <p style="margin-top: 10px; color: #666; font-size: 0.9rem;">
                                Fichier : <code><?= htmlspecialchars($leVehicule['image']) ?></code>
                            </p>
                        </div>
                    <?php else: ?>
                        <p style="color: #999; font-style: italic;">Aucune image</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-btns">
            <?php if (isset($leVehicule) && $leVehicule != null): ?>
                <input type="hidden" name="idvehicule" value="<?php echo $leVehicule['idvehicule']; ?>">
                <input type="submit" name="ModifierVehicule" value="Enregistrer les modifications" class="btn-primary">
            <?php else: ?>
                <input type="submit" name="valider_vehicule" value="Valider l'ajout" class="btn-primary">
            <?php endif; ?>
        </div>
    </form>
</div>