<?php
function binhluanform($idsp,$noidung,$date,$name,$iduser){
      $sql = "INSERT INTO binhluan (noidung,ngaybinhluan,idsp,iduser,nameuser) VALUE('$noidung','$date','$idsp','$iduser','$name') ";
    pdo_execute($sql);
}
function loadallbl($idsp){
    $sql = "SELECT * FROM binhluan WHERE idsp='".$idsp."' ORDER BY id DESC ";
    $bl = pdo_query($sql);
    return $bl;
}
?>
