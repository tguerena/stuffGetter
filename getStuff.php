<?php
date_default_timezone_set("America/New_York");
$devices = `adb devices`;
preg_match_all("/(.*)\s+device\n/",$devices,$matches);
$devices = $matches[1];
print_r($devices);
$count = 0;
$keycode = 0;
while (true) {
    $time = date("g:i:s a");
    echo "\e[35mRun #" . $count . "    " . $time . "\e[0m\n";
    $startx = mt_rand(100,400);
    $starty = mt_rand(800,1500);
    $endx = mt_rand(1000,1400);
    $endy = mt_rand(800,1500);
    $duration = mt_rand(100,250);
    $sleep = mt_rand(1,4);
    $sleep2 = mt_rand(279,290);
    echo "Turning On\n";
    foreach ($devices as $device) {
        `adb -s $device shell input keyevent 82`;
    }
    if ($keycode > 0) {
        `adb shell input text $keycode && adb shell input keyevent 66`;
    }
    if ($count %5 == 0){
        foreach ($devices as $device) {
            echo "KILLING THE APP\n";
            `adb -s $device shell am force-stop com.nianticlabs.pokemongo`;
            echo "STARTING THE APP\n";
            `adb -s $device shell monkey -p com.nianticlabs.pokemongo  -c android.intent.category.LAUNCHER 1`;
        }
        sleep(20);
        echo "Accept Agreement\n";
        foreach ($devices as $device) {
            $checkForTopApp = `adb -s $device shell dumpsys activity | grep top-activity`;
            echo $checkForTopApp;
            if (strpos($checkForTopApp,"pokemon") !== false) {
                `adb -s $device shell input tap 843 1443`;
            }
        }
    }
//    $topApp = `adb shell dumpsys activity | grep top-activity`;
//    echo "$topApp\n";
    echo "Sleeping for 10\n";
    sleep(12);
    echo "Touching all over to find the spot... er... stop\n";

    foreach ($devices as $device) {
        $checkForTopApp = `adb -s $device shell dumpsys activity | grep top-activity`;
        if (strpos($checkForTopApp,"pokemon") !== false) {
            `adb -s $device shell "input touchscreen tap 1245 1345 && input touchscreen tap 1145 1345 && input touchscreen tap 1045 1345 && input touchscreen tap 945 1345 && input touchscreen tap 845 1345 && input touchscreen tap 745 1345 && input touchscreen tap 645 1345 && input touchscreen tap 545 1345"`;
        }
    }
    echo "Sleeping for $sleep\n";

    sleep($sleep);

    echo "Swiping the PokeStop\n";

    foreach ($devices as $device) {
        $checkForTopApp = `adb -s $device shell dumpsys activity | grep top-activity`;
        if (strpos($checkForTopApp,"pokemon") !== false) {
            `adb -s $device shell input touchscreen swipe $startx $starty $endx $endy $duration;`;
        }
    }
    echo "Tap Back\n";
    foreach ($devices as $device) {
        $checkForTopApp = `adb -s $device shell dumpsys activity | grep top-activity`;
        if (strpos($checkForTopApp,"pokemon") !== false) {
            `adb -s $device shell input keyevent KEYCODE_BACK`;
        }
    }
    echo "Sleeping for 3\n";
    sleep(3);
    foreach ($devices as $device) {
        $checkForTopApp = `adb -s $device shell dumpsys activity | grep top-activity`;
        if (strpos($checkForTopApp,"pokemon") !== false) {
            `adb -s $device shell input keyevent KEYCODE_POWER`;
        }
    }

    foreach ($devices as $device) {
        $command = `adb -s $device shell dumpsys battery | grep level`;
        echo "\e[36mBattery$command\e[0m";
    }
    echo "Sleeping for $sleep2\n";
    echo "------------------------------------------------------------------------\n";
    sleep($sleep2);
    foreach ($devices as $device) {
        $checkForTopApp = `adb -s $device shell dumpsys activity | grep top-activity`;
        if (strpos($checkForTopApp,"pokemon") !== false) {
            `adb -s $device shell input tap 843 1443`;
        }
    }
    $count++;
}



//KILL IT
//adb shell am force-stop com.nianticlabs.pokemongo

//START IT
//adb shell monkey -p com.nianticlabs.pokemongo  -c android.intent.category.LAUNCHER 1

//TAP ACCEPT
//adb shell input tap 843 1443