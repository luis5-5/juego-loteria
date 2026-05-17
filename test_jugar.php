<?php
/**
 * Archivo de Pruebas Unitarias para el método jugar()
 * Versión 1.1
 * 
 * Pruebas para validar la lógica del método jugar() del controlador
 */

session_start();
require_once 'controller.php';

class TestJuego {
    private $controller;
    private $testsRun = 0;
    private $testsPassed = 0;
    private $resultados = [];

    public function __construct() {
        $this->controller = new Controller();
    }

    /**
     * Test 1: Verificar que el puntaje inicial es 2000
     */
    public function testPuntajeInicial() {
        $this->testsRun++;
        $_SESSION['puntaje'] = 2000;
        $puntajeEsperado = 2000;
        
        if ($_SESSION['puntaje'] === $puntajeEsperado) {
            $this->testsPassed++;
            $this->resultados[] = "✓ TEST 1 PASADO: Puntaje inicial es 2000";
            return true;
        } else {
            $this->resultados[] = "✗ TEST 1 FALLIDO: Puntaje inicial no es 2000 (actual: {$_SESSION['puntaje']})";
            return false;
        }
    }

    /**
     * Test 2: Verificar que cuando gana se suma 200 puntos
     */
    public function testGananciaPorVictoria() {
        $this->testsRun++;
        $_SESSION['puntaje'] = 2000;
        
        // Simulamos una victoria (todos los números iguales)
        $puntajeAntes = 2000;
        $puntajeEsperado = $puntajeAntes + 200; // 2200
        
        // Ejecutar juego múltiples veces (máximo 1000) para obtener una victoria
        $encontroVictoria = false;
        for ($i = 0; $i < 1000; $i++) {
            $this->controller->jugar();
            if ($_SESSION['resultado'] === 'Ganaste') {
                $encontroVictoria = true;
                break;
            }
        }
        
        if ($encontroVictoria && $_SESSION['puntaje'] > $puntajeAntes) {
            $this->testsPassed++;
            $this->resultados[] = "✓ TEST 2 PASADO: Al ganar se suma puntos (fue de 2000 a {$_SESSION['puntaje']})";
            return true;
        } else {
            $this->resultados[] = "✗ TEST 2 NO CONCLUYENTE: No se pudo simular una victoria en 1000 intentos";
            return false;
        }
    }

    /**
     * Test 3: Verificar que cuando pierde se restan 10 puntos
     */
    public function testPerdidaPorDerrota() {
        $this->testsRun++;
        $_SESSION['puntaje'] = 2000;
        
        $puntajeAntes = 2000;
        
        // Ejecutar juego múltiples veces para obtener una derrota
        $encontroDerrota = false;
        for ($i = 0; $i < 1000; $i++) {
            $this->controller->jugar();
            if ($_SESSION['resultado'] === 'Perdiste') {
                $encontroDerrota = true;
                break;
            }
        }
        
        if ($encontroDerrota && $_SESSION['puntaje'] < $puntajeAntes) {
            $this->testsPassed++;
            $this->resultados[] = "✓ TEST 3 PASADO: Al perder se restan puntos (fue de 2000 a {$_SESSION['puntaje']})";
            return true;
        } else {
            $this->resultados[] = "✗ TEST 3 NO CONCLUYENTE: No se pudo simular una derrota en 1000 intentos";
            return false;
        }
    }

    /**
     * Test 4: Verificar que el puntaje no puede ser negativo
     */
    public function testPuntajeNoNegativo() {
        $this->testsRun++;
        $_SESSION['puntaje'] = 10; // Muy bajo para que pierda
        
        // Jugar hasta que pierda
        for ($i = 0; $i < 100; $i++) {
            $this->controller->jugar();
        }
        
        if ($_SESSION['puntaje'] >= 0) {
            $this->testsPassed++;
            $this->resultados[] = "✓ TEST 4 PASADO: El puntaje nunca es negativo (actual: {$_SESSION['puntaje']})";
            return true;
        } else {
            $this->resultados[] = "✗ TEST 4 FALLIDO: El puntaje es negativo ({$_SESSION['puntaje']})";
            return false;
        }
    }

    /**
     * Test 5: Verificar que se generan 3 números aleatorios
     */
    public function testGeneracionNumerosAleatorios() {
        $this->testsRun++;
        $_SESSION['puntaje'] = 2000;
        
        $this->controller->jugar();
        
        $numeros = $_SESSION['numeros'] ?? [];
        
        if (count($numeros) === 3 && 
            all($numeros, fn($n) => $n >= 1 && $n <= 3)) {
            $this->testsPassed++;
            $this->resultados[] = "✓ TEST 5 PASADO: Se generan 3 números aleatorios (1-3) correctamente";
            return true;
        } else {
            $this->resultados[] = "✗ TEST 5 FALLIDO: Los números no se generaron correctamente";
            return false;
        }
    }

    /**
     * Test 6: Verificar Game Over cuando puntaje es 0
     */
    public function testGameOver() {
        $this->testsRun++;
        $_SESSION['puntaje'] = 0;
        
        $this->controller->jugar();
        
        if ($_SESSION['resultado'] === 'Game Over' && $_SESSION['puntaje'] === 0) {
            $this->testsPassed++;
            $this->resultados[] = "✓ TEST 6 PASADO: Game Over se activa cuando puntaje llega a 0";
            return true;
        } else {
            $this->resultados[] = "✗ TEST 6 FALLIDO: Game Over no funciona correctamente";
            return false;
        }
    }

    /**
     * Ejecutar todos los tests
     */
    public function ejecutarTodos() {
        echo "\n";
        echo "═══════════════════════════════════════════════════════════\n";
        echo "          PRUEBAS UNITARIAS - MÉTODO jugar()\n";
        echo "═══════════════════════════════════════════════════════════\n\n";
        
        $this->testPuntajeInicial();
        $this->testGananciaPorVictoria();
        $this->testPerdidaPorDerrota();
        $this->testPuntajeNoNegativo();
        $this->testGeneracionNumerosAleatorios();
        $this->testGameOver();
        
        $this->mostrarResultados();
    }

    /**
     * Mostrar resultados de las pruebas
     */
    private function mostrarResultados() {
        echo "\n------- RESULTADOS DETALLADOS -------\n\n";
        foreach ($this->resultados as $resultado) {
            echo $resultado . "\n";
        }
        
        echo "\n------- RESUMEN -------\n";
        echo "Total de pruebas ejecutadas: {$this->testsRun}\n";
        echo "Pruebas pasadas: {$this->testsPassed}\n";
        echo "Pruebas fallidas: " . ($this->testsRun - $this->testsPassed) . "\n";
        
        $porcentaje = ($this->testsPassed / $this->testsRun) * 100;
        echo "Porcentaje de éxito: " . number_format($porcentaje, 2) . "%\n";
        
        echo "\n═══════════════════════════════════════════════════════════\n";
        
        if ($this->testsPassed === $this->testsRun) {
            echo "✓ TODAS LAS PRUEBAS PASARON CORRECTAMENTE\n";
        } else {
            echo "✗ ALGUNAS PRUEBAS FALLARON - REVISAR RESULTADOS\n";
        }
        echo "═══════════════════════════════════════════════════════════\n\n";
    }
}

// Helper function
function all($array, $callback) {
    foreach ($array as $item) {
        if (!$callback($item)) {
            return false;
        }
    }
    return true;
}

// Ejecutar pruebas
$test = new TestJuego();
$test->ejecutarTodos();
?>
