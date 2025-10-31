<?php
// obtiene la ruta en la q estamos con la var global $_server['request_uri']
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Definir una lista de elementos que deben ser ignorados en el Breadcrumb (ignorar carpeta rais descuento_city y index)
$ignore_segments = [
    'index.php',
    'index.html',
    'descuento-city',
    'views',
    'auth',
];

$segments = array_filter(explode('/', $path));


$segments_filtrados = [];
foreach ($segments as $segment) {
    // Compara el segmento en minúsculas con la lista de ignorados
    if (!in_array(strtolower($segment), $ignore_segments)) {
        $segments_filtrados[] = $segment;
    }
}

$segments = $segments_filtrados; // lista limpia

// Si no hay segmentos filtrados, raíz (Home)
if (empty($segments)) { // como active HOme
 
    echo '<nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb">';
    echo '<ol class="breadcrumb">';
    echo '<li class="breadcrumb-item active" aria-current="page">Home</li>';
    echo '</ol>';
    echo '</nav>';
    return;
}

//componente de Bootstrap
echo '<nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb">';
echo '<ol class="breadcrumb">';

echo '<li class="breadcrumb-item"><a href="/Descuento-City/index.php">Home</a></li>';

$current_path = '';
$total_segments = count($segments);

 //recorre los segmentos restantes (que serán las migas reales)
foreach ($segments as $index => $segment) {
    
    $segment_limpio = str_replace(array('.php', '.html', '-'), ' ', $segment);
    $segment_display = ucwords($segment_limpio); 
    
    // Determina si es el último elemento
    if ($index + 1 == $total_segments) {
        
        $texto_final = isset($breadcrumb_titulo_activo) ? $breadcrumb_titulo_activo : $segment_display;
        
        // ES EL ÚLTIMO: Estilo ACTIVE
        echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($texto_final) . '</li>';
        
    } else {
        // NO ES EL ÚLTIMO: Estilo ENLACE
        $current_path .= '/' . $segment;
        echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($current_path) . '">' . htmlspecialchars($segment_display) . '</a></li>';
    }
}

echo '</ol>';
echo '</nav>';
?>