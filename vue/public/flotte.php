<section class="hero-flotte">
    <div class="hero-flotte-overlay"></div>
    <div class="hero-flotte-content">
        <h1>Notre Flotte de Véhicules</h1>
        <p>
            Découvrez notre gamme complète de véhicules adaptés à tous vos besoins professionnels.
            Des citadines compactes aux berlines spacieuses,
            trouvez le véhicule idéal pour votre activité.
        </p>
    </div>
</section>

  

    <!-- AJOUT: Présentation de la flotte -->
    <div class="card" style="margin-bottom: 40px; background: linear-gradient(135deg, #0F4C81 0%, #1E5A96 100%); color: white; padding: 30px;">
        <h2 style="color: white; margin-bottom: 20px; font-size: 1.8rem;">Notre Engagement Qualité</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
            <div>
                <h3 style="color: #FF8A65; font-size: 1.2rem; margin-bottom: 10px;">Véhicules Récents</h3>
                <p style="line-height: 1.6;">Tous nos véhicules ont moins de 3 ans et sont équipés des dernières technologies de sécurité.</p>
            </div>
            <div>
                <h3 style="color: #FF8A65; font-size: 1.2rem; margin-bottom: 10px;">Entretien Rigoureux</h3>
                <p style="line-height: 1.6;">Révisions tous les 10 000 km par nos mécaniciens agréés. Contrôle technique à jour.</p>
            </div>
            <div>
                <h3 style="color: #FF8A65; font-size: 1.2rem; margin-bottom: 10px;">Double Commande</h3>
                <p style="line-height: 1.6;">Tous nos véhicules sont équipés de doubles commandes pour votre sécurité maximale.</p>
            </div>
        </div>
    </div>

    <div class="section" >
     <h2 class="section-title">Le véhicule idéal pour débuter la conduite</h2>
    <p style="color: var(--text-medium); font-size: 1.1rem; margin-bottom: 30px;">
   Pour un apprentissage de la conduite sûr et efficace, il est essentiel de choisir le véhicule adapté. Des voitures fiables, modernes et faciles à prendre en main garantissent une expérience fluide pour les élèves, quel que soit leur niveau.</p>
    <p>Des modèles compacts aux citadines spacieuses, en boîte automatique ou manuelle, offrent une conduite intuitive, des technologies de sécurité avancées et un confort optimal pour les premiers kilomètres. Ces véhicules permettent aux élèves de se concentrer sur l'apprentissage, sans stress, et facilitent la progression rapide et sécurisée.</p><br>
   <p> Choisir le bon véhicule, c'est allier sécurité, confort et praticité, et offrir aux futurs conducteurs une expérience d'apprentissage agréable et professionnelle. Découvrez notre sélection de véhicules spécialement adaptés aux besoins des auto-écoles et commencez l'aventure de la conduite avec confiance.</p>
    </p>
    </div>

    <div class="vehicle-grid">
        <?php if(!empty($lesvehicules) && is_array($lesvehicules)): ?>
            <?php foreach($lesvehicules as $vehicule): ?>
                <div class="vehicle-card">
                    <!-- AJOUT: Affichage de l'image -->
                    <div class="vehicle-image" style="height: 200px; overflow: hidden; background: #f0f0f0;">
                        <?php
                            // On laisse le navigateur charger l'image, et si elle n'existe pas,
                            // onerror affiche l'image par défaut. Plus robuste que file_exists()
                            // qui peut planter sur les liens symboliques / chemins relatifs Apache.
                            $img = !empty($vehicule['image']) ? $vehicule['image'] : 'default-car.jpg';
                        ?>
                        <img src="uploads/vehicules/<?= htmlspecialchars($img) ?>"
                             alt="<?= htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']) ?>"
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.onerror=null; this.src='uploads/vehicules/default-car.jpg';">
                    </div>
                    
                    <div class="vehicle-info">
                        <h3><?= htmlspecialchars($vehicule['marque']) ?> <?= htmlspecialchars($vehicule['modele']) ?></h3>
                        <div class="vehicle-plate"><?= htmlspecialchars($vehicule['immatriculation']) ?></div>
                        <div style="margin-top: 15px;">
                            <span class="badge badge-success">Disponible</span>
                        </div>
                        
                        <!-- AJOUT: Informations supplémentaires -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                            <p style="font-size: 0.9rem; color: #666; line-height: 1.6;">
                                <strong style="color: #0F4C81;">Équipements :</strong><br>
                                • Double commande<br>
                                • Climatisation<br>
                                • ABS & ESP<br>
                                • Caméra de recul
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                <p style="color: var(--text-medium); font-size: 1.1rem;">
                    Nos véhicules sont actuellement en cours de maintenance.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- AJOUT: Section informations complémentaires -->
    <div class="card" style="margin-top: 40px; background: var(--bg-light); border-left-color: var(--accent-salmon);">
        <h3>Entretien & Sécurité</h3>
        <ul style="margin-top: 15px; padding-left: 20px; color: var(--text-medium); line-height: 2;">
            <li><strong>Révision complète</strong> tous les 10 000 km</li>
            <li><strong>Contrôle technique</strong> à jour et disponible sur demande</li>
            <li><strong>Nettoyage intérieur/extérieur</strong> quotidien</li>
            <li><strong>Assurance tous risques</strong> avec couverture complète</li>
            <li><strong>Carburant</strong> fourni pour toutes les leçons</li>
        </ul>
     

    </div>

   
 <div class="section no-border">

    <div class="section" >
  <h2 class="section-title">Le véhicule idéal pour débuter la conduite</h2>
  <p style="color: var(--text-medium); font-size: 1.1rem; margin-bottom: 30px;">
   Pour un apprentissage de la conduite sûr et efficace, il est essentiel de choisir le véhicule adapté. Des voitures fiables, modernes et faciles à prendre en main garantissent une expérience fluide pour les élèves, quel que soit leur niveau.
Des modèles compacts aux citadines spacieuses, en boîte automatique ou manuelle, offrent une conduite intuitive, des technologies de sécurité avancées et un confort optimal pour les premiers kilomètres. Ces véhicules permettent aux élèves de se concentrer sur l'apprentissage, sans stress, et facilitent la progression rapide et sécurisée.
Choisir le bon véhicule, c'est allier sécurité, confort et praticité, et offrir aux futurs conducteurs une expérience d'apprentissage agréable et professionnelle. Découvrez notre sélection de véhicules spécialement adaptés aux besoins des auto-écoles et commencez l'aventure de la conduite avec confiance.
  </p>
</div>

    <div class="card" style="margin-top: 30px; background: var(--bg-light); border-left-color: var(--primary-blue);">
        <h3>Nos Véhicules en Chiffres</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 20px; text-align: center;">
            <div>
                <div style="font-size: 3rem; font-weight: 700; color: var(--primary-blue);">
                    <?= count($lesvehicules) ?>
                </div>
                <p style="color: var(--text-medium); margin-top: 10px;">Véhicules disponibles</p>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: 700; color: var(--primary-blue);">100%</div>
                <p style="color: var(--text-medium); margin-top: 10px;">Équipés double commande</p>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: 700; color: var(--primary-blue);">&lt;3</div>
                <p style="color: var(--text-medium); margin-top: 10px;">Ans d'âge moyen</p>
            </div>
        </div>
    </div>
</div>