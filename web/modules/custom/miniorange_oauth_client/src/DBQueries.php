<?php


namespace Drupal\miniorange_oauth_client;

class DBQueries
{
    public static function get_user_id($user)
    {
        $MF = $user->id();
        $RM = \Drupal::database();
        $e1 = $RM->query("\x53\x45\x4c\105\x43\x54\x20\x2a\40\x46\x52\x4f\115\40\155\151\x6e\x69\157\x72\141\156\x67\x65\x5f\x6f\x61\x75\x74\x68\x5f\x63\154\151\145\156\164\x5f\x74\x6f\153\x65\156\x20\x77\x68\x65\x72\145\40\165\163\x65\162\x5f\x69\x64\137\166\141\154\40\75\x20{$MF}");
        $e1->allowRowCount = TRUE;
        if (!($e1->rowCount() > 0)) {
            goto L7;
        }
        return TRUE;
        L7:
        return FALSE;
    }
    public static function insert_user_in_table($user)
    {
        $MF = $user->id();
        $nS = \Drupal::database();
        $ZN = array("\x75\163\x65\x72\137\151\x64\137\x76\141\x6c" => $MF);
        $nS->insert("\x6d\x69\156\151\x6f\x72\141\156\147\x65\137\157\141\165\164\x68\x5f\x63\154\151\x65\156\164\137\x74\x6f\153\x65\x6e")->fields($ZN)->execute();
    }
    public static function update_user_in_table($user)
    {
        $RM = \Drupal::database();
        $N_ = $RM->update("\155\151\156\x69\157\162\x61\x6e\147\x65\x5f\x6f\141\165\164\x68\x5f\x63\154\151\x65\x6e\x74\x5f\164\x6f\153\x65\x6e")->fields(array("\165\x73\145\162\x5f\151\144\137\166\x61\154" => $user->uid))->execute();
    }
    public static function insert_code_from_user_id($ES, $user)
    {
        $MF = $user->id();
        $RM = \Drupal::database();
        $GY = $RM->update("\x6d\x69\156\x69\157\x72\141\156\147\x65\x5f\157\x61\x75\164\150\137\143\x6c\x69\145\156\x74\x5f\164\157\153\145\156")->fields(array("\141\165\x74\x68\137\143\157\x64\x65" => $ES))->condition("\x75\163\x65\x72\x5f\151\x64\x5f\x76\x61\x6c", $MF, "\x3d")->execute();
        return $GY;
    }
    public static function get_code_from_user_id($UB)
    {
        $Mp = array("\x75\x73\145\162\x5f\x69\x64\137\166\141\x6c");
        $RM = \Drupal::database();
        $e1 = $RM->query("\123\x45\x4c\105\x43\124\40\x2a\40\106\x52\117\x4d\40\x6d\151\x6e\151\x6f\x72\141\156\x67\x65\x5f\157\141\x75\x74\x68\137\x63\154\151\x65\x6e\x74\137\164\x6f\153\145\156\x20\167\x68\x65\x72\x65\40\x61\x75\164\150\137\143\x6f\144\145\40\75\40\x27{$UB}\x27");
        $MF = $e1->fetchAssoc();
        return $MF;
    }
    public static function insert_code_expiry_from_user_id($gr, $user)
    {
        $MF = $user->id();
        $RM = \Drupal::database();
        $C_ = $RM->update("\155\151\156\x69\x6f\x72\141\x6e\x67\145\x5f\157\x61\x75\x74\x68\x5f\143\154\151\145\x6e\x74\x5f\164\157\153\145\x6e")->fields(array("\141\165\164\x68\x5f\x63\x6f\144\145\137\145\170\x70\151\162\171\137\x74\x69\155\x65" => $gr))->condition("\x75\x73\145\x72\137\151\x64\137\x76\141\x6c", $MF, "\x3d")->execute();
        return $C_;
    }
    public static function get_same_code_as_received($UB)
    {
        $RM = \Drupal::database();
        $e1 = $RM->query("\x53\105\114\105\x43\124\x20\52\40\106\122\117\115\x20\x6d\x69\x6e\x69\157\x72\141\156\x67\145\137\x6f\141\165\x74\150\137\143\x6c\151\145\156\164\137\164\x6f\x6b\x65\156\x20\167\x68\x65\162\145\40\141\x75\x74\150\137\x63\x6f\144\x65\x20\75\x20\x27{$UB}\47");
        $ES = $e1->fetchAssoc();
        $ES = $ES["\141\165\x74\x68\x5f\x63\157\x64\145"];
        return $ES;
    }
    public static function insert_access_token_with_user_id($MF, $X0)
    {
        $RM = \Drupal::database();
        $fG = $RM->update("\x6d\x69\x6e\x69\157\x72\x61\156\x67\x65\x5f\157\x61\x75\x74\150\x5f\143\154\x69\145\x6e\164\137\164\x6f\153\x65\156")->fields(array("\141\143\143\x65\163\163\x5f\164\x6f\x6b\145\x6e" => $X0))->condition("\x75\x73\x65\x72\x5f\151\144\x5f\x76\x61\x6c", $MF, "\x3d")->execute();
        return $fG;
    }
    public static function insert_access_token_expiry_time($MF, $bg)
    {
        $RM = \Drupal::database();
        $xM = $RM->update("\155\151\x6e\151\x6f\x72\141\156\147\x65\137\x6f\141\x75\x74\x68\137\x63\x6c\x69\x65\156\164\137\164\x6f\153\145\156")->fields(array("\141\x63\x63\145\163\x73\x5f\164\157\x6b\x65\156\137\162\x65\161\165\145\163\164\137\164\151\155\x65" => $bg))->condition("\x75\x73\145\162\137\x69\144\x5f\x76\141\154", $MF, "\x3d")->execute();
        return $xM;
    }
    public static function get_user_id_from_access_token($Zq)
    {
        $Mp = array("\x75\x73\x65\162\137\x69\x64\x5f\x76\x61\x6c");
        $RM = \Drupal::database();
        $e1 = $RM->query("\123\x45\114\x45\x43\124\40\52\40\x46\122\117\x4d\x20\155\x69\x6e\x69\157\x72\141\156\147\145\137\157\x61\165\x74\150\x5f\x63\154\151\145\156\164\137\164\x6f\x6b\145\x6e\40\x77\150\x65\x72\145\x20\x61\x63\143\x65\163\x73\137\164\x6f\x6b\x65\156\x20\75\x20\x27{$Zq}\x27");
        $MF = $e1->fetchAssoc();
        return $MF;
    }
    public static function get_access_token_request_time_from_user_id($MF)
    {
        $RM = \Drupal::database();
        $e1 = $RM->query("\x53\105\114\x45\103\x54\40\x2a\40\106\x52\x4f\x4d\x20\155\151\156\151\157\162\x61\156\x67\145\137\x6f\141\165\x74\x68\137\x63\x6c\151\x65\x6e\164\x5f\x74\157\153\x65\x6e\40\167\x68\x65\162\x65\x20\165\x73\x65\x72\x5f\151\x64\x5f\166\141\154\40\75\x20\x27{$MF}\47");
        $bg = $e1->fetchAssoc();
        return $bg;
    }
}
?>
