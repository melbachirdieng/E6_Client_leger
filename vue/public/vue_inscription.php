<div class="form-card" style="max-width: 700px; margin: 40px auto;">
    <h1 class="section-title" style="text-align: center; border: none;">Inscription</h1>
    <p style="text-align: center; color: var(--text-medium); margin-bottom: 30px;">
        Rejoignez Castellane Auto et obtenez votre permis
    </p>

    <form method="post" action="index.php?page=10">
        <div class="form-grid">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Nom *</label>
                <input type="text" name="nom" required placeholder="Votre nom" minlength="2" maxlength="50" pattern="[a-zA-ZÀ-ÿ\s\-']+" title="Lettres uniquement (min. 2 caractères)">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Prénom *</label>
                <input type="text" name="prenom" required placeholder="Votre prénom" minlength="2" maxlength="50" pattern="[a-zA-ZÀ-ÿ\s\-']+" title="Lettres uniquement (min. 2 caractères)">
            </div>
        </div>

        <div class="form-grid">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email *</label>
                <input type="email" name="email" required placeholder="votre.email@exemple.fr" maxlength="100">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Téléphone *</label>
                <input type="tel" name="tel" required placeholder="06 12 34 56 78" pattern="[0-9\s\-\+\(\)]+" minlength="10" maxlength="20" title="Numéro de téléphone valide (ex: 06 12 34 56 78)">
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Adresse complète *</label>
            <input type="text" name="adresse" required placeholder="Numéro, rue, ville, code postal" minlength="5" maxlength="150">
        </div>

        <div class="form-grid">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Êtes-vous étudiant ?</label>
                <select name="est_etudiant">
                    <option value="0">Non</option>
                    <option value="1">Oui (réduction de 10%)</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Nom de votre école/université</label>
                <input type="text" name="nom_ecole" placeholder="Si étudiant">
            </div>
        </div>

        <div class="input-group">
            <label>Mot de passe *</label>
            <input type="password" name="mdp" required minlength="8" maxlength="100" placeholder="Minimum 8 caractères">
            <small style="color: var(--text-medium); display: block; margin-top: 5px;">
                Au moins 8 caractères, une majuscule, un chiffre, sans espaces.
            </small>
        </div>

        <div class="input-group">
            <label>Confirmer le mot de passe *</label>
            <input type="password" name="mdp2" required minlength="8" maxlength="100" placeholder="Répétez votre mot de passe">
        </div>

        <div class="card" style="margin-top: 30px; background: var(--bg-light); border-left-color: var(--primary-blue);">
            <p style="color: var(--text-medium); line-height: 1.8;">
                <strong>Après votre inscription :</strong><br>
                Notre équipe vous contactera sous 24h pour planifier votre évaluation de départ gratuite et vous présenter nos forfaits.
            </p>
        </div>


        <input type="submit" name="Sinscrire" value="Valider mon inscription" style="margin-top: 30px;">
        
        <p style="text-align: center; margin-top: 20px; color: var(--text-medium);">
            Déjà inscrit ? 
            <a href="index.php?page=99" style="color: var(--primary-blue); text-decoration: none; font-weight: 600;">
                Connectez vous
            </a>
        </p>
    </form>
</div>