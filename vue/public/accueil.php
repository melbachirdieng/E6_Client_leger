<section class="hero">
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <h1>CASTELLANE AUTO</h1>
    <p>Auto-école à Toulon • 30 ans d'expérience • Taux de réussite élevé</p>

    <div class="hero-actions">
      <?php if (!isset($_SESSION['role'])): ?>
        <a class="btn btn-primary" href="index.php?page=10">S’inscrire</a>
      <?php endif; ?>
      <a class="btn btn-outline hero-outline" href="#permis">Voir les permis</a>
    </div>
  </div>
</section>


<div class="section" id="permis">
  <h2 class="section-title">Choisissez votre formation</h2>
  <p style="color: var(--text-medium); font-size: 1.1rem; margin-bottom: 30px;">
    Permis B, AAC ou Moto : une formation adaptée à votre profil
  </p>

  <div class="card-grid">
    <a href="index.php?page=20" class="card-link">
      <div class="card">
        <div class="icon-box">B</div>
        <h3>Permis B</h3>
        <p style="color: var(--text-medium);">
          Formation complète sur véhicules récents. Taux de réussite : 92%
        </p>
        <span class="btn btn-outline" style="margin-top: 15px; display: inline-block; padding: 10px 20px;">
          En savoir plus
        </span>
      </div>
    </a>

    <a href="index.php?page=21" class="card-link">
      <div class="card">
        <div class="icon-box aac">AAC</div>
        <h3>Conduite Accompagnée</h3>
        <p style="color: var(--text-medium);">
          Dès 15 ans, apprentissage progressif avec accompagnateur
        </p>
        <span class="btn btn-outline" style="margin-top: 15px; display: inline-block; padding: 10px 20px;">
          En savoir plus
        </span>
      </div>
    </a>

    <a href="index.php?page=22" class="card-link">
      <div class="card">
        <div class="icon-box">A</div>
        <h3>Permis Moto</h3>
        <p style="color: var(--text-medium);">
          Permis A1 et A2, formation sur piste sécurisée
        </p>
        <span class="btn btn-outline" style="margin-top: 15px; display: inline-block; padding: 10px 20px;">
          En savoir plus
        </span>
      </div>
    </a>
  </div>
</div>

<div class="section">
    <h2 class="section-title">Nos atouts</h2>
    <div class="card-grid">
        <div class="card">
            <h3>Moniteurs diplômés</h3>
            <p style="color: var(--text-medium);">
                10 moniteurs expérimentés et pédagogues à votre écoute
            </p>
        </div>
        <div class="card">
            <h3>Véhicules récents</h3>
            <p style="color: var(--text-medium);">
                Flotte moderne et entretenue régulièrement pour votre sécurité
            </p>
        </div>
        <div class="card">
            <h3>Flexibilité</h3>
            <p style="color: var(--text-medium);">
                Planning adapté à vos disponibilités, y compris week-ends
            </p>
        </div>
    </div>
    
    <?php if (!isset($_SESSION['role'])): ?>
      <div style="text-align: center; margin-top: 40px;">
          <a href="index.php?page=10" class="btn btn-primary" style="font-size: 1.1rem; padding: 16px 40px; text-decoration: none;">
              Inscrivez-vous maintenant
          </a>
      </div>
    <?php endif; ?>
</div>