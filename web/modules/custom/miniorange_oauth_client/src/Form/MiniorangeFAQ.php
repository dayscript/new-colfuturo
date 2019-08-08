<?php


namespace Drupal\miniorange_oauth_client\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Render;
class MiniorangeFAQ extends FormBase
{
    public function getFormId()
    {
        return "\155\x69\x6e\151\x6f\162\141\156\x67\x65\x5f\157\141\x75\x74\150\x5f\x63\154\151\145\156\x74\x5f\146\x61\161";
    }
    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
        $y2 = "\x3c\144\x69\x76\76\x3c\157\x62\x6a\145\143\x74\40\x74\x79\160\145\x3d\47\164\145\170\x74\x2f\x68\164\x6d\154\x27\40\144\x61\164\x61\x3d\47\150\164\164\160\163\x3a\57\57\x66\141\x71\56\x6d\151\x6e\x69\x6f\x72\x61\x6e\147\145\x2e\143\x6f\x6d\57\x6b\x62\x2f\x6f\x61\x75\x74\x68\x2d\x6f\160\145\156\x69\x64\55\143\157\x6e\x6e\145\x63\164\57\47\x20\x77\x69\144\164\x68\x3d\x27\x31\60\60\x25\47\x20\x68\145\x69\x67\x68\164\75\47\x36\x30\60\x70\x78\47\x20\x3e\x3c\57\x6f\x62\152\x65\143\164\76\x3c\57\x64\x69\166\x3e";
        $form["\x74\x65\x78\x74"]["\x23\x6d\x61\162\153\165\x70"] = t($y2);
        return $form;
    }
    public function submitForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state)
    {
    }
}
