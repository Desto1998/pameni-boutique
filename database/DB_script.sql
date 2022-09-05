drop table if exists devises;
create table devises
(
    devise_id  int primary key AUTO_INCREMENT,
    nom_devise varchar(230) not null,
    symbole    varchar(6)   not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Liste des pays pour les clients et les fournisseurs
drop table if exists pays;
create table pays
(
    pays_id    int primary key AUTO_INCREMENT,
    nom_pays   varchar(255) not null,
    code_pays  varchar(255) not null,
    drapeau    varchar(255) null,
    visible    int       default 0,
    iddevise   int null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Liste des client de l'entreprise'
drop table if exists clients;
create table clients
(
    client_id       int primary key AUTO_INCREMENT,
    raison_s_client varchar(1000) null,
    nom_client      varchar(255) null,
    prenom_client   varchar(255) null,
    email_client    varchar(255) null,
    phone_1_client  varchar(20) not null,
    phone_2_client  varchar(20) null,
    idpays          int null,
    ville_client    varchar(255) null,
    adresse_client  varchar(255) null,
    logo_client     varchar(255),
    date_ajout      date        not null,
    contribuable    varchar(100) default null,
    slogan          varchar(500) null,
    siteweb         varchar(500) null,
    rcm             varchar(500) null,
    postale         varchar(50) null,
    type_client     varchar(50) null,
    iduser          int null,
    iddevise        int null,
    idpoint         int not null,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Liste des fournisseurs de l'entreprise
drop table if exists fournisseurs;
create table fournisseurs
(
    fournisseur_id int primary key AUTO_INCREMENT,
    raison_s_fr    varchar(255) null,
    nom_fr         varchar(255) null,
    prenom_fr      varchar(255) null,
    email_fr       varchar(255) null,
    phone_1_fr     varchar(20) not null,
    phone_2_fr     varchar(20) null,
    idpays         int null,
    ville_fr       varchar(255) null,
    adresse_fr     varchar(255) null,
    logo_fr        varchar(255) null,
    date_ajout_fr  date        not null,
    contribuable   varchar(100) default null,
    slogan         varchar(500) null,
    siteweb        varchar(500) null,
    rcm            varchar(500) null,
    postale        varchar(50) null,
    type_fr        varchar(50) null,
    iduser         int         not null,
    iddevise       int null,
    idpoint         int not null,
    created_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- actuaNum will increment when product is added is use to generate product reference
-- /* Categprie de produits
-- */
drop table if exists categories;
create table categories
(
    categorie_id    int primary key AUTO_INCREMENT,
    titre_cat       varchar(255) not null,
    code_cat        varchar(10)  not null,
    description_cat varchar(1000) null,
    actualNum       int       default 0,
    iduser          int,
    idpoint         int not null,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
    Liste des produits:
    quantite_produit contient la quantite de produit deja approvisionnee a chaque
    approvissionnement on augmente la quantite de la celle approvisionnee
  */
drop table if exists produits;
create table produits
(
    produit_id          int primary key AUTO_INCREMENT,
    reference           varchar(20)   not null,
    titre_produit       varchar(1000) not null,
    description_produit varchar(1000) null,
    quantite_produit    int           not null,
    prix_produit        float         not null,
    idcategorie         int null,
    iduser              int           not null,
    idpoint         int not null,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Categorie de depense de l'entreprise, cree manuellement par les utilisateur
drop table if exists charges;
create table charges
(
    charge_id   int primary key AUTO_INCREMENT,
    titre       varchar(255) not null,
    description varchar(1000) null,
    type_charge int,
    alerte      int,
    iduser      int,
    idpoint         int not null,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Liste des depenses de l'entreprise apres chaque depense on enregistre
-- /* Statut : 1 si pris en compte par la caisse 0 ou 2 sinon*/
drop table if exists taches;
create table taches
(
    tache_id   int primary key AUTO_INCREMENT,
    date_debut date  not null,
    date_fin   date  not null,
    date_ajout date  not null,
    raison     varchar(1000) null,
    nombre     int   not null,
    prix       float not null,
    idcharge   int   not null,
    iduser     int   not null,
    statut     int       default 1,
    idpoint         int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Contient toutes les proformats avec des produits en stocks
/*statut: 1= valide, ) non validee par defaut 0*/
drop table if exists devis;
create table devis
(
    devis_id             int primary key AUTO_INCREMENT,
    reference_devis      varchar(20) not null,
    date_devis           date        not null,
    statut               int       default 0,
    idclient             int         not null,
    validite             int         not null,
    tva_statut           int       default 0,
    objet                varchar(1000) null,
    disponibilite        varchar(1000) null,
    garentie             varchar(1000) null,
    condition_financiere varchar(1000) null,
    date_paie            date null,
    echeance             date null,
    iduser               int         not null,
    idpoint         int not null,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Contient toutes les factures avec des produits en stocks
-- meme principe pour les devis
drop table if exists factures;
create table factures
(
    facture_id           int primary key AUTO_INCREMENT,
    reference_fact       varchar(20) not null,
    date_fact            date        not null,
    statut               int       default 0,
    tva_statut           int       default 0,
    idclient             int         not null,
    objet                varchar(1000) null,
    disponibilite        varchar(1000) null,
    garentie             varchar(1000) null,
    condition_financiere varchar(1000) null,
    iduser               int         not null,
    iddevis              int null,
    idpoint         int not null,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Liste des produits de  factures
drop table if exists produit_factures;
create table produit_factures
(
    produit_f_id int primary key AUTO_INCREMENT,
    quantite     int   not null,
    prix         float not null,
    remise       float null,
    tva          float null,
    num_serie    varchar(255) null,
    idfacture    int   not null,
    idproduit    int   not null,
    iduser       int   not null,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists commentaires;
create table commentaires
(
    commentaire_id     int primary key AUTO_INCREMENT,
    message            varchar(1000) not null,
    date_commentaire   date          not null,
    statut_commentaire int       default 0,
    idcommande         int null,
    iddevis            int null,
    idfacture          int null,
    iduser             int           not null,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists paiements;
create table paiements
(
    paiement_id   int primary key AUTO_INCREMENT,
    mode          varchar(255) not null,
    date_paiement date         not null,
    description   varchar(1000) null,
    montant       float        not null,
    statut        int       default 1,
    idcommande    int null,
    iddevis       int null,
    idfacture     int null,
    iduser        int          not null,
    idpoint         int not null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists pocedes;
create table pocedes
(
    pocede_id  int primary key AUTO_INCREMENT,
    quantite   int   not null,
    prix       float not null,
    remise     float     default 0,
    tva        float     default 0,
    num_serie  varchar(1000) null,
    iddevis    int   not null,
    idproduit  int   not null,
    iduser     int   not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists commandes;
create table commandes
(
    commande_id        int primary key AUTO_INCREMENT,
    reference_commande varchar(20)   not null,
    objet              varchar(1000) not null,
    date_commande      date          not null,
    statut             int       default 0,
    tva_statut         int       default 0,
    idfournisseur      int           not null,
    service            varchar(1000) null,
    direction          varchar(1000) null,
    mode_paiement      varchar(1000) null,
    condition_paiement varchar(1000) null,
    delai_liv          varchar(1000) null,
    observation        varchar(1000) null,
    note               varchar(1000) null,
    lieu_liv           varchar(1000) null,
    iduser             int           not null,
    idpoint         int not null,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists comportes;
create table comportes
(
    comporte_id int primary key AUTO_INCREMENT,
    quantite    int   not null,
    prix        float not null,
    remise      float     default 0,
    tva         float     default 0,
    idcommande  int   not null,
    idproduit   int   not null,
    iduser      int   not null,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists pieces;
create table pieces
(
    piece_id   int primary key AUTO_INCREMENT,
    chemin     varchar(500) null,
    ref        varchar(50),
    remise     float null,
    idcommande int null,
    idfacture  int null,
    date_piece date null,
    iddevis    int null,
    iduser     int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists complements;
create table complements
(
    complement_id int primary key AUTO_INCREMENT,
    quantite      int   not null,
    prix          float not null,
    remise        float     default 0,
    tva           float     default 0,
    idproduit     int   not null,
    iddevis       int   not null,
    iduser        int   not null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists num_factures;
create table num_factures
(
    idnum_facture int primary key AUTO_INCREMENT,
    numero        int,
    date_num      date,
    iddevis       int null,
    iduser        int null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists menus;
create table menus
(
    menu_id     int primary key AUTO_INCREMENT,
    position    int,
    code        varchar(5),
    label       varchar(100),
    description varchar(1000) null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists user_menus;
create table user_menus
(
    user_menu_id int primary key AUTO_INCREMENT,
    idmenu       int,
    userid       int,
    iduser       int,
--     FOREIGN KEY (userid) REFERENCES users(id),
    FOREIGN KEY (idmenu) REFERENCES menus (menu_id),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists caisses;
create table caisses
(
    caisse_id      int primary key AUTO_INCREMENT,
    montant        float not null,
    raison         varchar(255) null,
    date_depot     date,
    description    varchar(1000) null,
    idtache        int null,
    identre        int null,
    idpaiement     int null,
    type_operation int   not null,
    iduser         int   not null,
    idpoint         int not null,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists entrees;
create table entrees
(
    entre_id          int primary key AUTO_INCREMENT,
    raison_entre      varchar(255) not null,
    montant_entre     float        not null,
    description_entre varchar(1000) null,
    date_entre        date,
    statut_entre      int       default 1,
    iduser            int          not null,
    idpoint         int not null,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists avoirs;
create table avoirs
(
    avoir_id        int primary key AUTO_INCREMENT,
    reference_avoir varchar(20)   not null,
    objet           varchar(1000) not null,
    date_avoir      date          not null,
    statut          int       default 0,
    tva_statut      int       default 0,
    idfacture       int           not null,
    iduser          int           not null,
    idpoint         int not null,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists produit_avoir;
create table produit_avoir
(
    produitavoir_id int primary key AUTO_INCREMENT,
    quantite        int   not null,
    prix            float not null,
    remise          float     default 0,
    tva             float     default 0,
    idavoir         int   not null,
    idproduit       int   not null,
    iduser          int   not null,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists bon_livraisons;
create table bon_livraisons
(
    bonlivraison_id int primary key AUTO_INCREMENT,
    reference_bl    varchar(20) not null,
    date_bl         date        not null,
    statut          int       default 0,
    iddevis         int null,
    idfacture       int null,
    objet           varchar(1000) null,
    delai_liv       varchar(1000) null,
    lieu_liv        varchar(1000) null,
    iduser          int         not null,
    idpoint         int not null,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists produit_bon;
create table produit_bon
(
    produitbon_id  int primary key AUTO_INCREMENT,
    quantite       int   not null,
    prix           float not null,
    remise         float     default 0,
    tva            float     default 0,
    idbonlivraison int   not null,
    idproduit      int   not null,
    iduser         int   not null,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE commentaires
    add column idbonlivraison int default null;
ALTER TABLE commentaires
    add column idavoir int default null;

drop table if exists log_factures;
create table log_factures
(
    log_f_id                 int primary key AUTO_INCREMENT,
    log_date_fact            date not null,
    log_statut               int       default 0,
    log_tva_statut           int       default 0,
    log_idclient             int  not null,
    log_objet                varchar(1000) null,
    log_disponibilite        varchar(1000) null,
    log_garentie             varchar(1000) null,
    log_condition_financiere varchar(1000) null,
    log_iduser               int  not null,
    log_idfacture            int null,
    iduser                   int  not null,
    idpoint         int not null,
    created_at               TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at               DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists log_p_factures;
create table log_p_factures
(
    log_pf_id     int primary key AUTO_INCREMENT,
    log_quantite  int   not null,
    log_prix      float not null,
    log_remise    float null,
    log_tva       float null,
    log_num_serie varchar(255) null,
    log_idf       int   not null,
    log_idpf      int   not null,
    log_idproduit int   not null,
    log_iduser    int   not null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Table pour la partie divers
-- Contient toutes les proformat pour les chantiers avec des produits manuellement entres
-- meme principe pour les factures
drop table if exists proformats;
create table proformats
(
    proformat_id         int primary key AUTO_INCREMENT,
    reference_pro        varchar(20) not null,
    date_pro             date        not null,
    statut               int       default 0,
    tva_statut           int       default 0,
    idclient             int         not null,
    objet                varchar(1000) null,
    disponibilite        varchar(1000) null,
    garentie             varchar(1000) null,
    condition_financiere varchar(1000) null,
    date_paie            date null,
    echeance             date null,
    iduser               int         not null,
    idpoint         int not null,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists facture_divers;
create table facture_divers
(
    fd_id         int primary key AUTO_INCREMENT,
    reference_fd       varchar(20) not null,
    date_fd            date        not null,
    statut               int       default 0,
    tva_statut           int       default 0,
    idclient             int         not null,
    objet                varchar(1000) null,
    disponibilite        varchar(1000) null,
    garentie             varchar(1000) null,
    condition_financiere varchar(1000) null,
    iduser               int         not null,
    idproformat               int         default null,
    idpoint         int not null,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Liste des produits de  divers, factures et proformat
drop table if exists produit_divers;
create table produit_divers
(
    pdivers_id               int primary key AUTO_INCREMENT,
    reference_pp        varchar(20)   not null,
    titre_produit       varchar(1000) not null,
    description_produit varchar(1000) null,
    quantite            int           not null,
    prix                float         not null,
    remise              float null,
    tva                 float null,
    num_serie           varchar(255) null,
    idproformat         int       default null,
    idfactured          int       default null,
    iduser              int           not null,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE commentaires
    add column idfactured int default null;
ALTER TABLE commentaires
    add column idproformat int default null;

ALTER TABLE `pocedes`
    ADD COLUMN `reference_pocede` VARCHAR(20) NULL DEFAULT NULL AFTER `pocede_id`,
	ADD COLUMN `titre_pocede` VARCHAR(1000) NULL DEFAULT NULL AFTER `reference_pocede`,
	ADD COLUMN `description_pocede` TEXT(10000) NULL AFTER `titre_pocede`;
ALTER TABLE `pocedes`
    CHANGE COLUMN `idproduit` `idproduit` INT(11) NULL AFTER `iddevis`;

ALTER TABLE `complements`
--     ADD COLUMN `reference_com` VARCHAR(20) NULL DEFAULT NULL AFTER `complement_id`,
	ADD COLUMN `titre_com` VARCHAR(1000) NULL DEFAULT NULL AFTER `complement_id`,
	ADD COLUMN `description_com` TEXT(10000) NULL AFTER `titre_com`;
ALTER TABLE `complements`
    CHANGE COLUMN `idproduit` `idproduit` INT(11) NULL AFTER `tva`;

ALTER TABLE `produit_factures`
    ADD COLUMN `reference_pf` VARCHAR(20) NULL DEFAULT NULL AFTER `produit_f_id`,
	ADD COLUMN `titre_pf` VARCHAR(1000) NULL DEFAULT NULL AFTER `reference_pf`,
	ADD COLUMN `description_pf` TEXT(10000) NULL AFTER `titre_pf`;
ALTER TABLE `produit_factures`
    CHANGE COLUMN `idproduit` `idproduit` INT(11) NULL AFTER `idfacture`;

ALTER TABLE `produit_bon`
    ADD COLUMN `reference_bon` VARCHAR(20) NULL DEFAULT NULL AFTER `produitbon_id`,
	ADD COLUMN `titre_bon` VARCHAR(1000) NULL DEFAULT NULL AFTER `reference_bon`,
	ADD COLUMN `description_bon` TEXT(10000) NULL AFTER `titre_bon`;
ALTER TABLE `produit_bon`
    CHANGE COLUMN `idproduit` `idproduit` INT(11) NULL AFTER `idbonlivraison`;

ALTER TABLE `produit_avoir`
    ADD COLUMN `reference_avoir` VARCHAR(20) NULL DEFAULT NULL AFTER `produitavoir_id`,
	ADD COLUMN `titre_avoir` VARCHAR(1000) NULL DEFAULT NULL AFTER `reference_avoir`,
	ADD COLUMN `description_avoir` TEXT(10000) NULL AFTER `titre_avoir`;
ALTER TABLE `produit_avoir`
    CHANGE COLUMN `idproduit` `idproduit` INT(11) NULL AFTER `idavoir`;

ALTER TABLE `devis`
    ADD COLUMN `type_devis` INT DEFAULT 0 AFTER `iduser`;

ALTER TABLE `factures`
    ADD COLUMN `type_fact` INT DEFAULT 0 AFTER `iddevis`;

ALTER TABLE `avoirs`
    ADD COLUMN `type_avoir` INT DEFAULT 0 AFTER `iduser`;

ALTER TABLE `bon_livraisons`
    ADD COLUMN `type_bon` INT DEFAULT 0 AFTER `iduser`;

-- Table point de vente

drop table if exists points;
create table points
(
    point_id int primary key AUTO_INCREMENT,
    nom_point    varchar(255) null,
    email_point       varchar(255) null,
    phone_1_point     varchar(20) not null,
    phone_2_point     varchar(20) null,
    ville_point       varchar(255) null,
    adresse_point     varchar(255) null,
    logo_point        varchar(255) null,
    date_ajout_point  date        not null,
    postale        varchar(50) null,
    iduser         int         not null,
    created_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
