<?php


namespace Drupal\miniorange_oauth_client;

class handler
{
    static function generateRandom($YO = 30)
    {
        $cX = "\x61\142\143\144\x65\x66\x67\x68\x69\152\153\x6c\x6d\x6e\157\160\161\x72\163\164\x75\x76\167\170\171\x7a\101\x42\103\104\x45\x46\107\110\x49\x4a\x4b\x4c\115\116\x4f\120\121\122\123\124\x55\x56\x57\130\131\132\60\x31\62\63\x34\x35\66\x37\70\71";
        $AQ = strlen($cX);
        $Dl = '';
        $nN = 0;
        Mb:
        if (!($nN < $YO)) {
            goto YN;
        }
        $Dl .= $cX[rand(0, $AQ - 1)];
        Tr:
        $nN++;
        goto Mb;
        YN:
        return $Dl;
    }
    static function miniorange_oauth_client_validate_code($ES, $UB, $ez)
    {
        $fi = time();
        if (!($fi - $ez >= 400)) {
            goto ks;
        }
        echo "\x59\157\165\x72\x20\x61\x75\x74\150\x65\156\x74\x69\x63\141\x74\x69\x6f\156\x20\143\x6f\x64\145\40\x68\x61\x73\x20\x65\x78\x70\151\x72\145\144\x2e\x20\120\x6c\x65\x61\163\x65\x20\164\x72\171\x20\141\x67\141\151\x6e\x2e";
        die;
        ks:
        if ($ES == $UB) {
            goto FN;
        }
        print_r("\111\156\143\157\x72\162\145\x63\x74\x20\x43\157\144\145");
        die;
        goto fn;
        FN:
        \Drupal::configFactory()->getEditable("\x6d\x69\x6e\151\157\x72\x61\x6e\147\x65\137\157\x61\x75\x74\150\x5f\x63\154\151\145\156\164\56\163\x65\164\164\151\156\x67\x73")->set("\155\x69\x6e\151\x6f\162\x61\x6e\x67\x65\137\157\141\x75\164\x68\137\x63\x6c\x69\x65\156\164\137\143\x6f\144\x65", '')->save();
        fn:
    }
    static function ValidateAccessToken($id, $ez)
    {
        $fi = time();
        if (!($fi - $ez >= 900)) {
            goto Ti;
        }
        echo "\131\157\x75\x72\x20\141\143\x63\145\163\163\40\164\x6f\153\145\156\40\150\141\x73\x20\x65\170\x70\151\162\145\144\56\x20\120\154\x65\x61\x73\x65\x20\x74\x72\x79\x20\141\147\x61\x69\156\x2e";
        die;
        Ti:
    }
    static function miniorange_oauth_client_validate_clientSecret($Oy)
    {
        $Hr = \Drupal::config("\155\x69\156\151\x6f\x72\141\x6e\x67\x65\x5f\157\x61\165\164\150\137\143\x6c\x69\145\x6e\164\56\163\145\164\x74\151\x6e\147\163")->get("\x6d\x69\x6e\151\x6f\162\141\x6e\x67\x65\137\x6f\x61\x75\164\150\137\143\x6c\x69\145\156\164\137\x63\154\x69\145\x6e\x74\137\163\x65\x63\162\145\x74");
        if ($Hr != '') {
            goto qw;
        }
        print_r("\103\x6c\151\x65\156\164\40\123\x65\143\162\x65\x74\40\x69\x73\x20\x6e\x6f\x74\x20\143\x6f\156\146\151\147\x75\162\x65\144");
        die;
        goto bi;
        qw:
        if (!($Oy != $Hr)) {
            goto zE;
        }
        print_r("\103\154\x69\x65\x6e\x74\40\123\x65\143\162\x65\x74\x20\x6d\151\163\155\x61\164\143\x68");
        die;
        zE:
        bi:
    }
    static function miniorange_oauth_client_validate_grant($Fk)
    {
        if (!($Fk != "\141\165\x74\150\157\x72\151\172\141\164\x69\157\x6e\137\143\157\x64\145")) {
            goto iy;
        }
        print_r("\117\156\154\171\x20\x41\165\x74\x68\x6f\x72\x69\x7a\141\164\x69\x6f\x6e\x20\x43\157\x64\145\x20\147\x72\141\x6e\164\40\164\x79\160\x65\40\x73\165\160\x70\x6f\x72\164\145\144");
        die;
        iy:
    }
    static function miniorange_oauth_client_validate_clientId($BY)
    {
        $Ta = \Drupal::config("\x6d\x69\156\151\x6f\162\141\156\147\x65\137\157\141\x75\x74\150\x5f\143\154\151\x65\x6e\x74\x2e\163\145\164\x74\151\156\x67\163")->get("\155\151\156\151\x6f\x72\x61\156\147\145\137\x6f\141\x75\x74\150\137\143\154\151\145\156\x74\x5f\x63\x6c\x69\145\156\164\x5f\x69\x64");
        if ($Ta != '') {
            goto Gv;
        }
        print_r("\x43\x6c\151\145\x6e\164\x20\x49\104\x20\x69\163\x20\156\157\x74\40\143\x6f\x6e\146\x69\147\x75\x72\145\144");
        die;
        goto Ok;
        Gv:
        if (!($BY != $Ta)) {
            goto Hj;
        }
        print_r("\103\154\151\145\156\164\40\111\x44\40\155\151\x73\155\x61\x74\x63\150");
        die;
        Hj:
        Ok:
    }
    static function miniorange_oauth_client_validate_redirectUrl($uW)
    {
        $D1 = \Drupal::config("\155\151\x6e\x69\157\x72\x61\x6e\147\145\x5f\x6f\x61\x75\164\150\x5f\x63\x6c\x69\145\x6e\164\56\163\145\164\164\x69\156\147\163")->get("\x6d\151\156\x69\x6f\x72\x61\156\x67\x65\x5f\157\141\165\164\150\137\x63\x6c\x69\x65\x6e\164\x5f\x72\x65\144\151\x72\145\143\164\137\165\162\x6c");
        if ($D1 != '') {
            goto F3;
        }
        print_r("\x52\x65\144\151\162\x65\x63\x74\x20\125\x52\114\x20\x69\x73\x20\156\157\164\x20\x63\x6f\156\146\x69\x67\x75\x72\145\144");
        die;
        goto cC;
        F3:
        if (!($uW != $D1)) {
            goto HY;
        }
        print_r("\x52\145\144\151\162\x65\143\164\x20\125\x52\x4c\x20\x6d\x69\x73\x6d\141\164\x63\x68");
        die;
        HY:
        cC:
    }
}
?>
