<?php


namespace Drupal\miniorange_oauth_client\Controller;

use Drupal\user\Entity\User;
use Drupal\Component\Utility\Html;
use Drupal\Core\Controller\ControllerBase;
use Drupal\miniorange_oauth_client\Utilities;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Component\Render\FormattableMarkup;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\HeaderBag;


class miniorange_oauth_clientController extends ControllerBase
{
    public static function miniorange_oauth_client_mo_login()  {
        
        $bypass = false;
        // custom 
        if(!is_null($_SESSION['miniorange_congito_oauth2'])){
            $id = $_SESSION['miniorange_congito_oauth2']['AccessToken'];
            $bypass = true;
            goto Fh;
        }
        //custom

        $ES = Html::escape($_GET["code"]);
        $NA = Html::escape($_GET["state"]);
        if (!(isset($ES) && isset($NA))) {
            goto Fh;
        }
        if (!(session_id() == '' || !isset($_SESSION))) {
            goto q6;
        }
        session_start();
        
        q6:
            if (!isset($ES)) {
                goto Ml;
            }
            $f6 = '';
            if (isset($_SESSION["appname"]) && !empty($_SESSION["appname"])) {
                goto bK;
            }
            if (!(isset($NA) && !empty($NA))) {
                goto pW;
            }
            $f6 = base64_decode($NA);
        pW:
            goto gH;
        bK:
            $f6 = $_SESSION["appname"];
        gH:
            if (!empty($f6)) {
                goto ly;
            }
            die("No request found for this application.");
        ly:
            goto Cb;
        Ml:
            if (isset($_GET["error_description"])) {
                goto MG;
            }
            if (!isset($_GET["error"])) {
                goto rC;
            }
            die($_GET["error"]);
        rC:
            goto nA;
        MG:
            die($_GET["error_description"]);
        nA:
            die("Invalid response");
        Cb:
        Fh:
            $VH = array();
            $VH = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_appval");
            $nJ = '';
            $EE = '';
            $o6 = '';
            $UQ = '';
            if (!isset($VH["miniorange_oauth_client_email_attr"])) {
                goto UK;
            }
            $EE = $VH["miniorange_oauth_client_email_attr"];
        UK:
            if (!isset($VH["miniorange_oauth_client_name_attr"])) {
                goto rK;
            }
            $nJ = $VH["miniorange_oauth_client_name_attr"];
        rK:
            // Custom
            if(!isset($id)){
                $id = self::getAccessToken($VH["access_token_ep"], "authorization_code", $VH["client_id"], $VH["client_secret"], $ES, $VH["callback_uri"]);
            }
            // Custom
            if ($id) {
                goto SN;
            }
            print_r("Invalid token received.");
            die;
        SN:
            $pY = $VH["user_info_ep"];
            
            if (!(substr($pY, -1) == "=")) {
                goto M1;
            }
        M1:
            //Custom
            if(!$bypass){
                $D9 = self::getResourceOwner($pY, $id);
            }else{
                $cognito = \Drupal::service('colfuturo_apps.aws_cognito');
                $D9 = $cognito->client->decodeAccessToken($_SESSION['miniorange_congito_oauth2']['IdToken']);
            }
            
            //Custom
            if (!(isset($_COOKIE["Drupal_visitor_mo_oauth_test"]) && $_COOKIE["Drupal_visitor_mo_oauth_test"] == true)) {
                goto LX;
            }
            user_cookie_save(array("mo_oauth_test" => false));
            echo "<style>table{border-collapse: collapse;}table, td, th {border: 1px solid black;padding:4px}</style>";
            echo "<h2>Test Configuration</h2><table><tr><th>Attribute Name</th><th>Attribute Value</th></tr>";
            self::testattrmappingconfig('', $D9);
            echo "</table>";
            die;
            return new Response();
        LX:
            $In = array();
            $Fb = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_attr1_name");
            $Ag = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_attr1_name");
            $eJ = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_attr2_name");
            $eq = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_attr2_name");
            $mb = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_attr3_name");
            $IM = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_attr3_name");
            $qM = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_attr4_name");
            $MR = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_attr4_name");
            $WN = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_role_attr_name");
            if (!(!empty($Fb) && !empty($Ag))) {
                goto CN;
            }
            $In[$Fb] = $Ag;
        CN:
            if (!(!empty($eJ) && !empty($eq))) {
                goto wE;
            }
            $In[$eJ] = $eq;
        wE:
            if (!(!empty($mb) && !empty($IM))) {
                goto hZ;
            }
            $In[$mb] = $IM;
        hZ:
            if (!(!empty($qM) && !empty($MR))) {
                goto z1;
            }
            $In[$qM] = $MR;
        z1:
            $mV = '';
            $Lc = '';
            $Ps = null;
            $Ax = array();
            if (!(\Drupal::config("miniorange_oauth_client.settings")->get("rolemap") != '')) {
                goto RX;
            }
            $Lc = \Drupal::config("miniorange_oauth_client.settings")->get("rolemap");
        RX:
            if (!(\Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_role_attr_name") != '')) {
                goto Wz;
            }
            $mV = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_role_attr_name");
        Wz:
            //Custom
            // $token = '*';
            // $string = $mV; // array index with token to search;
            // $token_pos = NULL;
            // foreach( $D9 as $index => $value ){
            //     if($token_pos = strpos($string,$token)){
            //         for($i = 0 ; $i <= count($D9)-1 ;$i++){
            //             $string[$token_pos] = $i;   
            //             if(isset($D9[$string]) ){
            //                 $roles[] = $D9[$string];
            //             }
            //         }
            //     }else{
            //         continue;
            //     }
            // }
            
            // if(is_null($roles)){ //Custom
                if (empty($D9[$mV])) {
                    goto Zi;
                }
                if (empty($D9[$mV])) {
                    goto QI;
                }
            // }//Custom
            $Hk = (is_array($D9[$mV])) ? implode(',',$D9[$mV]) : $D9[$mV];
        QI:
            goto P2;
        Zi:
            if (!(strpos($mV, ".") !== false)) {
                goto WN;
            }
            $gS = $D9;
            $YX = explode(".", $mV);
            $nN = 0;
        Zk:
            if (!($nN < sizeof($YX))) {
                goto TE;
            }
            $Jq = $YX[$nN];
            $gS = $gS[$Jq];
            $Hk = $gS;
        ht:
            $nN++;
            goto Zk;
        TE:
        WN:
        P2:
            $Ps = array();
            if (!is_array($Hk)) {
                goto PS;
            }
            
            goto WZ;
        PS:
            $Ps[0] = $Hk;
            
        WZ:
            if (!(isset($mV) && !empty($mV) && isset($Ps))) {
                goto Ec;
            }
            $Ps[0] = preg_replace("/\s+/", '', $Ps[0]);
            $O4 = strpos($Ps[0], ",");
            if (!(sizeof($Ps) == 1 && $O4 !== false)) {
                goto Xk;
            }
            $wc = explode(",", $Ps[0]);
            $Ps = $wc;
        Xk:
            $nN = 0;
        nD:
            if (!($nN < sizeof($Ps))) {
                goto z5;
            }
            $ZB[$nN] = $Ps[$nN];
        Bk:
            $nN++;
            goto nD;
        z5:
            $Ax = array();
            $nN = 0;
        AF:
            if (!($nN < sizeof($ZB))) {
                goto MM;
            }
            // $Lc => Roles from drupal mini map
            // $Ps => Roles from cognito
            
            foreach ($Lc as $Dy => $on) {
                // if (!(!empty($Dy) && !is_null($Dy) && !strcasecmp($ZB[$nN], $Dy))) {
                //     goto TI;
                // }
                $user_roles = $Ps; //user_roles();
                
                $S5 = array_search($on, $Ps);
                //$S5 = ( array_key_exists($Dy, $user_roles) ) ? $Dy:array_search($on, $user_roles);
                if($S5 !== false){
                    $Ax[$Dy] = $on;
                }
                
                $nN++;
                TI:
                LN:
            }
            
        ow:
        pA:
            $nN++;
            goto AF;
        MM:
        Ec:
            if (empty($EE)) {
                goto L6;
            }
            $UQ = self::getnestedattribute($D9, $EE);
        L6:
            if (empty($nJ)) {
                goto y6;
            }
            $o6 = self::getnestedattribute($D9, $nJ);
        y6:
            if (!empty($UQ)) {
                goto kl;
            }
            Utilities::save_SSO_report_data("FAILURE. Email not mapped", $o6 ? $o6 : "-", "-");
            echo "<div style='font-family:Calibri;padding:0 3%;'>";
            echo "<div style='color: #a94442;background-color: #f2dede;padding:15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;'> ERROR</div>
                        \xa 
                    <div style='color: #a94442;font-size:14pt; margin-bottom:20px;'><p><strong>Error: </strong>Email address does not received.
                    </p>\xa<p>Check your <b>Attribute Mapping</b> configuration.</p>
                        \xa<p><strong>Possible Cause: </strong>Email Attribute field is not configured.</p>
                    </div>
                    <div style='margin:3%;display:block;text-align:center;'></div>
                    \xa
                    <div style='margin:3%;display:block;text-align:center;'>
                    \xa
                    <input style='padding:1%;width:100px;background: #0091CD none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA;box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.6) inset;color: #FFF;'type='button' value='Done' onClick='self.close();'>
                    \xa
                </div>";
            die;
            return new Response();
        kl:
            $XZ = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_allow_domains");
            $E3 = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_restrict_domains");
            $N4 = strtolower(substr($UQ, strpos($UQ, "@") + 1));
            global $base_url;
            if (!empty(\Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_base_url"))) {
                goto ew;
            }
            $OK = $base_url;
            goto ZX;
        ew:
            $OK = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_base_url");
        ZX:
            if (empty($XZ)) {
                goto AB;
            }
            $XZ = explode(";", preg_replace("/\s+/", '', strtolower($XZ)));
            if (in_array($N4, $XZ)) {
                goto DW;
            }
            Utilities::save_SSO_report_data("FAILURE. Domain Restricted", $o6 ? $o6 : "-", $UQ);
            echo '<div style="font-family:Calibri;padding:0 3%;">';
            echo "<div style='color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;'> ERROR</div>
                <div style='color: #a94442;font-size:14pt; margin-bottom:20px;'><p><strong>Error: </strong>Domain restriction is enabled.</p>
                    <p>Please contact your administrator.</p>\xa<p><strong>Possible Cause: </strong>Your domin is not allowed to login.</p>\xa</div>
                <div style='margin:3%;display:block;text-align:center;'></div>\xa<div style='margin:3%;display:block;text-align:center;'>\xa<form action='' . $OK . '' method ='post'>\xa<input style='padding:1%;width:100px;background: #0091CD none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA;box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.6) inset;color: #FFF;'type='submit' value='Done'>\xa</form></div>";
            die;
            return new Response();
        DW:
        AB:
            if (empty($E3)) {
                goto Im;
            }
            $E3 = explode(";", preg_replace("/\s+/", '', strtolower($E3)));
            if (!in_array($N4, $E3)) {
                goto b9;
            }
            Utilities::save_SSO_report_data("FAILURE. Domain Restricted", $o6 ? $o6 : "-", $UQ);
            echo "<div style='font-family:Calibri;padding:0 3%;'>";
            echo "<div style='color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;'> ERROR</div>
                                    <div style='color: #a94442;font-size:14pt; margin-bottom:20px;'><p><strong>Error: </strong>Domain restriction is enabled.</p>
                                        <p>Please contact your administrator.</p>\xa <p><strong>Possible Cause: </strong>Your domin is not allowed to login.</p>\xa                                </div>
                                    <div style='margin:3%;display:block;text-align:center;'></div>
                                    <div style='margin:3%;display:block;text-align:center;'>
                                    <form action='' . $OK . '' method ='post'>
                                    <input style='padding:1%;width:100px;background: #0091CD none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA;box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.6) inset;color: #FFF;'type='submit' value='Done'>
                                    </form></div>";
            die;
            return new Response();
        b9:
        Im:
            $KY = '';
            if (empty($UQ)) {
                goto sd;
            }
            $KY = user_load_by_mail($UQ);
        sd:
            if (!($KY == null)) {
                goto TN;
            }
            if (!(!empty($o6) && isset($o6))) {
                goto cV;
            }
            $KY = user_load_by_name($o6);
        cV:
        TN:
            global $user;
            $zN = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_auto_create_users");
            $Z0 = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_default_role");
            $Qa = user_role_names(TRUE);
            $Qa = array_values($Qa);
            $Z0 = $Qa[$Z0];
            if (!empty($o6)) {
                goto tc;
            }
            $o6 = $UQ;
        tc:
            if (isset($KY->uid)) {
                goto tU;
            }
            if ($zN) {
                goto e7;
            }
            Utilities::save_SSO_report_data("FAILURE. Registration Disabled", $o6, $UQ);
            echo "<div style='font-family:Calibri;padding:0 3%;'>";
            echo "<div style='color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;'> ERROR</div>
                                    <div style='color: #a94442;font-size:14pt; margin-bottom:20px;'><p><strong>Error: </strong>Account does not exist with your username.</p>\xa<p>Please Contact your administrator</p>
                                        <p><strong>Possible Cause: </strong>Auto creation of user is not allowed if user does not exist.</p>\xa</div>
                                    <div style='margin:3%;display:block;text-align:center;'></div>
                                    <div style='margin:3%;display:block;text-align:center;'>
                                        <input style='padding:1%;width:100px;background: #0091CD none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA;box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.6) inset;color: #FFF;'type='button' value='Done' onClick='self.close();'>
                                    </div>";
            die;
            return new Response();
            goto BV;
        e7:
            $VZ = user_password(8);
            $pt = array("name" => $o6, "mail" => $UQ, "pass" => $VZ, "status" => 1, "roles" => $Z0);
            $KY = User::create($pt);
            $KY->save();
        BV:
        tU:
            $user = \Drupal\user\Entity\User::load($KY->id());
            if (empty($Ag)) {
                goto f0;
            }
            $Vg = self::getnestedattribute($D9, $Ag);
        f0:
            if (empty($eq)) {
                goto uW;
            }
            $hE = self::getnestedattribute($D9, $eq);
        uW:
            if (empty($IM)) {
                goto IF1;
            }
            $P_ = self::getnestedattribute($D9, $IM);
        IF1:
            if (empty($MR)) {
                goto r4;
            }
            $Zr = self::getnestedattribute($D9, $MR);
        r4:
            if (empty($Vg)) {
                goto ag;
            }
            //$KY->{$Fb}["und"][0]["value"] = $Vg;
            $KY->{$Fb} = $Vg;
        ag:
            if (empty($hE)) {
                goto Tl;
            }
            //$KY->{$eJ}["und"][0]["value"] = $hE;
            $KY->{$eJ} = $hE;
        Tl:
            if (empty($P_)) {
                goto ax;
            }
            //$KY->{$mb}["und"][0]["value"] = $P_;
            $KY->{$mb} = $P_;
        ax:
            if (empty($Zr)) {
                goto ik;
            }
            //$KY->{$qM}["und"][0]["value"] = $Zr;
            $KY->{$qM} = $Zr;
        ik:
            $KY->save();
            if (is_null($KY)) {
                goto zt;
            }
            $eI = \Drupal::configFactory()->getEditable("miniorange_oauth_client.settings")->get("miniorange_oauth_disable_role_update");
            $KY = \Drupal\user\Entity\User::load($KY->id());
            $RY = $KY->getRoles();
            $kZ = array();
            if (!$eI) {
                goto oH;
            }
            
            $kZ = array_intersect($RY, $Qx);
        oH:
        
        foreach ($RY as $Dy => $on) {
            if (empty($kZ)) {
                goto Mi;
            }
            if (in_array($on, $kZ)) {
                goto VM;
            }
            goto Rt;
            Mi:
                $KY->removeRole($on);
                goto Rt;
            VM:
                $KY->removeRole($on);
            Rt:
            pm:
        }
        
        tu:
        if (!(isset($Ax) && !empty($Ax))) {
            goto ry;
        }
        
        foreach ($Ax as $Dy => $on) {
            if (!array_key_exists($on, $Qx)) {
                goto hG;
            }
            $KY->addRole(str_replace(" ", "_", strtolower($Qx[$on])));
            $KY->save();
            hG:
            Rq:
        }
        lw:
        ry:
        zt:
            if (!(sizeof($KY->getRoles()) == 1)) {
                goto fD;
            }
            $KY->addRole(str_replace(" ", "_", strtolower($Z0)));
            $KY->save();
        fD:
            if (!(isset($Ax) && !empty($Ax))) {
                goto Dh;
            }
            
            //$Ax => roles from cognito
            foreach ($Ax as $Dy => $on) {
                $KY->addRole(str_replace(" ", "_", strtolower($Dy)));
                $KY->save();
                c0:
            }
        mP:
        Dh:
            $xp = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_default_relaystate");
            $Hr = \Drupal::config("miniorange_oauth_client.settings")->get("current_link");
            if ($xp != '') {
                goto xh;
            }
            if (!($Hr != '')) {
                goto E3;
            }
            $OK = $Hr;
        E3:
            goto cO;
        xh:
        $OK = $xp;
        cO:
        Utilities::save_SSO_report_data("SUCCESS", $o6, $UQ);
        $x1 = array();
        $x1["redirect"] = $OK;
        user_login_finalize($KY);
        $CI = new RedirectResponse($x1["redirect"]);
        $CI->send();
        return new Response(); 
    }
    
    public static function getAccessToken($Xe, $Fk, $wO, $Oc, $ES, $xp)  {
        
        $io = curl_init($Xe);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_POST, true);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode($wO . ":" . $Oc), "Accept: application/json"));
        curl_setopt($io, CURLOPT_POSTFIELDS, "redirect_uri=" . urlencode($xp) . "&grant_type=" . $Fk . "&client_id=" . $wO . "&client_secret=" . $Oc . "&code=" . $ES);
        $Uc = curl_exec($io);
        
