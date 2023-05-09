<?php
// ＜アルゴリズムの注意点＞
// アルゴリズムではこれまでのように調べる力ではなく物事を論理的に考える力が必要です。
// 検索して答えを探して解いても考える力には繋がりません。
// まずは検索に頼らずに自分で処理手順を考えてみましょう。


// 以下はポーカーの役を判定するプログラムです。
// cards配列に格納したカードの役を判定し、結果表示してください。
// cards配列には計5枚、それぞれ絵柄(suit)、数字(numeber)を格納する
// 絵柄はheart, spade, diamond, clubのみ
// 数字は1-13のみ

// 上記以外の絵柄や数字が存在した場合、または同一の絵柄、数字がcards配列に存在した場合、
// 役の判定前に「手札が不正です」と表示してください。
// 役判定は関数に記述し、関数を呼び出して結果表示すること
// プログラムが完成したらcards配列を差し替えてすべての役で検証を行い、提出時にテストケースを示すこと

// <役>
// ワンペア・・・同じ数字２枚（ペア）が１組
// ツーペア・・・同じ数字２枚（ペア）が２組
// スリーカード・・・同じ数字３枚
// ストレート・・・数字の連番５枚（13と1は繋がらない）
// フラッシュ・・・同じマークが５枚
// フルハウス・・・同じ数字３枚が１組＋同じ数字２枚（ペア）が１組
// フォーカード・・・同じ数字４枚
// ストレートフラッシュ・・・数字の連番５枚＋同じマークが５枚
// ロイヤルストレートフラッシュ・・・1, 10, 11, 12, 13で同じマーク
// ※下の方が強い

// 表示例1）
// 手札は 
// heart2 heart5 heart3 heart4 culb1
// 役はストレートです

// 表示例2）
// 手札は 
// heart1 spade2 diamond11 club13 heart9
// 役はなしです

// 表示例3）
// 手札は 
// heart1 heart1 heart3 heart4 heart5
// 手札は不正です


// 手札
$cards = [
    ['suit' => 'heart', 'number' => 1],
    ['suit' => 'spade', 'number' => 2],
    ['suit' => 'diamond', 'number' => 11],
    ['suit' => 'club', 'number' => 13],
    ['suit' => 'heart', 'number' => 9],
];

function  sortByNumber($Number,$sort_order,$array){
    foreach($array as $number => $value){
        $standard_number_array[$number] = $value[$Number];
    }
    
    array_multisort($standard_number_array, $sort_order, $array);

    return $array;
}

function frashJudge($cards){
    $cards_suit = [];
    for($i = 0; $i <= 4 ; $i ++){
        array_push($cards_suit,$cards[$i]['suit']);
    }
    $cards_suit_count = array_count_values($cards_suit);
    $cards_suit_max = max($cards_suit_count);
    if($cards_suit_max == 5){
        return true;
    } else {
        return false;
    }
}

function straightJudge($cards){
    $cards_number = [];
    for($i = 0 ; $i <= 4 ; $i ++){
        array_push($cards_number,$cards[$i]['number']);
    }
    if($cards_number[1] == $cards_number[0] + 1 && $cards_number[2] == $cards_number[0] + 2 && $cards_number[3] == $cards_number[0] + 3 && $cards_number[4] == $cards_number[0] + 4){
        return true;
    } else {
        return false;
    }
}

function judge($cards)
{
    // この関数内に処理を記述
    // カードの不正チェック
    $cards_arr = [];
    for($i = 0 ; $i <= 4 ; $i ++){
        array_push($cards_arr,$cards[$i]['suit'].$cards[$i]['number']);
        $cards_count = array_count_values($cards_arr);
        $max = max($cards_count);
        if($cards[$i]['number'] <= 0 || $cards[$i]['number'] >= 14 ||  $max > 1){
            return "手札は不正です。";
        }
        if($cards[$i]['suit'] != 'heart' && $cards[$i]['suit'] != 'spade' && $cards[$i]['suit'] != 'diamond' && $cards[$i]['suit'] != 'club'){
            return "手札は不正です。";
        }
    }
    // カードの並び替え
    $sorted_cards = sortByNumber('number', SORT_ASC, $cards);

    //　役判定
    $frash = frashJudge($sorted_cards);
    $straight = straightJudge($sorted_cards);
    $cards_arr2 = [];
    for($i = 0 ; $i <= 4 ; $i ++){
        array_push($cards_arr2,$sorted_cards[$i]['number']);
        $cards_count2 = array_count_values($cards_arr2);
        $cards_count3 = array_count_values($cards_count2);
        $max2 = max($cards_count2);
        $max3 = max($cards_count3);
        $min2 = min($cards_count2);
    }
    if($frash && $sorted_cards[0]['number'] == 1 && $sorted_cards[1]['number'] == 10 && $sorted_cards[2]['number'] == 11 && $sorted_cards[3]['number'] == 12 && $sorted_cards[4]['number'] == 13 ){
        return"役はロイヤルストレートフラッシュです";
    }
    if($frash && $straight){
        return "役はストレートフラッシュです";
    }
    if($max2 == 4){
        return "役はフォーカードです";
    }
    if($max2 == 3 && $min2 == 2){
        return "役はフルハウスです";
    }
    if($frash){
        return "役はフラッシュです";
        }
    if($straight){
        return "役はストレートです";
    }
    if($max2 == 3){
        return "役はスリーカードです";
    }
    if($max3 == 2){
        return "役はツーペアです";
    }
    if($max2 == 2){
        return "役はワンペアです";
    } else {
        return "役はなしです";
    }

    // 結果を返す
}


// 関数「judge」を呼び出して結果を表示する
echo "手札は\n";
for($i = 0 ; $i <= 4 ; $i ++){
    echo $cards[$i]['suit'].$cards[$i]['number']." ";
}
echo "\n";
echo judge($cards)."\n";

//　テストケース
// heart12 club spade2 diamond9 heart9
// heart1 heart1 heart3 heart4 heart5
// heart1 spade2 diamond11 club13 heart9
?>