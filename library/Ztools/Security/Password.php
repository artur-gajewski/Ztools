<?php

/**
 * The Ztools_Security_Password component
 *
 * @copyright  2010 Artur Gajewski
 * @license    http://framework.zend.com/license   BSD License
 * @version    Release: @package_version@
 * @link       http://ztools.arturgajewski.com
 * @since      Class available since Release 1.0.0
 */
class Ztools_Security_Password
{
    /**
     * Create a random password with selected length.
     * Characters l (lowercase L) and the number 1 have
     * been removed because they can be mixed up.
     * 
     * @param int $length
     * @return string $password
     */
    public function generate($length = 7, $firstUpperCase = true) 
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $password = '' ;

        while ($i <= ($length-1)) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $password = $password . $tmp;
            $i++;
        }
        if ($firstUpperCase) {
            $password[0] = strtoupper($password[0]);
        }
        return $password;
    }
}
