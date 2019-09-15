<?php

namespace App\Parsers\GE;

use App\Parsers\CsvParseTrait;
use App\Parsers\ParseInterface;
//use Symfony\Component\Config\Resource\FileResource;

/**
 * php bin/console app:parse:csv GE:htmlmap
 */
class htmlmap implements ParseInterface
{
    use CsvParseTrait;

    // the wiki output format / template we shall use
    const WIKI_FORMAT = '
    <!doctype html>

    <html lang="en">
    <head>
      <meta charset="utf-8">

      <title>{mapshort} - {placename}</title>
      <link rel="stylesheet" href="assets/css/main.css">

    </head>

    <body>
        <div style="width: 2048px; height: 2048px; position: absolute;">
        <img id="backgroundmap" style="position: relative;" src="maps/{mapshort} - {placename}.png" alt="..." title="{placename}" />


        <div class="top-left">
            <button onclick="key()">Key Toggle</button><br>
            <button onclick="allmarkers()">allmarkers</button><br>
            <div id="key">
            <button onclick="positionmarker()">PositionMarker = <img src="icons/5.png" alt=""></button><br>
            <button onclick="gimmick()">Gimmick = <img src="icons/6.png" alt=""></button><br>
            <button onclick="eventnpc()">EventNpc = <img src="icons/8.png" alt=""></button><br>
            <button onclick="battlenpc()">BattleNpc = <img src="icons/9.png" alt=""></button><br>
            <button onclick="aetheryte()">Aetheryte = <img src="icons/12.png" alt=""></button><br>
            <button onclick="gathering()">Gathering = <img src="icons/14.png" alt=""></button><br>
            <button onclick="treasure()">Treasure = <img src="icons/16.png" alt=""></button><br>
            <button onclick="poprange()">PopRange = <img src="icons/40.png" alt=""></button><br>
            <button onclick="exitrange()">ExitRange = <img src="icons/41.png" alt=""></button><br>
            <button onclick="eventobject()">EventObject = <img src="icons/45.png" alt=""></button><br>
            <button onclick="eventrange()">EventRange = <img src="icons/49.png" alt=""></button><br>
            <button onclick="questmarker()">QuestMarker = <img src="icons/51.png" alt=""></button><br>
            <button onclick="collisionbox()">CollisionBox = <img src="icons/57.png" alt=""></button><br>
            <button onclick="clientpath()">ClientPath = <img src="icons/65.png" alt=""></button><br>
            <button onclick="serverpath()">ServerPath = <img src="icons/66.png" alt=""></button><br>
            <button onclick="targetmarker()">TargetMarker = <img src="icons/68.png" alt=""></button><br>
        </div>
    <div id="allmarkers">
    <div id="positionmarker">
        {output5}
    </div>
    <div id="Gimmick">
        {output6}
    </div>
    <div id="eventnpc">
        {output8}
    </div>
    <div id="battlenpc">
        {output9}
    </div>
    <div id="aetheryte">
        {output12}
    </div>
    <div id="gathering">
        {output14}
    </div>
    <div id="poprange">
        {output40}
    </div>
    <div id="exitrange">
        {output41}
    </div>
    <div id="eventobject">
        {output45}
    </div>
    <div id="eventrange">
        {output49}
    </div>
    <div id="questmarker">
        {output51}
    </div>
    <div id="collisionbox">
        {output57}
    </div>
    <div id="clientpath">
        {output65}
    </div>
    <div id="serverpath">
        {output66}
    </div>
    <div id="targetmarker">
        {output68}
    </div>

    </div>
    </div>
    <script src="assets/js/key.js"></script>
    </body>
    </html>
     ';


    public function parse()
    {
        // grab CSV files we want to use
        $Level = $this->csv('Level');
        $mapcsv = $this->csv('Map');
        $placenamecsv = $this->csv('PlaceName');
        $gatheringpointcsv = $this->csv('GatheringPoint');
        $gatheringpointbasecsv = $this->csv('GatheringPointBase');
        $GatheringTypecsv = $this->csv('GatheringType');
        $enpcresidentcsv = $this->csv('ENpcResident');
        $eobjnamecsv = $this->csv('EObjName');

        //this controls the map it will make, just change it to anything in map.exd
        $mapnumber = 29;
        
        // (optional) start a progress bar
        $this->io->progressStart($Level->total);

        $Total5 =[];
        // loop through data
        foreach ($Level->data as $id => $LevelData) {
            $this->io->progressAdvance();

            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            //skip if not map 494
            if ($map !=$mapnumber) continue;
            if ($type !=5) continue;

            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
                $placename = $placenamecsv->at($mapplacename)['Name'];

            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];

            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
                $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);

            $icon = $type;


            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";



            $Total5[] = $string;

//start of section
             $Total6 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=6) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total6[] = $string;
        }
