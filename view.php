<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Juego de Lotería 🎰</title>
</head>
<body>
    <?php
    // Eliminar la línea de session_start()
    $puntaje = isset($_SESSION['puntaje']) ? $_SESSION['puntaje'] : 2000;
    $resultado = $_SESSION['resultado'] ?? '';
    $numeros = $_SESSION['numeros'] ?? [1, 1, 1];
    ?>
    
    <div class="container">
        <div class="header">
            <h1>🎰 JUEGO DE LOTERÍA 🎰</h1>
            <div class="puntaje-display">
                <span class="label">Puntaje:</span>
                <span class="valor">$<?php echo number_format($puntaje); ?></span>
            </div>
        </div>
        
        <div class="game-zone">
            <div class="imagenes">
                <div class="slot">
                    <img src="imagenes/<?php echo $numeros[0]; ?>.jpg" alt="Slot 1" />
                </div>
                <div class="slot">
                    <img src="imagenes/<?php echo $numeros[1]; ?>.jpg" alt="Slot 2" />
                </div>
                <div class="slot">
                    <img src="imagenes/<?php echo $numeros[2]; ?>.jpg" alt="Slot 3" />
                </div>
            </div>
            
            <div class="resultado-display <?php echo strtolower($resultado); ?>">
                <h2><?php echo $resultado ?: 'Bienvenido'; ?></h2>
            </div>
        </div>
        
        <div class="buttons">
            <?php if ($resultado === 'Game Over') { ?>
                <button class="btn btn-restart" onclick="location.href='index.php'">🔄 Vuelve a Jugar</button>
            <?php } else { ?>
                <button class="btn btn-play" onclick="location.href='index.php?action=jugar'">▶️ Jugar</button>
                <button class="btn btn-save" onclick="location.href='index.php?action=guardar'">💾 Guardar</button>
            <?php } ?>
        </div>
        
        <footer>
            <p>Versión 1.1 | Juego de Lotería v1.1</p>
        </footer>
    </div>
</body>
</html>
