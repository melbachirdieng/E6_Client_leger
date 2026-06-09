<div class="form-card" style="max-width: 500px; margin: 60px auto;">
    <h1 class="section-title" style="text-align: center; border: none;">Connexion</h1>
    <p style="text-align: center; color: var(--text-medium); margin-bottom: 30px;">
       
    </p>

    <form method="post" action="index.php?page=99">
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email</label>
            <input type="email" name="email" required placeholder="@email.fr">
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Mot de passe</label>
            <input type="password" name="mdp" required placeholder="••••••••">
        </div>

        <input type="submit" name="Connexion" value="Se connecter">

       

        <p style="text-align: center; margin-top: 25px; color: var(--text-medium);">
            Vous ne possédez pas de compte?
            <a href="index.php?page=10" style="color: var(--primary-blue); text-decoration: none; font-weight: 600;">
                Inscrivez-vous ici
            </a>
        </p>
    </form>
</div>