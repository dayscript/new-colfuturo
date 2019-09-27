<?php


namespace Drupal\miniorange_oauth_client\Controller;

use Drupal\user\Entity\User;
use Drupal\Component\Utility\Html;
use Drupal\Core\Controller\ControllerBase;
use Drupal\miniorange_oauth_client\Utilities;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Component\Render\FormattableMarkup;
use Symfony\Component\HttpFoundation\RedirectResponse;
class miniorange_oauth_clientController extends ControllerBase
{
    public static function miniorange_oauth_client_mo_login()
    {
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
            $id = self::getAccessToken($VH["access_token_ep"], "authorization_code", $VH["client_id"], $VH["client_secret"], $ES, $VH["callback_uri"]);
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
            $pY .= $id;
        M1:
            $D9 = self::getResourceOwner($pY, $id);
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
            if (empty($D9[$mV])) {
                goto Zi;
            }
            if (empty($D9[$mV])) {
                goto QI;
            }
            $Hk = $D9[$mV];
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
            $Ps = $Hk;
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
            foreach ($Lc as $Dy => $on) {
                if (!(!empty($Dy) && !is_null($Dy) && !strcasecmp($ZB[$nN], $Dy))) {
                    goto TI;
                }
                $S5 = array_search($on, user_roles());
                $Ax[$S5] = $on;
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
            $KY->{$Fb}["und"][0]["value"] = $Vg;
        ag:
            if (empty($hE)) {
                goto Tl;
            }
            $KY->{$eJ}["und"][0]["value"] = $hE;
        Tl:
            if (empty($P_)) {
                goto ax;
            }
            $KY->{$mb}["und"][0]["value"] = $P_;
        ax:
            if (empty($Zr)) {
                goto ik;
            }
            $KY->{$qM}["und"][0]["value"] = $Zr;
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
            foreach ($Ax as $Dy => $on) {
                $KY->addRole(str_replace(" ", "_", strtolower($on)));
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
    
    public static function getAccessToken($Xe, $Fk, $wO, $Oc, $ES, $xp)
    {
        $io = curl_init($Xe);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_POST, true);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\x41\x75\x74\x68\x6f\x72\x69\172\141\164\151\x6f\156\x3a\x20\x42\141\x73\x69\x63\40" . base64_encode($wO . "\72" . $Oc), "\101\x63\x63\145\160\x74\x3a\x20\x61\160\x70\x6c\x69\x63\141\x74\x69\157\156\x2f\152\163\x6f\156"));
        curl_setopt($io, CURLOPT_POSTFIELDS, "\x72\x65\144\x69\x72\x65\x63\x74\x5f\x75\162\x69\x3d" . urlencode($xp) . "\46\x67\x72\x61\x6e\164\137\164\x79\x70\145\x3d" . $Fk . "\46\x63\x6c\151\145\x6e\164\137\151\x64\75" . $wO . "\46\x63\154\151\145\x6e\x74\137\x73\x65\143\x72\145\x74\x3d" . $Oc . "\x26\143\157\144\145\75" . $ES);
        $Uc = curl_exec($io);
        if (!curl_error($io)) {
            goto Nz;
        }
        echo "\74\x62\x3e\122\145\x73\x70\157\156\x73\145\40\72\40\x3c\x2f\142\x3e\x3c\142\x72\x3e";
        print_r($Uc);
        echo "\74\142\x72\76\x3c\142\x72\76";
        die(curl_error($io));
        Nz:
        if (is_array(json_decode($Uc, true))) {
            goto DH;
        }
        echo "\x3c\142\x3e\122\x65\163\x70\x6f\156\163\x65\40\72\x20\74\x2f\142\x3e\74\142\x72\x3e";
        print_r($Uc);
        echo "\74\142\162\76\x3c\142\162\x3e";
        die("\111\156\x76\x61\x6c\151\144\x20\162\x65\163\x70\x6f\156\163\145\40\162\145\143\145\x69\166\x65\144\x2e");
        DH:
        $Uc = json_decode($Uc, true);
        if (isset($Uc["\145\x72\x72\x6f\x72\x5f\144\145\163\x63\x72\151\x70\164\x69\x6f\156"])) {
            goto aQ;
        }
        if (isset($Uc["\x65\162\162\x6f\x72"])) {
            goto jk;
        }
        if (isset($Uc["\141\x63\143\145\163\x73\x5f\x74\x6f\x6b\x65\156"])) {
            goto uq;
        }
        die("\111\156\166\x61\154\x69\x64\40\x72\x65\x73\160\x6f\x6e\x73\145\x20\162\145\x63\145\151\166\145\144\40\x66\162\x6f\x6d\40\117\101\x75\164\150\40\x50\x72\157\x76\151\144\x65\x72\x2e\x20\103\157\156\164\x61\143\x74\40\x79\x6f\x75\162\x20\141\144\155\151\x6e\151\x73\164\x72\x61\164\x6f\x72\40\146\157\x72\40\155\x6f\x72\145\x20\x64\145\164\x61\151\x6c\163\56");
        goto l2;
        uq:
        $X0 = $Uc["\141\143\143\x65\163\x73\x5f\x74\157\153\145\156"];
        l2:
        goto wZ;
        jk:
        die($Uc["\x65\x72\162\x6f\162"]);
        wZ:
        goto D8;
        aQ:
        die($Uc["\145\x72\162\157\x72\137\144\145\163\x63\162\151\x70\164\151\157\x6e"]);
        D8:
        $_SESSION['access_token_cognito'] = $Uc;
        return $X0;
    }
    public function getResourceOwner($pY, $X0)
    {
        $io = curl_init($pY);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_POST, false);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\x41\x75\x74\150\x6f\x72\151\172\141\164\151\157\x6e\72\40\x42\145\141\162\x65\162\40" . $X0));
        $Uc = curl_exec($io);
        if (!curl_error($io)) {
            goto E4;
        }
        die(curl_error($io));
        E4:
        if (is_array(json_decode($Uc, true))) {
            goto WU;
        }
        die("\111\x6e\x76\x61\154\x69\144\40\x72\145\163\160\157\x6e\163\x65\40\x72\145\x63\145\151\166\145\144\x2e");
        WU:
        $Uc = json_decode($Uc, true);
        if (isset($Uc["\x65\162\x72\x6f\162\x5f\144\x65\x73\143\x72\151\x70\x74\x69\x6f\x6e"])) {
            goto BB;
        }
        if (!isset($Uc["\x65\x72\162\157\x72"])) {
            goto Vm;
        }
        if (is_array($Uc["\145\162\x72\x6f\162"])) {
            goto up;
        }
        echo $Uc["\145\x72\162\x6f\x72"];
        goto f_;
        up:
        print_r($Uc["\145\162\162\157\x72"]);
        f_:
        die;
        Vm:
        goto ge;
        BB:
        if (is_array($Uc["\145\x72\x72\x6f\x72\x5f\x64\145\163\x63\162\151\160\164\x69\157\x6e"])) {
            goto tM;
        }
        echo $Uc["\145\x72\x72\x6f\x72\x5f\144\145\163\x63\x72\x69\x70\164\151\x6f\x6e"];
        goto Am;
        tM:
        print_r($Uc["\x65\162\x72\157\162\x5f\144\145\x73\143\x72\x69\x70\x74\151\x6f\156"]);
        Am:
        die;
        ge:
        return $Uc;
    }
    public static function testattrmappingconfig($px, $zf)
    {
        foreach ($zf as $Dy => $zg) {
            if (is_array($zg) || is_object($zg)) {
                goto j7;
            }
            echo "\x3c\x74\x72\x3e\x3c\x74\x64\76";
            if (empty($px)) {
                goto Gr;
            }
            echo $px . "\56";
            Gr:
            echo $Dy . "\74\57\x74\144\x3e\x3c\164\144\x3e" . $zg . "\74\57\x74\144\x3e\74\57\x74\162\x3e";
            goto i2;
            j7:
            if (empty($px)) {
                goto Ju;
            }
            $px .= "\x2e";
            Ju:
            self::testattrmappingconfig($px . $Dy, $zg);
            i2:
            yA:
        }
        yW:
    }
    public static function getnestedattribute($zg, $Dy)
    {
        if (!empty($Dy)) {
            goto pD;
        }
        return '';
        pD:
        $Jk = explode("\x2e", $Dy);
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
    public static function mo_oauth_client_initiateLogin()
    {
        \Drupal::service("\x70\x61\147\x65\x5f\143\x61\x63\150\145\137\153\151\x6c\x6c\137\163\167\151\x74\x63\150")->trigger();
        \Drupal::configFactory()->getEditable("\x6d\151\x6e\x69\x6f\162\x61\x6e\x67\145\x5f\157\x61\165\x74\x68\137\x63\x6c\x69\x65\x6e\x74\x2e\163\x65\x74\x74\x69\x6e\x67\163")->set("\156\141\x76\151\x67\141\164\151\157\x6e\x5f\165\x72\154", $_SERVER["\x48\124\x54\120\x5f\122\x45\106\x45\122\105\122"])->save();
        $y6 = \Drupal::config("\155\x69\x6e\x69\x6f\162\x61\x6e\x67\145\x5f\157\x61\x75\x74\x68\137\143\154\151\x65\156\x74\x2e\x73\145\164\x74\x69\156\x67\163")->get("\x6d\x69\156\x69\x6f\x72\141\156\x67\x65\x5f\141\165\164\x68\x5f\x63\x6c\x69\145\156\164\x5f\x61\x70\160\x5f\156\141\x6d\x65");
        $BY = \Drupal::config("\155\151\x6e\151\x6f\162\141\156\x67\145\x5f\x6f\x61\165\x74\150\x5f\x63\154\151\x65\156\164\56\x73\145\x74\164\151\x6e\147\163")->get("\x6d\151\x6e\x69\x6f\x72\141\x6e\147\145\x5f\141\165\164\x68\x5f\x63\154\x69\x65\156\164\137\x63\154\x69\145\156\x74\137\151\x64");
        $Oy = \Drupal::config("\x6d\x69\156\x69\157\162\x61\x6e\x67\145\137\x6f\x61\x75\164\x68\x5f\x63\x6c\x69\x65\156\164\x2e\163\145\164\x74\151\x6e\x67\163")->get("\x6d\x69\156\151\157\x72\141\156\x67\145\x5f\141\x75\x74\150\x5f\x63\x6c\x69\x65\x6e\164\137\x63\x6c\x69\x65\156\164\137\x73\x65\x63\x72\145\164");
        $jb = \Drupal::config("\155\x69\156\151\157\x72\x61\156\147\x65\137\x6f\x61\165\164\x68\x5f\143\x6c\x69\x65\x6e\x74\56\163\145\x74\x74\x69\156\x67\163")->get("\155\x69\156\x69\157\162\x61\x6e\147\x65\137\x61\165\x74\150\137\143\x6c\x69\145\156\x74\x5f\x73\x63\x6f\160\145");
        $KA = \Drupal::config("\x6d\x69\x6e\151\x6f\162\x61\x6e\x67\x65\137\x6f\x61\x75\x74\x68\137\x63\x6c\x69\x65\x6e\x74\56\163\x65\164\164\x69\156\147\x73")->get("\155\151\x6e\x69\x6f\162\x61\156\x67\145\137\x61\x75\164\x68\x5f\x63\x6c\151\x65\x6e\164\x5f\x61\x75\164\x68\157\162\151\172\145\137\145\156\x64\x70\157\151\x6e\164");
        $mS = \Drupal::config("\155\x69\156\x69\x6f\x72\141\156\147\145\137\157\x61\165\164\150\137\143\154\x69\145\156\164\x2e\x73\145\164\x74\x69\156\x67\x73")->get("\155\x69\x6e\151\x6f\x72\141\156\x67\145\x5f\x61\x75\164\150\x5f\x63\154\151\145\x6e\x74\137\x63\x61\154\154\x62\x61\x63\x6b\x5f\x75\x72\151");
        $NA = base64_encode($y6);
        if (strpos($KA, "\x3f") !== false) {
            goto hE;
        }
        $KA = $KA . "\77\x63\154\151\x65\x6e\164\137\x69\144\75" . $BY . "\x26\x73\143\157\160\145\75" . $jb . "\x26\x72\x65\144\151\x72\x65\x63\x74\x5f\165\162\x69\75" . $mS . "\x26\x72\145\163\160\x6f\x6e\163\x65\137\x74\171\160\145\75\x63\x6f\144\x65\46\x73\x74\x61\x74\145\75" . $NA;
        goto r3;
        hE:
        $KA = $KA . "\x26\143\x6c\x69\145\156\164\x5f\151\x64\75" . $BY . "\x26\163\143\157\x70\x65\75" . $jb . "\x26\x72\x65\144\x69\x72\x65\143\x74\137\x75\162\151\75" . $mS . "\46\162\x65\x73\x70\x6f\156\x73\145\137\164\171\160\x65\x3d\x63\x6f\144\145\x26\x73\x74\141\x74\x65\x3d" . $NA;
        r3:
        $_SESSION["\157\x61\x75\x74\x68\x32\x73\164\141\x74\145"] = $NA;
        $_SESSION["\141\x70\x70\x6e\x61\x6d\x65"] = $y6;
        header("\114\157\x63\141\x74\151\157\x6e\x3a\x20" . $KA);
        $CI = new RedirectResponse($KA);
        $CI->send();
        return new Response();
    }
    public static function test_mo_config()
    {
        if (\Drupal::config("\155\151\x6e\151\x6f\162\x61\156\147\145\137\x6f\141\165\164\150\x5f\x63\154\x69\x65\156\x74\x2e\x73\145\164\x74\x69\x6e\147\163")->get("\x6d\151\x6e\151\x6f\162\x61\x6e\x67\x65\x5f\x6f\141\165\164\x68\x5f\143\154\151\145\156\x74\x5f\154\x69\143\x65\x6e\x73\145\x5f\153\145\x79") != NULL) {
            goto OR1;
        }
        print_r("\117\101\x75\164\150\x20\x50\162\157\166\151\x64\x65\x72\x20\x63\157\156\146\151\147\165\x72\x61\164\151\x6f\156\x73\x20\156\x6f\164\40\x66\157\165\x6e\x64\56\40\103\157\x6e\x74\141\x63\x74\40\171\x6f\165\162\40\141\144\155\151\156\x69\x73\x74\x72\x61\164\x6f\162\x2e");
        die;
        goto iV;
        OR1:
        user_cookie_save(array("\155\x6f\137\x6f\x61\165\164\x68\137\x74\145\x73\164" => true));
        self::mo_oauth_client_initiateLogin();
        iV:
        return new Response();
    }
    public static function miniorange_oauth_client_mologin()
    {
        if (\Drupal::config("\155\x69\x6e\151\157\162\141\156\147\x65\137\157\141\x75\164\x68\x5f\x63\x6c\151\x65\x6e\164\56\x73\145\164\164\x69\x6e\147\x73")->get("\x6d\151\x6e\x69\x6f\x72\x61\x6e\x67\145\137\x6f\141\165\x74\x68\137\x63\154\x69\x65\x6e\x74\137\x6c\151\x63\x65\x6e\x73\x65\x5f\x6b\145\171") != NULL) {
            goto dj;
        }
        print_r("\117\x41\x75\x74\150\x20\120\162\157\166\x69\x64\145\162\40\143\157\156\146\151\x67\x75\162\x61\x74\x69\x6f\156\163\40\x6e\x6f\164\40\x66\157\165\x6e\144\56\40\x43\x6f\x6e\x74\141\x63\164\x20\x79\157\x75\162\40\141\144\155\x69\x6e\x69\163\164\x72\141\164\157\x72\x2e");
        die;
        goto w1;
        dj:
        self::mo_oauth_client_initiateLogin();
        w1:
        return new Response();
    }
    function oauth_client_logout()
    {
        global $base_url;
        if (!empty(\Drupal::config("\155\x69\156\151\157\162\141\x6e\147\x65\137\157\141\x75\x74\150\x5f\x63\154\151\x65\x6e\x74\x2e\163\145\x74\164\x69\x6e\147\163")->get("\x6d\x69\156\151\157\x72\x61\156\147\145\137\157\x61\165\164\150\x5f\x63\x6c\x69\145\x6e\x74\137\142\x61\x73\x65\x5f\165\162\x6c"))) {
            goto z6;
        }
        $OK = $base_url;
        goto YY;
        z6:
        $OK = \Drupal::config("\155\151\x6e\151\157\162\141\156\x67\x65\137\x6f\141\x75\164\x68\137\143\154\151\145\x6e\164\x2e\x73\x65\164\164\151\156\147\163")->get("\x6d\x69\156\151\x6f\162\x61\x6e\x67\x65\137\157\x61\165\164\x68\x5f\143\154\151\145\x6e\164\x5f\142\141\x73\x65\x5f\x75\x72\x6c");
        YY:
        $xY = $OK . "\57\x75\x73\x65\x72\x2f\x6c\x6f\147\151\156";
        \Drupal::service("\x73\x65\163\163\151\157\x6e\137\x6d\141\x6e\x61\x67\x65\x72")->destroy();
        $NM = \Drupal::request();
        $NM->getSession()->clear();
        if (empty(\Drupal::config("\x6d\151\156\x69\x6f\x72\x61\156\147\145\137\157\141\x75\x74\x68\x5f\143\x6c\151\145\156\164\56\163\145\164\x74\x69\156\x67\163")->get("\x6d\151\x6e\x69\x6f\162\141\156\147\145\137\157\141\x75\164\150\137\143\x6c\x69\x65\156\164\x5f\x6c\157\x67\x6f\x75\x74\x5f\165\x72\154"))) {
            goto mn;
        }
        $PL = \Drupal::config("\155\x69\156\x69\157\162\x61\x6e\147\145\137\157\x61\x75\x74\x68\137\143\x6c\151\145\156\164\56\x73\145\x74\x74\151\156\x67\163")->get("\x6d\x69\156\x69\x6f\162\141\156\x67\x65\137\157\x61\165\164\150\x5f\143\154\151\145\156\x74\137\154\157\x67\157\165\x74\137\x75\162\154");
        $CI = new RedirectResponse($PL);
        $CI->send();
        mn:
        $CI = new RedirectResponse($xY);
        $CI->send();
        return new Response();
    }
}
