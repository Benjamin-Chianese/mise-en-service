## Mise en service

### INSTALLATION

- Creation de la table SQL (schema.sql)
- Php7 MySQL apache
- Connexion a la base SI-PLUGIN
- Composer ("phpmailer/phpmailer": "~6.0")
- Includes/conf.php à modifier pour connexion SQL 
 

### DROIT SQL

- Table : maintenance          Droit : UPDATE / INSERT
- Table : network_account      Droit : UPDATE / INSERT
- Table : network_vision       Droit : UPDATE / INSERT
- Table : network_fon       Droit : UPDATE / INSERT
- Table : network_resiliation  Droit : UPDATE / INSERT
- Table : odroid               Droit : UPDATE / INSERT

```
GRANT ALL PRIVILEGES ON `si_plugins`.`network_resiliation` TO 'mise_en_service'@'%';
GRANT ALL PRIVILEGES ON `si_plugins`.`network_vision` TO 'mise_en_service'@'%';
GRANT ALL PRIVILEGES ON `si_plugins`.`network_fon` TO 'mise_en_service'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON `si_plugins`.`odroid` TO 'mise_en_service'@'%';
GRANT SELECT, INSERT, UPDATE ON `si_plugins`.`maintenance` TO 'mise_en_service'@'%';
GRANT SELECT, INSERT, UPDATE ON `si_plugins`.`network_account` TO 'mise_en_service'@'%';
GRANT SELECT ON `si_plugins`.`OrangeSourceInfo` TO 'mise_en_service'@'%';
```


### UTILISATION 

- Gestion des mise en service 
- Gestion des Odroid 4G (localisation de l'equipement)
- Gestion des résiliations (Réseau et ADV)
- Envoi des prévenances Réseau et téléphonie
- Gestion des annulation des prevenances (avec envoie de mail au client)
- Création et modification des fiches client
- Assignation Fibre Natira et port collecte au client
- Template pour l'équipe réseau (CPE et ASA)
