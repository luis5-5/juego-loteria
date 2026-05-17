<?php
/**
 * PHP Lint - Herramienta de análisis estático
 * Versión 1.1
 * 
 * Esta herramienta verifica errores de sintaxis y buenas prácticas en los archivos PHP
 * del proyecto.
 */

class PHPLint {
    private $archivos = [];
    private $errores = [];
    private $advertencias = [];
    private $exitoTotal = 0;
    private $fallo_total = 0;

    public function __construct($ruta = '.') {
        $this->buscarArchivosPhp($ruta);
    }

    /**
     * Buscar todos los archivos PHP en la ruta
     */
    private function buscarArchivosPhp($ruta) {
        $archivos = glob($ruta . '/*.php');
        foreach ($archivos as $archivo) {
            if (basename($archivo) !== 'php_lint.php') {
                $this->archivos[] = $archivo;
            }
        }
    }

    /**
     * Ejecutar PHP Lint en todos los archivos
     */
    public function ejecutar() {
        echo "\n";
        echo "╔═══════════════════════════════════════════════════════════╗\n";
        echo "║     PHP LINT - Análisis Estático de Código PHP            ║\n";
        echo "╚═══════════════════════════════════════════════════════════╝\n\n";

        foreach ($this->archivos as $archivo) {
            $this->analizarArchivo($archivo);
        }

        $this->mostrarResultados();
    }

    /**
     * Analizar un archivo PHP
     */
    private function analizarArchivo($archivo) {
        echo "Analizando: " . basename($archivo) . "... ";
        
        $output = [];
        $return_var = 0;
        
        // Ejecutar PHP lint
        exec("php -l " . escapeshellarg($archivo) . " 2>&1", $output, $return_var);
        
        if ($return_var === 0) {
            echo "✓ OK\n";
            $this->exitoTotal++;
            $this->verificarBuenasPracticas($archivo);
        } else {
            echo "✗ ERROR\n";
            $this->errores[basename($archivo)] = $output;
            $this->fallo_total++;
        }
    }

    /**
     * Verificar buenas prácticas en el código
     */
    private function verificarBuenasPracticas($archivo) {
        $contenido = file_get_contents($archivo);
        $linea_num = 1;
        $lineas = explode("\n", $contenido);
        
        $advertenciasArchivo = [];

        foreach ($lineas as $linea) {
            // Verificar variables sin usar
            if (preg_match('/^\s*\$\w+\s*=/', $linea) && !preg_match('/\$\w+/', substr($contenido, strpos($contenido, $linea) + strlen($linea)))) {
                $advertenciasArchivo[] = "Línea $linea_num: Variable posiblemente no utilizada";
            }
            
            // Verificar uso de var_dump en producción
            if (strpos($linea, 'var_dump') !== false) {
                $advertenciasArchivo[] = "Línea $linea_num: Encontrado var_dump - revisar para producción";
            }
            
            // Verificar die() o exit()
            if (preg_match('/\b(die|exit)\s*\(/', $linea)) {
                $advertenciasArchivo[] = "Línea $linea_num: Uso de die() o exit() detectado";
            }
            
            // Verificar uso seguro de sesiones
            if (strpos($linea, '$_SESSION') !== false && strpos($linea, 'isset') === false) {
                $advertenciasArchivo[] = "Línea $linea_num: Acceso a \$_SESSION sin verificar si existe";
            }
            
            $linea_num++;
        }
        
        if (!empty($advertenciasArchivo)) {
            $this->advertencias[basename($archivo)] = $advertenciasArchivo;
        }
    }

    /**
     * Mostrar resultados finales
     */
    private function mostrarResultados() {
        echo "\n╔═══════════════════════════════════════════════════════════╗\n";
        echo "║                    RESULTADOS DEL LINT                   ║\n";
        echo "╚═══════════════════════════════════════════════════════════╝\n\n";

        echo "Archivos analizados: " . count($this->archivos) . "\n";
        echo "✓ Exitosos: " . $this->exitoTotal . "\n";
        echo "✗ Con errores: " . $this->fallo_total . "\n\n";

        if (!empty($this->errores)) {
            echo "┌─ ERRORES ENCONTRADOS ─\n";
            foreach ($this->errores as $archivo => $error) {
                echo "│ " . $archivo . ":\n";
                foreach ($error as $msg) {
                    echo "│   → " . $msg . "\n";
                }
            }
            echo "└────────────────────────\n\n";
        }

        if (!empty($this->advertencias)) {
            echo "┌─ ADVERTENCIAS (Buenas Prácticas) ─\n";
            foreach ($this->advertencias as $archivo => $warns) {
                echo "│ " . $archivo . ":\n";
                foreach ($warns as $warn) {
                    echo "│   ⚠ " . $warn . "\n";
                }
            }
            echo "└────────────────────────────────────\n\n";
        }

        echo "╔═══════════════════════════════════════════════════════════╗\n";
        if ($this->fallo_total === 0) {
            echo "║  ✓ ANÁLISIS COMPLETADO - SIN ERRORES CRÍTICOS            ║\n";
        } else {
            echo "║  ✗ SE ENCONTRARON ERRORES - REVISAR ANTES DE PRODUCCIÓN ║\n";
        }
        echo "╚═══════════════════════════════════════════════════════════╝\n\n";
    }
}

// Ejecutar PHP Lint
$lint = new PHPLint(__DIR__);
$lint->ejecutar();
?>
