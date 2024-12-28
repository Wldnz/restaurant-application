<?php

class Cart{
   
    private $id,$nama,$qty,$harga_satuan,$image_url;

    public function __construct($id,$nama,$qty,$harga_satuan,$image_url){
        $this->id=$id;
        $this->nama=$nama;
        $this->qty=$qty;
        $this->harga_satuan=$harga_satuan;
        $this->image_url=$image_url;
    }

    public function getId(){
        return $this->id;
    }

    public function getNama(){
        return $this->nama;
    }

    public function getQty(){
        return $this->qty;
    }

    public function getHarga(){
        return $this->harga_satuan;
    }

    public function getImage_url(){
        return $this->image_url;
    }

    public function changeQty($newQty){
        if(isset($newQty) && $newQty> 0) return $this->qty = $newQty;
    }

    public function increaseQty(){
        return $this->qty +=1;
    }

    public function decreaseQty(){
        return $this->qty -=1;
    }

    public function getTotalPrice(){
        return $total_price = $this->qty * $this->harga_satuan;
    }


}
