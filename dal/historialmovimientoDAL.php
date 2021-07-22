<?php

require 'conexion.php';

function registroMovimientoMontura($productos, $idtorigen, $idtdestino, $comentario){
    $gdb = getConnection();
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi, comentario)'
                . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi, :comentario)');
        $exito = $sent->execute(array(':id' => $productos[$i][0], ':indicador' => 'TRASLADO', ':idtiendaubi' => $idtdestino,':comentario' => $comentario));
        
        $sentup = $gdb->prepare('update monturas set idtienda=:idtienda where idmonturas=:idmonturas');
        $exitoup = $sentup->execute(array(':idtienda' => $idtdestino, ':idmonturas' => $productos[$i][0]));
    }
    return $exitoup;
}

function listHistorialByIdMontura($idmonturas) {
    $idmonturas = "%".$idmonturas."%";
    $gdb = getConnection();
    $data = $gdb->prepare('select h.idhistorial, h.idmonturas, h.fecha, h.hora, h.indicador, h.idtiendaubi, h.comentario, t.tienda 
            FROM historialmovimiento h inner join tienda t on h.idtiendaubi=t.idtienda where h.idmonturas LIKE :idU order by h.fecha');
    $data->execute(array(':idU' => $idmonturas));
    $data = $data->fetchAll();
    return $data;
}

function registroMovimientoMonturaTienda($productos, $idtdestino, $comentario){
    $gdb = getConnection();
    for ($i = 0; $i < count($productos); ++$i) {
        $sent = $gdb->prepare('insert into historialmovimiento(idmonturas, fecha, hora, indicador, idtiendaubi, comentario)'
                . 'values(:id, CURRENT_DATE, curTime(), :indicador, :idtiendaubi, :comentario)');
        $exito = $sent->execute(array(':id' => $productos[$i][0], ':indicador' => 'TRASLADO', ':idtiendaubi' => $idtdestino,':comentario' => $comentario));
        
        $sentup = $gdb->prepare('update monturas set idtienda=:idtienda where idmonturas=:idmonturas');
        $exitoup = $sentup->execute(array(':idtienda' => $idtdestino, ':idmonturas' => $productos[$i][0]));
    }
    return $exitoup;
}