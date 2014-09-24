<?php

class Grabber_Fotocasa
{

    public static function grabList($url)
    {
        $crp = 1;
        $total = 0;
        do {
            $content = curl($url."&crp=".$crp);
            if (strstr($content, "Verificación Anti-Robots")) {
                Cli::finish("Captcha!", "error");
            }
            //Parse HTML
            $html = str_get_html($content);
            if (is_object($html)) {
                foreach ($html->find('li.property-description-links-media a') as $link) {
                    if (is_object($link)) {
                        self::grabHouse($link->href);
                        $total++;
                        //Anti-captcha
                        if ($total>20) {
                            Cli::output("Sleeping...", "warning");
                            sleep(60);
                            $total = 0;
                        }
                    }
                }
            }
            $crp++;
        } while ($crp<100);
    }

    public static function grabHouse($url)
    {
        $content = curl($url);
        if (strstr($content, "Verificación Anti-Robots")) {
            Cli::finish("Captcha!", "error");
        }
        $title = betterTrim(get_between($content, "<title>", "</title>"));
        $websiteId = "fotocasa.es".get_between($content, '<input type="hidden" name="ctl00$content1$hid_PropertyId" id="hid_PropertyId" value="', '"');
        Cli::output("Grabbing: ".$title, "notice");
        //Exists?
        if (!House::getBy("websiteId", $websiteId)) {
            //Parse JSON ;)
            $json = json_decode(get_between($content, "var advertisementConfig = JSON.parse('", "');"));
            //New car
            $house = new House();
            $house->title = $title;
            $house->url = $url;
            $house->websiteId = $websiteId;
            $house->zone = $json->DistrictPremium;
            $house->type = $json->TransactionType;
            $house->rooms = $json->oasNumRooms;
            $house->bathrooms = get_between(strrev($content), 'ab;psbn&>b/<', ">b<");
            $house->m2 = $json->oasSqmetres;
            $features = explode("|||", $json->PropertyFeature);
            $house->features = json_encode($features);
            if (@in_array("parking", $features) || @in_array("parking-comunitario", $features)) {
                $house->parking = true;
            }
            if (strstr(strtolower($content), "amueblado") || @in_array("amueblado", $features)) {
                $house->furnished = true;
            }
            $house->price = $json->oasPrice;
            $house->lat = $json->Lat;
            $house->lon = $json->Lng;
            $house->cp = $json->oasGeoPostalCode;

            $house->description = get_between($content, '<input name="ctl00$hid_Comments" type="hidden" id="hid_Comments" value="', '"');
            //Free RAM
            unset($content);
            //Release insert
            if ($house->insert()) {
                Cli::output("Done!", "success");

                return $house;
            } else {
                Cli::outputMessages();
            }
        } else {
            Cli::output("Ad already exist!", "error");
        }

        return false;
    }
}
