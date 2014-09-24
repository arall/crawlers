<?php

class Grabber_Segundamano
{
    /*
    @todo
    public static function grabMarcas()
    {
        $content = curl("http://www.segundamano.es/coches-de-segunda-mano-tarragona/");
        $html = str_get_html($content);
    }*/

    public static function grabList($url)
    {
        $o = 1;
        do {
            $content = curl($url."?od=1&o=".$o);
            //Parse HTML
            $html = str_get_html($content);
            if (is_object($html)) {
                foreach ($html->find('a.subjectTitle') as $link) {
                    if (is_object($link)) {
                        self::grabCar($link->href);
                    }
                }
            }
            $o++;
        } while ($o<100);
    }

    public static function grabCar($url)
    {
        $content = curl($url);
        $title = get_between($content, "<title>", "</title>");
        $websiteId = "segundamano.es".get_between($content, '<input type="hidden" name="id" value="', "'");
        Cli::output("Grabbing: ".$title, "notice");
        //Exists?
        if (!Car::getBy("websiteId", $websiteId)) {
            //Parse HTML
            $html = str_get_html($content);
            //New car
            $car = new Car();
            $car->title = $title;
            $car->url = $url;
            $car->websiteId = $websiteId;
            $car->marcaId = get_between($content, "var oas_marca = '", "'");
            $car->marca = get_between($content, 'var marca = "', '"');
            $car->modeloId = get_between($content, "var oas_modelo = '", "'");
            $car->modelo = get_between($content, 'var modelo = "', '"');
            $car->year = get_between($content, "var year = '", "'");
            $car->price = str_replace(".", "", get_between($content, '<span class="price">', "&euro;"));
            $car->mileage = get_between($content, "var oas_mileage = '", "'");
            $car->fuel = get_between($content, "var fuel = '", "'");
            $car->bodywork = get_between($content, "var oas_bodywork = '", "'");
            $car->desciption = $html->find('#descriptionText', 0)->plaintext;
            $date = $html->find('li.productDate', 0)->plaintext;
            $date = substr($date, 11);
            if ($date == "hoy") {
                $date = "today";
            } elseif ($date == "ayer") {
                $date = "yesterday";
            } else {
                $date = spanishMonthsToEnglish($date)." 2014";
            }
            //echo "Date: ".$date."\n";
            $car->productDate = date("Y-m-d", strtotime($date));
            //Free RAM
            unset($html);
            unset($content);
            //Release insert
            if ($car->insert()) {
                Cli::output("Done!", "success");

                return $car;
            } else {
                Cli::outputMessages();
            }
        } else {
            Cli::output("Ad already exist!", "error");
        }

        return false;
    }
}
