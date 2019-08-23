<?php


namespace Drupal\miniorange_oauth_client\EventSubscriber;

use Drupal\miniorange_oauth_client\Controller\miniorange_oauth_clientController;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\user\Entity\User;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
class InitSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        $x0[KernelEvents::REQUEST][] = array("\x63\150\145\143\x6b\x46\x6f\162\122\145\x64\x69\x72\145\143\x74\151\x6f\156", 30);
        return $x0;
    }
    public function checkForRedirection()
    {
        global $base_url;
        if (!empty(\Drupal::config("\155\x69\156\x69\157\162\x61\x6e\147\x65\x5f\157\141\x75\x74\150\x5f\143\154\151\145\x6e\164\56\163\145\164\x74\x69\156\147\163")->get("\155\151\156\x69\157\x72\x61\x6e\147\145\137\157\141\165\x74\x68\x5f\143\x6c\x69\x65\156\x74\x5f\x62\x61\x73\145\x5f\165\162\x6c"))) {
            goto SD;
        }
        $OK = $base_url;
        goto SO;
        SD:
        $OK = \Drupal::config("\155\x69\156\x69\x6f\x72\x61\x6e\147\145\x5f\x6f\x61\x75\164\x68\x5f\x63\154\x69\145\x6e\164\56\x73\x65\x74\x74\x69\156\x67\x73")->get("\x6d\151\x6e\x69\157\x72\x61\156\147\145\137\157\141\x75\164\150\137\143\154\151\x65\156\164\137\x62\x61\163\145\137\x75\x72\154");
        SO:
        $mU = '';
        $KC = \Drupal::config("\x6d\151\x6e\151\x6f\x72\x61\156\x67\145\137\x6f\x61\x75\x74\x68\137\143\x6c\151\145\x6e\x74\56\163\x65\x74\164\151\x6e\x67\x73")->get("\155\151\156\151\x6f\162\141\156\147\x65\x5f\x6f\x61\x75\164\150\137\143\x6c\x69\x65\x6e\164\137\141\x75\x74\157\137\162\145\x64\151\162\x65\x63\164\x5f\x74\157\x5f\x69\144\160");
        $AG = \Drupal::config("\155\151\x6e\x69\157\x72\x61\156\147\145\137\x6f\x61\x75\x74\x68\137\143\154\x69\145\156\164\56\163\145\164\164\151\156\147\163")->get("\x6d\x69\x6e\x69\x6f\x72\x61\x6e\x67\x65\x5f\x6f\141\x75\x74\x68\137\x63\154\151\145\x6e\x74\x5f\145\156\x61\x62\x6c\145\x5f\142\141\143\153\144\157\157\162");
        $W6 = \Drupal::config("\155\151\x6e\x69\x6f\162\x61\156\x67\145\x5f\157\141\165\164\150\x5f\143\x6c\x69\x65\x6e\164\x2e\x73\145\164\164\x69\156\147\x73")->get("\155\x69\x6e\x69\x6f\162\x61\156\147\x65\x5f\x6f\x61\x75\x74\x68\x5f\143\154\151\x65\x6e\164\x5f\146\157\162\x63\x65\x5f\141\165\x74\150");
        $DH = \Drupal::config("\x6d\x69\156\151\x6f\x72\141\x6e\147\x65\x5f\x6f\141\165\164\x68\137\x63\154\151\145\x6e\x74\x2e\x73\x65\164\x74\151\x6e\147\x73")->get("\x6d\x69\156\151\157\x72\141\x6e\147\145\x5f\x6f\141\165\164\150\137\x63\x6c\x69\x65\x6e\164\x5f\154\151\x63\145\156\163\145\x5f\x6b\145\171");
        $CI = false;
        if (strpos($_SERVER["\x52\x45\x51\x55\x45\123\124\x5f\125\122\x49"], "\155\157\x5f\154\x6f\147\151\x6e") == false) {
            goto Kv;
        }
        $CI = true;
        goto Jg;
        Kv:
        $CI = false;
        Jg:
        if (!(!\Drupal::currentUser()->isAuthenticated() && $CI == false && !isset($_POST["\160\x61\x73\x73"]))) {
            goto mH;
        }
        if ($AG && isset($_GET["\x6f\x61\165\x74\150\x5f\x63\154\151\145\156\x74\x5f\154\x6f\x67\x69\x6e"]) && $_GET["\157\x61\x75\164\x68\137\x63\x6c\151\x65\x6e\x74\137\154\x6f\x67\x69\156"] == "\x66\x61\154\x73\145") {
            goto LO;
        }
        if (!$W6) {
            goto dJ;
        }
        $Pc = $_SERVER["\122\105\x51\x55\x45\x53\124\x5f\125\122\x49"];
        \Drupal::configFactory()->getEditable("\x6d\x69\156\151\x6f\162\x61\156\147\145\x5f\x6f\x61\x75\x74\150\x5f\x63\154\151\x65\x6e\x74\56\x73\x65\164\x74\151\x6e\x67\x73")->set("\x63\x75\x72\162\x65\156\164\137\154\x69\x6e\x6b", $Pc)->save();
        miniorange_oauth_clientController::miniorange_oauth_client_mologin();
        dJ:
        goto PP;
        LO:
        PP:
        $qI = '';
        if (!($DH == NULL)) {
            goto On;
        }
        \Drupal::state()->delete("\155\151\x6e\151\157\162\x61\156\147\145\x5f\x6f\x61\x75\x74\x68\137\143\154\x69\145\x6e\164\x5f\x66\157\x72\143\x65\x5f\x61\165\x74\150");
        \Drupal::state()->delete("\155\151\156\x69\157\162\141\x6e\x67\145\137\x6f\x61\x75\164\150\137\x63\154\151\x65\156\164\137\145\156\141\x62\x6c\145\137\142\x61\x63\x6b\x64\x6f\157\162");
        On:
        mH:
    }
}
