<?php


namespace Drupal\miniorange_oauth_client;

class MiniorangeOAuthClientSupport
{
    public $email;
    public $phone;
    public $query;
    public function __construct($UQ, $tG, $e1)
    {
        $this->email = $UQ;
        $this->phone = $tG;
        $this->query = $e1;
    }
    public function sendSupportQuery()
    {
        $this->query = "\133\x44\x72\165\160\141\x6c\x20\x38\40\117\x41\x75\164\150\40\103\x6c\151\x65\x6e\x74\x20\x45\x6e\164\145\162\160\x72\151\x73\145\40\120\154\165\x67\x69\156\x5d\40" . $this->query;
        $ZN = array("\143\157\155\x70\141\156\x79" => $_SERVER["\x53\x45\x52\126\x45\x52\x5f\116\x41\115\105"], "\145\x6d\x61\x69\154" => $this->email, "\160\x68\x6f\x6e\145" => $this->phone, "\x71\x75\145\162\171" => $this->query);
        $QM = json_encode($ZN);
        $eK = MiniorangeOAuthClientConstants::BASE_URL . "\57\x6d\x6f\141\x73\57\x72\x65\163\164\57\143\x75\163\x74\x6f\x6d\x65\162\57\143\x6f\156\164\141\143\x74\x2d\165\163";
        $io = curl_init($eK);
        curl_setopt($io, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($io, CURLOPT_ENCODING, '');
        curl_setopt($io, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($io, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($io, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($io, CURLOPT_MAXREDIRS, 10);
        curl_setopt($io, CURLOPT_HTTPHEADER, array("\103\157\x6e\164\x65\156\164\55\124\x79\x70\x65\72\40\x61\x70\x70\154\x69\x63\141\x74\x69\157\156\x2f\x6a\163\157\156", "\143\150\141\x72\163\145\164\72\x20\125\x54\106\x2d\70", "\101\165\164\x68\x6f\x72\151\x7a\141\164\151\157\156\x3a\40\x42\141\163\151\143"));
        curl_setopt($io, CURLOPT_POST, TRUE);
        curl_setopt($io, CURLOPT_POSTFIELDS, $QM);
        $Uc = curl_exec($io);
        if (!curl_errno($io)) {
            goto Fu;
        }
        $kl = array("\45\155\x65\164\x68\157\144" => "\x73\145\156\x64\x53\165\x70\x70\157\x72\164\x51\165\x65\x72\x79", "\x25\x66\151\x6c\x65" => "\x6d\x69\x6e\151\x6f\162\x61\156\147\145\137\157\141\165\164\150\137\143\x6c\151\x65\156\x74\137\163\x75\x70\160\x6f\x72\164\x2e\x70\x68\160", "\45\145\162\x72\157\x72" => curl_error($io));
        watchdog("\x6d\x69\x6e\151\x6f\x72\x61\x6e\147\145\137\x6f\141\x75\164\x68\137\x63\x6c\151\145\x6e\164", "\x63\125\122\x4c\40\x45\x72\162\x6f\x72\40\x61\x74\40\x25\155\x65\x74\150\x6f\144\40\157\x66\40\45\x66\x69\x6c\145\x3a\x20\x25\145\162\162\157\162", $kl);
        return FALSE;
        Fu:
        curl_close($io);
        return TRUE;
    }
}
