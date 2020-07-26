<?php
// -513 60 -880 -410 916 -933 -577 391 -774 249 360 -877 243 -857 221 -33 -733 -757 426 -136 -888 -706 881 268 660 786 437 158 -686 -173 -360 73 158 271 -581 986 -992 -934 -175 917 59 585 -346 283 595 185 -182 -994 60 -953 -985 530 -713 -614 309 -378 -321 683 -49 -592 -112 809 986 56 903 -458 31 -290 364 601 32 377 -789 -641 -805 630 -861 -219 689 -385 323 666 -385 805 141 -635 261 24 -192 566 965 -382 -496 622 -318 -130 -441 -441 -133 233
// echo "hello";
$la = $argv;
$lb = $op = [];

if (count($la) === 1) {
    echo "Please enter a number list." . PHP_EOL;
    exit();
}
unset($la[0]);
$la = array_filter(array_values($la));

if (count($la) === 1) {
    echo "Please enter more than 1 number." . PHP_EOL;
    exit();
}

if (min(array_count_values($la)) > 1) {
    echo "You can't have duplicate numbers." . PHP_EOL;
    exit();
}

$sorted = array_values($la);
sort($sorted);

// Get pivot = average
function getPivot()
{
    global $la;
    $average = array_sum($la) / count($la);
    echo "Average is " . $average . PHP_EOL;
    $closest = null;
    foreach ($la as $number) {
        if ($closest === null || abs($average - $closest) > abs($number - $average)) {
            $closest = $number;
        }
    }
    return $closest;
}

$pivot = getPivot();
echo "Pivot is " . $pivot . PHP_EOL;

// Échange les positions des deux premiers éléments de la
function sa()
{
    global $la, $op;
    if (count($la) <= 1) { // not enough numbers
        return true;
    }

    $temp = $la[0];
    $la[0] = $la[1];
    $la[1] = $temp;

    array_push($op, 'sa');
}

// Échange les positions des deux premiers éléments de lb
function sb()
{
    global $lb, $op;
    if (count($lb) <= 1) { // not enough numbers
        return true;
    }

    $temp = $lb[0];
    $lb[0] = $lb[1];
    $lb[1] = $temp;

    array_push($op, 'sb');
}

// sa et sb en même temps.
function sc()
{
    sa();
    sb();
    array_push($op, 'sc');
}

// Prend le premier élément de lb et le place à la première position de la
function pa()
{
    global $la, $lb, $op;
    if (count($lb) === 0) { // not enough numbers
        return true;
    }

    array_unshift($la, $lb[0]);
    unset($lb[0]);
    $lb = array_values($lb);
    array_push($op, 'pa');
}

// Prend le premier élément de la et le place à la première position de lb
function pb()
{
    global $la, $lb, $op;
    if (count($la) === 0) { // not enough numbers
        return true;
    }

    array_unshift($lb, $la[0]);
    unset($la[0]);
    $la = array_values($la);
    array_push($op, 'pb');
}

// Fait une rotation de la vers le début
function ra()
{
    global $la, $op;
    if (count($la) <= 1) { // not enough numbers
        return true;
    }

    array_push($la, array_shift($la));
    array_push($op, 'ra');
}

// Fait une rotation de lb vers le début
function rb()
{
    global $lb, $op;
    if (count($lb) <= 1) { // not enough numbers
        return true;
    }

    array_push($lb, array_shift($lb));
    array_push($op, 'rb');
}

// ra et rb en même temps.
function rr()
{
    ra();
    rb();
    array_push($op, 'rr');
}

// Fait une rotation de la vers la fin. (le dernier élément devient le premier).
function rra()
{
    global $la, $op;
    if (count($la) <= 1) { // not enough numbers
        return true;
    }
    array_unshift($la, array_pop($la));
    array_push($op, 'rra');
}

// Fait une rotation de lb vers la fin. (le dernier élément devient le premier).
function rrb()
{
    global $lb, $op;
    if (count($lb) <= 1) { // not enough numbers
        return true;
    }

    array_unshift($lb, array_pop($lb));
    array_push($op, 'rrb');
}

// rra et rrb en même temps.
function rrr()
{

    rra();
    rrb();
    array_push($op, 'rrr');
}

// print_r($la);
// sa();
// sb();
// rra();
// print_r($la);
// print_r($op);

echo "Lets sort " . count($la) . " numbers ;D" . PHP_EOL;

// Verify if array is sorted
function verify()
{
    global $la, $sorted;
    if ($sorted === $la) {
        return true;
    }
}

// function quick_sort($my_array)
// {
//     global $op;
//     array_push($op, 'quicksorting....');
//     $loe = $gt = array();
//     if (count($my_array) < 2) {
//         return $my_array;
//     }
//     $pivot_key = key($my_array);
//     $pivot = array_shift($my_array);
//     foreach ($my_array as $val) {
//         if ($val <= $pivot) {
//             $loe[] = $val;
//         } elseif ($val > $pivot) {
//             $gt[] = $val;
//         }
//     }
//     return array_merge(quick_sort($loe), array($pivot_key => $pivot), quick_sort($gt));
// }

// $la = quick_sort($la);

function simple_sort()
{
    global $la, $sorted;

    if (count($la) === 0) {
        return true;
    }
    for ($i = 0; $i < count($sorted); $i++) {
        $key = array_search($sorted[$i], $la);
        echo ($sorted[$i] . "  " . $key . " " . PHP_EOL);
        if ($key <= count($sorted) / 2) {
            for ($j = 0; $j < $key; $j++) {
                ra();
            }
        } else {
            for ($j = 0; $j < (count($la) - $key); $j++) {
                echo ('entering reverse la' . PHP_EOL);
                rra();
            }
        }
        pb();
    }
    for ($i = 0; $i < count($sorted); $i++) {
        pa();
    }
}

simple_sort();
print_r($la);
print_r($lb);

if (verify()) {
    echo "Array is sorted ! It took " . count($op) . " operations." . PHP_EOL;
}
