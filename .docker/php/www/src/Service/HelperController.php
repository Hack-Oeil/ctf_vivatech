<?php
namespace App\Service;
use Yoop\AbstractController;

class HelperController extends AbstractController { 
    /**
     * La fonction getFlag étant en protected on doit ajouter un helper
     */
    public function flag($name) {
        return $this->getFlag($name);
    }

    public function secretIsCorrect(string $data, string $secret) {
        return $this->isSecretData($data, $secret);
    }

    /**
     * Générer flag spécifique au niveau/nom demandé
     */
    protected function getFlag(?string $flagEnvName = null): string
    {
        $flag = '';
        $envKey = $flagEnvName;
        if ($envKey === 'FLAG_JOB' && !isset($_ENV['FLAG_JOB']) && isset($_ENV['FLAG_BONUS_JOB'])) {
            $envKey = 'FLAG_BONUS_JOB';
        }

        if ($envKey !== null && isset($_ENV[$envKey])) {
            $flag = SHA1($_ENV[$envKey] . '-CTF-YOOP-Fl@g');
            // Les flags personnalisés
            if (!empty($_SERVER["HTTP_X_USER_NAME"])) {
                $flag = $this->personalFlag()($flag, sha1($_SERVER['HTTP_X_USER_NAME']));
            } elseif (isset($_ENV['HOOS_CTF_USERNAME'])) {
                $flag = $this->personalFlag()($flag, sha1($_ENV['HOOS_CTF_USERNAME']));
            } elseif (isset($_ENV['HOOS_CTF_EMAIL'])) {
                $flag = $this->personalFlag()($flag, sha1($_ENV['HOOS_CTF_EMAIL']));
            }
        } elseif (!empty($_SERVER["HTTP_X_USER_NAME"]) && !empty($_SERVER["HTTP_X_FORWARDED_HOST"])) {
            $flag = sha1(md5($_SERVER["HTTP_X_USER_NAME"]) . '-' . md5($_SERVER["HTTP_X_FORWARDED_HOST"]));
        } elseif (isset($_ENV['DEFAULT_CTF_FLAG'])) {
            $flag = SHA1($_ENV['DEFAULT_CTF_FLAG'] . '-CTF-YOOP-Fl@g');
            // Les flags personnalisés
            if (!empty($_SERVER["HTTP_X_USER_NAME"])) {
                $flag = $this->personalFlag()($flag, sha1($_SERVER['HTTP_X_USER_NAME']));
            } elseif (isset($_ENV['HOOS_CTF_USERNAME'])) {
                $flag = $this->personalFlag()($flag, sha1($_ENV['HOOS_CTF_USERNAME']));
            } elseif (isset($_ENV['HOOS_CTF_EMAIL'])) {
                $flag = $this->personalFlag()($flag, sha1($_ENV['HOOS_CTF_EMAIL']));
            }
        }

        return $flag;
    }
}
