<?php

    function mailResetPassword($name, $email, $reset_digest) {
        echo "should send email";

        $to      = 'a52249@ualg.pt';
        $subject = 'the subject';
        $message = 'Olá Sr.(a) '.$name. '
        Para obter uma nova password clique no link

        http://all.deei.fct.ualg.pt/~a52249/LAB8/new_password.php?token='.$reset_digest.'.
        
        Este link tem a validade de uma hora.
        Se NÃO pediu uma nova password IGNORE este email.
        
        
        Cumprimentos,
        webmaster!
        Página Web: http://intranet.deei.fct.ualg.pt/~a52249/Lab8/
        E-mail: a52249@deei.fct.ualg.pt
        NOTA: Não responda a este email, não vai obter resposta!';
        
        mail($to, $subject, $message);
    }

?>