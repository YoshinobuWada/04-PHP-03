<?php
// ＜アルゴリズムの注意点＞
// アルゴリズムではこれまでのように調べる力ではなく物事を論理的に考える力が必要です。
// 検索して答えを探して解いても考える力には繋がりません。
// まずは検索に頼らずに自分で処理手順を考えてみましょう。


// 「algorithm5」で作成したポーカープログラムにジョーカーを追加してください。
// ジョーカー１枚のみ、suitをjoker、numberを0と表す。
// 上記以外は不正として処理してください。

// 追加された役
// 「フォーカード」＋ジョーカーは「ファイブカード」

// 判定は強い役を優先してください。組み合わせの強さ順は以下とする。
// ロイヤルストレートフラッシュ > ストレートフラッシュ > ファイブカード > フォーカード > フルハウス > フラッシュ > ストレート > スリーカード > ツーペア > ワンペア
// ジョーカーが出た時点で最低でも「ワンペア」となること


// 手札
$cards = [
    ['suit' => 'heart', 'number' => 1],
    ['suit' => 'joker', 'number' => 0],
    ['suit' => 'heart', 'number' => 11],
    ['suit' => 'heart', 'number' => 10],
    ['suit' => 'heart', 'number' => 13],
];

function sortByNumber($Number, $sort_order, $array)
{
    foreach ($array as $number => $value) {
        $standard_number_array[$number] = $value[$Number];
    }

    array_multisort($standard_number_array, $sort_order, $array);

    return $array;
}

function frashJudge($cards)
{
    $cards_count = count($cards);
    $cards_suit = [];
    for ($i = 0; $i <= $cards_count - 1; $i++) {
        array_push($cards_suit, $cards[$i]['suit']);
    }
    $cards_suit_count = array_count_values($cards_suit);
    $cards_suit_max = max($cards_suit_count);
    if ($cards_suit_max == $cards_count) {
        return true;
    } else {
        return false;
    }
}

function straightJudge($cards)
{
    $cards_count = count($cards);
    $cards_number = [];
    if ($cards_count == 4) {
        for ($i = 0; $i <= 3; $i++) {
            array_push($cards_number, $cards[$i]['number']);
        }
        if ($cards_number[1] == $cards_number[0] + 1 && $cards_number[2] == $cards_number[0] + 2 && $cards_number[3] == $cards_number[0] + 3) {
            return true;
        } else {
            return false;
        }
    }
    if ($cards_count == 5) {
        for ($i = 0; $i <= 4; $i++) {
            array_push($cards_number, $cards[$i]['number']);
        }
        if ($cards_number[1] == $cards_number[0] + 1 && $cards_number[2] == $cards_number[0] + 2 && $cards_number[3] == $cards_number[0] + 3 && $cards_number[4] == $cards_number[0] + 4) {
            return true;
        } else {
            return false;
        }
    }
}

