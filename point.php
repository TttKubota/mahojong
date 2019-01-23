<?php

/*
順子 = 0
刻子 = 2

暗刻 *= 2 

壱九牌 *= 2 

槓子 *= 4
 */


function koutsu($prop) {
  $point  = $prop[  'koutsu']  ? 2 : 0;
  $point *= $prop[   'ankou']  ? 2 : 1;
  $point *= $prop['ichikyui']  ? 2 : 1;
  $point *= $prop[    'kann']  ? 4 : 1;
  return $point;
}
function atama($prop) {
  $point = $prop['ichikyui']  ? 2 : 0;
  return $point;
}

function TestKoutsu() {
  $prop = [];
  $pairs= [];
  foreach(range(1,8) as $k) {
    $propAtama['ichikyui'] = rand(0,1) == 1 ? 2 : 0;
    $pAtama = $propAtama['ichikyui']  ?  '断' : '老';
    echo sprintf("[%s:%02d]",$pAtama, $propAtama['ichikyui'] );
    foreach(range(1,4) as $n) {
      $prop[  'koutsu'] = rand(0,1) == 1 ? true : false ;
      $prop[   'ankou'] = rand(0,1) == 1 ? true : false ;
      $prop['ichikyui'] = rand(0,1) == 1 ? true : false ;
      $prop[    'kann'] = rand(0,1) == 1 ? true : false ;
      $pairs[$n]= koutsu($prop); 
    }
    $sum = 0;
    foreach(range(1,4) as $n) {
      $p1 = $prop[  'koutsu']  ? '刻' : '順';
      $p2 = $prop[   'ankou']  ?  '暗' : '明';
      $p3 = $prop['ichikyui']  ?  '断' : '老';
      $p4 = $prop[    'kann']  ?  '槓' : '  ';
      $sum += $pairs[$n];
      echo sprintf("[%s%s%s%S:%02d]",$p1, $p2, $p3, $p4, $pairs[$n]);
    }
    // 待ち
    $待ち = [];
    $待ち['待ち'] = rand(0,1) == 1 ? 2 : 0;
    $待ち['自摸'] = rand(0,1) == 1 ? 2 : 0;
    $待ち点 = $待ち['待ち'] + $待ち['自摸'];

    echo '待ち' . $待ち点 . '  sum = ' . $sum . PHP_EOL. PHP_EOL;
  }
}

