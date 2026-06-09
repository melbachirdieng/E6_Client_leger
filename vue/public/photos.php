<div style="text-align: center; margin-bottom: 40px;">
    <h2 style="font-family: 'Orbitron'; color: var(--accent);">NOTRE FLOTTE</h2>
    <p style="color: #888;">Apprenez sur les meilleurs véhicules du marché.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
    <?php foreach ($lesvehicules as $unVehicule) : ?>
    <div style="background: var(--card-grey); border-radius: 15px; overflow: hidden; border: 1px solid #333;">
        <div style="background: #000; height: 150px; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
            
        </div>
        <div style="padding: 20px;">
            <h3 style="margin: 0; color: #fff;"><?= $unVehicule['marque'] . " " . $unVehicule['modele'] ?></h3>
            <p style="color: var(--accent); font-size: 0.9rem;"><?= $unVehicule['immatriculation'] ?></p>
            <div style="margin-top: 10px; display: inline-block; padding: 5px 10px; background: #222; border-radius: 5px; font-size: 0.8rem; color: #00ff00;">
                ● <?= $unVehicule['etat'] ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>