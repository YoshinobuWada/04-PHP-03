<?php
// ＜アルゴリズムの注意点＞
// アルゴリズムではこれまでのように調べる力ではなく物事を論理的に考える力が必要です。
// 検索して答えを探して解いても考える力には繋がりません。
// まずは検索に頼らずに自分で処理手順を考えてみましょう。


// 以下は自動販売機のお釣りを計算するプログラムです。
// 150円のお茶を購入した際のお釣りを計算して表示してください。
// 計算内容は関数に記述し、関数を呼び出して結果表示すること
// $yen と $product の金額を変更して計算が合っているか検証を行うこと

// 表示例1）
// 10000円札で購入した場合、
// 10000円札x0枚、5000円札x1枚、1000円札x4枚、500円玉x1枚、100円玉x3枚、50円玉x1枚、10円玉x0枚、5円玉x0枚、1円玉x0枚

// 表示例2）
// 100円玉で購入した場合、
// 50円足りません。

$yen = 9999;   // 購入金額
$product = 150; // 商品金額

function calc($yen, $product) {
    // この関数内に処理を記述
    $yen = $yen - $product;
    $yenp = $yen % 10000;
    $yen10000 = ($yen - $yenp) / 10000;
    echo "10000円札x".$yen10000."枚、";
    $yen = $yenp;
    $yenp = $yen % 5000;
    $yen5000 = ($yen - $yenp) / 5000;
    echo "5000円札x".$yen5000."枚、";
    $yen = $yenp;
    $yenp = $yen % 1000;
    $yen1000 = ($yen - $yenp) / 1000;
    echo "1000円札x".$yen1000."枚、";
    $yen = $yenp;
    $yenp = $yen % 500;
    $yen500 = ($yen - $yenp) / 500;
    echo "500円玉x".$yen500."枚、";
    $yen = $yenp;
    $yenp = $yen % 100;
    $yen100 = ($yen - $yenp) / 100;
    echo "100円玉x".$yen100."枚、";
    $yen = $yenp;
    $yenp = $yen % 50;
    $yen50 = ($yen - $yenp) / 50;
    echo "50円玉x".$yen50."枚、";
    $yen = $yenp;
    $yenp = $yen % 10;
    $yen10 = ($yen - $yenp) / 10;
    echo "10円玉x".$yen10."枚、";
    $yen = $yenp;
    $yenp = $yen % 5;
    $yen5 = ($yen - $yenp) / 5;
    echo "5円玉x".$yen5."枚、";
    $yen = $yenp;
    $yen1 = $yen;
    echo "1円玉x".$yen1."枚\n";
}

if($yen >= $product){
    calc($yen, $product);
} else {
    $husoku = $product - $yen;
    echo $husoku."円足りません。\n";
}


// 10 / 4 = 2 … 2
// 10 / 4 = 2 + 2
// 10 = 4 * 2 + 2
// $yen / 10000 = 0　…　9850
// $yen = 10000 * 0　+　9850


?>
