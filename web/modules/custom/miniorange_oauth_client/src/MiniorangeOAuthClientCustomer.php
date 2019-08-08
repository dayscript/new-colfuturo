<?php


namespace Drupal\miniorange_oauth_client;

use Drupal\miniorange_oauth_client\Utilities;
class MiniorangeOAuthClientCustomer
{
    public $email;
    public $phone;
    public $customerKey;
    public $transactionId;
    public $password;
    public $otpToken;
    private $defaultCustomerId;
    private $defaultCustomerApiKey;
    public function __construct($UQ, $tG, $jF, $e8)
    {
        $this->email = $UQ;
        $this->phone = $tG;
        $this->password = $jF;
        $this->otpToken = $e8;
        $this->defaultCustomerId = "\61\x36\x35\65\x35";
        $this->defaultCustomerApiKey = "\x66\106\144\62\130\x63\x76\x54\x47\x44\x65\155\132\x76\142\x77\61\142\143\x55\145\x73\116\x4a\127\105\161\x4b\x62\x62\x55\161";
    }
    public function checkCustomer()
    {
        if (Utilities::isCurlInstalled()) {
            goto wS;
        }
        return json_encode(array("\x73\x74\x61\164\x75\163" => "\103\125\x52\x4c\137\105\x52\x52\x4f\x52", "\x73\x74\x61\164\165\x73\115\145\x73\x73\x61\147\145" => "\x3c\141\40\x68\x72\145\x66\x3d\x22\150\x74\x74\x70\x3a\57\x2f\x70\150\x70\x2e\156\145\164\57\x6d\x61\x6e\165\141\154\57\x65\x6e\57\143\165\162\154\x2e\x69\x6e\x73\164\x61\x6c\154\141\x74\x69\157\x6e\56\x70\150\x70\42\x3e\x50\x48\120\40\x63\125\x52\x4c\40\x65\x78\x74\145\x6e\163\151\x6f\x6e\x3c\x2f\141\76\40\x69\x73\40\156\157\164\40\x69\x6e\163\x74\141\154\x6c\145\x64\40\157\162\40\144\x69\x73\141\x62\x6c\145\x64\x2e"));
        wS:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\57\x6d\157\141\x73\57\x72\x65\163\164\x2f\143\x75\163\x74\157\155\145\x72\x2f\143\x68\x65\x63\153\55\x69\x66\55\145\x78\x69\x73\x74\163";
        $io = curl_init($eK);
        $UQ = $this->email;
        $ZN = array("\145\155\x61\x69\x6c" => $UQ);
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($io, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\x43\157\156\164\145\x6e\164\55\x54\x79\160\x65\x3a\x20\141\x70\x70\x6c\x69\x63\141\164\151\157\x6e\57\x6a\x73\x6f\156", "\x63\x68\141\162\163\145\x74\72\40\125\x54\106\40\55\x20\x38", "\x41\165\164\x68\x6f\x72\151\172\x61\x74\x69\157\x6e\72\40\x42\x61\163\x69\143"));
        curl_setopt($io, CURLOPT_POST, TRUE);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto XK;
        }
        $kl = array("\45\x6d\145\164\150\x6f\144" => "\x63\x68\145\x63\153\103\x75\x73\x74\157\155\145\162", "\45\x66\151\x6c\x65" => "\143\x75\x73\164\157\x6d\145\x72\x5f\163\x65\x74\x75\160\x2e\160\150\x70", "\45\145\x72\162\157\x72" => curl_error($io));
        watchdog("\x6d\151\x6e\x69\157\162\141\156\147\145\x5f\x6f\x61\165\164\150\137\x63\x6c\151\x65\156\x74", "\105\x72\x72\157\162\40\x61\164\40\x25\155\x65\164\150\157\x64\40\157\x66\40\45\146\151\x6c\145\x3a\40\x25\x65\x72\x72\x6f\x72", $kl);
        XK:
        curl_close($io);
        return $Uc;
    }
    function check_status($ES)
    {
        global $base_url;
        if (Utilities::isCurlInstalled()) {
            goto wk;
        }
        return json_encode(array("\x73\164\141\164\165\163" => "\103\125\x52\114\x5f\105\122\122\x4f\x52", "\163\164\141\164\165\163\115\145\163\x73\x61\x67\145" => "\x3c\141\40\150\162\145\146\x3d\42\x68\x74\x74\x70\72\x2f\x2f\x70\150\x70\x2e\156\145\x74\x2f\155\141\156\165\141\154\x2f\x65\x6e\x2f\x63\165\x72\x6c\56\151\156\163\x74\x61\x6c\154\141\164\151\x6f\156\x2e\160\x68\x70\42\76\120\110\x50\40\x63\125\122\114\40\x65\x78\x74\145\156\163\151\157\x6e\x3c\57\141\76\x20\151\x73\x20\156\x6f\164\x20\x69\x6e\x73\x74\x61\154\x6c\x65\x64\40\x6f\x72\40\144\151\163\x61\x62\x6c\x65\144\56"));
        wk:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\x2f\155\157\141\x73\x2f\141\160\151\57\142\x61\x63\153\165\160\143\157\144\x65\x2f\x76\x65\x72\151\146\171";
        $io = curl_init($eK);
        $Iq = \Drupal::config("\x6d\x69\x6e\151\157\162\x61\156\x67\x65\137\157\141\x75\x74\x68\x5f\143\154\151\x65\156\x74\x2e\x73\x65\x74\164\x69\156\x67\x73")->get("\155\151\156\151\x6f\x72\141\156\147\x65\x5f\x6f\x61\165\x74\x68\137\x63\x6c\151\x65\156\164\137\x63\x75\x73\164\x6f\155\145\162\x5f\x69\144");
        $TX = \Drupal::config("\x6d\x69\156\x69\x6f\162\x61\x6e\147\x65\137\x6f\x61\x75\x74\150\x5f\143\x6c\151\145\x6e\164\56\x73\x65\164\x74\x69\x6e\147\163")->get("\155\x69\156\151\x6f\x72\x61\x6e\x67\x65\x5f\x6f\x61\x75\164\150\137\x63\154\151\x65\156\x74\137\x63\165\x73\164\x6f\x6d\145\x72\137\141\x70\x69\137\153\x65\171");
        $YL = self::get_timestamp();
        $nA = $Iq . $YL . $TX;
        $zC = hash("\163\150\141\x35\61\62", $nA);
        $Sc = "\x43\165\163\x74\157\155\x65\x72\55\113\145\x79\x3a\40" . $Iq;
        $z4 = "\124\x69\155\x65\163\x74\141\x6d\160\72\40" . number_format($YL, 0, '', '');
        $Mk = "\x41\165\x74\150\157\x72\x69\172\141\x74\x69\157\156\72\40" . $zC;
        $ZN = '';
        $ZN = array("\x63\x6f\144\145" => $ES, "\143\x75\163\x74\157\x6d\145\x72\113\x65\x79" => $Iq, "\x61\x64\144\151\x74\151\157\156\x61\x6c\x46\151\145\154\144\163" => array("\x66\x69\x65\154\144\61" => $base_url));
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\157\156\164\x65\x6e\x74\55\124\171\x70\145\x3a\40\141\x70\x70\x6c\x69\x63\x61\164\151\x6f\156\57\x6a\163\x6f\x6e", $Sc, $z4, $Mk));
        curl_setopt($io, CURLOPT_POST, true);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        curl_setopt($io, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($io, CURLOPT_TIMEOUT, 20);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto z0;
        }
        echo "\122\145\161\165\145\x73\x74\x20\x45\x72\162\157\162\72" . curl_error($io);
        die;
        z0:
        curl_close($io);
        $Uc = json_decode($Uc, true);
        return $Uc;
    }
    function update_status()
    {
        global $base_url;
        if (Utilities::isCurlInstalled()) {
            goto k2;
        }
        return json_encode(array("\163\164\x61\164\x75\x73" => "\103\x55\x52\x4c\x5f\x45\x52\122\x4f\122", "\x73\x74\141\164\165\x73\115\x65\x73\x73\x61\x67\x65" => "\x3c\141\x20\x68\x72\145\x66\x3d\x22\x68\164\x74\160\x3a\57\57\160\150\160\56\x6e\x65\x74\57\155\141\x6e\x75\x61\x6c\x2f\x65\x6e\x2f\x63\x75\x72\154\x2e\x69\x6e\163\164\x61\x6c\x6c\x61\x74\151\157\x6e\56\160\x68\160\42\76\120\110\x50\40\143\125\x52\114\x20\x65\170\x74\145\x6e\x73\151\157\x6e\74\x2f\141\76\40\151\163\x20\156\x6f\164\40\x69\x6e\163\x74\141\x6c\154\145\144\40\157\x72\x20\x64\151\163\x61\142\154\x65\x64\x2e"));
        k2:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\x2f\x6d\x6f\x61\x73\x2f\x61\160\151\x2f\x62\141\143\x6b\165\160\143\x6f\x64\145\57\x75\160\144\x61\164\x65\163\x74\x61\x74\x75\x73";
        $io = curl_init($eK);
        $Iq = \Drupal::config("\x6d\151\x6e\x69\157\162\141\x6e\147\145\137\157\141\165\164\150\x5f\x63\154\x69\x65\x6e\x74\56\x73\145\x74\x74\x69\x6e\147\163")->get("\155\x69\156\x69\x6f\162\141\156\147\x65\137\x6f\x61\165\x74\150\x5f\143\x6c\151\145\x6e\x74\x5f\x63\x75\163\x74\157\x6d\145\162\x5f\x69\x64");
        $TX = \Drupal::config("\155\x69\x6e\x69\x6f\x72\x61\156\147\x65\x5f\x6f\141\x75\164\150\x5f\x63\x6c\x69\x65\156\164\x2e\x73\x65\164\x74\151\x6e\147\x73")->get("\155\x69\156\x69\x6f\162\x61\x6e\147\x65\137\x6f\141\x75\164\x68\x5f\143\154\x69\x65\x6e\x74\137\x63\165\163\x74\x6f\x6d\x65\x72\x5f\141\x70\151\x5f\153\145\x79");
        $YL = self::get_timestamp();
        $nA = $Iq . number_format($YL, 0, '', '') . $TX;
        $zC = hash("\x73\150\x61\x35\x31\62", $nA);
        $Sc = "\103\x75\x73\x74\x6f\x6d\145\x72\x2d\x4b\x65\x79\72\40" . $Iq;
        $z4 = "\x54\x69\155\x65\x73\x74\x61\155\x70\x3a\x20" . number_format($YL, 0, '', '');
        $Mk = "\x41\165\164\150\x6f\162\151\x7a\x61\164\151\157\156\x3a\40" . $zC;
        $Dy = \Drupal::config("\155\151\x6e\x69\157\162\x61\x6e\x67\x65\137\157\x61\165\x74\x68\x5f\x63\x6c\151\x65\x6e\x74\56\163\145\x74\x74\x69\156\147\x73")->get("\x6d\151\156\x69\157\162\x61\156\147\x65\x5f\157\141\165\164\150\137\x63\x6c\x69\145\156\164\137\x63\165\x73\164\x6f\155\145\162\137\x61\144\x6d\151\x6e\137\164\x6f\153\x65\156");
        $ES = Utilities::decrypt_data(\Drupal::config("\155\151\x6e\151\x6f\x72\x61\156\147\145\137\x6f\141\x75\x74\150\x5f\143\x6c\151\x65\156\164\56\163\x65\x74\164\151\x6e\x67\163")->get("\x6d\151\156\151\x6f\x72\141\x6e\x67\145\x5f\x6f\x61\165\x74\x68\x5f\143\154\151\145\156\x74\137\154\x69\143\145\x6e\163\145\137\x6b\145\x79"), $Dy);
        $ZN = array("\143\157\x64\x65" => $ES, "\143\165\163\164\x6f\x6d\145\x72\x4b\145\171" => $Iq);
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\157\156\164\x65\156\164\55\124\171\x70\x65\x3a\40\x61\x70\160\x6c\x69\143\x61\x74\151\157\156\57\x6a\163\157\156", $Sc, $z4, $Mk));
        curl_setopt($io, CURLOPT_POST, true);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        curl_setopt($io, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($io, CURLOPT_TIMEOUT, 20);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto Xe;
        }
        echo "\122\x65\161\165\x65\x73\164\40\105\162\x72\157\x72\72" . curl_error($io);
        Xe:
        curl_close($io);
        return $Uc;
    }
    function ccl()
    {
        global $base_url;
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\57\x6d\x6f\x61\x73\57\x72\x65\x73\164\x2f\x63\x75\x73\x74\x6f\x6d\145\162\57\154\x69\143\145\x6e\x73\145";
        $io = curl_init($eK);
        $Iq = \Drupal::config("\155\151\156\x69\157\x72\141\x6e\147\x65\x5f\x6f\x61\x75\164\150\137\143\x6c\151\x65\156\x74\56\163\145\x74\164\151\156\x67\163")->get("\x6d\151\x6e\151\x6f\162\x61\x6e\147\x65\137\157\x61\165\164\x68\137\143\x6c\x69\x65\156\x74\x5f\x63\165\x73\x74\157\155\x65\x72\x5f\x69\144");
        $TX = \Drupal::config("\155\x69\x6e\151\157\162\x61\x6e\x67\145\137\157\141\x75\x74\x68\137\x63\x6c\151\145\x6e\x74\56\x73\x65\164\164\x69\156\x67\163")->get("\x6d\x69\156\x69\x6f\x72\141\x6e\147\x65\137\157\x61\x75\164\150\x5f\143\x6c\x69\145\x6e\164\137\x63\x75\x73\164\x6f\x6d\x65\162\x5f\x61\x70\151\x5f\153\145\x79");
        $YL = self::get_timestamp();
        $nA = $Iq . $YL . $TX;
        $zC = hash("\163\150\141\65\61\x32", $nA);
        $Sc = "\x43\x75\x73\x74\157\155\x65\x72\55\x4b\x65\x79\72\40" . $Iq;
        $z4 = "\124\151\155\145\163\164\x61\x6d\x70\x3a\x20" . $YL;
        $Mk = "\x41\165\164\150\x6f\x72\x69\172\x61\x74\151\157\x6e\x3a\x20" . $zC;
        $ZN = '';
        $ZN = array("\143\x75\163\164\x6f\155\x65\162\x49\x64" => $Iq, "\x61\160\160\x6c\x69\143\x61\x74\x69\x6f\156\x4e\x61\x6d\x65" => "\x64\162\x75\x70\141\x6c\137\157\141\x75\164\x68\137\143\x6c\x69\x65\156\x74");
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\157\x6e\x74\145\x6e\x74\x2d\x54\x79\160\145\x3a\x20\x61\x70\x70\x6c\151\143\x61\x74\151\157\x6e\x2f\152\x73\157\x6e", $Sc, $z4, $Mk));
        curl_setopt($io, CURLOPT_POST, true);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        curl_setopt($io, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($io, CURLOPT_TIMEOUT, 20);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto Nv;
        }
        return null;
        Nv:
        curl_close($io);
        return $Uc;
    }
    function get_timestamp()
    {
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\x2f\x6d\157\x61\163\57\162\145\163\x74\57\155\157\142\151\x6c\145\x2f\x67\145\164\x2d\x74\151\155\145\163\164\x61\155\160";
        $io = curl_init($eK);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($io, CURLOPT_AUTOREFERER, true);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_POST, true);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto XE;
        }
        echo "\105\x72\162\x6f\162\40\151\x6e\x20\x73\x65\156\x64\151\x6e\147\40\x63\165\x72\154\x20\x52\145\x71\x75\145\163\x74";
        die;
        XE:
        curl_close($io);
        return $Uc;
    }
    public function createCustomer()
    {
        if (Utilities::isCurlInstalled()) {
            goto sN;
        }
        return json_encode(array("\x73\164\x61\164\x75\x73\x43\x6f\144\x65" => "\x45\x52\122\x4f\122", "\163\x74\x61\x74\x75\x73\x4d\x65\x73\x73\x61\147\145" => "\56\x20\120\x6c\145\x61\163\x65\x20\x63\x68\x65\x63\x6b\x20\171\157\x75\x72\40\143\157\x6e\146\x69\147\165\162\141\x74\151\157\156\x2e"));
        sN:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\57\155\x6f\141\163\x2f\x72\145\163\x74\x2f\143\x75\x73\164\x6f\155\145\x72\57\141\144\x64";
        $io = curl_init($eK);
        $ZN = array("\x63\157\x6d\160\141\156\x79\116\141\155\145" => $_SERVER["\x53\105\122\x56\x45\x52\137\x4e\101\x4d\105"], "\x61\162\x65\141\x4f\x66\x49\156\x74\x65\x72\x65\x73\164" => "\104\122\125\120\101\x4c\40\70\x20\117\101\165\164\150\x20\x53\x65\162\166\x65\x72", "\145\x6d\x61\x69\x6c" => $this->email, "\160\150\157\x6e\x65" => $this->phone, "\160\141\x73\x73\167\157\162\x64" => $this->password);
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($io, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\x6f\x6e\x74\x65\156\164\x2d\x54\171\x70\x65\x3a\40\x61\x70\160\x6c\151\143\141\164\x69\157\x6e\57\152\163\157\156", "\143\x68\141\x72\x73\x65\x74\x3a\x20\125\x54\106\40\55\x20\x38", "\101\x75\164\150\157\162\151\172\141\x74\151\x6f\156\x3a\40\102\x61\x73\x69\143"));
        curl_setopt($io, CURLOPT_POST, TRUE);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto pH;
        }
        $kl = array("\x25\x6d\x65\x74\x68\157\144" => "\143\x72\x65\x61\x74\x65\103\165\x73\164\x6f\155\145\x72", "\x25\x66\151\x6c\x65" => "\143\x75\163\x74\x6f\x6d\x65\162\137\x73\x65\164\x75\160\56\160\x68\160", "\45\145\162\x72\157\x72" => curl_error($io));
        watchdog("\155\x69\156\x69\157\x72\141\156\147\145\x5f\157\x61\x75\164\x68\137\143\x6c\x69\145\x6e\x74", "\105\162\x72\157\162\x20\141\164\40\45\155\x65\164\150\x6f\x64\x20\x6f\146\40\x25\x66\x69\x6c\x65\x3a\x20\45\x65\x72\x72\x6f\162", $kl);
        pH:
        curl_close($io);
        return $Uc;
    }
    public function getCustomerKeys()
    {
        if (Utilities::isCurlInstalled()) {
            goto vq;
        }
        return json_encode(array("\x61\160\151\x4b\x65\171" => "\103\x55\x52\114\x5f\x45\122\x52\117\122", "\x74\157\153\x65\156" => "\74\x61\x20\x68\x72\x65\x66\x3d\x22\x68\x74\164\160\x3a\57\x2f\x70\150\160\x2e\156\145\164\57\x6d\141\156\x75\141\154\57\x65\x6e\57\143\165\x72\154\56\151\x6e\163\164\x61\x6c\x6c\x61\164\151\157\156\x2e\160\150\x70\x22\x3e\x50\x48\x50\40\143\x55\122\114\40\145\170\x74\145\156\x73\151\157\x6e\x3c\x2f\141\76\x20\151\x73\40\x6e\x6f\x74\x20\151\156\163\x74\141\x6c\154\145\x64\40\157\162\x20\144\x69\x73\141\x62\x6c\x65\x64\x2e"));
        vq:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\x2f\x6d\x6f\141\x73\57\x72\145\x73\x74\x2f\143\x75\163\x74\x6f\155\x65\162\x2f\x6b\x65\x79";
        $io = curl_init($eK);
        $UQ = $this->email;
        $jF = $this->password;
        $ZN = array("\x65\155\141\x69\x6c" => $UQ, "\x70\x61\x73\163\167\x6f\162\x64" => $jF);
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($io, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\x6f\156\164\145\x6e\x74\55\x54\171\160\x65\x3a\40\x61\160\x70\154\151\x63\141\164\151\x6f\156\57\152\x73\x6f\x6e", "\143\x68\x61\162\163\145\x74\x3a\x20\125\x54\106\x20\x2d\40\x38", "\x41\x75\164\x68\157\162\x69\172\x61\x74\x69\x6f\156\x3a\x20\102\x61\163\x69\143"));
        curl_setopt($io, CURLOPT_POST, TRUE);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto hK;
        }
        $kl = array("\45\155\x65\164\x68\x6f\144" => "\x67\x65\164\103\165\x73\164\157\155\145\162\113\x65\171\x73", "\x25\x66\x69\x6c\x65" => "\x63\165\x73\164\157\155\x65\x72\x5f\163\145\164\165\x70\x2e\160\x68\160", "\45\145\x72\162\x6f\x72" => curl_error($io));
        watchdog("\x6d\x69\x6e\x69\x6f\162\x61\x6e\x67\145\x5f\157\x61\165\x74\150\x5f\143\x6c\x69\x65\x6e\x74\137\x69\x64\160", "\105\x72\x72\x6f\x72\40\141\x74\x20\x25\155\145\x74\150\x6f\x64\40\157\x66\x20\45\x66\151\x6c\145\72\40\45\145\162\162\x6f\162", $kl);
        hK:
        curl_close($io);
        return $Uc;
    }
    public function sendOtp()
    {
        if (Utilities::isCurlInstalled()) {
            goto Sy;
        }
        return json_encode(array("\x73\x74\x61\164\165\163" => "\x43\125\x52\x4c\137\x45\122\122\x4f\122", "\x73\164\x61\x74\165\163\x4d\145\163\163\141\147\145" => "\x3c\x61\40\150\162\x65\146\x3d\x22\x68\164\x74\160\72\57\x2f\160\x68\160\56\156\145\x74\x2f\155\141\156\x75\141\154\57\145\156\x2f\143\x75\162\x6c\x2e\151\156\163\x74\141\x6c\x6c\141\164\151\157\x6e\x2e\x70\150\160\x22\x3e\x50\110\120\40\143\x55\x52\114\40\145\170\164\145\156\163\x69\x6f\x6e\x3c\x2f\x61\76\40\151\x73\x20\x6e\157\x74\40\x69\156\x73\164\141\x6c\154\x65\144\40\x6f\162\x20\144\151\x73\141\142\x6c\145\144\56"));
        Sy:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\x2f\x6d\157\x61\163\57\x61\160\151\57\x61\165\x74\x68\57\143\x68\x61\x6c\154\x65\156\147\x65";
        $io = curl_init($eK);
        $x4 = $this->defaultCustomerId;
        $gn = $this->defaultCustomerApiKey;
        $YR = \Drupal::config("\155\x69\156\x69\x6f\x72\x61\156\147\145\x5f\157\141\165\x74\x68\x5f\143\x6c\151\x65\156\x74\56\x73\145\164\x74\x69\156\147\163")->get("\155\151\156\151\157\162\x61\156\x67\145\x5f\157\141\x75\x74\150\137\143\x6c\x69\x65\x6e\164\x5f\x63\165\163\164\157\155\145\162\x5f\141\x64\x6d\x69\156\x5f\x65\x6d\x61\151\154");
        $XL = round(microtime(TRUE) * 1000);
        $mC = $x4 . $XL . $gn;
        $AP = hash("\163\x68\141\x35\x31\62", $mC);
        $tj = "\x43\x75\x73\164\157\x6d\145\162\55\x4b\145\171\72\40" . $x4;
        $JD = "\124\x69\155\145\x73\x74\141\x6d\x70\x3a\40" . $XL;
        $Bk = "\101\x75\x74\x68\157\162\151\x7a\141\x74\x69\x6f\156\x3a\40" . $AP;
        $ZN = array("\x63\165\163\164\x6f\155\x65\x72\113\x65\171" => $x4, "\145\x6d\141\151\x6c" => $YR, "\x61\x75\164\150\x54\x79\160\x65" => "\x45\x4d\x41\111\x4c");
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($io, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\x6f\156\164\145\x6e\x74\55\124\x79\x70\x65\x3a\x20\x61\x70\x70\x6c\151\x63\141\164\x69\x6f\x6e\x2f\152\x73\157\x6e", $tj, $JD, $Bk));
        curl_setopt($io, CURLOPT_POST, TRUE);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto De;
        }
        $kl = array("\x25\x6d\145\164\150\x6f\x64" => "\163\145\156\x64\x4f\x74\160", "\45\146\x69\x6c\x65" => "\143\x75\163\x74\157\x6d\145\162\x5f\x73\x65\x74\x75\x70\x2e\x70\x68\x70", "\x25\145\162\162\x6f\162" => curl_error($io));
        watchdog("\x6d\x69\156\151\157\x72\x61\156\147\145\x5f\x6f\x61\165\x74\150\x5f\143\x6c\x69\145\156\164", "\105\162\162\x6f\162\40\141\x74\x20\x25\x6d\x65\164\150\157\x64\x20\157\x66\40\45\146\x69\x6c\145\x3a\x20\x25\x65\162\162\157\162", $kl);
        De:
        curl_close($io);
        return $Uc;
    }
    public function validateOtp($ya)
    {
        if (Utilities::isCurlInstalled()) {
            goto cM;
        }
        return json_encode(array("\x73\164\x61\164\x75\x73" => "\103\x55\122\114\x5f\x45\x52\x52\x4f\122", "\x73\164\141\x74\x75\163\x4d\145\x73\x73\x61\x67\145" => "\74\x61\40\150\162\145\146\x3d\x22\150\164\164\x70\72\57\x2f\160\150\160\56\156\145\164\57\x6d\141\156\165\x61\154\57\x65\x6e\x2f\x63\165\162\x6c\x2e\x69\x6e\x73\x74\x61\x6c\x6c\141\x74\x69\x6f\x6e\x2e\160\150\x70\42\x3e\120\x48\x50\40\x63\x55\x52\114\40\145\x78\164\145\156\x73\x69\x6f\156\74\57\141\76\x20\151\x73\40\156\157\164\40\151\156\x73\164\141\154\154\x65\144\x20\157\x72\40\x64\151\x73\141\x62\x6c\145\x64\56"));
        cM:
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\57\155\157\x61\163\x2f\x61\160\151\x2f\141\x75\x74\150\57\166\x61\x6c\151\144\x61\164\x65";
        $io = curl_init($eK);
        $x4 = $this->defaultCustomerId;
        $gn = $this->defaultCustomerApiKey;
        $XL = round(microtime(TRUE) * 1000);
        $mC = $x4 . $XL . $gn;
        $AP = hash("\163\150\141\65\x31\62", $mC);
        $tj = "\x43\x75\163\x74\x6f\155\x65\162\55\113\x65\x79\x3a\x20" . $x4;
        $JD = "\x54\x69\x6d\x65\x73\x74\x61\155\160\72\x20" . $XL;
        $Bk = "\x41\x75\x74\150\157\162\x69\x7a\141\x74\151\x6f\x6e\72\40" . $AP;
        $ZN = array("\164\170\x49\x64" => $ya, "\164\x6f\153\x65\x6e" => $this->otpToken);
        $QM = json_encode($ZN);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($io, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\x43\x6f\x6e\x74\x65\156\x74\55\x54\171\x70\x65\x3a\40\141\x70\160\154\x69\143\x61\164\x69\157\x6e\x2f\x6a\x73\x6f\156", $tj, $JD, $Bk));
        curl_setopt($io, CURLOPT_POST, TRUE);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto we;
        }
        $kl = array("\45\x6d\145\x74\150\157\x64" => "\x76\141\154\151\144\141\164\x65\117\x74\x70", "\45\146\151\x6c\145" => "\x63\165\x73\164\157\155\x65\162\137\163\145\164\165\x70\x2e\160\150\160", "\x25\x65\x72\x72\x6f\x72" => curl_error($io));
        watchdog("\155\151\156\151\157\162\x61\x6e\147\145\x5f\x6f\x61\165\x74\x68\x5f\143\154\x69\x65\x6e\164", "\105\x72\162\x6f\x72\x20\141\x74\40\x25\x6d\x65\x74\150\x6f\x64\x20\157\x66\x20\45\146\x69\x6c\145\72\x20\45\145\162\x72\x6f\162", $kl);
        we:
        curl_close($io);
        return $Uc;
    }
}
