<?php

/*
Created:  2014
Dscription:   Here is a helper file containing several handy funciton for data parsing, formating, and readable outputs.  It also contains simplified inputs for form values.
Other:  This is a HeaderHelper.php file that is located under the '/View/helper' directory under your main CakePHP directory (typically app).
*/

App::uses('AppHelper', 'View/Helper');

class HeaderHelper extends AppHelper {

   var $helpers = array('Html', 'Session');

   //used for sorting
   function headerClass($sort, $dir, $column) {
       $class = ($sort==$column ? "headerSort" . ($dir=="asc" ? "Up" : "Down") : "header");
       return $class;
   }
	
   //formats dates on views from MySQL dateformat.  if date then format in M/D/Y format else, format in m/d/Y hh:mm
   function dateFormat($input, $dow = 0) {
      if(strlen($input)==10) {
         if($dow) {
            return date('l m/d/Y', strtotime($input));
         } else {
            return date('m/d/Y', strtotime($input));
         }
      } else if(strlen($input)==19) {
         if($dow) {
            return date('l m/d/Y h:i:s A', strtotime($input));
         } else {
            return date('m/d/Y h:i:s A', strtotime($input));
         }
      } else {
         return $input;
      }
   }

   //formats phone number in (xxx) xxx-xxxx format in views.
   function phoneFormat($phone) {
      return "(" . substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);
   }
   
   //formats numberical (decimals) values to currency (ex. $2.00).
   function currencyFormat($currency) {
      if ($currency == null)
         $currency = 0;
      else
   	 $currency = number_format($currency, 2);
      return $currency;
   }

   //adds a standard naviagation menu to views.  Stylizes inline due to current MVC framwork applciation.  Change to fit your applciation's style.
   function standardMenu($current = null, $exclude = array()) {
      $menu = '';
      if(!in_array("Add", $exclude)) {
         if($current=="Add") {
            $menu = "";
         } else {
         $menu = $this->Html->link('Add', array('action' => 'add'), array('class' => 'button'));
         $menu .= '&nbsp;&nbsp;';
         }
      }

      if(!in_array("Export", $exclude)) {
         if($current=="Export") {
            $menu .= "";
         } else {
            $menu .= $this->Html->link('Export', array('action' => 'export'), array('class' => 'button'));
            $menu .= '&nbsp;&nbsp;';
         }
      }

      if(!in_array("Find", $exclude)) {
         if($current=="Find") {
            $menu .= "";
         } else {
            $menu .= $this->Html->link('Find', array('action' => 'find'), array('class' => 'button'));
         }
      }
      $menu .= '<div style="line-height: 20px;">&nbsp;</div>';
      return $menu;
      
   }

   //records created date, user, modified date, and modified by for logging purposes.  assumes database field names are created (datetime), created_by (varchar), modified (datetime), modified_by (varchar).
   //NOTE:  depends on the dateFormat function to exist.
   function createdModified($record = array()) {
      return 'Created ' . $this->dateFormat($record['created']) .' by ' . $record['created_by'] . '&nbsp;|&nbsp;' . 'Modified '. $this->dateFormat($record['modified']) .' by ' . $record['modified_by'] . '<br /><br />';
   }

   //merges arrays.  used prior to return values in several functions.
   function arrayMerge($current = null, $return = array()) {
      if(isset($current) && $current<>'') {
         if(!array_key_exists($current, $return)) {
            $return[$current] = $current;
         }
      } 
      return $return;    
   }

   function arrayLookupMerge($current = null, $lookup = array(), $return = array()) {
      if(isset($current) && $current<>'') {
         if(!array_key_exists($current, $return)) {
            $return[$current] = $lookup[$current];
         }
      } 
      return $return;    
   }

   //adds abiltiy to navigate to next/previous records on a view
   function prevNext($model = null, $action = 'view', $prev = null, $next = null) {
      $return = '';
      if($this->Session->read('idxModel')==$model) {
         if(!empty($prev)) {
            $return .= " | " . $this->Html->link('Previous', array('action'=>$action, $prev));
         }
         if(!empty($next)) {
            $return .= " | " . $this->Html->link('Next', array('action'=>$action, $next));
         }
      }
      return $return;
   }
}
   
   //standard two letter abbrevation for all 50 US states plus territories.
   function getState($current = null) {
      $states = array (
	'AL' => 'AL',
	'AK' => 'AK',
	'AZ' => 'AZ',
	'AR' => 'AR',
	'CA' => 'CA',
	'CO' => 'CO',
	'CT' => 'CT',
	'DE' => 'DE',
	'DC' => 'DC',
	'FL' => 'FL',
	'GA' => 'GA',
	'HI' => 'HI',
	'ID' => 'ID',
	'IL' => 'IL',
	'IN' => 'IN',
	'IA' => 'IA',
	'KS' => 'KS',
	'KY' => 'KY',
	'LA' => 'LA',
	'ME' => 'ME',
	'MD' => 'MD',
	'MA' => 'MA',
	'MI' => 'MI',
	'MN' => 'MN',
	'MS' => 'MS',
	'MO' => 'MO',
	'MT' => 'MT',
	'NE' => 'NE',
	'NV' => 'NV',
	'NH' => 'NH',
	'NJ' => 'NJ',
	'NM' => 'NM',
	'NY' => 'NY',
	'NC' => 'NC',
	'ND' => 'ND',
	'OH' => 'OH',
	'OK' => 'OK',
	'OR' => 'OR',
	'PA' => 'PA',
	'PR' => 'PR',
	'RI' => 'RI',
	'SC' => 'SC',
	'SD' => 'SD',
	'TN' => 'TN',
	'TX' => 'TX',
	'UT' => 'UT',	
	'VT' => 'VT',	
	'VA' => 'VA',	
	'WA' => 'WA',	
	'WV' => 'WV',	
	'WI' => 'WI',	
	'WY' => 'WY'
	);
      return $this->arrayMerge($current, $states);
   }   

   //standard two-letter key values for a list of countries across the world.
  function getCountry($current = null) {
      $countries = array (
	'US' => 'United States',  				
	'AF' =>    'Afganistan', 
	'AL' =>    'Albania', 
	'DZ' =>    'Algeria', 
	'AS' => 'American Samoa', 
	'AD' => 'Andorra',  
	'AO' => 'Angola', 
	'AI' => 'Anguilla', 
	'AQ' => 'Antarctica', 
	'AG' => 'Antigua and Barbuda',  
	'AR' => 'Argentina',  
	'AM' => 'Armenia',  
	'AW' => 'Aruba',  
	'AU' => 'Australia',  
	'AT' => 'Austria',  
	'AZ' => 'Azerbaijan', 
	'BS' => 'Bahamas',  
	'BH' => 'Bahrain',  
	'BD' => 'Bangladesh', 
	'BB' => 'Barbados', 
	'BY' => 'Belarus',  
	'BE' => 'Belgium',  
	'BZ' => 'Belize', 
	'BJ' => 'Benin',  
	'BM' => 'Bermuda',  
	'BT' => 'Bhutan', 
	'BO' => 'Bolivia',  
	'BA' => 'Bosnia and Herzegowina', 
	'BW' => 'Botswana', 
	'BV' => 'Bouvet Island',  
	'BR' => 'Brazil', 
	'IO' => 'British Indian Ocean Territory', 
	'BN' => 'Brunei Darussalam',  
	'BG' => 'Bulgaria', 
	'BF' => 'Burkina Faso', 
	'BI' => 'Burundi',  
	'KH' => 'Cambodia', 
	'CM' => 'Cameroon', 
	'CA' => 'Canada', 
	'CV' => 'Cape Verde', 
	'KY' => 'Cayman Islands', 
	'CF' => 'Central African Republic', 
	'TD' => 'Chad', 
	'CL' => 'Chile',  
	'CN' => 'China', 
	'CX' => 'Christmas Island',     
	'CC' => 'Cocos (Keeling) Islands',  
	'CO' => 'Colombia', 
	'KM' => 'Comoros',  
	'CG' => 'Congo',  
	'CD' => 'Congo, the Democratic Republic of the',  
	'CK' => 'Cook Islands', 
	'CR' => 'Costa Rica', 
	'CI' => 'Cote d\'Ivoire',  
	'HR' => 'Croatia (Hrvatska)', 
	'CU' => 'Cuba', 
	'CY' => 'Cyprus', 
	'CZ' => 'Czech Republic', 
	'DK' => 'Denmark',  
	'DJ' => 'Djibouti', 
	'DM' => 'Dominica', 
	'DO' => 'Dominican Republic', 
	'TP' => 'East Timor', 
	'EC' => 'Ecuador',  
	'EG' => 'Egypt',  
	'SV' => 'El Salvador',  
	'GQ' => 'Equatorial Guinea',  
	'ER' => 'Eritrea',  
	'EE' => 'Estonia',  
	'ET' => 'Ethiopia', 
	'FK' => 'Falkland Islands (Malvinas)',  
	'FO' => 'Faroe Islands',  
	'FJ' => 'Fiji', 
	'FI' => 'Finland', 
	'FR' => 'France', 
	'FX' => 'France, Metropolitan', 
	'GF' => 'French Guiana',  
	'PF' => 'French Polynesia', 
	'TF' => 'French Southern Territories',  
	'GA' => 'Gabon',  
	'GM' => 'Gambia', 
	'GE' => 'Georgia',  
	'DE' => 'Germany',  
	'GH' => 'Ghana',  
	'GI' => 'Gibraltar',  
	'GR' => 'Greece', 
	'GL' => 'Greenland',  
	'GD' => 'Grenada',  
	'GP' => 'Guadeloupe', 
	'GU' => 'Guam', 
	'GT' => 'Guatemala',  
	'GN' => 'Guinea', 
	'GW' => 'Guinea-Bissau',  
	'GY' => 'Guyana', 
	'HT' => 'Haiti',  
	'HM' => 'Heard and Mc Donald Islands',  
	'VA' => 'Holy See (Vatican City State)',  
	'HN' => 'Honduras', 
	'HK' => 'Hong Kong',  
	'HU' => 'Hungary',  
	'IS' => 'Iceland',  
	'IN' => 'India',  
	'ID' => 'Indonesia',  
	'IR' => 'Iran (Islamic Republic of)', 
	'IQ' => 'Iraq', 
	'IE' => 'Ireland',  
	'IL' => 'Israel', 
	'IT' => 'Italy',  
	'JM' => 'Jamaica',  
	'JP' => 'Japan', 
	'JO' => 'Jordan', 
	'KZ' => 'Kazakhstan', 
	'KE' => 'Kenya',  
	'KI' => 'Kiribati', 
	'KP' => 'Korea, Democratic People\'s Republic of', 
	'KR' => 'Korea, Republic of', 
	'KW' => 'Kuwait', 
	'KG' => 'Kyrgyzstan', 
	'LA' => 'Lao People\'s Democratic Republic', 
	'LV' => 'Latvia', 
	'LB' => 'Lebanon', 
	'LS' => 'Lesotho',  
	'LR' => 'Liberia',  
	'LY' => 'Libyan Arab Jamahiriya', 
	'LI' => 'Liechtenstein',  
	'LT' => 'Lithuania', 
	'LU' => 'Luxembourg', 
	'MO' => 'Macau',  
	'MK' => 'Macedonia, The Former Yugoslav Republic of', 
	'MG' => 'Madagascar', 
	'MW' => 'Malawi', 
	'MY' => 'Malaysia', 
	'MV' => 'Maldives', 
	'ML' => 'Mali', 
	'MT' => 'Malta', 
	'MH' => 'Marshall Islands', 
	'MQ' => 'Martinique', 
	'MR' => 'Mauritania', 
	'MU' => 'Mauritius', 
	'YT' => 'Mayotte',  
	'MX' => 'Mexico', 
	'FM' => 'Micronesia, Federated States of', 
	'MD' => 'Moldova, Republic of', 
	'MC' => 'Monaco', 
	'MN' => 'Mongolia', 
	'MS' => 'Montserrat', 
	'MA' => 'Morocco', 
	'MZ' => 'Mozambique', 
	'MM' => 'Myanmar', 
	'NA' => 'Namibia', 
	'NR' => 'Nauru',  
	'NP' => 'Nepal',  
	'NL' => 'Netherlands', 
	'AN' => 'Netherlands Antilles', 
	'NC' => 'New Caledonia', 
	'NZ' => 'New Zealand',  
	'NI' => 'Nicaragua',  
	'NE' => 'Niger',  
	'NG' => 'Nigeria',  
	'NU' => 'Niue', 
	'NF' => 'Norfolk Island', 
	'MP' => 'Northern Mariana Islands', 
	'NO' => 'Norway', 
	'OM' => 'Oman', 
	'PK' => 'Pakistan', 
	'PW' => 'Palau', 
	'PA' => 'Panama', 
	'PG' => 'Papua New Guinea', 
	'PY' => 'Paraguay', 
	'PE' => 'Peru', 
	'PH' => 'Philippines', 
	'PN' => 'Pitcairn', 
	'PL' => 'Poland', 
	'PT' => 'Portugal', 
	'PR' => 'Puerto Rico', 
	'QA' => 'Qatar', 
	'RE' => 'Reunion', 
	'RO' => 'Romania', 
	'RU' => 'Russian Federation', 
	'RW' => 'Rwanda', 
	'KN' => 'Saint Kitts and Nevis',  
	'LC' => 'Saint LUCIA',  
	'VC' => 'Saint Vincent and the Grenadines', 
	'WS' => 'Samoa',  
	'SM' => 'San Marino', 
	'ST' => 'Sao Tome and Principe', 
	'SA' => 'Saudi Arabia', 
	'SN' => 'Senegal', 
	'SC' => 'Seychelles', 
	'SL' => 'Sierra Leone', 
	'SG' => 'Singapore',  
	'SK' => 'Slovakia (Slovak Republic)', 
	'SI' => 'Slovenia', 
	'SB' => 'Solomon Islands', 
	'SO' => 'Somalia',  
	'ZA' => 'South Africa', 
	'GS' => 'South Georgia and the South Sandwich Islands', 
	'ES' => 'Spain', 
	'LK' => 'Sri Lanka', 
	'SH' => 'St. Helena', 
	'PM' => 'St. Pierre and Miquelon',  
	'SD' => 'Sudan',  
	'SR' => 'Suriname', 
	'SJ' => 'Svalbard and Jan Mayen Islands', 
	'SZ' => 'Swaziland',  
	'SE' => 'Sweden', 
	'CH' => 'Switzerland',  
	'SY' => 'Syrian Arab Republic', 
	'TW' => 'Taiwan, Province of China', 
	'TJ' => 'Tajikistan', 
	'TZ' => 'Tanzania, United Republic of', 
	'TH' => 'Thailand', 
	'TG' => 'Togo', 
	'TK' => 'Tokelau', 
	'TO' => 'Tonga',  
	'TT' => 'Trinidad and Tobago',  
	'TN' => 'Tunisia',  
	'TR' => 'Turkey', 
	'TM' => 'Turkmenistan', 
	'TC' => 'Turks and Caicos Islands', 
	'TV' => 'Tuvalu', 
	'UG' => 'Uganda', 
	'UA' => 'Ukraine', 
	'AE' => 'United Arab Emirates', 
	'GB' => 'United Kingdom', 
	'UM' => 'United States Minor Outlying Islands', 
	'UY' => 'Uruguay',  
	'UZ' => 'Uzbekistan', 
	'VU' => 'Vanuatu',  
	'VE' => 'Venezuela', 
	'VN' => 'Viet Nam', 
	'VG' => 'Virgin Islands (British)', 
	'VI' => 'Virgin Islands (U.S.)',  
	'WF' => 'Wallis and Futuna Islands',  
	'EH' => 'Western Sahara', 
	'YE' => 'Yemen',  
	'YU' => 'Yugoslavia', 
	'ZM' => 'Zambia', 
	'ZW' => 'Zimbabwe'     
        );            
   return $this->arrayMerge($current, $countries);        			
   }   

   //array of two digit keys (for months) and full name for display values
   function getMonths($current = null) {
      $months = array(
         '01'=>'January',
         '02'=>'February',
         '03'=>'March',
         '04'=>'April',
         '05'=>'May',
         '06'=>'June',
         '07'=>'July',
         '08'=>'August',
         '09'=>'September',
         '10'=>'October',
         '11'=>'November',
         '12'=>'December'
      );
      return $this->arrayMerge($current, $months);
   }

   //formats time into readable hh:mm format
   function formatHourMins($minutes) {
      $d = 0;
      if($minutes>1440) {
         do {
            $d++;
            $minutes = $minutes - 1440;
         } while ($minutes > 1440);
      }
      $h = ltrim(date('H', mktime(0, $minutes)),'0') + (24 * $d);
      $m = ltrim(date('i', mktime(0, $minutes)),'0');
      $return = '';
      if($h>0) $return .= $h . ($h > 1 ? ' hours ' : ' hour ');
      if($m>0) $return .= $m . ($m > 1 ? ' mins ' : ' min ');
      return $return;
   }

   //formats duration (timestamp) into readable decimal format (primary for viewing purposes)
   function formatDurationDecimal($minutes) {
      $d = 0;
      if($minutes>1440) {
         do {
            $d++;
            $minutes = $minutes - 1440;
         } while ($minutes > 1440);
      }
      $h = ltrim(date('H', mktime(0, $minutes)),'0') + (24 * $d);
      $m = ltrim(date('i', mktime(0, $minutes)),'0');
      $m = round($m / 60,2);
      $return = $h + $m;
      return $return;
   }

}
