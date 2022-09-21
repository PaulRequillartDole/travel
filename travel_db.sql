-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : database:3306
-- Généré le : mar. 20 sep. 2022 à 14:58
-- Version du serveur : 10.3.32-MariaDB-1:10.3.32+maria~focal
-- Version de PHP : 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_db`
--

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id`, `voyage_id`, `author_id`, `title`, `content`) VALUES
(3, 1, 1, 'Partie en voyage en guadeloupe', 'Bienvenue à Karukera, l’île aux belles-eaux ! La Guadeloupe, île-papillon, a deux ailes aux beautés étonnantes et différentes. Grande Terre la touristique vous charmera avec ses plages de rêve, tandis que Basse-Terre la sauvage vous surprendra avec sa forêt tropicale, paradis pour les randonneurs et tous les aventuriers. Les plongeurs trouveront ici des fonds exceptionnels, avec la fameuse Réserve Cousteau.\r\ntest'),
(6, 1, 1, 'Infos covid', '[https://www.guadeloupe.gouv.fr/Politiques-publiques/Risques-naturels-technologiques-et-sanitaires/Securite-sanitaire/Informations-coronavirus/COVID-19-Point-de-situation-du-10-aout-2022-et-recommandations](https://www.guadeloupe.gouv.fr/Politiques-publiques/Risques-naturels-technologiques-et-sanitaires/Securite-sanitaire/Informations-coronavirus/COVID-19-Point-de-situation-du-10-aout-2022-et-recommandations)\r\n\r\nLa baisse des nouvelles contaminations se poursuit mais la circulation virale reste très active. Présence constante en Guadeloupe des sous-lignages BA.4 et BA.5 d’OMICRON.Les taux de positivité et d’incidence continuent à diminuer et sont respectivement à 11.3 % et à 362.7 /100 000 habitants selon les données SIDEP ARS. Le R effectif est de 0,63.Les 8 et 9 août (semaine 32), 384 nouvelles contaminations ont été enregistrées (contre 586 les 2 premiers jours de la S31) parmi les 2 989 personnes testées ; ce qui porte à 12.8 % le taux de positivité pour ces deux journées.Il faut continuer à appliquer toutes les mesures barrières et par ce geste, protéger les personnes fragiles de cette infection virale.'),
(8, 8, 1, 'City Card', '**City card Copenhague avec toutes les visites + métro ( de l’aéroport aussi ), bus, navettes fluviales inclus**  = 85 euros.'),
(9, 9, 1, 'LISBOA CARD', 'Prix pour 72h : 44€'),
(10, 12, 1, 'Range date picker', '[https://mymth.github.io/vanillajs-datepicker/#/?id=bootstrap](https://mymth.github.io/vanillajs-datepicker/#/?id=bootstrap)\r\n\r\n[https://stackoverflow.com/questions/63465360/bootstrap-date-range-on-symfony-5-using-the-controller](https://stackoverflow.com/questions/63465360/bootstrap-date-range-on-symfony-5-using-the-controller)'),
(11, 13, 1, 'Range date picker', '[https://mymth.github.io/vanillajs-datepicker/#/?id=bootstrap](https://mymth.github.io/vanillajs-datepicker/#/?id=bootstrap)\r\n[https://stackoverflow.com/questions/63465360/bootstrap-date-range-on-symfony-5-using-the-controller](https://stackoverflow.com/questions/63465360/bootstrap-date-range-on-symfony-5-using-the-controller)'),
(12, 13, 1, 'Todo', '* [ ] Ajouter des tags\r\n* [ ] Ajouter Pays (multiple)\r\n* [ ] Filtre page accueil : Tous mes voyages, mes voyages prévus, en cours, terminés, etc.. (multiple) (case à cocher ? js ?)\r\n* [ ] Finir modal pour création voyage, suppression voyage\r\n* [ ] Peut être être plus libre sur les sections dans un voyage ? (Bouton ajouter une section avec titre, et possibilité d\'ajouter des items à l\'intérieur)\r\n* [ ] Ajouter \"Voyage to\" dans le titre du voyage pour pouvoir le modifier comme on le souhaite\r\n* [ ] Lors de l\'ajout, l\'edit ou la suppression d\'un élement dans une liste : mettre à jour via js la page\r\n* [ ] modal pour ajouter/modifier uniquement l\'image de couverture');

--
-- Déchargement des données de la table `place`
--

