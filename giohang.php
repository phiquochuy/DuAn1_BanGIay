<?php
function    insert_cart($name,$price,$tongtien,$img,$soluong,$id,$idtk){
    $sql ="INSERT INTO giohang(namesp,price,tongprice,soluong,idsp,img,idtk) VALUE('$name','$price','$tongtien','$soluong','$id','$img','$idtk')";
    pdo_execute($sql);
}

    function result_giohang($id){
        $sql = "SELECT * FROM giohang WHERE idtk=".$id;
        $gh = pdo_query($sql);
        return $gh;
    }
    function result_tongtien($id){
        $sql = "SELECT tongprice FROM giohang WHERE idtk=".$id;
        $result = pdo_query($sql);
        return $result;
    }
   function  xoa_gh_id($id){
    $sql = "DELETE FROM giohang WHERE id=".$id;
    pdo_execute($sql);
   }
   function deletegh($id){
    $sql = "DELETE FROM giohang WHERE idtk=".$id;
    pdo_execute($sql);
       }
    function sohanghoa($iduser){
        $sql = "SELECT giohang.soluong FROM giohang WHERE idtk=".$iduser;
        $result_sl =  pdo_query($sql);
        return $result_sl;
    }
?>
