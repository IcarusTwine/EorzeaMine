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
    {x}
    {key}
    <html lang="en">
    <head>
      <meta charset="utf-8">

      <title>{mapshort} - {placename}</title>
      <link rel="stylesheet" href="assets/css/main.css">
      <link rel="stylesheet" href="assets/css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
    </head>

<body>

<!-- Navbar -->
<div class="w3-sidebar w3-bar-block w3-black" style="width:4%">
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="allmarkers()">---Markers on/off</button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="positionmarker()"><img src="icons/5.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="gimmick()"><img src="icons/6.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="eventnpc()"><img src="icons/8.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="battlenpc()"><img src="icons/9.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="aetheryte()"><img src="icons/12.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="gathering()"><img src="icons/14.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="treasure()"><img src="icons/16.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="poprange()"><img src="icons/40.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="exitrange()"><img src="icons/41.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="eventobject()"><img src="icons/45.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="eventrange()"><img src="icons/49.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="questmarker()"><img src="icons/51.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="collisionbox()"><img src="icons/57.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="clientpath()"><img src="icons/65.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="serverpath()"><img src="icons/66.png" alt=""></button>
            <button class="w3-bar-item w3-button w3-black w3-border-top w3-border-bottom w3-border-green " onclick="targetmarker()"><img src="icons/68.png" alt=""></button>
</div>

<div class="w3-top">
  <div class="w3-bar w3-black w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-black" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="index.html" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-hide-small w3-padding-large w3-hover-white">Markers</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
      </div>
    </div>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 4</a>
  </div>
</div>

          <div style="width: 2048px; height: 2048px; position: absolute;">
        <img id="backgroundmap" style="position: relative; left: 18px; top: 18px" src="maps/{mapshort} - {placename}.png" alt="..."/></div>

    <div id="allmarkers">
    <div id="positionmarker">
        {output5}
    </div>
    <div id="gimmick">
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
    <div id="treasure">
        {output16}
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
    <script src="assets/js/key.js"></script>
    <script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>
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
        $mapmarkercsv = $this->csv('MapMarker');
        //this controls the map it will make, just change it to anything in map.exd
        $mapnumber = 12;

    // (optional) start a progress bar
        $this->io->progressStart($Level->total);
        $Total5 =[];
        // loop through data
        foreach ($Level->data as $id => $LevelData) {
            $this->io->progressAdvance();

            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type != 5) continue;

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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
            $Total5[] = $string;

        };

//start of section
             $Total6 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type != 6) continue;

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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
            $Total6[] = $string;

        };
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nENpc_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            elseif ($type <1) {
                $total14 = '000';
            }

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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
            $Total14[] = $string;
        }
// end of section

        //start of section
             $Total16 =[];
        foreach ($Level->data as $id => $LevelData) {
            $type = $LevelData['Type'];
            $map = $LevelData['Map'];
            $name = $id;
            if ($map !=$mapnumber) continue;
            if ($type !=16) continue;
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
            $Total16[] = $string;
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $eobjectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\n\nEObj_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
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
            ". $objectname ."\nLevel_ID: ". $name ."\nType: ".$type ."\nObject_ID: ". $object ."\" />\n\n";
            $Total68[] = $string;
        }
// end of section




        
            $Total5 = implode($Total5);
            $Total6 = implode($Total6);
            $Total8 = implode($Total8);
            $Total9 = implode($Total9);
            $Total12 = implode($Total12);
            $Total14 = implode($Total14);
            $Total16 = implode($Total16);
            $Total40 = implode($Total40);
            $Total41 = implode($Total41);
            $Total45 = implode($Total45);
            $Total49 = implode($Total49);
            $Total51 = implode($Total51);
            $Total57 = implode($Total57);
            $Total65 = implode($Total65);
            $Total66 = implode($Total66);
            $Total68 = implode($Total68);
{
            // Save some data
            $data = [
                '{output5}' => "\n\n$Total5",
                '{output6}' => "\n\n$Total6",
                '{output8}' => "\n\n$Total8",
                '{output9}' => "\n\n$Total9",
                '{output12}' => "\n\n$Total12",
                '{output16}' => "\n\n$Total16",
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
                '{x}' => $marker['X'],
                '{key}' => $key,
//                '{mapdata}' => $mapmarker,
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