<?php 
/**
 * 
 * @author WP Shop Team
 */

// Handle the parsing of the _ga cookie or setting it to a unique identifier
function gaParseCookie() {
  if (isset($_COOKIE['_ga'])) {
    list($version,$domainDepth, $cid1, $cid2) = split('[\.]', $_COOKIE["_ga"],4);
    $contents = array('version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1.'.'.$cid2);
    $cid = $contents['cid'];
  }
  else $cid = gaGenUUID();
  return $cid;
}

// Generate UUID v4 function - needed to generate a CID when one isn't available
function gaGenUUID() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

    // 16 bits for "time_mid"
    mt_rand( 0, 0xffff ),

    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand( 0, 0x0fff ) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand( 0, 0x3fff ) | 0x8000,

    // 48 bits for "node"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
}

function gaBuildHit( $method = null, $info = null ) {
  if ( $method && $info) {

  // Standard params
  $v = 1;
  $tid = get_option("wpshop.google_analytic"); // Put your own Analytics ID in here
  $cid = gaParseCookie();

  // Register a PAGEVIEW
  if ($method === 'pageview') {

    // Send PageView hit
    $data = array(
      'v' => $v,
      'tid' => $tid,
      'cid' => $cid,
      't' => 'pageview',
      'dt' => $info['title'],
      'dp' => $info['slug']
    );

    gaFireHit($data);

  } // end pageview method

  // Register an ECOMMERCE TRANSACTION (and an associated ITEM)
  else if ($method === 'ecommerce') {

    // Set up Transaction params
    $ti = $info['t_num']; // Transaction ID
    $ta = 'order#'.$ti;
    $tr = $info['price']; // transaction value (native currency)
    $cu = get_option("wpshop.google_analytic_cc"); // currency code
	$ts = $info['shiping'];
    // Send Transaction hit
    $data = array(
      'v' => $v,
      'tid' => $tid,
      'cid' => $cid,
      't' => 'transaction',
      'ti' => $ti,
      'ta' => $ta,
      'tr' => $tr,
      'cu' => $cu,
	  'ts' => $ts
    );
    gaFireHit($data);

    // Set up Item params
    $iv = urlencode('SI'); // Product Category - we use 'SI' in all cases, you may not want to

    // Send Item hit
   
	foreach($info['info'] as $value){
	
		$data['in']= $value['in'];
		$data['ip']= $value['ip'];
		$data['iq']= $value['iq'];
		$data['ic']= $value['ic'];
		
		$data['v']= $v;
		$data['tid']= $tid;
		$data['cid']= $cid;
		$data['t']= 'item';
		$data['ti']= $ti;
		$data['iv']= '';
		$data['cu']= $cu;
		
		gaFireHit($data);
	}
    

  } // end ecommerce method
 }
}

// See https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide
function gaFireHit( $data = null ) {
  if ( $data ) {
    $getString = 'https://ssl.google-analytics.com/collect';
    $getString .= '?payload_data&';
    $getString .= http_build_query($data);
    $result = wp_remote_get( $getString );

    //$sendlog = error_log($getString, 1, "admin@gmail.com"); // comment this in and change your email to get an log sent to your email

    return $result;
  }
  return false;
}