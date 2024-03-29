<?php

/*
<!#CR>
************************************************************************************************************************
*                                                    Copyrigths ©                                                      *
* -------------------------------------------------------------------------------------------------------------------- *
*          Authors Names    > PowerChaos                                                                               *
*          Company Name     > VPS Data                                                                                 *
*          Company Email    > info@vpsdata.be                                                                          *
*          Company Websites > https://vpsdata.be                                                                       *
*                             https://vpsdata.shop                                                                     *
*          Company Socials  > https://facebook.com/vpsdata                                                             *
*                             https://twitter.com/powerchaos                                                           *
*                             https://instagram.com/vpsdata                                                            *
* -------------------------------------------------------------------------------------------------------------------- *
*                                           File and License Informations                                              *
* -------------------------------------------------------------------------------------------------------------------- *
*          File Name        > <!#FN> shipping.class.php </#FN>                                                         
*          File Birth       > <!#FB> 2021/09/23 21:28:36.050 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/23 21:29:44.503 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/


class Shipping
{
    /* public function __construct()
	{
		// start db en Sessie
		$this->db = new Db;
		$this->session = new Session;
		$this->hash = new PasswordStorage;
	} */


    function land($land = "")
    {
        // All countries
        // length 252
        $country = array(
            "AF" => array("name" => "Afghanistan", "continent_code" => "AS"),
            "AX" => array("name" => "Aland Islands", "continent_code" => "EU"),
            "AL" => array("name" => "Albania", "continent_code" => "EU"),
            "DZ" => array("name" => "Algeria", "continent_code" => "AF"),
            "AS" => array("name" => "American Samoa", "continent_code" => "OC"),
            "AD" => array("name" => "Andorra", "continent_code" => "EU"),
            "AO" => array("name" => "Angola", "continent_code" => "AF"),
            "AI" => array("name" => "Anguilla", "continent_code" => "NA"),
            "AQ" => array("name" => "Antarctica", "continent_code" => "AN"),
            "AG" => array("name" => "Antigua and Barbuda", "continent_code" => "NA"),
            "AR" => array("name" => "Argentina", "continent_code" => "SA"),
            "AM" => array("name" => "Armenia", "continent_code" => "AS"),
            "AW" => array("name" => "Aruba", "continent_code" => "NA"),
            "AU" => array("name" => "Australia", "continent_code" => "OC"),
            "AT" => array("name" => "Austria", "continent_code" => "EU"),
            "AZ" => array("name" => "Azerbaijan", "continent_code" => "AS"),
            "BS" => array("name" => "Bahamas", "continent_code" => "NA"),
            "BH" => array("name" => "Bahrain", "continent_code" => "AS"),
            "BD" => array("name" => "Bangladesh", "continent_code" => "AS"),
            "BB" => array("name" => "Barbados", "continent_code" => "NA"),
            "BY" => array("name" => "Belarus", "continent_code" => "EU"),
            "BE" => array("name" => "Belgium", "continent_code" => "EU"),
            "BZ" => array("name" => "Belize", "continent_code" => "NA"),
            "BJ" => array("name" => "Benin", "continent_code" => "AF"),
            "BM" => array("name" => "Bermuda", "continent_code" => "NA"),
            "BT" => array("name" => "Bhutan", "continent_code" => "AS"),
            "BO" => array("name" => "Bolivia", "continent_code" => "SA"),
            "BQ" => array("name" => "Bonaire, Sint Eustatius and Saba", "continent_code" => "NA"),
            "BA" => array("name" => "Bosnia and Herzegovina", "continent_code" => "EU"),
            "BW" => array("name" => "Botswana", "continent_code" => "AF"),
            "BV" => array("name" => "Bouvet Island", "continent_code" => "AN"),
            "BR" => array("name" => "Brazil", "continent_code" => "SA"),
            "IO" => array("name" => "British Indian Ocean Territory", "continent_code" => "AS"),
            "BN" => array("name" => "Brunei Darussalam", "continent_code" => "AS"),
            "BG" => array("name" => "Bulgaria", "continent_code" => "EU"),
            "BF" => array("name" => "Burkina Faso", "continent_code" => "AF"),
            "BI" => array("name" => "Burundi", "continent_code" => "AF"),
            "KH" => array("name" => "Cambodia", "continent_code" => "AS"),
            "CM" => array("name" => "Cameroon", "continent_code" => "AF"),
            "CA" => array("name" => "Canada", "continent_code" => "NA"),
            "CV" => array("name" => "Cape Verde", "continent_code" => "AF"),
            "KY" => array("name" => "Cayman Islands", "continent_code" => "NA"),
            "CF" => array("name" => "Central African Republic", "continent_code" => "AF"),
            "TD" => array("name" => "Chad", "continent_code" => "AF"),
            "CL" => array("name" => "Chile", "continent_code" => "SA"),
            "CN" => array("name" => "China", "continent_code" => "AS"),
            "CX" => array("name" => "Christmas Island", "continent_code" => "AS"),
            "CC" => array("name" => "Cocos (Keeling) Islands", "continent_code" => "AS"),
            "CO" => array("name" => "Colombia", "continent_code" => "SA"),
            "KM" => array("name" => "Comoros", "continent_code" => "AF"),
            "CG" => array("name" => "Congo", "continent_code" => "AF"),
            "CD" => array("name" => "Congo, Democratic Republic of the Congo", "continent_code" => "AF"),
            "CK" => array("name" => "Cook Islands", "continent_code" => "OC"),
            "CR" => array("name" => "Costa Rica", "continent_code" => "NA"),
            "CI" => array("name" => "Cote D'Ivoire", "continent_code" => "AF"),
            "HR" => array("name" => "Croatia", "continent_code" => "EU"),
            "CU" => array("name" => "Cuba", "continent_code" => "NA"),
            "CW" => array("name" => "Curacao", "continent_code" => "NA"),
            "CY" => array("name" => "Cyprus", "continent_code" => "AS"),
            "CZ" => array("name" => "Czech Republic", "continent_code" => "EU"),
            "DK" => array("name" => "Denmark", "continent_code" => "EU"),
            "DJ" => array("name" => "Djibouti", "continent_code" => "AF"),
            "DM" => array("name" => "Dominica", "continent_code" => "NA"),
            "DO" => array("name" => "Dominican Republic", "continent_code" => "NA"),
            "EC" => array("name" => "Ecuador", "continent_code" => "SA"),
            "EG" => array("name" => "Egypt", "continent_code" => "AF"),
            "SV" => array("name" => "El Salvador", "continent_code" => "NA"),
            "GQ" => array("name" => "Equatorial Guinea", "continent_code" => "AF"),
            "ER" => array("name" => "Eritrea", "continent_code" => "AF"),
            "EE" => array("name" => "Estonia", "continent_code" => "EU"),
            "ET" => array("name" => "Ethiopia", "continent_code" => "AF"),
            "FK" => array("name" => "Falkland Islands (Malvinas)", "continent_code" => "SA"),
            "FO" => array("name" => "Faroe Islands", "continent_code" => "EU"),
            "FJ" => array("name" => "Fiji", "continent_code" => "OC"),
            "FI" => array("name" => "Finland", "continent_code" => "EU"),
            "FR" => array("name" => "France", "continent_code" => "EU"),
            "GF" => array("name" => "French Guiana", "continent_code" => "SA"),
            "PF" => array("name" => "French Polynesia", "continent_code" => "OC"),
            "TF" => array("name" => "French Southern Territories", "continent_code" => "AN"),
            "GA" => array("name" => "Gabon", "continent_code" => "AF"),
            "GM" => array("name" => "Gambia", "continent_code" => "AF"),
            "GE" => array("name" => "Georgia", "continent_code" => "AS"),
            "DE" => array("name" => "Germany", "continent_code" => "EU"),
            "GH" => array("name" => "Ghana", "continent_code" => "AF"),
            "GI" => array("name" => "Gibraltar", "continent_code" => "EU"),
            "GR" => array("name" => "Greece", "continent_code" => "EU"),
            "GL" => array("name" => "Greenland", "continent_code" => "NA"),
            "GD" => array("name" => "Grenada", "continent_code" => "NA"),
            "GP" => array("name" => "Guadeloupe", "continent_code" => "NA"),
            "GU" => array("name" => "Guam", "continent_code" => "OC"),
            "GT" => array("name" => "Guatemala", "continent_code" => "NA"),
            "GG" => array("name" => "Guernsey", "continent_code" => "EU"),
            "GN" => array("name" => "Guinea", "continent_code" => "AF"),
            "GW" => array("name" => "Guinea-Bissau", "continent_code" => "AF"),
            "GY" => array("name" => "Guyana", "continent_code" => "SA"),
            "HT" => array("name" => "Haiti", "continent_code" => "NA"),
            "HM" => array("name" => "Heard Island and Mcdonald Islands", "continent_code" => "AN"),
            "VA" => array("name" => "Holy See (Vatican City State)", "continent_code" => "EU"),
            "HN" => array("name" => "Honduras", "continent_code" => "NA"),
            "HK" => array("name" => "Hong Kong", "continent_code" => "AS"),
            "HU" => array("name" => "Hungary", "continent_code" => "EU"),
            "IS" => array("name" => "Iceland", "continent_code" => "EU"),
            "IN" => array("name" => "India", "continent_code" => "AS"),
            "ID" => array("name" => "Indonesia", "continent_code" => "AS"),
            "IR" => array("name" => "Iran, Islamic Republic of", "continent_code" => "AS"),
            "IQ" => array("name" => "Iraq", "continent_code" => "AS"),
            "IE" => array("name" => "Ireland", "continent_code" => "EU"),
            "IM" => array("name" => "Isle of Man", "continent_code" => "EU"),
            "IL" => array("name" => "Israel", "continent_code" => "AS"),
            "IT" => array("name" => "Italy", "continent_code" => "EU"),
            "JM" => array("name" => "Jamaica", "continent_code" => "NA"),
            "JP" => array("name" => "Japan", "continent_code" => "AS"),
            "JE" => array("name" => "Jersey", "continent_code" => "EU"),
            "JO" => array("name" => "Jordan", "continent_code" => "AS"),
            "KZ" => array("name" => "Kazakhstan", "continent_code" => "AS"),
            "KE" => array("name" => "Kenya", "continent_code" => "AF"),
            "KI" => array("name" => "Kiribati", "continent_code" => "OC"),
            "KP" => array("name" => "Korea, Democratic People's Republic of", "continent_code" => "AS"),
            "KR" => array("name" => "Korea, Republic of", "continent_code" => "AS"),
            "XK" => array("name" => "Kosovo", "continent_code" => "EU"),
            "KW" => array("name" => "Kuwait", "continent_code" => "AS"),
            "KG" => array("name" => "Kyrgyzstan", "continent_code" => "AS"),
            "LA" => array("name" => "Lao People's Democratic Republic", "continent_code" => "AS"),
            "LV" => array("name" => "Latvia", "continent_code" => "EU"),
            "LB" => array("name" => "Lebanon", "continent_code" => "AS"),
            "LS" => array("name" => "Lesotho", "continent_code" => "AF"),
            "LR" => array("name" => "Liberia", "continent_code" => "AF"),
            "LY" => array("name" => "Libyan Arab Jamahiriya", "continent_code" => "AF"),
            "LI" => array("name" => "Liechtenstein", "continent_code" => "EU"),
            "LT" => array("name" => "Lithuania", "continent_code" => "EU"),
            "LU" => array("name" => "Luxembourg", "continent_code" => "EU"),
            "MO" => array("name" => "Macao", "continent_code" => "AS"),
            "MK" => array("name" => "Macedonia, the Former Yugoslav Republic of", "continent_code" => "EU"),
            "MG" => array("name" => "Madagascar", "continent_code" => "AF"),
            "MW" => array("name" => "Malawi", "continent_code" => "AF"),
            "MY" => array("name" => "Malaysia", "continent_code" => "AS"),
            "MV" => array("name" => "Maldives", "continent_code" => "AS"),
            "ML" => array("name" => "Mali", "continent_code" => "AF"),
            "MT" => array("name" => "Malta", "continent_code" => "EU"),
            "MH" => array("name" => "Marshall Islands", "continent_code" => "OC"),
            "MQ" => array("name" => "Martinique", "continent_code" => "NA"),
            "MR" => array("name" => "Mauritania", "continent_code" => "AF"),
            "MU" => array("name" => "Mauritius", "continent_code" => "AF"),
            "YT" => array("name" => "Mayotte", "continent_code" => "AF"),
            "MX" => array("name" => "Mexico", "continent_code" => "NA"),
            "FM" => array("name" => "Micronesia, Federated States of", "continent_code" => "OC"),
            "MD" => array("name" => "Moldova, Republic of", "continent_code" => "EU"),
            "MC" => array("name" => "Monaco", "continent_code" => "EU"),
            "MN" => array("name" => "Mongolia", "continent_code" => "AS"),
            "ME" => array("name" => "Montenegro", "continent_code" => "EU"),
            "MS" => array("name" => "Montserrat", "continent_code" => "NA"),
            "MA" => array("name" => "Morocco", "continent_code" => "AF"),
            "MZ" => array("name" => "Mozambique", "continent_code" => "AF"),
            "MM" => array("name" => "Myanmar", "continent_code" => "AS"),
            "NA" => array("name" => "Namibia", "continent_code" => "AF"),
            "NR" => array("name" => "Nauru", "continent_code" => "OC"),
            "NP" => array("name" => "Nepal", "continent_code" => "AS"),
            "NL" => array("name" => "Netherlands", "continent_code" => "EU"),
            "AN" => array("name" => "Netherlands Antilles", "continent_code" => "NA"),
            "NC" => array("name" => "New Caledonia", "continent_code" => "OC"),
            "NZ" => array("name" => "New Zealand", "continent_code" => "OC"),
            "NI" => array("name" => "Nicaragua", "continent_code" => "NA"),
            "NE" => array("name" => "Niger", "continent_code" => "AF"),
            "NG" => array("name" => "Nigeria", "continent_code" => "AF"),
            "NU" => array("name" => "Niue", "continent_code" => "OC"),
            "NF" => array("name" => "Norfolk Island", "continent_code" => "OC"),
            "MP" => array("name" => "Northern Mariana Islands", "continent_code" => "OC"),
            "NO" => array("name" => "Norway", "continent_code" => "EU"),
            "OM" => array("name" => "Oman", "continent_code" => "AS"),
            "PK" => array("name" => "Pakistan", "continent_code" => "AS"),
            "PW" => array("name" => "Palau", "continent_code" => "OC"),
            "PS" => array("name" => "Palestinian Territory, Occupied", "continent_code" => "AS"),
            "PA" => array("name" => "Panama", "continent_code" => "NA"),
            "PG" => array("name" => "Papua New Guinea", "continent_code" => "OC"),
            "PY" => array("name" => "Paraguay", "continent_code" => "SA"),
            "PE" => array("name" => "Peru", "continent_code" => "SA"),
            "PH" => array("name" => "Philippines", "continent_code" => "AS"),
            "PN" => array("name" => "Pitcairn", "continent_code" => "OC"),
            "PL" => array("name" => "Poland", "continent_code" => "EU"),
            "PT" => array("name" => "Portugal", "continent_code" => "EU"),
            "PR" => array("name" => "Puerto Rico", "continent_code" => "NA"),
            "QA" => array("name" => "Qatar", "continent_code" => "AS"),
            "RE" => array("name" => "Reunion", "continent_code" => "AF"),
            "RO" => array("name" => "Romania", "continent_code" => "EU"),
            "RU" => array("name" => "Russian Federation", "continent_code" => "AS"),
            "RW" => array("name" => "Rwanda", "continent_code" => "AF"),
            "BL" => array("name" => "Saint Barthelemy", "continent_code" => "NA"),
            "SH" => array("name" => "Saint Helena", "continent_code" => "AF"),
            "KN" => array("name" => "Saint Kitts and Nevis", "continent_code" => "NA"),
            "LC" => array("name" => "Saint Lucia", "continent_code" => "NA"),
            "MF" => array("name" => "Saint Martin", "continent_code" => "NA"),
            "PM" => array("name" => "Saint Pierre and Miquelon", "continent_code" => "NA"),
            "VC" => array("name" => "Saint Vincent and the Grenadines", "continent_code" => "NA"),
            "WS" => array("name" => "Samoa", "continent_code" => "OC"),
            "SM" => array("name" => "San Marino", "continent_code" => "EU"),
            "ST" => array("name" => "Sao Tome and Principe", "continent_code" => "AF"),
            "SA" => array("name" => "Saudi Arabia", "continent_code" => "AS"),
            "SN" => array("name" => "Senegal", "continent_code" => "AF"),
            "RS" => array("name" => "Serbia", "continent_code" => "EU"),
            "CS" => array("name" => "Serbia and Montenegro", "continent_code" => "EU"),
            "SC" => array("name" => "Seychelles", "continent_code" => "AF"),
            "SL" => array("name" => "Sierra Leone", "continent_code" => "AF"),
            "SG" => array("name" => "Singapore", "continent_code" => "AS"),
            "SX" => array("name" => "Sint Maarten", "continent_code" => "NA"),
            "SK" => array("name" => "Slovakia", "continent_code" => "EU"),
            "SI" => array("name" => "Slovenia", "continent_code" => "EU"),
            "SB" => array("name" => "Solomon Islands", "continent_code" => "OC"),
            "SO" => array("name" => "Somalia", "continent_code" => "AF"),
            "ZA" => array("name" => "South Africa", "continent_code" => "AF"),
            "GS" => array("name" => "South Georgia and the South Sandwich Islands", "continent_code" => "AN"),
            "SS" => array("name" => "South Sudan", "continent_code" => "AF"),
            "ES" => array("name" => "Spain", "continent_code" => "EU"),
            "LK" => array("name" => "Sri Lanka", "continent_code" => "AS"),
            "SD" => array("name" => "Sudan", "continent_code" => "AF"),
            "SR" => array("name" => "Suriname", "continent_code" => "SA"),
            "SJ" => array("name" => "Svalbard and Jan Mayen", "continent_code" => "EU"),
            "SZ" => array("name" => "Swaziland", "continent_code" => "AF"),
            "SE" => array("name" => "Sweden", "continent_code" => "EU"),
            "CH" => array("name" => "Switzerland", "continent_code" => "EU"),
            "SY" => array("name" => "Syrian Arab Republic", "continent_code" => "AS"),
            "TW" => array("name" => "Taiwan, Province of China", "continent_code" => "AS"),
            "TJ" => array("name" => "Tajikistan", "continent_code" => "AS"),
            "TZ" => array("name" => "Tanzania, United Republic of", "continent_code" => "AF"),
            "TH" => array("name" => "Thailand", "continent_code" => "AS"),
            "TL" => array("name" => "Timor-Leste", "continent_code" => "AS"),
            "TG" => array("name" => "Togo", "continent_code" => "AF"),
            "TK" => array("name" => "Tokelau", "continent_code" => "OC"),
            "TO" => array("name" => "Tonga", "continent_code" => "OC"),
            "TT" => array("name" => "Trinidad and Tobago", "continent_code" => "NA"),
            "TN" => array("name" => "Tunisia", "continent_code" => "AF"),
            "TR" => array("name" => "Turkey", "continent_code" => "AS"),
            "TM" => array("name" => "Turkmenistan", "continent_code" => "AS"),
            "TC" => array("name" => "Turks and Caicos Islands", "continent_code" => "NA"),
            "TV" => array("name" => "Tuvalu", "continent_code" => "OC"),
            "UG" => array("name" => "Uganda", "continent_code" => "AF"),
            "UA" => array("name" => "Ukraine", "continent_code" => "EU"),
            "AE" => array("name" => "United Arab Emirates", "continent_code" => "AS"),
            "GB" => array("name" => "United Kingdom", "continent_code" => "EU"),
            "US" => array("name" => "United States", "continent_code" => "NA"),
            "UM" => array("name" => "United States Minor Outlying Islands", "continent_code" => "NA"),
            "UY" => array("name" => "Uruguay", "continent_code" => "SA"),
            "UZ" => array("name" => "Uzbekistan", "continent_code" => "AS"),
            "VU" => array("name" => "Vanuatu", "continent_code" => "OC"),
            "VE" => array("name" => "Venezuela", "continent_code" => "SA"),
            "VN" => array("name" => "Viet Nam", "continent_code" => "AS"),
            "VG" => array("name" => "Virgin Islands, British", "continent_code" => "NA"),
            "VI" => array("name" => "Virgin Islands, U.s.", "continent_code" => "NA"),
            "WF" => array("name" => "Wallis and Futuna", "continent_code" => "OC"),
            "EH" => array("name" => "Western Sahara", "continent_code" => "AF"),
            "YE" => array("name" => "Yemen", "continent_code" => "AS"),
            "ZM" => array("name" => "Zambia", "continent_code" => "AF"),
            "ZW" => array("name" => "Zimbabwe", "continent_code" => "AF")
        );

        $continents = array(
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'OC' => 'Australia',
            'NA' => 'North America',
            'SA' => 'South America'
        );
        if ($land) {
            return $continents[$country[$land]['continent_code']];
        }
        return $country;
    }

    function dpd($land = "")
    {
        // DPD
        // length 22
        $dpd = array(
            "AT" => array("naam" => "Austria", "prijs" => "20"),
            "BE" => array("naam" => "Belgium", "prijs" => "10"),
            "BG" => array("naam" => "Bulgaria", "prijs" => "30"),
            "CZ" => array("naam" => "Czech Republic", "prijs" => "20"),
            "DK" => array("naam" => "Denmark", "prijs" => "20"),
            "EE" => array("naam" => "Estonia", "prijs" => "22"),
            "FI" => array("naam" => "Finland", "prijs" => "25"),
            "FR" => array("naam" => "France", "prijs" => "15"),
            "DE" => array("naam" => "Germany", "prijs" => "12"),
            "GR" => array("naam" => "Greece", "prijs" => "30"),
            "HU" => array("naam" => "Hungary", "prijs" => "20"),
            "IT" => array("naam" => "Italy", "prijs" => "22"),
            "LV" => array("naam" => "Latvia", "prijs" => "22"),
            "LT" => array("naam" => "Lithuania", "prijs" => "22"),
            "LU" => array("naam" => "Luxembourg", "prijs" => "15"),
            "NL" => array("naam" => "Netherlands", "prijs" => "12"),
            "PL" => array("naam" => "Poland", "prijs" => "20"),
            "PT" => array("naam" => "Portugal", "prijs" => "22"),
            "RO" => array("naam" => "Romania", "prijs" => "30"),
            "SK" => array("naam" => "Slovakia", "prijs" => "22"),
            "SI" => array("naam" => "Slovenia", "prijs" => "22"),
            "ES" => array("naam" => "Spain", "prijs" => "22"),
            "SE" => array("naam" => "Sweden", "prijs" => "25"),
        );
        if (array_key_exists($land, $dpd)) {
            return $dpd[$land]['prijs'];
        } else {
            return false;
        }
    }
}