function QuizeKoutsu() {
  foreach(range(1,8) as $k) {
    $prop = [];
    $pairs= [];
    $propAtama['ichikyui'] = rand(0,1) == 1 ? true:false;
    $propAtama['KANJI'] = $propAtama['ichikyui'] ? '役牌':'断公牌';
    $propAtama['tensu'] = $propAtama['ichikyui'] ? 2 : 0;
    foreach(range(1,4) as $n) {
      $prop[$n][  'koutsu'] = rand(0,1) == 1 ? true : false ;
      $prop[$n][   'ankou'] = rand(0,1) == 1 ? true : false ;
      $prop[$n]['ichikyui'] = rand(0,1) == 1 ? true : false ;
      if ($prop[$n][  'koutsu']) {
        $prop[$n]['kann'] = rand(0,9) == 0 ? true : false ;
      } else {
        $prop[$n]['kann'] =  false ;
      }
      $pairs[$n]= koutsu($prop[$n]); 
    }
    $sum = 0;
    $p1 = $p2 = $p3 = $p4 = '';
    foreach(range(1,4) as $n) {
      $prop[$n][  'koutsuKANJI'] = $prop[$n][  'koutsu'] ? '刻' : '順';
      $prop[$n][   'ankouKANJI'] = $prop[$n][   'ankou'] ?  '暗' : '明';
      $prop[$n]['ichikyuiKANJI'] = $prop[$n]['ichikyui'] ?  '断' : '老';
      $prop[$n][    'kannKANJI'] = $prop[$n][    'kann'] ?  '槓' : '  ';
      $kind = $prop[$n]['kann'] ? '慣' : $prop[$n]['koutsuKANJI'];
      $prop[$n]['KANJI'] =
          $prop[$n][   'ankouKANJI'] .
          $kind .
          $prop[$n]['ichikyuiKANJI'];
      $sum += $pairs[$n];
    }
    // 待ち
    $待ちと上り方 = [];
    $待ちと上り方 = [
     0 => [ 'mati' => '両面待ち',                  'ten' => 0 ],
     1 => [ 'mati' => 'カンチャン待ち',            'ten' => 2 ],
     2 => [ 'mati' => 'ペンチャン待ち',            'ten' => 2 ],
     3 => [ 'mati' => 'シャンポン待ち(タンヤオ牌)','ten' => 0 ],
     4 => [ 'mati' => 'シャンポン待ち(１９牌字牌)','ten' => 0 ],
     5 => [ 'mati' => 'アタマ待ち(タンヤオ牌)',    'ten' => 2 ],
     6 => [ 'mati' => 'アタマ待ち(１９牌字牌)',    'ten' => 2 ],
     7 => [ 'agari' => 'ロン',                      'ten' => 0 ],
     8 => [ 'agari' => '自摸',                      'ten' => 2 ],
   ];

    $待ち   = rand(0,6);
    $上り方 = rand(7,8);

    echo '======問題============================'. PHP_EOL;
    echo sprintf("[%s:??]",$propAtama['KANJI']);
    foreach(range(1,4) as $n) {
   //   echo sprintf("[%s%s%s%S:??]",$p1, $p2, $p3, $p4);
      echo sprintf("[%s:??]", $prop[$n]['KANJI']);
    }
    echo PHP_EOL;
    echo sprintf("待ち:%s = ??点, 上り方:%s = ??点",
      $待ちと上り方[$待ち]['mati'], 
      $待ちと上り方[$上り方]['agari']
    ). PHP_EOL;
    echo '      ========== 上り点は？=========='. PHP_EOL;
    $command = trim(fgets(STDIN));
    echo PHP_EOL;
    if ($command == "q") { break; }

    // Anser
    echo '======回答============================'. PHP_EOL;
    echo sprintf("[%s:%02d]",
            $propAtama['KANJI'], $propAtama['tensu']);
    foreach(range(1,4) as $n) {
    //  echo sprintf("[%s%s%s%S:%02d]",$p1, $p2, $p3, $p4, $pairs[$n]);
      echo sprintf("[%s:%02d]", $prop[$n]['KANJI'], $pairs[$n]);
    }
    echo PHP_EOL;
    echo sprintf("待ち:%s = %d点, 上り方:%s = %d点",
      $待ちと上り方[$待ち]['mati'], 
      $待ちと上り方[$待ち]['ten'], 
      $待ちと上り方[$上り方]['agari'], 
      $待ちと上り方[$上り方]['ten'] 
    ). PHP_EOL;

    $基本点 = 20;
    $sumAll = $sum + 
      $基本点+
      $待ちと上り方[$待ち]['ten'] +
      $待ちと上り方[$上り方]['ten'] + 
      $propAtama['ichikyui'] ; 

    echo sprintf("合計:%d点 = 基本点:%d点 刻子:%d点 雀頭:%d点 待ち:%d点 上り:%d点",
      $sumAll,
      $基本点,
      $sum,
      $propAtama['ichikyui'],
      $待ちと上り方[$待ち]['ten'],
      $待ちと上り方[$上り方]['ten']);
    echo PHP_EOL;
    echo sprintf("最後に切り上げて、上り点は%2d点です。",
      round($sumAll+4, -1));

    echo PHP_EOL;

    $command = trim(fgets(STDIN));
    echo PHP_EOL;
    if ($command == "q") { break; }
  }
}

QuizeKoutsu();