function judge($cards)
{
    // この関数内に処理を記述
    // 手札にjokerがある場合
    if (array_search('joker', array_column($cards, 'suit')) && array_search(0, array_column($cards, 'number'))) {
        for ($i = 0; $i <= 4; $i++) {
            if ($cards[$i]['number'] == 0) {
                unset($cards[$i]);
                $cards = array_values($cards);
                break;
            }
        }
        //　カードの不正チェック
        $cards_arr = [];
        for ($i = 0; $i <= 3; $i++) {
            array_push($cards_arr, $cards[$i]['suit'] . $cards[$i]['number']);
            $cards_count = array_count_values($cards_arr);
            $max = max($cards_count);
            if ($cards[$i]['number'] <= 0 || $cards[$i]['number'] >= 14 || $max > 1) {
                return "手札は不正です。";
            }
            if ($cards[$i]['suit'] != 'heart' && $cards[$i]['suit'] != 'spade' && $cards[$i]['suit'] != 'diamond' && $cards[$i]['suit'] != 'club') {
                return "手札は不正です。";
            }
        }
        // カードの並び替え
        $sorted_cards = sortByNumber('number', SORT_ASC, $cards);

        // 役判定
        $frash = frashJudge($sorted_cards);
        $straight = straightJudge($sorted_cards);
        $cards_arr2 = [];
        for ($i = 0; $i <= 3; $i++) {
            array_push($cards_arr2, $sorted_cards[$i]['number']);
        }
        $cards_count2 = array_count_values($cards_arr2);
        $cards_count3 = array_count_values($cards_count2);
        $max2 = max($cards_count2);
        $max3 = max($cards_count3);
        $min2 = min($cards_count2);
        if ($frash 
        && ($cards_arr2[0] == 1 || $cards_arr2[0] == 10)
        && ($cards_arr2[1] == 10 || $cards_arr2[1] == 11)
        && ($cards_arr2[2] == 11 || $cards_arr2[2] == 12)
        && ($cards_arr2[3] == 12 || $cards_arr2[3] == 13)
        ){
            return "役はロイヤルストレートフラッシュです";
        }
        if ($frash && $straight) {
            return "役はストレートフラッシュです";
        }
        if ($max2 == 4) {
            return "役はファイブカードです";
        }
        if ($max2 == 3) {
            return "役はフォーカードです";
        }
        if ($max3 == 2) {
            return "役はフルハウスです";
        }
        if ($frash) {
            return "役はフラッシュです";
        }
        if ($straight) {
            return "役はストレートです";
        }
        if ($max2 == 2) {
            return "役はスリーカードです";
        }
        if ($max3 == 2) {
            return "役はスリーカードです";
        }
        return "役はワンペアです";
    }

    // 手札にjokerがない場合
    // カードの不正チェック
    $cards_arr = [];
    for ($i = 0; $i <= 4; $i++) {
        array_push($cards_arr, $cards[$i]['suit'] . $cards[$i]['number']);
        $cards_count = array_count_values($cards_arr);
        $max = max($cards_count);
        if ($cards[$i]['number'] <= 0 || $cards[$i]['number'] >= 14 || $max > 1) {
            return "手札は不正です。";
        }
        if ($cards[$i]['suit'] != 'heart' && $cards[$i]['suit'] != 'spade' && $cards[$i]['suit'] != 'diamond' && $cards[$i]['suit'] != 'club') {
            return "手札は不正です。";
        }
    }
    // カードの並び替え
    $sorted_cards = sortByNumber('number', SORT_ASC, $cards);

    //　役判定
    $frash = frashJudge($sorted_cards);
    $straight = straightJudge($sorted_cards);
    $cards_arr2 = [];
    for ($i = 0; $i <= 4; $i++) {
        array_push($cards_arr2, $sorted_cards[$i]['number']);
    }
    $cards_count2 = array_count_values($cards_arr2);
    $cards_count3 = array_count_values($cards_count2);
    $max2 = max($cards_count2);
    $max3 = max($cards_count3);
    $min2 = min($cards_count2);
    if ($frash && $sorted_cards[0]['number'] == 1 && $sorted_cards[1]['number'] == 10 && $sorted_cards[2]['number'] == 11 && $sorted_cards[3]['number'] == 12 && $sorted_cards[4]['number'] == 13) {
        return "役はロイヤルストレートフラッシュです";
    }
    if ($frash && $straight) {
        return "役はストレートフラッシュです";
    }
    if ($max2 == 4) {
        return "役はフォーカードです";
    }
    if ($max2 == 3 && $min2 == 2) {
        return "役はフルハウスです";
    }
    if ($frash) {
        return "役はフラッシュです";
    }
    if ($straight) {
        return "役はストレートです";
    }
    if ($max2 == 3) {
        return "役はスリーカードです";
    }
    if ($max3 == 2) {
        return "役はツーペアです";
    }
    if ($max2 == 2) {
        return "役はワンペアです";
    }

    // 結果を返す
}


// 関数「judge」を呼び出して結果を表示する
echo "手札は\n";
for ($i = 0; $i <= 4; $i++) {
    echo $cards[$i]['suit'] . $cards[$i]['number'] . " ";
}
echo "\n";
echo judge($cards) . "\n";

?>