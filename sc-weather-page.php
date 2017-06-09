<?php
// WordPress check to deny direct access to the file
//defined( 'ABSPATH' ) or die( "Error: contact admin@surfing-chef.com" );

// Functions
require_once 'sc-weather-functions.php';
require_once 'api.php'; //$api
?>
<section id="sc-forecast" class="container-forecast">

  <header class="sc-weather-header">
    <span>Weather</span>
    <a href="https://darksky.net/forecast/50.2963,-117.6857/ca12/en" target="_blank">Powered by Dark Sky</a>
  </header>

  <div class="container-currently">

    <article class="container-icon-temp">

      <div class="icon-current">
        <img src="<?php echo SCWEATHER_IMG_URL . output_cache('currently', 'icon'); ?>.png" alt="">
      </div>

      <div class="temp-current">
        <?php echo round(output_cache('currently', 'temperature')); ?>&deg;
      </div>

    </article>

    <article class="container-summary-wind">

      <div class="summary-current">
        <?php echo output_cache('currently', 'summary'); ?>
      </div>

      <div class="summary-wind">
        Wind: <?php echo round(output_cache('currently', 'windSpeed')); ?> m/s (<?php echo getDirection(round(output_cache('currently', 'windBearing')));?>)
      </div>

    </article>

  </div>
  <!-- END container-currently -->

  <div class="container-daily">
    <?php
      // find height of graphical temp display
      // using max and min temps
      $max=-100;
      $min=200;
      foreach (output_cache('daily', 'data') as $key => $value) {
        $tempMax = round($value['temperatureMax']);
        if($max < $tempMax){
          $max = $tempMax;
        }

        $tempMin = round($value['temperatureMin']);
        if($min > $tempMin){
          $min = $tempMin;
        }
      }

      // display data
      $timezone = parse_cache()['timezone'];
      foreach (output_cache('daily', 'data') as $key => $value) {
        echo '<div class="daily-day">';

        // day
        if($key == 0){
          $time = "Today";
        } else {
          $time = $value['time'];
          $time = date('D', $time);
        }
        echo "<h4>$time</h4>";

        // icon
        $icon = $value['icon'];
        echo '<div class="icon-daily"><img src="'.SCWEATHER_IMG_URL.$icon.'"></div>';
        //echo $icon;

        // temperatures
        $tempMax = round($value['temperatureMax']);
        $tempMin = round($value['temperatureMin']);
        $topOffset = 50 + ($max - $tempMax)*3;
        $temp_height = 4*($tempMax-$tempMin);

          echo "<div class=\"temp-daily-container\" style=\"top: ".$topOffset."px;\">";

            echo "<span class=\"max temp-daily\">$tempMax&deg;</span>";

            // chart temperature
            echo '<div class="temp-graph" style="width: 1em; height: '.$temp_height.'px;"></div>';

            echo "<span class=\"min temp-daily\">$tempMin&deg;</span>";

          echo '</div>';

        echo '</div>';
      }
    ?>
  </div>
  <!-- END container-daily -->
</section>
