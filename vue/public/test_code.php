<div class="quiz-container" style="max-width: 900px; margin: 0 auto;">
    
    <?php
    // CALCULER LE RÉSULTAT SI LE FORMULAIRE EST SOUMIS
    $showResult = false;
    $score = 0;
    $total = 20;
    $note = 0;
    $appreciation = '';
    $color = '';
    
    $questions = [
        ["q" => "À quelle distance minimale devez-vous vous garer d'un passage piéton ?", "a" => ["3 mètres", "5 mètres", "7 mètres", "10 mètres"], "c" => 1],
        ["q" => "Quel est le taux d'alcoolémie maximum autorisé pour un conducteur novice ?", "a" => ["0,2 g/L", "0,5 g/L", "0,8 g/L", "0 g/L"], "c" => 0],
        ["q" => "Sur autoroute, quelle est la vitesse minimale autorisée sur la voie de gauche ?", "a" => ["60 km/h", "70 km/h", "80 km/h", "90 km/h"], "c" => 2],
        ["q" => "Combien de points possède un permis probatoire au départ ?", "a" => ["6 points", "8 points", "10 points", "12 points"], "c" => 0],
        ["q" => "Quelle est la distance d'arrêt sur route sèche à 90 km/h ?", "a" => ["45 mètres", "70 mètres", "90 mètres", "110 mètres"], "c" => 2],
        ["q" => "À partir de quel âge peut-on commencer la conduite accompagnée (AAC) ?", "a" => ["14 ans", "15 ans", "16 ans", "17 ans"], "c" => 1],
        ["q" => "Quelle est la durée de validité d'un code de la route ?", "a" => ["3 ans", "5 ans", "7 ans", "10 ans"], "c" => 1],
        ["q" => "Sur quelle voie devez-vous circuler en temps normal ?", "a" => ["La plus à gauche", "La plus à droite", "Celle du milieu", "N'importe laquelle"], "c" => 1],
        ["q" => "Combien de points perd-on en cas de franchissement d'une ligne continue ?", "a" => ["1 point", "2 points", "3 points", "4 points"], "c" => 2],
        ["q" => "Quelle est la vitesse maximale autorisée en agglomération ?", "a" => ["30 km/h", "50 km/h", "70 km/h", "90 km/h"], "c" => 1],
        ["q" => "Que signifie un panneau rond à fond bleu avec une flèche blanche ?", "a" => ["Interdiction", "Obligation", "Danger", "Indication"], "c" => 1],
        ["q" => "À quelle distance doit-on placer un triangle de signalisation ?", "a" => ["30 mètres", "50 mètres", "100 mètres", "150 mètres"], "c" => 0],
        ["q" => "Combien d'années dure le permis probatoire ?", "a" => ["2 ans", "3 ans", "4 ans", "5 ans"], "c" => 1],
        ["q" => "Quelle distance de sécurité faut-il respecter sur autoroute ?", "a" => ["2 secondes", "3 secondes", "4 secondes", "5 secondes"], "c" => 0],
        ["q" => "À partir de combien de points restants recevez-vous une lettre 48SI ?", "a" => ["6 points ou moins", "5 points ou moins", "4 points ou moins", "3 points ou moins"], "c" => 0],
        ["q" => "Quelle est la sanction en cas de dépassement de 40 km/h de la vitesse autorisée ?", "a" => ["Amende et 2 points", "Amende et 4 points", "Suspension de permis", "Toutes ces réponses"], "c" => 3],
        ["q" => "Le port de la ceinture de sécurité est-il obligatoire à l'arrière ?", "a" => ["Oui toujours", "Non jamais", "Uniquement sur autoroute", "Uniquement pour les enfants"], "c" => 0],
        ["q" => "Quelle est la vitesse maximale autorisée sur une route à double sens sans séparateur ?", "a" => ["70 km/h", "80 km/h", "90 km/h", "110 km/h"], "c" => 1],
        ["q" => "Que devez-vous faire à un feu orange fixe ?", "a" => ["Accélérer pour passer", "S'arrêter si cela ne présente pas de danger", "Continuer normalement", "Klaxonner"], "c" => 1],
        ["q" => "Combien de temps faut-il pour récupérer tous ses points ?", "a" => ["6 mois", "1 an", "2 ans", "3 ans"], "c" => 3]
    ];
    
    if(isset($_POST['submit_quiz'])) {
        $showResult = true;
        
        foreach($questions as $i => $q) {
            if(isset($_POST["q$i"]) && $_POST["q$i"] == $q['c']) {
                $score++;
            }
        }
        
        $note = ($score / $total) * 40;
        
        if($score >= 17) {
            $appreciation = "Félicitations ! Vous êtes prêt pour l'examen !";
            $color = "var(--success)";
        } elseif($score >= 14) {
            $appreciation = "Très bien ! Encore un petit effort.";
            $color = "var(--primary-blue)";
        } elseif($score >= 10) {
            $appreciation = "Correct, mais vous devez réviser davantage.";
            $color = "var(--accent-salmon)";
        } else {
            $appreciation = "Insuffisant. Reprenez vos cours et réessayez.";
            $color = "var(--danger)";
        }
    }
    ?>

    <?php if($showResult): ?>
        <!-- AFFICHAGE DU RÉSULTAT EN HAUT -->
        <div class="score-display" style="background: <?= $color ?>; margin-bottom: 40px;">
            <h2>Résultat de votre examen</h2>
            <div class="score-number"><?= $score ?> / <?= $total ?></div>
            <p style="font-size: 1.5rem;">Note : <?= $note ?> / 40</p>
            <p style="margin-top: 20px; font-size: 1.2rem;"><?= $appreciation ?></p>
            <a href="index.php?page=4" class="btn" style="margin-top: 30px; background: white; color: <?= $color ?>; display: inline-block; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: 600;">
                Recommencer le test
            </a>
        </div>
        
        <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 20px;">Correction détaillée</h2>
        
        <?php foreach($questions as $i => $q): ?>
            <div class="question-card">
                <div class="question-number">Question <?= $i + 1 ?> / 20</div>
                <div class="question-text"><?= htmlspecialchars($q['q']) ?></div>
                
                <?php foreach($q['a'] as $j => $option): ?>
                    <?php 
                        $userAnswer = isset($_POST["q$i"]) ? $_POST["q$i"] : null;
                        $isCorrect = ($j == $q['c']);
                        $isUserAnswer = ($userAnswer == $j);
                        
                        $class = '';
                        if($isCorrect) {
                            $class = 'correct';
                        } elseif($isUserAnswer && !$isCorrect) {
                            $class = 'incorrect';
                        }
                    ?>
                    <div class="correction-option <?= $class ?>" style="<?= $isCorrect ? 'border-color: var(--success); background: rgba(76, 175, 80, 0.1);' : ($isUserAnswer ? 'border-color: var(--danger); background: rgba(244, 67, 54, 0.1);' : '') ?>">
                        <?= $isCorrect ? '✓' : ($isUserAnswer ? '✗' : '') ?> <?= htmlspecialchars($option) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        
    <?php else: ?>
        <!-- FORMULAIRE DU TEST -->
        <h1 class="section-title">Examen Blanc - Code de la Route</h1>
        <p style="color: var(--text-medium); font-size: 1.1rem; margin-bottom: 30px;">
            20 questions pour tester vos connaissances. Validé à partir de 35/40 (17 bonnes réponses)
        </p>

        <form method="post" action="index.php?page=4">
            <?php foreach($questions as $i => $q): ?>
                <div class="question-card">
                    <div class="question-number">Question <?= $i + 1 ?> / 20</div>
                    <div class="question-text"><?= htmlspecialchars($q['q']) ?></div>
                    
                    <?php foreach($q['a'] as $j => $option): ?>
                        <label class="answer-option">
                            <input type="radio" name="q<?= $i ?>" value="<?= $j ?>" required>
                            <?= htmlspecialchars($option) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <input type="hidden" name="submit_quiz" value="1">
            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="font-size: 1.1rem; padding: 16px 50px;">
                    Valider mes réponses
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>