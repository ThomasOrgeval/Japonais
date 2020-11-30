<?php

function sendResetPassword($pseudo, $code)
{
    return '
         <html>
         <head>
          <title>Récupération de mot de passe - lexiquejaponais.fr</title>
          <meta charset="utf-8" />
         </head>
         <body>
          <font color="#303030";>
            <div align="center">
               <table width="600px">
                <tr>
                  <td>
                     <div align="center">Bonjour <b>' . $pseudo . '</b>,</div>
                     Voici votre code de récupération: <b>' . $code . '</b>
                     A bientôt sur <a href="https://lexiquejaponais.fr">lexiquejaponais.fr</a> !
                     
                  </td>
                </tr>
                <tr>
                  <td align="center">
                     <font size="2">
                      Ceci est un email automatique, merci de ne pas y répondre
                     </font>
                  </td>
                </tr>
               </table>
            </div>
          </font>
         </body>
         </html>
         ';
}