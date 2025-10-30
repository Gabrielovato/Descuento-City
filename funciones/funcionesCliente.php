<?php

function verificarCategoria($categoriaCliente){
    
    $categorias_permitidas = [];

    if($categoriaCliente == "premium"){
        $categorias_permitidas = ['inicial','medium','premium'];
    }
    elseif($categoriaCliente == "medium"){
        $categorias_permitidas = ['inicial','medium'];
    }
    elseif($categoriaCliente == "inicial"){
        $categorias_permitidas = ['inicial'];
    }

    return $categorias_permitidas;
}


?>