INSERT INTO `place` (`id`, `voyage_id`, `title`, `description`) VALUES
(1, 1, 'Volcan la souffrière', NULL),
(2, 1, 'La reserve Cousteau', 'Ilet aux pigeons, nager avec les tortues, etc'),
(3, 4, 'Colisée', NULL),
(4, 4, 'Panthéon', NULL),
(5, 4, 'Fontaine de Trévi', NULL),
(6, 7, 'Athène', '- Acropole\r\n- Parthénon\r\n- Musée Archéologique'),
(7, 8, 'Jardins de Tivoli', 'Les jardins de Tivoli sont une des attractions majeures au centre actuel de Copenhague, au Danemark. Il s\'agit d\'un parc d\'attractions comprenant de nombreuses attractions, mais aussi des restaurants, des expositions, des concerts, ainsi que des pantomimes.\r\nhttps://fr.wikipedia.org/wiki/Jardins_de_Tivoli'),
(8, 8, 'Christianshavn et la ville libre de Christiania', NULL),
(9, 8, 'Copenhaguen Street Food', NULL),
(10, 8, 'Le quartier Nyhavn', 'Nyhavn( qui veut dire nouveau port) est certainement l’endroit où vous rencontrerez le plus de touristes. En effet c’est de ce petit port que partent la plupart des bateaux qui font le tour des canaux de la ville.'),
(11, 8, 'Le musée du design danois', NULL),
(12, 8, 'Le château de Christianborg slot', NULL),
(13, 8, 'La maison de contes de fée de Hans Christian Andersen', NULL),
(14, 9, 'Sintra', 'Classée au Patrimoine culturel de l\'Humanité, la cité portugaise de Sintra regorge de merveilles.'),
(15, 9, 'Quartier de Baixa', 'Vieux quartier touristique : \r\n- Ascenseur de Santa Justa\r\n- Praça de Comeirço (place principale)\r\n- Lisboa Story Center (musée sur l\'histoire de la ville)');

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `label`, `color`) VALUES
(1, 'Idée de voyage', 'indigo'),
(2, 'Voyage prévu', 'purple'),
(3, 'En cours', 'azure'),
(4, 'Terminé', 'green'),
(5, 'Annulé', 'red'),
(6, 'Reporté', 'dark');

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'Paul', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe'),
(2, 'Elodie', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe'),
(3, 'Jo', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe'),
(4, 'Lou', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe'),
(5, 'Jules', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe'),
(6, 'Maman', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe'),
(7, 'Papa', '[]', '$2y$13$nCBz.4/tpb.uWgQ66tnegezxm2rJgPbkLdJkKT7qSTRtE2dfsfdYe');

--
-- Déchargement des données de la table `voyage`
--

INSERT INTO `voyage` (`id`, `destination`, `description`, `start_at`, `end_at`, `status_id`, `owner_id`, `image`) VALUES
(1, 'Guadeloupe', 'Voyage sur l\'ile de la Guadeloupe', '2022-06-19', '2022-06-30', 4, 1, 'https://media.routard.com/image/13/5/guadeloupe.1557135.c1000x300.jpg'),
(2, 'Paris', 'Formation à Paris', '2022-09-09', '2022-09-10', 2, 2, 'https://thumbs.dreamstime.com/b/banner-travel-skyline-paris-city-roofs-eiffel-tower-which-paris-best-destinations-europe-travel-landmark-concept-220385446.jpg'),
(3, 'Annecy', 'qsdqsd', '2022-10-27', '2022-10-28', 1, 2, 'https://fac.img.pmdstatic.net/fit/https.3A.2F.2Fi.2Epmdstatic.2Enet.2Ffac.2F2021.2F09.2F23.2Fcd4d4cb1-cc0f-4825-8813-11a80af81cda.2Ejpeg/1200x1200/quality/80/crop-from/center/visite-a-annecy-10-idees-originales-pour-decouvrir-la-ville-nos-bonnes-adresses.jpeg'),
(4, 'Rome', 'Weekend to Italie', '2022-10-21', '2022-10-24', 1, 1, 'https://upload.wikimedia.org/wikipedia/commons/6/64/Rome_banner_panorama.jpg'),
(7, 'Grèce 🏺', NULL, NULL, NULL, 1, 1, 'https://upload.wikimedia.org/wikipedia/commons/e/ee/Athens%2C_Greece_banner-_Parthenon_view_1.jpg'),
(8, 'Copenhague', NULL, NULL, NULL, 1, 1, 'https://www.tapcorporate.com//-/media/Flytap/new-tap-pages/destinations/europe/denmark/copenhagen/destinations-copenhagen-banner-desktop-1920x600.jpg?h=600&w=1920&la=fr&hash=11B7F66EA043490C834D5F9A4F44570EB01306D4'),
(9, 'Lisbonne', NULL, NULL, NULL, 1, 1, 'https://thumbs.dreamstime.com/b/paysage-urbain-de-lisbonne-vue-la-vieille-ville-alfama-portugal-107309789.jpg'),
(10, 'Budapest', 'Budapest, capitale de la Hongrie, est la ville la plus importante du pays et est devenue l’une des principales villes touristiques d’Europe.', NULL, NULL, 1, 1, 'https://www.budapestcard.org/fr/wp-content/themes/bud/img/home-banner.jpg'),
(11, 'Stockholm', NULL, NULL, NULL, 1, 1, 'https://upload.wikimedia.org/wikipedia/commons/a/a4/Stockholm_Wikivoyage_front_page_banner.jpg'),
(12, 'Prague', NULL, NULL, NULL, 1, 1, NULL),
(13, 'Notes pour cet app', NULL, NULL, NULL, 3, 1, NULL);

--
-- Déchargement des données de la table `voyage_user`
--

INSERT INTO `voyage_user` (`voyage_id`, `user_id`) VALUES
(1, 2),
(3, 1),
(4, 2),
(7, 2),
(8, 2),
(9, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
