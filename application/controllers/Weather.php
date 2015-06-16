<?php

class Weather extends CI_Controller {

    function index() {
        if (isset($_GET['q'])) {

            $data = array();
            $q = $_GET['q'];

            $lastSpace = strrpos($q, "in");
            $lastSpace = $lastSpace + 2;
            $city = substr($q, $lastSpace, strpos($q, '?'));
            $city = trim($city, '?');

            $ww = json_decode(
                            file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=$city")
            );


            if ((strpos($q, 'humidity') !== false)) {
                $data['answer'] = $ww->main->humidity;
            } else if ((strpos($q, 'temperature') !== false)) {
                $data['answer'] = $ww->main->temp." K";
            } else if ((strpos($q, 'Rain') !== false)) {
                foreach ($ww as $key => $value) {
                    $data['answer'] = "No";
                    if ($key == "rain") {
                        $data['answer'] = "Yes";
                        break;
                    }
                }
            } else if ((strpos($q, 'Clouds') !== false)) {
                foreach ($ww as $key => $value) {
                    if ($key == "clouds") {
                        foreach ($value as $k => $v) {
                            if ($k == "all") {
                                if ($v == 0) {
                                    $data['answer'] = "No";
                                    break;
                                } else {
                                    $data['answer'] = "Yes";
                                    break;
                                }
                            }
                        }
                    }
                }
            } else if ((strpos($q, 'Clear') !== false)) {
                foreach ($ww as $key => $value) {
                    if ($key == "clouds") {
                        foreach ($value as $k => $v) {
                            if ($k == "all") {
                                if ($v == 0) {
                                    $data['answer'] = "Yes";
                                    break;
                                } else {
                                    $data['answer'] = "No";
                                    break;
                                }
                            }
                        }
                    }
                }
            } else {
                $data['answer'] = "Invalid Question";
            }

            $result = json_encode($data);
            echo $result;
        } else {
            echo show_404();
        }
    }

}