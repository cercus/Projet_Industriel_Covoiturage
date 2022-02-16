<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <p>Réception d'une prise de contact avec les éléments suivants :</p>
    <ul>
      <li><strong>Email</strong> : {{ $contact['email'] }}</li>
      <li><strong>Objet</strong> : {{ $contact['objet'] }}</li>
      <li><strong>Message</strong> : {{ $contact['message'] }}</li>
      
    </ul>
  </body>
</html>