        if (!curl_error($io)) {
            goto Nz;
        }
        echo "<b>Response : </b><br>";
        print_r($Uc);
        echo "<br><br>";
        die(curl_error($io));
        Nz:
            if (is_array(json_decode($Uc, true))) {
                goto DH;
            }
            echo "<b>Response : </b><br>";
            print_r($Uc);
            echo "<br><br>";
            die("Invalid response received.");
        DH:
            $Uc = json_decode($Uc, true);
            if (isset($Uc["error_description"])) {
                goto aQ;
            }
            if (isset($Uc["error"])) {
                goto jk;
            }
            if (isset($Uc["access_token"])) {
                goto uq;
            }
            die("Invalid response received from OAuth Provider. Contact your administrator for more details.");
            goto l2;
        uq:
            $X0 = $Uc["access_token"];
        l2:
            goto wZ;
        jk:
            die($Uc["error"]);
        wZ:
            goto D8;
        aQ:
            die($Uc["error_description"]);
        D8:
            //$_SESSION['access_token_cognito'] = $Uc;
            return $X0;
    }

    public function getResourceOwner($pY, $X0)   {
        
        $io = curl_init($pY);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_POST, false);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $X0));
        
        $Uc = curl_exec($io);
        
        if (!curl_error($io)) {
            goto E4;
        }
        die(curl_error($io));
        E4:
        if (is_array(json_decode($Uc, true))) {
            goto WU;
        }
        die("Invalid response received.");
        WU:
        $Uc = json_decode($Uc, true);
        if (isset($Uc["error_description"])) {
            goto BB;
        }
        if (!isset($Uc["error"])) {
            goto Vm;
        }
        if (is_array($Uc["error"])) {
            goto up;
        }
        echo $Uc["error"];
        goto f_;
        up:
        print_r($Uc["error"]);
        f_:
        die;
        Vm:
        goto ge;
        BB:
        if (is_array($Uc["error_description"])) {
            goto tM;
        }
        echo $Uc["error_description"];
        goto Am;
        tM:
        print_r($Uc["error_description"]);
        Am:
        die;
        ge:
        return $Uc;
    }

    public static function testattrmappingconfig($px, $zf)  {
        foreach ($zf as $Dy => $zg) {
            if (is_array($zg) || is_object($zg)) {
                goto j7;
            }
            echo "<tr><td>";
            if (empty($px)) {
                goto Gr;
            }
            echo $px . ".";
            Gr:
            echo $Dy . "</td><td>" . $zg . "</td></tr>";
            goto i2;
            j7:
            if (empty($px)) {
                goto Ju;
            }
            $px .= ".";
            Ju:
            self::testattrmappingconfig($px . $Dy, $zg);
            i2:
            yA:
        }
        yW:
    }
    public static function getnestedattribute($zg, $Dy)  {
        if (!empty($Dy)) {
            goto pD;
        }
        return '';
        pD:
        $Jk = explode(".", $Dy);
        if (sizeof($Jk) > 1) {
            goto i4;
        }
        $gE = $Jk[0];
        if (!isset($zg[$gE])) {
            goto bw;
        }
        return $zg[$gE];
        bw:
        goto aY;
        i4:
        $gE = $Jk[0];
        if (!isset($zg[$gE])) {
            goto zG;
        }
        return self::getnestedattribute($zg[$gE], str_replace($gE . "\56", '', $Dy));
        zG:
        aY:
    }
    public static function mo_oauth_client_initiateLogin() {
        

        \Drupal::service("page_cache_kill_switch")->trigger();
        \Drupal::configFactory()->getEditable("miniorange_oauth_client.settings")->set("navigation_url", $_SERVER["HTTP_REFERER"])->save();
        $y6 = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_app_name");
        $BY = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_client_id");
        $Oy = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_client_secret");
        $jb = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_scope");
        $KA = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_authorize_endpoint");
        $mS = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_callback_uri");
        $NA = base64_encode($y6);
        if (strpos($KA, "?") !== false) {
            goto hE;
        }
        $KA = $KA . "?client_id=" . $BY . "&scope=" . $jb . "&redirect_uri=" . $mS . "&response_type=code&state=" . $NA;
        goto r3;
        hE:
        $KA = $KA . "&client_id=" . $BY . "&scope=" . $jb . "&redirect_uri=" . $mS . "&response_type=code&state=" . $NA;
        r3:
        $_SESSION["oauth2state"] = $NA;
        $_SESSION["appname"] = $y6;
        
        /**/
        $CI = new RedirectResponse('/d_login');
        $CI->send();
        return new Response(); 
        /**/


        // header("Location: " . $KA);
        // $CI = new RedirectResponse($KA);
        // $CI->send();
        // return new Response(); 
        
    }

    public static function colfuturo_login_form(){
        
        // class namespace and name and load form
        $form_class = '\Drupal\miniorange_oauth_client\Form\MiniorangeLoginForm';
        $form = \Drupal::formBuilder()->getForm($form_class);
        
        //load renderer Drupal Service and redender form
        $renderer = \Drupal::service('renderer');
        $form_renderer = $renderer->render($form);

        return [
            '#markup' => $form_renderer
        ];

    }

    public static function test_mo_config() {
        if (\Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_license_key") != NULL) {
            goto OR1;
        }
        print_r("OAuth Provider configurations not found. Contact your administrator.");
        die;
        goto iV;
        OR1:
        user_cookie_save(array("mo_oauth_test" => true));
        self::mo_oauth_client_initiateLogin();
        iV:
        return new Response();
    }
    public static function miniorange_oauth_client_mologin() {
        if (\Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_license_key") != NULL) {
            goto dj;
        }
        print_r("OAuth Provider configurations not found. Contact your administrator.");
        die;
        goto w1;
        dj:
        self::mo_oauth_client_initiateLogin();
        w1:
        return new Response();
    }

    function oauth_client_logout() {
        global $base_url;
        if (!empty(\Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_base_url"))) {
            goto z6;
        }
        $OK = $base_url;
        goto YY;
        z6:
        $OK = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_base_url");
        YY:
        $xY = $OK . "/";
        \Drupal::service("session_manager")->destroy();
        $NM = \Drupal::request();
        $NM->getSession()->clear();
        if (empty(\Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_logout_url"))) {
            goto mn;
        }
        $PL = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_oauth_client_logout_url");
        $CI = new RedirectResponse($PL);
        $CI->send();
        mn:
        $CI = new RedirectResponse($xY);
        $CI->send();
        return new Response(); 
    }
}
