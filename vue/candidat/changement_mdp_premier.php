<div class="form-card" style="max-width: 600px; margin: 60px auto;">
    <div style="background: linear-gradient(135deg, #2868A8 0%, #2868A8 100%); color: white; padding: 30px; border-radius: 12px 12px 0 0; text-align: center; margin: -20px -20px 30px -20px;">
        <h2 style="color: white; margin: 0; font-size: 1.8rem;">Changement de mot de passe obligatoire</h2>
    </div>
    
    <div class="card" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin-bottom: 30px;">
        <p style="margin: 0; line-height: 1.8; color: #856404;">
            <strong>Première connexion</strong><br>
            Pour des raisons de sécurité, vous devez choisir un nouveau mot de passe personnel avant d'accéder à votre espace.
        </p>
    </div>
    
    <form method="post" class="elite-form">
        <div class="input-group">
            <label>Nouveau mot de passe *</label>
            <input type="password" name="nouveau_mdp" required minlength="3" 
                   placeholder="Minimum 3 caractères" 
                   style="border: 2px solid #0F4C81;">
            <small style="color: #666; display: block; margin-top: 5px;">
                Choisissez un mot de passe sécurisé que vous seul connaissez
            </small>
        </div>
        
        <div class="input-group">
            <label>Confirmer le nouveau mot de passe *</label>
            <input type="password" name="nouveau_mdp2" required minlength="3" 
                   placeholder="Retapez le même mot de passe"
                   style="border: 2px solid #0F4C81;">
        </div>
        
        <div class="card" style="background: #d1ecf1; border-left: 4px solid #0F4C81; padding: 15px; margin-top: 20px;">
            <p style="margin: 0; font-size: 0.9rem; color: #0c5460; line-height: 1.6;">
                 <strong>Conseils pour un bon mot de passe :</strong><br>
                • Au moins 8 caractères<br>
                • Mélangez lettres et chiffres<br>
                • Utilisez des caractères spéciaux (!, @, #, etc.)<br>
                • Ne réutilisez pas un mot de passe existant
            </p>
        </div>
        
        <button type="submit" name="changer_mdp_premier" 
                style="width: 100%; margin-top: 30px; padding: 15px; background: linear-gradient(135deg, #0F4C81 0%, #1E5A96 100%); color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
            ✓ Valider mon nouveau mot de passe
        </button>
    </form>
    
    <p style="text-align: center; margin-top: 20px; color: #666; font-size: 0.9rem;">
        Ce mot de passe sera utilisé pour toutes vos futures connexions
    </p>
</div>

<style>
button[name="changer_mdp_premier"]:hover {
    background: linear-gradient(135deg, #1E5A96 0%, #2868A8 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(15, 76, 129, 0.3);
    transition: all 0.3s ease;
}
</style>