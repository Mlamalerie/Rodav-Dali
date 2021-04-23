
--
-- Déchargement des données de la table `categorie`
--
DELETE FROM `categorie`;

INSERT INTO `categorie` (`categorie_id`, `categorie_title`) VALUES
(1, 'albums'),
(2, 'tableaux'),
(3, 'mode');


--
-- Déchargement des données de la table `produit`
--

DELETE FROM `produit`;

INSERT INTO `produit` (`produit_id`, `produit_title`, `produit_author`, `produit_year`, `produit_cat`, `produit_price`, `produit_quantity`, `produit_src`) VALUES
(22, 'Eyes Of Days', 'Cruel Santi', 2020, 1, 17.00, 5, 'img/cover/cover%20(1).jpg'),
(23, 'I Want', 'Cruel Santi', 2018, 1, 10.00, 42, 'img/cover/cover%20(4).jpg'),
(24, 'Slutt Diez', 'Lil Flip', 2020, 1, 20.00, 13, 'img/cover/cover%20(2).jpg'),
(25, 'La Bonne Epoque', 'Mlamali', 2004, 1, 50.20, 1, 'img/cover/cover%20(1).jpeg'),
(26, 'Silver', 'Amadunsi', 2020, 1, 10.00, 33, 'img/cover/cover%20(5).jpg'),
(27, 'WEB', 'Mlamali & Redouane', 2021, 1, 3.00, 3, 'img/cover/cover%20(6).jpg'),
(28, 'Feminine stereo', 'Romina Bant', 2015, 2, 350.00, 1, 'img/tableau/tableau%20(2).jpg'),
(29, 'Cloudy', 'Romina Bant', 2014, 2, 150.00, 1, 'img/tableau/tableau%20(1).jpg'),
(30, 'Rose Gogh', 'Lauralai', 2020, 2, 90.00, 1, 'img/tableau/tableau%20(3).jpg'),
(31, 'Madame', 'Lauralai', 2020, 2, 110.00, 1, 'img/tableau/tableau%20(4).jpg'),
(32, 'A touch of glass', 'Xav', 2020, 2, 535.00, 2, 'img/tableau/tableau%20(17).jpg'),
(33, 'Bisous d\'automne', 'Xav', 2021, 2, 1000.00, 3, 'img/tableau/tableau%20(6).jpg'),
(34, '\'20 février.\'', 'NameMy', 2021, 2, 75.00, 1, 'img/tableau/tableau%20(8).jpg'),
(35, '\'21 février.\'', 'NameMy', 2021, 2, 75.00, 1, 'img/tableau/tableau%20(14).jpg'),
(36, 'Je te vois', 'Salva Ro', 2021, 2, 175.00, 5, 'img/tableau/tableau%20(16).jpg'),
(37, 'AJ1 • Hadès', '@Pako-custom', 2021, 3, 110.00, 2, 'img/dress/dress%20(1).JPG'),
(38, 'AJ1 • FleurRouge', '@Pako-custom', 2021, 3, 160.00, 2, 'img/dress/dress%20(2).JPG'),
(39, 'AJ1 • ASTROWORLD', '@Pako-custom', 2021, 3, 165.00, 1, 'img/dress/dress%20(3).JPG'),
(40, 'AJ1 • KEN', '@Pako-custom', 2020, 3, 125.00, 1, 'img/dress/dress%20(4).JPG'),
(41, 'AJ1 • Sharingan', '@Pako-custom', 2021, 3, 175.00, 8, 'img/dress/dress%20(1).PNG'),
(42, 'BLOCKS Jeans', 'Marvinha', 2021, 3, 15.00, 3, 'img/dress/dress%20(5).JPG');


--
-- Déchargement des données de la table `user`
--
DELETE FROM `user`;

INSERT INTO `user` (`user_id`, `user_role`, `user_email`, `user_pseudo`, `user_password`, `user_dateinscription`) VALUES
(1, 1, 'mlamali@gmail.com', 'Mlamali', '$6$rounds=5000$grzgirjzgrpzhte9$cKO2cfaYjn9b0IirKoi2HxLdA0jlRtfki60D967chSwEzTQ3qMT171yvuWCi6ikxTRIX9qq8QfbKYkFy4qGin/', '2021-04-17 17:07:56'),
(2, 0, 'admin@rodavdali.com', 'Admin1', '$6$rounds=5000$grzgirjzgrpzhte9$cKO2cfaYjn9b0IirKoi2HxLdA0jlRtfki60D967chSwEzTQ3qMT171yvuWCi6ikxTRIX9qq8QfbKYkFy4qGin/', '2021-04-20 18:16:24');




