<?php
class Etudiant {
    private $nom;
    private $notes = [];
    
    public function __construct($nom, $notes) {
        $this->nom = $nom;
        $this->notes = $notes;
    }
    
    public function getNotes() {
        return $this->notes;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function moyenne() {
        $somme = 0;
        for ($i = 0; $i < count($this->notes); $i++) {
            $somme += $this->notes[$i];
        }
        return $somme / count($this->notes);
    }
    
    public function admis() {
        return $this->moyenne() >= 10 ? "admis" : "non admis";
    }
}

$etudiantone = new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]);
$etudianttwo = new Etudiant("Skander", [15, 9, 8, 16]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-4">
        <div class="row">
            <div class="col">
                <h3><?php echo ($etudiantone->getNom()); ?></h3>
                <?php 
                $notesAymen = $etudiantone->getNotes();
                for ($i = 0; $i < count($notesAymen); $i++) {
                    $note = $notesAymen[$i];
                    $bgColor = ($note < 10) ? '#DB586E' : 
                              (($note > 10) ? '#A9DC8C' : '#F0E68C');
                    echo '<div class="note-box" style="background-color: '.$bgColor.'">'.$note.'</div>';
                }
                ?>
                <div class="note-box moyenne-box">
                    Moyenne: <?php echo number_format($etudiantone->moyenne(), 2); ?> - 
                    <?php echo $etudiantone->admis(); ?>
                </div>
            </div>
            
            <div class="col">
                <h3><?php echo ($etudianttwo->getNom()); ?></h3>
                <?php 
                $notesSkander = $etudianttwo->getNotes();
                for ($i = 0; $i < count($notesSkander); $i++) {
                    $note = $notesSkander[$i];
                    $bgColor = ($note < 10) ? '#DB586E' : 
                              (($note > 10) ? '#A9DC8C' : '#F0E68C');
                    echo '<div class="note-box" style="background-color: '.$bgColor.'">'.$note.'</div>';
                }
                ?>
                <div class="note-box moyenne-box">
                    Moyenne: <?php echo number_format($etudianttwo->moyenne(), 2); ?> - 
                    <?php echo $etudianttwo->admis(); ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>