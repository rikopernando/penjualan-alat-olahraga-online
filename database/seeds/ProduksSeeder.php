<?php

use Illuminate\Database\Seeder;
use App\Produk;

class ProduksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $produk1 = new Produk(); 
       $produk1->nama = "Nike Classic Cortez Leather Shoes";
       $produk1->harga_jual = "250000";
       $produk1->deskripsi= "Sneakers klasik dalam nuansa pastel yang feminin, Warna smokey mauve, Upper kulit sintetis dan genuine leather, EVA insole untuk cushioning ringan ,Rubber outsole dengan herringbone patter, Tali depan, Round toe";
       $produk1->save();

       $produk2 = new Produk(); 
       $produk2->nama = "Casual Sneakers";
       $produk2->harga_jual= "350000";
       $produk2->deskripsi= "Two,tone casual canvas sneakers, Synthetic upper, Synthetic insole, Rubber outsole, Lace up fastening, Round toecap";
       $produk2->save();

       $produk3 = new Produk(); 
       $produk3->nama = "Luna Ivory , Women";
       $produk3->harga_jual= "550000";
       $produk3->deskripsi= "Keterangan Material Luna,Upper: Faux Leather ,Colour Upper: Ivory,Lining: Air Mesh Lining,Inshock: Air Mesh + Latex Foam,Outsole: Thermoplastic Rubber,Colour Sole: White Mix Brown,Colour Laces: Dark Brown";
       $produk3->save();

       $produk4 = new Produk(); 
       $produk4->nama = "Luna Ivory , Women";
       $produk4->harga_jual= "550000";
       $produk4->deskripsi= "Sneakers monokrom detail logo,Warna putih,Upper tekstil,Insole tekstil,Rubber outsole,Tali depan,Round toe";
       $produk4->save();
    }
}