// end of section
//start of section
             $Total8 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=8) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total8[] = $string;
        }
// end of section
//start of section
             $Total9 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=9) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total9[] = $string;
        }
// end of section
//start of section
             $Total12 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=12) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total12[] = $string;
        }
// end of section
//start of section
             $Total14 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=14) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total14[] = $string;
        }
// end of section
//start of section
             $Total40 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=40) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total40[] = $string;
        }
// end of section
//start of section
             $Total41 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=41) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total41[] = $string;
        }
// end of section
//start of section
             $Total45 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=45) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $eobjectname ."\" title=\"
            ". $eobjectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total45[] = $string;
        }
// end of section
//start of section
             $Total49 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=49) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total49[] = $string;
        }
// end of section
//start of section
             $Total51 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=51) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total51[] = $string;
        }
// end of section
//start of section
             $Total57 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=57) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total57[] = $string;
        }
// end of section
//start of section
             $Total65 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=65) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total65[] = $string;
        }
// end of section
//start of section
             $Total66 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=66) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total66[] = $string;
        }
// end of section
//start of section
             $Total68 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=68) continue;
            $mapshort = substr($mapcsv->at($map)['Id'], 0, 4);
            $mapplacename = $mapcsv->at($map)['PlaceName'];
            $placename = $placenamecsv->at($mapplacename)['Name'];
            $object = $LevelData['Object'];
            $objectname = $enpcresidentcsv->at($object)['Singular'];
            $eobjectname = $eobjnamecsv->at($object)['Singular'];
            //get the map positions for each object
            $scale = $mapcsv->at($LevelData["Map"])['SizeFactor'];
            $c = $scale / 100.0;
            $NpcLevelX = $LevelData["X"];
            $NpcLevelY = $LevelData["Z"];
            $offsetx = $mapcsv->at($LevelData["Map"])['Offset{X}'];
            $offsetValueX = ($NpcLevelX + $offsetx) * $c;
                $NpcLocX = ((41.0 / $c) * (($offsetValueX + 1024.0) / 2048.0) +1);
                $NpcPixelX = (($NpcLocX - 1) * 50 * $c);
            $offsety = $mapcsv->at($LevelData["Map"])['Offset{Y}'];
                $offsetValueY = ($NpcLevelY + $offsety) * $c;
                $NpcLocY = ((41.0 / $c) * (($offsetValueY + 1024.0) / 2048.0) +1);
                $NpcPixelY = (($NpcLocY - 1) * 50 * $c);
            $icon = $type;
            $string =
            "<img id=\"". $id ."\" style=\"position: absolute; left: ". (round($NpcPixelX, 2)) ."px; top: ". (round($NpcPixelY, 2)) ."px;\" src=\"icons/". $icon .".png\" alt=\"". $objectname ."\" title=\"
            ". $objectname ."
            \n
ID: ". $name ."
            \n
Type: ". $type ."
            \" />\n\n";
            $Total68[] = $string;
        }
// end of section





    }

        {
            $Total5 = implode($Total5);
            $Total6 = implode($Total6);
            $Total8 = implode($Total8);
            $Total9 = implode($Total9);
            $Total12 = implode($Total12);
            $Total14 = implode($Total14);
            $Total40 = implode($Total40);
            $Total41 = implode($Total41);
            $Total45 = implode($Total45);
            $Total49 = implode($Total49);
            $Total51 = implode($Total51);
            $Total57 = implode($Total57);
            $Total65 = implode($Total65);
            $Total66 = implode($Total66);
            $Total68 = implode($Total68);

            // Save some data
            $data = [
                '{output5}' => "\n\n$Total5",
                '{output6}' => "\n\n$Total6",
                '{output8}' => "\n\n$Total8",
                '{output9}' => "\n\n$Total9",
                '{output12}' => "\n\n$Total12",
                '{output14}' => "\n\n$Total14",
                '{output40}' => "\n\n$Total40",
                '{output41}' => "\n\n$Total41",
                '{output45}' => "\n\n$Total45",
                '{output49}' => "\n\n$Total49",
                '{output51}' => "\n\n$Total51",
                '{output57}' => "\n\n$Total57",
                '{output65}' => "\n\n$Total65",
                '{output66}' => "\n\n$Total66",
                '{output68}' => "\n\n$Total68",
                '{mapshort}' => $mapshort,
                '{placename}' => $placename,

            ];

            // format using Gamer Escape formatter and add to data array
            // need to look into using item-specific regex, if required.
            $this->data[] = GeFormatter::format(self::WIKI_FORMAT, $data);
        }

        // save our data to the filename: GeRecipeWiki.txt
        $this->io->progressFinish();
        $this->io->text('Saving ...');
        $info = $this->save('Level_'. $mapshort .'.html', 999999);

        $this->io->table(
            [ 'Filename', 'Data Count', 'File Size' ],
            $info
        );
    }
}