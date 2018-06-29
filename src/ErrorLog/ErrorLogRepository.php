<?php

namespace Yoon\YoonMvp\ErrorLog;

use Yoon\YoonMvp\Repository;

// Verwaltet alle Stellar Status
class ErrorLogRepository extends Repository
{
    
    /**
     * Function to get the client ip address
     *
     * @return void
     */
    public function get_client_ip_env()
    {
        global $config;
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    /*
     * Logs an error
     */
    public function logError($typ = 'default', string $description = null)
    {
        global $config;
        // liegt eine Sperre vor?
        if (isset($_SESSION['errorlog'][$typ])) {
            $config['errorlogzeit'] = $config['millisek'] - $_SESSION['errorlog'][$typ];
            if ($config['errorlogzeit'] < 20) {
                $config['block'] = 1;
            }
        }
        // Prüft ob ein Block vorliegt (Zeitsperre) -> wenn nicht .. los!
        if (empty($config['block'])) {
            // eindeutige Error-ID erzeugen
            $mi = $config['millisek'] . substr(microtime(), 2, 6);

            // Insert into DB
            $ret = $this->database->insert('INSERT INTO
			        system__errorlog
			    SET
				    eid=' . (int) $mi . ',
				    typ="' . $this->database->strip($typ) . '",
			        ' . (!empty($config['user']['id']) ? 'userid=' . (int) $config['user']['id'] . ',' : '') . '
				    ip="' . $this->database->strip($_SERVER['REMOTE_ADDR']) . '",
				    clientip="' . $this->get_client_ip_env() . '",
                    created=NOW(),
                    description = "'. $this->database->escape($description).'"'
            , 'write');

            // Setzt eine Zeitsperre (Datenbank-Bombardierung verhindern)
            $_SESSION['errorlog'][$typ] = $config['millisek'];

            // Gib die individuelle Error-ID zurück
            return $mi;
        } else {
            return 0;
        }
    }
}

?>